using Soneta.Business;
using Soneta.Towary;
using System.Linq;
using enova365.OnlineStoreWithErp.Utils;
using enova365.OnlineStoreWithErp.Models.CommitSessionModels;

namespace enova365.OnlineStoreWithErp.Workers.AktualizujNazwyGrup
{
    public class AktualizujNazwyGrupWorker
    {
        public AktualizujNazwyGrupPrms Prms { get; }

        private AktualizujNazwyGrupWorker(AktualizujNazwyGrupPrms prms) => Prms = prms;

        public static void AktaulizujNazwyGrupMethod(Session session)
        {
            using (Session sess = session.Login.CreateSession(false, true))
            {
                AktualizujNazwyGrupPrms prms = new AktualizujNazwyGrupPrms(sess);
                AktualizujNazwyGrupWorker worker = new AktualizujNazwyGrupWorker(prms);

                worker.AktaulizujNazwyGrupMethod();
            }
        }

        public void AktaulizujNazwyGrupMethod()
        {
            using (ITransaction trans = Prms.Session.Logout(true))
            {
                foreach (Towar towar in Prms.Towary)
                    if (Prms.Grupy.FirstOrDefault(g => g.Id == towar.GetGrupaId()) is Grupa grupa)
                        towar.SetGrupa(grupa.NazwaHierarchiczna);

                trans.CommitUI();
            }

            Prms.Session.Save();
        }
    }
}