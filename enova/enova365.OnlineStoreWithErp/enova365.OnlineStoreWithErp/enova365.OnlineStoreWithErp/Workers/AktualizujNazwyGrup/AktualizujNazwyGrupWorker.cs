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

                UpdateNameOfGrups(sess, towary, grupy);

                sess.Save();
            }

            return null;
        }

        private static void UpdateNameOfGrups(Session sess, Towar[] towary, List<Grupa> grupy)
        {
            using (ITransaction trans = sess.Logout(true))
            {
                towary.ToList().ForEach(t => UpdateGroup(grupy, t));

                trans.CommitUI();
            }
        }

        private static void UpdateGroup(List<Grupa> list, Towar towar)
        {
            if (list.FirstOrDefault(g => g.Id == towar.GetGrupaId()) is Grupa grupa)
                towar.SetGrupa(grupa.NazwaHierarchiczna);
        }
    }
}