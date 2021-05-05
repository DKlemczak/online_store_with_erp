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