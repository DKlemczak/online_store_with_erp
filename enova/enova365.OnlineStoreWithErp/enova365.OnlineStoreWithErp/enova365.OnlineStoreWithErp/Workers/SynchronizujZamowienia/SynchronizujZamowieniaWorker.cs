using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Newtonsoft.Json;
using Soneta.Business;
using Soneta.Business.UI;
using Soneta.Forms;
using Soneta.Handel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Text;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujZamowienia
{
    public class SynchronizujZamowieniaWorker
    {
        private Log Log => new Log("Synchronizacja zamówień", true);
        private SynchronizujZamowieniaPrms Prms { get; }

        private SynchronizujZamowieniaWorker(SynchronizujZamowieniaPrms prms) => Prms = prms;

        public static object SynchronizujZamowienia(Context context)
        {
            Progress progress = new Progress(false, false, $"Synchronizacja zamówień...");

            try
            {
                SynchronizujZamowieniaPrms prms = new SynchronizujZamowieniaPrms(context);
                SynchronizujZamowieniaWorker worker = new SynchronizujZamowieniaWorker(prms);

                return worker.SynchronizujZamowienia();
            }
            finally { progress.Dispose(); }
        }

        private object SynchronizujZamowienia()
        {
            StoreTools.ProgressWriteLine($"Walidacja");
            try { new SynchronizujZamowieniaValidation(Prms).Validate(); }
            catch (Exception ex) { return StoreTools.ExceptionMBox(ex); }

            StoreTools.ProgressWriteLine($"Pobieranie zamówień z bazy danych sklepu.");
            string zamowieniaJson = StoreTools.GetStringRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/orders");

            List<JSONSynchronizujZamowienia> zamowienia = JsonConvert.DeserializeObject<List<JSONSynchronizujZamowienia>>(zamowieniaJson);

            int zamowieniaCounter = 0;
            foreach (JSONSynchronizujZamowienia zamowienie in zamowienia.OrderBy(z => z.CreatedAt))
            {
                zamowieniaCounter++;

                StoreTools.ProgressWriteLine($"[ {zamowieniaCounter} z {zamowienia.Count} ]: Zamówienie - {zamowienie.UUId}");
                StoreTools.ProgressBar(zamowieniaCounter, zamowienia.Count);

                try
                {
                    using (Session sess = Prms.Session.Login.CreateSession(false, true))
                    {
                        InsertZamowienieWorker worker = new InsertZamowienieWorker(Prms, zamowienie, sess);
                        DokumentHandlowy dokument = worker.InsertZamowienie();
                        sess.Save();

                        Prms.SavedDocuments.Add(dokument);
                    }
                }
                catch (Exception ex) { Log.WriteLine($"{zamowienie.UUId} - {ex.Message}"); }
            }

            StoreTools.ProgressWriteLine($"Zapisywanie sesji.");
            try { Prms.Session.Save(); }
            catch (Exception ex) { throw new Exception($"Z powodu błedu przy zapisie sesji nie dodano żadnego z zamówień: {ex.Message}"); }

            if (Prms.SavedDocuments.Count > 0)
            {
                StoreTools.ProgressWriteLine($"Wysyłanie stanów pobranych zamówień.");
                List<JSONStatusZamowienia> savedZamowienia = Prms.SavedDocuments.ConvertAll(d => new JSONStatusZamowienia(d));
                HttpResponseMessage response = StoreTools.PostRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/orders/setstatus", savedZamowienia);
            }

            StringBuilder builder = new StringBuilder();
            builder.AppendLine($"Dodano zamówień: {Prms.SavedDocuments.Count}");

            if (Prms.NewKontrahets.Count > 0)
                builder.AppendLine($"Dodano kontrahentów: {Prms.NewKontrahets.Count}");

            if (HasErrors(zamowienia))
                builder.AppendLine($"Błędy przy dodawaniu dokumentów: {zamowienia.Count - Prms.SavedDocuments.Count} - Więcej informacji w Logu programu");

            return StoreTools.MBox("Synchronizacja zamówień", builder.ToString(), HasErrors(zamowienia) ? MessageBoxInformationType.Warning : MessageBoxInformationType.Information); ;
        }

        private bool HasErrors(List<JSONSynchronizujZamowienia> zamowienia)
            => zamowienia.Count - Prms.SavedDocuments.Count > 0;
    }
}