using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Soneta.Business;
using Soneta.Forms;
using Soneta.Towary;
using System;
using System.Text;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryWorker
    {
        private SynchronizujTowaryPrms Prms { get; }

        private SynchronizujTowaryWorker(SynchronizujTowaryPrms prms) => Prms = prms;

        public static object SynchronizujTowaryMethod(Session session)
        {
            Progress progress = new Progress(false, false, $"Synchronizacja towarów...");

            try
            {
                RowCondition cond = new FieldCondition.Equal(nameof(Towar.Typ), TypTowaru.Towar);
                SynchronizujTowaryPrms prms = new SynchronizujTowaryPrms(session, session.GetTowary().Towary.WgKodu[cond]);
                SynchronizujTowaryWorker worker = new SynchronizujTowaryWorker(prms);

                return worker.SynchronizujTowary();
            }
            finally { progress.Dispose(); }
        }

        private object SynchronizujTowary()
        {
            StoreTools.ProgressWriteLine($"Walidacja...");
            try { new SynchronizujTowaryValidation(Prms).Validate(); }
            catch (Exception ex) { return StoreTools.ExceptionMBox(ex); }

            JSONSynchronizujTowary jsonObject = new JSONSynchronizujTowary(Prms.Towary, Prms.Grupy);

            StoreTools.ProgressWriteLine($"Wysyłanie grup...");
            if (StoreTools.PostRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/productsgroup", jsonObject.Grupy).IsSuccessStatusCode == false)
                throw new Exception("Błąd przy synchronizacji grup...");

            StoreTools.ProgressWriteLine($"Wysyłanie towarów...");
            if (StoreTools.PostRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/products", jsonObject.Towary).IsSuccessStatusCode == false)
                throw new Exception($"Zsynchronizowano {jsonObject.Grupy.Count} grup. Błąd przy synchronizacji towarów...");

            StringBuilder builder = new StringBuilder();
            builder.AppendLine("Poprawnie zsynchronizowano:");
            builder.AppendLine($"Grup: {jsonObject.Grupy.Count}");
            builder.AppendLine($"Towarów: {jsonObject.Towary.Count}");

            return StoreTools.MBox("Synchronizacja towarów", builder.ToString());
        }
    }
}