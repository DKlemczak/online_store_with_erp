using Soneta.Business;
using Soneta.Handel;
using Soneta.Towary;
using System.Collections.Generic;
using System.Linq;
using enova365.OnlineStoreWithErp.Utils;
using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using enova365.OnlineStoreWithErp.Config;

namespace enova365.OnlineStoreWithErp.Workers.AktualizujNazwyGrup
{
    public class AktualizujNazwyGrupWorker
    {
        public static object AktaulizujNazwyGrupMethod(Session session)
        {
            using (Session sess = session.Login.CreateSession(false, true))
            {
                Towar[] towary = sess.GetHandel().Towary.Towary.WgKodu.ToArray();
                List<Grupa> grupy = new EnovaConfig(sess).Grupy;

                using (ITransaction trans = sess.Logout(true))
                {
                    foreach (Towar towar in towary)
                    {
                        Grupa grupa = grupy.FirstOrDefault(g => g.Id == towar.GetGrupaId());

                        if (grupa != null)
                            towar.SetGrupa(grupa.NazwaHierarchiczna);
                    }

                    trans.CommitUI();
                }

                sess.Save();
            }

            return null;
        }
    }
}