using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Soneta.Business;
using Soneta.Towary;
using System;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryWorker
    {
        public SynchronizujTowaryPrms Prms { get; }

        private SynchronizujTowaryWorker(SynchronizujTowaryPrms prms) => Prms = prms;

        public static object SynchronizujTowaryMethod(Session session)
        {
            SynchronizujTowaryPrms prms = new SynchronizujTowaryPrms(session, session.GetTowary().Towary.WgKodu);
            SynchronizujTowaryWorker worker = new SynchronizujTowaryWorker(prms);

            return worker.SynchronizujTowary();
        }

        private object SynchronizujTowary()
        {
            try { new SynchronizujTowaryValidation(Prms).Validate(); }
            catch (Exception ex) { return StoreTools.ExceptionMBox(ex); }

            JSONSynchronizujTowary jsonObject = new JSONSynchronizujTowary(Prms.Towary, Prms.Grupy);

            if (StoreTools.PostRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/productsgroup", jsonObject.Grupy).IsSuccessStatusCode == false)
                throw new Exception();

            if (StoreTools.PostRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/products", jsonObject.Towary).IsSuccessStatusCode == false)
                throw new Exception();

            return null;
        }
    }
}