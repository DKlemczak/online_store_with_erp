using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using Soneta.Business;
using System.Collections.Generic;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Models.CustomViewInfos
{
    public class GrupaList : List<Grupa> { }

    public class GrupaViewInfo : CustomViewInfo<Grupa, GrupaList>
    {
        public GrupaViewInfo() : base("Grupa") { }

        protected override void AddNewAction(GrupaList list, ActionEventArgs args)
        {
            int newId = 1;

            foreach (Grupa grupa in list)
                if (grupa.Id >= newId)
                    newId = grupa.Id + 1;

            Grupa newGrupa = new Grupa(args.Context.Session, newId);
            list.Add(newGrupa);
            args.FocusedData = newGrupa;
        }

        protected override GrupaList NewList(Session sess)
        {
            GrupaList result = new GrupaList();
            List<Grupa> list = new EnovaConfig(sess).Grupy;
            list.ForEach(grupa => result.Add(grupa));

            return result;
        }

        protected override void Zapisz(Session sess, GrupaList list)
            => Zapisz(sess, list.ToList());

        public static void Zapisz(Session sess, List<Grupa> list)
            => new EnovaConfig(sess).Grupy = list;

        public static void Zapisz(Context cx)
        {
            GrupaViewInfo grupaViewInfo = new GrupaViewInfo();
            Zapisz(cx.Session, grupaViewInfo.GetListFromCx(cx));
        }

        public static List<Grupa> GetList(Session session)
            => new GrupaViewInfo().NewList(session).ToList();

        public static List<Grupa> GetListCx(Context cx)
            => new GrupaViewInfo().GetListFromCx(cx).ToList();

        public static void UpdateContext(Context cx, List<Grupa> list)
        {
            GrupaList resultList = new GrupaList();
            list.ForEach(g => resultList.Add(g));

            cx.Set(resultList);
        }
    }
}