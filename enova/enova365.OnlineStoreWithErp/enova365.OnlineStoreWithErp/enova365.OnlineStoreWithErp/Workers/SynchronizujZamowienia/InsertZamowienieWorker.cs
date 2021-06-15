using enova365.OnlineStoreWithErp.Models;
using Soneta.Business;
using Soneta.Core;
using Soneta.CRM;
using Soneta.Handel;
using Soneta.Tools;
using Soneta.Towary;
using Soneta.Types;
using System;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujZamowienia
{
    public class InsertZamowienieWorker
    {
        private DefDokHandlowego Definicja => HandelModule.DefDokHandlowych.WgSymbolu["FV"];
        private SynchronizujZamowieniaPrms Prms { get; }
        private JSONSynchronizujZamowienia Zamowienie { get; }
        private Session Session { get; }
        private CRMModule CRMModule { get; }
        private HandelModule HandelModule { get; }
        private CoreModule CoreModule { get; }

        public InsertZamowienieWorker(SynchronizujZamowieniaPrms prms, JSONSynchronizujZamowienia zamowienie, Session session)
        {
            Prms = prms;
            Zamowienie = zamowienie;
            Session = session;
            HandelModule = Session.GetHandel();
            CRMModule = Session.GetCRM();
            CoreModule = Session.GetCore();
        }

        public DokumentHandlowy InsertZamowienie()
        {
            Kontrahent kontrahent = GetOrCreateKontrahent();
            DokumentHandlowy result = CreateZk(kontrahent);
            return result;
        }

        private Kontrahent GetOrCreateKontrahent()
        {
            if (Zamowienie.User == null)
                return CRMModule.Kontrahenci.WgKodu["!INCYDENTALNY"];

            if (CRMModule.Kontrahenci.WgKodu.FirstOrDefault(k => k.EMAIL == Zamowienie.User.Email) is Kontrahent findedKontrahent)
                return findedKontrahent;

            Kontrahent kontrahent = new Kontrahent();

            using (ITransaction trans = Session.Logout(true))
            {
                CRMModule.Kontrahenci.AddRow(kontrahent);

                SetKontrahentValues(kontrahent, Zamowienie.User);

                trans.Commit();
            }

            Prms.NewKontrahets.Add(kontrahent);

            return kontrahent;
        }

        private DokumentHandlowy CreateZk(Kontrahent kontrahent)
        {
            try
            {
                if (HandelModule.DokHandlowe[Guid.Parse(Zamowienie.UUId)] != null)
                    throw new Exception($"Istnieje już dokument o Guid {Zamowienie.UUId}");
            }
            catch (Exception ex)
            {
                if (ex.Message == $"Istnieje już dokument o Guid {Zamowienie.UUId}")
                    throw ex;
            }

            DokumentHandlowy dokument = new DokumentHandlowy();

            using (ITransaction trans = Session.Logout(true))
            {
                HandelModule.DokHandlowe.AddRow(dokument);

                SetDokumentValues(dokument, Zamowienie, kontrahent);

                #region Transport

                PozycjaDokHandlowego transportPozycja = new PozycjaDokHandlowego(dokument);
                HandelModule.PozycjeDokHan.AddRow(transportPozycja);
                transportPozycja.Towar = GetOrAddUsluga(Zamowienie.Transport.Name);
                transportPozycja.Ilosc = new Quantity(1);
                transportPozycja.Cena = new Currency(Zamowienie.Transport.Price);

                #endregion Transport

                #region Sposób zapłaty

                PozycjaDokHandlowego paymentPozycja = new PozycjaDokHandlowego(dokument);
                HandelModule.PozycjeDokHan.AddRow(paymentPozycja);
                paymentPozycja.Towar = GetOrAddUsluga(Zamowienie.Payment.Name);
                paymentPozycja.Ilosc = new Quantity(1);
                paymentPozycja.Cena = new Currency(Zamowienie.Payment.Price);

                #endregion Sposób zapłaty

                foreach (JSONSynchronizujZamowienia.JSONPosition jsonPosition in Zamowienie.Positions)
                {
                    PozycjaDokHandlowego pozycja = new PozycjaDokHandlowego(dokument);
                    Session.GetHandel().PozycjeDokHan.AddRow(pozycja);

                    SetPozycjaValues(pozycja, jsonPosition);

                    double zmianaBrutto = double.Parse(pozycja.ZmianaBrutto.ToString());
                    transportPozycja.Cena = new DoubleCy(transportPozycja.Cena.Value - (zmianaBrutto - (jsonPosition.Price * jsonPosition.Amount)));
                }

                trans.CommitUI();

                if (dokument.BruttoCy.Value != decimal.Parse(Zamowienie.Value.ToString()))
                    throw new Exception($"Zsumowane pozycje dają wartość: {dokument.BruttoCy.Value}, a pobrane zamówienie posiada wartość: {Zamowienie.Value}");
            }

            return dokument;
        }

        private Towar GetOrAddUsluga(string nameToReplace)
        {
            string name = nameToReplace.Replace("\r", "").Replace("\n", "");
            if (HandelModule.Towary.Towary.WgNazwy.FirstOrDefault(t => t.Typ == TypTowaru.Usługa && t.Nazwa == name) is Towar findedUsluga)
                return findedUsluga;

            Towar usluga = new Towar();

            using (ITransaction trans = Session.Logout(true))
            {
                HandelModule.Towary.Towary.AddRow(usluga);

                usluga.Typ = TypTowaru.Usługa;
                usluga.Nazwa = name;
                usluga.DefinicjaStawki = CoreModule.DefStawekVat.WgKodu["-"];

                trans.Commit();
            }

            return usluga;
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

            dokument.Definicja = Definicja;
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
            pozycja.Towar = HandelModule.Towary.Towary[Guid.Parse(jsonPosition.ProductUUID)];
            pozycja.Ilosc = new Quantity(jsonPosition.Amount);
            pozycja.Cena = new Currency(jsonPosition.Price / (Percent.Hundred + pozycja.Towar.ProcentVAT));
        }

        #endregion Metody ustawiające wartości
    }
}