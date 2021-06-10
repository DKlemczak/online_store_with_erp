using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.UI.ExtViews;
using Soneta.Business;
using Soneta.Towary;
using enova365.OnlineStoreWithErp.Utils;
using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using System.Collections.Generic;

[assembly: Worker(typeof(TowarExtView))]

namespace enova365.OnlineStoreWithErp.UI.ExtViews
{
    public class TowarExtView : ContextBase
    {
        public TowarExtView(Context cx) : base(cx)
        {
            EnovaConfig = new EnovaConfig(cx.Session);
            GrupaList = EnovaConfig.Grupy;
        }

        private EnovaConfig EnovaConfig { get; }
        private List<Grupa> GrupaList { get; }

        [Context]
        public Towar Towar { get; set; }

        public bool IsActive
        {
            get => Towar.GetIsActive();
            set { Towar.SetIsActive(value); OnChanged(); }
        }

        public string Opis
        {
            get => Towar.GetOpis();
            set { Towar.SetOpis(value); OnChanged(); }
        }

        public string Tagi
        {
            get => Towar.GetTagi();
            set { Towar.SetTagi(value); OnChanged(); }
        }

        public string Rabat
        {
            get => Towar.GetRabat().ToString();
            set
            {
                int intValue = int.Parse(value);

                if (intValue < 0 || intValue > 100)
                    throw new System.Exception("Wartość musi znajdować się w przedziale '0 - 100'");

                Towar.SetRabat(intValue);
                OnChanged();
            }
        }

        public string[] GetListRabat()
        {
            List<string> result = new List<string>();

            for (int i = 0; i <= 100; i += 10)
                result.Add(i.ToString());

            return result.ToArray();
        }

        public string GrupaString
        {
            get => Grupa.GetToStringFromList(GrupaList, Towar.GetGrupaId());
            set { Towar.SetGrupaId(Grupa.GetIdFromToString(value)); OnChanged(); }
        }

        public string[] GetListGrupaString()
            => GrupaList
            .ConvertAll(g => g.ToString())
            .ToArray();
    }
}