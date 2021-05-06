using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Newtonsoft.Json;
using Soneta.Business;
using Soneta.Towary;
using System.Collections.Generic;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryWorker
    {
        public static object SynchronizujTowaryMethod(Session session)
        {
            EnovaConfig config = new EnovaConfig(session);

            List<Towar> towaryList = session.GetTowary().Towary.WgKodu.ToList();

            JSONSynchronizujTowary jsonObject = new JSONSynchronizujTowary(towaryList, config.Grupy);
            string JSON = JsonConvert.SerializeObject(jsonObject);

            return StoreTools.MBox("JSON", JSON);
        }
    }
}