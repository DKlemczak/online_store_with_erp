using enova365.OnlineStoreWithErp.Utils;
using Soneta.Tools;
using Soneta.Towary;
using System;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryValidation
    {
        private SynchronizujTowaryPrms Prms { get; }

        public SynchronizujTowaryValidation(SynchronizujTowaryPrms prms) => Prms = prms;

        public void Validate()
        {
            if (Prms.WebServiceAddress.IsNullOrEmpty())
                throw new ArgumentNullException("Nie podano adresu do Web Serwisu.");

            if (Prms.WebServiceToken.IsNullOrEmpty())
                throw new ArgumentNullException("Nie podano tokenu.");

            if (Prms.Towary.Count == 0)
                throw new ArgumentNullException($"Nie wybrano towarów do wysłania.");

            if (Prms.Grupy.Count == 0)
                throw new ArgumentNullException($"Brak skonfigurowanych grup produktów.");

            foreach (Towar towar in Prms.Towary)
            {
                if (towar.GetGrupa().IsNullOrEmpty())
                    throw new ArgumentNullException($"Towar {towar} nie został przypisany do grupy.");
            }
        }
    }
}