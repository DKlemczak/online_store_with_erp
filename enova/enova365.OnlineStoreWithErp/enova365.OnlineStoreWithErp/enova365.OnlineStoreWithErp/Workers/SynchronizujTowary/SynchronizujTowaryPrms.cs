using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using Soneta.Business;
using Soneta.Towary;
using System.Collections.Generic;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryPrms
    {
        public Session Session { get; }
        public List<Towar> Towary { get; }
        public List<Grupa> Grupy { get; }
        public string WebServiceToken { get; }
        public string WebServiceAddress { get; }

        public SynchronizujTowaryPrms(Session session, IEnumerable<Towar> towary)
        {
            Session = session;
            Towary = towary.ToList();

            EnovaConfig config = new EnovaConfig(Session);
            WebServiceToken = config.WebServiceToken;
            WebServiceAddress = config.WebServiceAddress;
            Grupy = config.Grupy;
        }
    }
}