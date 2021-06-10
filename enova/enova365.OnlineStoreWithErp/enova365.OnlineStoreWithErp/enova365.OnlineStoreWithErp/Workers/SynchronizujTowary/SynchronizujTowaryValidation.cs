using enova365.OnlineStoreWithErp.Utils;
using Soneta.Tools;
using Soneta.Towary;
using System;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryValidation
    {
        internal static void Validate(SynchronizujTowaryWorker worker)
        {
            if (worker.Prms.WebServiceAddress.IsNullOrEmpty())
                throw new ArgumentNullException("Nie podano adresu do Web Serwisu.");

            if (worker.Prms.WebServiceToken.IsNullOrEmpty())
                throw new ArgumentNullException("Nie podano tokenu.");

            if (worker.Prms.Towary.Count == 0)
                throw new ArgumentNullException($"Nie wybrano towarów do wsłania.");

            if (worker.Prms.Grupy.Count == 0)
                throw new ArgumentNullException($"Brak skonfigurowanych grup produktów.");

            foreach (Towar towar in worker.Prms.Towary)
            {
                if (towar.GetGrupa().IsNullOrEmpty())
                    throw new ArgumentNullException($"Towar {towar} nie został przypisany do grupy.");
            }
        }
    }
}