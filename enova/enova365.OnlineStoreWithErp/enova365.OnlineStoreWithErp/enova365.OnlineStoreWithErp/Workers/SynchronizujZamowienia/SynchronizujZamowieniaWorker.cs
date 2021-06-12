using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Newtonsoft.Json;
using Soneta.Business;
using Soneta.CRM;
using Soneta.Handel;
using Soneta.Tools;
using Soneta.Towary;
using Soneta.Types;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujZamowienia
{
    public class SynchronizujZamowieniaWorker
    {
        private Log Log => new Log("Synchronizacja zamówień", true);
        public SynchronizujZamowieniaPrms Prms { get; }

        private SynchronizujZamowieniaWorker(SynchronizujZamowieniaPrms prms) => Prms = prms;

        public static object SynchronizujZamowienia(Context context)
        {
            using (Session sess = context.Session.Login.CreateSession(false, true))
            {
                SynchronizujZamowieniaPrms prms = new SynchronizujZamowieniaPrms(sess, context);
                SynchronizujZamowieniaWorker worker = new SynchronizujZamowieniaWorker(prms);

                return worker.SynchronizujZamowienia();
            }
        }

        private object SynchronizujZamowienia()
        {
            try { new SynchronizujZamowieniaValidation(Prms).Validate(); }
            catch (Exception ex) { return StoreTools.ExceptionMBox(ex); }

            string zamowieniaJson = StoreTools.GetStringRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/orders");

            List<JSONSynchronizujZamowienia> zamowienia = JsonConvert.DeserializeObject<List<JSONSynchronizujZamowienia>>(zamowieniaJson);

            foreach (JSONSynchronizujZamowienia zamowienie in zamowienia.OrderBy(z => z.CreatedAt))
            {
                try
                {
                    Kontrahent kontrahent = GetOrCreateKontrahent(zamowienie);
                    DokumentHandlowy dokument = CreateZk(zamowienie, kontrahent);

                    Prms.SavedDocuments.Add(dokument);
                }
                catch (Exception ex) { Log.WriteLine($"{zamowienie.UUId} - {ex.Message}"); }
            }

            try { Prms.Session.Save(); }
            catch (Exception ex) { throw new Exception($"Z powodu błedu przy zapisie sesji nie dodano żadnego z zamówień: {ex.Message}"); }

            if (Prms.SavedDocuments.Count > 0)
            {
                List<JSONStatusZamowienia> savedZamowienia = Prms.SavedDocuments.ConvertAll(d => new JSONStatusZamowienia(d));
                HttpResponseMessage response = StoreTools.PostRequest(Prms.WebServiceToken, Prms.WebServiceAddress, "api/orders/setstatus", savedZamowienia);
            }

            return null;
        }

        private Kontrahent GetOrCreateKontrahent(JSONSynchronizujZamowienia zamowienie)
        {
            if (Prms.CRMModule.Kontrahenci.WgKodu.FirstOrDefault(k => k.EMAIL == zamowienie.Email) is Kontrahent findedKontrahent)
                return findedKontrahent;

            Kontrahent kontrahent = new Kontrahent();

            using (ITransaction trans = Prms.Session.Logout(true))
            {
                Prms.CRMModule.Kontrahenci.AddRow(kontrahent);

                SetKontrahentValues(kontrahent, zamowienie);

                trans.Commit();
            }

            return kontrahent;
        }

        private DokumentHandlowy CreateZk(JSONSynchronizujZamowienia zamowienie, Kontrahent kontrahent)
        {
            try
            {
                if (Prms.HandelModule.DokHandlowe[Guid.Parse(zamowienie.UUId)] != null)
                    throw new Exception($"Istnieje już dokument o Guid {zamowienie.UUId}");
            }
            catch (Exception ex)
            {
                if (ex.Message == $"Istnieje już dokument o Guid {zamowienie.UUId}")
                    throw ex;
            }

            DokumentHandlowy dokument = new DokumentHandlowy();

            using (ITransaction trans = Prms.Session.Logout(true))
            {
                Prms.HandelModule.DokHandlowe.AddRow(dokument);

                SetDokumentValues(dokument, zamowienie, kontrahent);

                foreach (JSONSynchronizujZamowienia.JSONPosition jsonPosition in zamowienie.Positions)
                {
                    PozycjaDokHandlowego pozycja = new PozycjaDokHandlowego(dokument);
                    Prms.HandelModule.PozycjeDokHan.AddRow(pozycja);

                    SetPozycjaValues(pozycja, jsonPosition);
                }

                trans.CommitUI();
            }

            return dokument;
        }

        #region Metody ustawiające wartości

        private void SetKontrahentValues(Kontrahent kontrahent, JSONSynchronizujZamowienia zamowienie)
        {
            kontrahent.Nazwa = zamowienie.User.Name;
            kontrahent.EMAIL = zamowienie.Email;
            kontrahent.Adres.Miejscowosc = zamowienie.User.City.IsNullOrEmpty() ? "" : zamowienie.User.City;
            kontrahent.Adres.KodPocztowyS = zamowienie.User.PostCode.IsNullOrEmpty() ? "" : zamowienie.User.PostCode;
            kontrahent.Adres.Ulica = zamowienie.User.Street.IsNullOrEmpty() ? "" : zamowienie.User.Street;
            kontrahent.EuVAT = zamowienie.User.NIP.IsNullOrEmpty() ? "" : zamowienie.User.NIP;

            if (zamowienie.User.BuildingNumber.IsNullOrEmpty() == false)
            {
                string[] domLokal = zamowienie.User.BuildingNumber.Split('/');
                kontrahent.Adres.NrDomu = domLokal[0].IsNullOrEmpty() ? "" : domLokal[0];
                kontrahent.Adres.NrLokalu = domLokal.Count() == 1 ? "" : domLokal[1];
            }
        }

        private void SetDokumentValues(DokumentHandlowy dokument, JSONSynchronizujZamowienia zamowienie, Kontrahent kontrahent)
        {
            dokument.Guid = new Guid(zamowienie.UUId);

            dokument.Definicja = Prms.Definicja;
            dokument.Magazyn = Prms.Magazyn;
            dokument.Kontrahent = kontrahent;

            dokument.Data = zamowienie.CreatedAt.Date;
            dokument.Czas = new Time(zamowienie.CreatedAt.TimeOfDay.Hours, zamowienie.CreatedAt.TimeOfDay.Minutes);

            string[] domLokal = zamowienie.BuildingNumber.Split('/');
            dokument.DaneKontrahenta.Adres.Miejscowosc = zamowienie.City;
            dokument.DaneKontrahenta.Adres.KodPocztowyS = zamowienie.PostCode;
            dokument.DaneKontrahenta.Adres.Ulica = zamowienie.Street;
            dokument.DaneKontrahenta.Adres.NrDomu = domLokal[0];
            dokument.DaneKontrahenta.Adres.NrLokalu = domLokal.Count() == 1 ? "" : domLokal[1];

            dokument.DaneOdbiorcy.Adres.Miejscowosc = zamowienie.City;
            dokument.DaneOdbiorcy.Adres.KodPocztowyS = zamowienie.PostCode;
            dokument.DaneOdbiorcy.Adres.Ulica = zamowienie.Street;
            dokument.DaneOdbiorcy.Adres.NrDomu = domLokal[0];
            dokument.DaneOdbiorcy.Adres.NrLokalu = domLokal.Count() == 1 ? "" : domLokal[1];
        }

        private void SetPozycjaValues(PozycjaDokHandlowego pozycja, JSONSynchronizujZamowienia.JSONPosition jsonPosition)
        {
            pozycja.Towar = Prms.HandelModule.Towary.Towary[Guid.Parse(jsonPosition.ProductUUID)];
            pozycja.Ilosc = new Quantity(jsonPosition.Amount);
            pozycja.Cena = new Currency(jsonPosition.Price / (Percent.Hundred + pozycja.Towar.ProcentVAT));
        }

        #endregion Metody ustawiające wartości
    }
}