using Soneta.Tools;
using System;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujZamowienia
{
    public class SynchronizujZamowieniaValidation
    {
        private SynchronizujZamowieniaPrms Prms { get; }

        public SynchronizujZamowieniaValidation(SynchronizujZamowieniaPrms prms) => Prms = prms;

        public void Validate()
        {
            if (Prms.WebServiceAddress.IsNullOrEmpty())
                throw new ArgumentNullException("Nie podano adresu do Web Serwisu.");

            if (Prms.WebServiceToken.IsNullOrEmpty())
                throw new ArgumentNullException("Nie podano tokenu.");
        }
    }
}