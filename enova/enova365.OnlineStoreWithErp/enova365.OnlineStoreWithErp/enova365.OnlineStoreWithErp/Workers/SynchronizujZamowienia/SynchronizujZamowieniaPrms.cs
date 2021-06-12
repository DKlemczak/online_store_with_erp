using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.Models;
using Soneta.Business;
using Soneta.CRM;
using Soneta.Handel;
using Soneta.Magazyny;
using System.Collections.Generic;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujZamowienia
{
    public class SynchronizujZamowieniaPrms
    {
        public DefDokHandlowego Definicja => HandelModule.DefDokHandlowych.WgSymbolu["FV"];
        public Magazyn Magazyn { get; }
        public Session Session { get; }
        public CRMModule CRMModule { get; }
        public HandelModule HandelModule { get; }
        public List<DokumentHandlowy> SavedDocuments { get; }
        public string WebServiceToken { get; }
        public string WebServiceAddress { get; }

        public SynchronizujZamowieniaPrms(Session session, Context context)
        {
            Session = session;
            Magazyn = (Magazyn)context[typeof(Magazyn)];
            HandelModule = Session.GetHandel();
            CRMModule = Session.GetCRM();
            SavedDocuments = new List<DokumentHandlowy>();

            EnovaConfig config = new EnovaConfig(Session);
            WebServiceToken = config.WebServiceToken;
            WebServiceAddress = config.WebServiceAddress;
        }
    }
}