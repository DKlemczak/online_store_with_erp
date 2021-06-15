using enova365.OnlineStoreWithErp.Config;
using Soneta.Business;
using Soneta.Core;
using Soneta.CRM;
using Soneta.Handel;
using Soneta.Magazyny;
using System.Collections.Generic;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujZamowienia
{
    public class SynchronizujZamowieniaPrms
    {
        public Magazyn Magazyn { get; }
        public Session Session { get; }
        public List<DokumentHandlowy> SavedDocuments { get; }
        public List<Kontrahent> NewKontrahets { get; }
        public string WebServiceToken { get; }
        public string WebServiceAddress { get; }

        public SynchronizujZamowieniaPrms(Context context)
        {
            Session = context.Session;
            Magazyn = (Magazyn)context[typeof(Magazyn)];
            SavedDocuments = new List<DokumentHandlowy>();
            NewKontrahets = new List<Kontrahent>();

            EnovaConfig config = new EnovaConfig(Session);
            WebServiceToken = config.WebServiceToken;
            WebServiceAddress = config.WebServiceAddress;
        }
    }
}