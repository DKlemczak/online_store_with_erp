using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using Soneta.Business;
using Soneta.Handel;
using Soneta.Towary;
using System.Collections.Generic;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Workers.AktualizujNazwyGrup
{
    public class AktualizujNazwyGrupPrms
    {
        public Session Session { get; }
        public List<Towar> Towary { get; }
        public List<Grupa> Grupy { get; }

        public AktualizujNazwyGrupPrms(Session session)
        {
            Session = session;
            Towary = Session.GetHandel().Towary.Towary.WgKodu.ToList();

            EnovaConfig config = new EnovaConfig(Session);

            Grupy = config.Grupy;
        }
    }
}