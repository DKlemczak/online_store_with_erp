using enova365.OnlineStoreWithErp.Models.CustomViewInfos;
using Soneta.Business;
using Soneta.Business.Db;
using Soneta.Tools;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace enova365.OnlineStoreWithErp.Models.CommitSessionModels
{
    public class JSONGrupa
    {
        public JSONGrupa() { }

        public JSONGrupa(Grupa grupa)
        {
            Id = grupa.Id;
            WMenu = grupa.WMenu;
            Nazwa = grupa.Nazwa;
            OrderValue = grupa.OrderValue;
            ParentId = grupa.ParentId;
        }

        public int Id { get; set; }
        public string Nazwa { get; set; }
        public bool WMenu { get; set; }
        public int OrderValue { get; set; }
        public int ParentId { get; set; }
    }

    public class Grupa : CommitSession
    {
        #region Constructors

        public Grupa(Session session, int id) : base(session) => Id = id;

        public Grupa(Session session, JSONGrupa jsonGrupa) : this(session, jsonGrupa.Id)
        {
            _Nazwa = jsonGrupa.Nazwa;
            _WMenu = jsonGrupa.WMenu;
            OrderValue = jsonGrupa.OrderValue;
            _ParentId = jsonGrupa.ParentId;
        }

        #endregion Constructors

        #region Fields

        private const string TAB = "    ";

        private string _Nazwa;
        private bool _WMenu;
        private int _ParentId = 0;

        public int Id { get; }

        public string Nazwa
        {
            get => _Nazwa;
            set
            {
                if (GrupaViewInfo.GetList(Session).FirstOrDefault(g => g.Nazwa == value && g.Id != Id) != null)
                {
                    string errorValue = value;
                    value = _Nazwa;
                    throw new Exception($"Istnieje już grupa o nazwie: {errorValue}");
                }

                _Nazwa = value;
                RefreshSession();
            }
        }

        public bool WMenu { get => _WMenu; set { _WMenu = value; RefreshSession(); } }
        public int ParentId { get => _ParentId; set { _ParentId = value; RefreshSession(); } }

        public string ParentNazwaGrupy
        {
            get => GetToStringFromList(GrupaViewInfo.GetList(Session), _ParentId);
            set
            {
                _ParentId = GetIdFromToString(value);
                RefreshSession();
            }
        }

        public string[] GetListParentNazwaGrupy() => GrupaViewInfo.GetList(Session)
            .Where(g => g.Id != Id && g.ParentId != Id)
            .Select(g => g.ToString())
            .ToArray();

        public Grupa ParentGrupa => GrupaViewInfo.GetList(Session).FirstOrDefault(z => z.Id == ParentId);
        public bool CzyPodrzedna => ParentGrupa != null;
        public List<Grupa> Childs => GrupaViewInfo.GetList(Session).Where(g => g.ParentId == Id).ToList();

        public string NazwaOnGrid
        {
            get
            {
                string tabs = "";
                Grupa grupa = this;

                while (grupa.CzyPodrzedna)
                {
                    tabs += TAB;
                    grupa = grupa.ParentGrupa;
                }

                return tabs + Nazwa;
            }
        }

        public string NazwaHierarchiczna
        {
            get
            {
                StringBuilder result = new StringBuilder();

                Grupa grupa = this;

                do
                {
                    result.Insert(0, '\\');
                    result.Insert(0, grupa.Nazwa);

                    grupa = grupa.ParentGrupa;
                } while (grupa != null);

                return result.ToString().TrimEnd('\\').Insert(0, "\\");
            }
        }

        public int ParentLevel
        {
            get
            {
                int level = 0;
                Grupa grupa = this;

                while (grupa.CzyPodrzedna)
                {
                    level++;
                    grupa = grupa.ParentGrupa;
                }

                return level;
            }
        }

        public int OrderValue { get; set; }

        #endregion Fields

        #region Methods

        public override object OnCommitting(Context cx)
        {
            if (Nazwa.IsNullOrEmpty())
                throw new Exception("Pole 'Nazwa' nie może byc puste");

            List<Grupa> grupaList = GrupaViewInfo.GetListCx(cx);
            List<Grupa> sortedGrupaList = new List<Grupa>();

            foreach (Grupa grupa in grupaList.OrderBy(g => g.ParentLevel))
            {
                if (sortedGrupaList.FirstOrDefault(g => g.Id == grupa.Id) != null)
                    sortedGrupaList.InsertRange(sortedGrupaList.IndexOf(grupa) + 1, grupa.Childs);
                else
                {
                    sortedGrupaList.Add(grupa);
                    sortedGrupaList.AddRange(grupa.Childs);
                }
            }

            foreach (Grupa grupa in grupaList)
            {
                grupa.OrderValue = sortedGrupaList.IndexOf(sortedGrupaList.FirstOrDefault(g => g.Id == grupa.Id));
                grupa.RefreshSession();
            }

            GrupaViewInfo.Zapisz(cx);

            return base.OnCommitting(cx);
        }

        public override string ToString() => $"{Id}. {Nazwa}";

        public static int GetIdFromToString(string toStringValue)
        {
            try { return int.Parse(toStringValue.Split('.').FirstOrDefault()); }
            catch { return 0; }
        }

        public static string GetToStringFromList(List<Grupa> list, int id)
            => list.FirstOrDefault(g => g.Id == id) is Grupa grupa
            ? grupa.ToString()
            : "";

        #endregion Methods
    }
}