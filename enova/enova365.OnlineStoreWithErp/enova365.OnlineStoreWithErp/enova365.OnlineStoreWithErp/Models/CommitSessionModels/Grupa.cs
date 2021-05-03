using enova365.OnlineStoreWithErp.Models.CustomViewInfos;
using Soneta.Business;
using Soneta.Tools;
using System;
using System.Collections.Generic;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Models.CommitSessionModels
{
    public class JSONGrupa
    {
        public JSONGrupa() { }

        public JSONGrupa(Grupa grupa)
        {
            WMenu = grupa.WMenu;
            Nazwa = grupa.Nazwa;
            ParentNazwaGrupy = grupa.ParentNazwaGrupy;
        }

        public string Nazwa { get; set; }
        public bool WMenu { get; set; }
        public string ParentNazwaGrupy { get; set; }
    }

    public class Grupa : CommitSession
    {
        #region Constructors

        public Grupa(Session session) : base(session) { }

        public Grupa(Session session, JSONGrupa jsonGrupa) : this(session)
        {
            _Nazwa = jsonGrupa.Nazwa;
            _WMenu = jsonGrupa.WMenu;
            _ParentNazwaGrupy = jsonGrupa.ParentNazwaGrupy;
        }

        #endregion Constructors

        #region Fields

        private const string TAB = "    ";

        private string _Nazwa;
        private bool _WMenu;
        private string _ParentNazwaGrupy;

        public string Nazwa
        {
            get => _Nazwa;
            set
            {
                if (GrupaViewInfo.GetList(Session).FirstOrDefault(g => g.Nazwa == value) != null)
                    throw new Exception($"Istnieje już grupa o nazwie: {value}");

                _Nazwa = value;
                //SetOrderValue();
                RefreshSession();
            }
        }

        public bool WMenu { get => _WMenu; set { _WMenu = value; RefreshSession(); } }
        public string ParentNazwaGrupy { get => _ParentNazwaGrupy; set { _ParentNazwaGrupy = value; /*SetOrderValue();*/ RefreshSession(); } }

        public string[] GetListParentNazwaGrupy() => GrupaViewInfo.GetList(Session)
            .Where(g => g.Nazwa != Nazwa && g.ParentNazwaGrupy != Nazwa)
            .Select(g => g.Nazwa)
            .ToArray();

        public Grupa ParentGrupa => GrupaViewInfo.GetList(Session).FirstOrDefault(z => z.Nazwa == ParentNazwaGrupy);
        public bool CzyPodrzedna => ParentGrupa != null;
        public List<Grupa> Childs => GrupaViewInfo.GetList(Session).Where(g => g.ParentNazwaGrupy == Nazwa).ToList();

        public string NazwaOnGrid
        {
            get
            {
                string tabulatory = "";
                Grupa grupa = this;

                while (grupa.CzyPodrzedna)
                {
                    tabulatory += TAB;
                    grupa = grupa.ParentGrupa;
                }

                return tabulatory + Nazwa;
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

        public double OrderValue { get; set; }

        #endregion Fields

        #region Methods

        //private void SetOrderValue()
        //{
        //    List<Grupa> grupaList = GrupaViewInfo.GetList(Session);

        //    foreach (Grupa grupa in grupaList)
        //    {
        //        grupa._Nazwa += "Ti";
        //    }

        //    GrupaViewInfo.Zapisz(Session, grupaList);

        //    //List<Grupa> sortedGrupaList = new List<Grupa>();

        //    //foreach (Grupa grupa in GrupaViewInfo.GetList(Session).OrderBy(g => g.ParentLevel))
        //    //{
        //    //    if (sortedGrupaList.FirstOrDefault(g => g.Nazwa == grupa.Nazwa) != null)
        //    //        sortedGrupaList.InsertRange(sortedGrupaList.IndexOf(grupa) + 1, grupa.Childs);
        //    //    else
        //    //    {
        //    //        sortedGrupaList.Add(grupa);
        //    //        sortedGrupaList.AddRange(grupa.Childs);
        //    //    }
        //    //}

        //    //int counter = 0;
        //    //foreach (Grupa grupa in sortedGrupaList)
        //    //    grupa.OrderValue = ++counter;

        //    //GrupaViewInfo.Zapisz(Session, sortedGrupaList);
        //}

        public override object OnCommitting(Context cx)
        {
            if (Nazwa.IsNullOrEmpty())
                throw new Exception("Pole 'Nazwa' nie może byc puste");

            GrupaViewInfo.Zapisz(cx);
            return base.OnCommitting(cx);
        }

        public override string ToString() => Nazwa;

        #endregion Methods
    }
}