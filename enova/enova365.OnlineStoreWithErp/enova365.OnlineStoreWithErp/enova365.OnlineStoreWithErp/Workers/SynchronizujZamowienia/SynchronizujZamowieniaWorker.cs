using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Newtonsoft.Json;
using Soneta.Business;
using Soneta.Business.UI;
using Soneta.CRM;
using Soneta.Forms;
using Soneta.Handel;
using Soneta.Tools;
using Soneta.Towary;
using Soneta.Types;
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
        public SynchronizujZamowieniaPrms Prms { get; }

        private SynchronizujZamowieniaWorker(SynchronizujZamowieniaPrms prms) => Prms = prms;

        public static object SynchronizujZamowienia(Context context)
        {
            Progress progress = new Progress(false, false, $"Synchronizacja zamówień...");

            try
            {
                using (Session sess = context.Session.Login.CreateSession(false, true))
                {
                    SynchronizujZamowieniaPrms prms = new SynchronizujZamowieniaPrms(sess, context);
                    SynchronizujZamowieniaWorker worker = new SynchronizujZamowieniaWorker(prms);

                    return worker.SynchronizujZamowienia();
                }
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
                    Kontrahent kontrahent = GetOrCreateKontrahent(zamowienie);
                    DokumentHandlowy dokument = CreateZk(zamowienie, kontrahent);

                    Prms.SavedDocuments.Add(dokument);
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

        private Kontrahent GetOrCreateKontrahent(JSONSynchronizujZamowienia zamowienie)
        {
            if (zamowienie.User == null)
                return Prms.CRMModule.Kontrahenci.WgKodu["!INCYDENTALNY"];

            if (Prms.CRMModule.Kontrahenci.WgKodu.FirstOrDefault(k => k.EMAIL == zamowienie.User.Email) is Kontrahent findedKontrahent)
                return findedKontrahent;

            Kontrahent kontrahent = new Kontrahent();

            using (ITransaction trans = Prms.Session.Logout(true))
            {
                Prms.CRMModule.Kontrahenci.AddRow(kontrahent);

                SetKontrahentValues(kontrahent, zamowienie.User);

                trans.Commit();
            }

            Prms.NewKontrahets.Add(kontrahent);

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

                #region Transport

                PozycjaDokHandlowego transportPozycja = new PozycjaDokHandlowego(dokument);
                Prms.HandelModule.PozycjeDokHan.AddRow(transportPozycja);
                transportPozycja.Towar = GetOrAddUsluga(zamowienie.Transport.Name);
                transportPozycja.Ilosc = new Quantity(1);
                transportPozycja.Cena = new Currency(zamowienie.Transport.Price / (Percent.Hundred + transportPozycja.Towar.ProcentVAT));

                #endregion Transport

                #region Sposób zapłaty

                PozycjaDokHandlowego paymentPozycja = new PozycjaDokHandlowego(dokument);
                Prms.HandelModule.PozycjeDokHan.AddRow(paymentPozycja);
                paymentPozycja.Towar = GetOrAddUsluga(zamowienie.Payment.Name);
                paymentPozycja.Ilosc = new Quantity(1);
                paymentPozycja.Cena = new Currency(zamowienie.Payment.Price / (Percent.Hundred + paymentPozycja.Towar.ProcentVAT));

                #endregion Sposób zapłaty

                foreach (JSONSynchronizujZamowienia.JSONPosition jsonPosition in zamowienie.Positions)
                {
                    PozycjaDokHandlowego pozycja = new PozycjaDokHandlowego(dokument);
                    Prms.HandelModule.PozycjeDokHan.AddRow(pozycja);

                    SetPozycjaValues(pozycja, jsonPosition);
                }

                if (ValueOfFV(dokument) != decimal.Parse(zamowienie.Value.ToString()))
                    throw new Exception($"Zsumowane pozycje dają wartość: {ValueOfFV(dokument)}, a pobrane zamówienie posiada wartość: {zamowienie.Value}");

                trans.CommitUI();
            }

            return dokument;
        }

        private Towar GetOrAddUsluga(string name)
        {
            RowCondition cond = new FieldCondition.Equal(nameof(Towar.Typ), TypTowaru.Usługa);
            if (Prms.HandelModule.Towary.Towary.WgNazwy[name][cond].FirstOrDefault() is Towar findedUsluga)
                return findedUsluga;

            Towar usluga = new Towar();

            using (ITransaction trans = Prms.Session.Logout(true))
            {
                Prms.HandelModule.Towary.Towary.AddRow(usluga);

                usluga.Nazwa = name;

                trans.Commit();
            }

            return usluga;
        }

        private decimal ValueOfFV(DokumentHandlowy dokument)
        {
            return dokument.Pozycje.Sum(p => p.WartoscCy.Value);
        }

        #region Metody ustawiające wartości

        private void SetKontrahentValues(Kontrahent kontrahent, JSONSynchronizujZamowienia.JSONUser user)
        {
            kontrahent.Nazwa = user.Name;
            kontrahent.EMAIL = user.Email;
            kontrahent.Adres.Miejscowosc = user.City.IsNullOrEmpty() ? "" : user.City;
            kontrahent.Adres.KodPocztowyS = user.PostCode.IsNullOrEmpty() ? "" : user.PostCode;
            kontrahent.Adres.Ulica = user.Street.IsNullOrEmpty() ? "" : user.Street;
            kontrahent.EuVAT = user.NIP.IsNullOrEmpty() ? "" : user.NIP;

            if (user.BuildingNumber.IsNullOrEmpty() == false)
            {
                string[] domLokal = user.BuildingNumber.Split('/');
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

            dokument.Opis = $"Email: {zamowienie.Email}{Environment.NewLine}Telefon: {zamowienie.PhoneNumber}";
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