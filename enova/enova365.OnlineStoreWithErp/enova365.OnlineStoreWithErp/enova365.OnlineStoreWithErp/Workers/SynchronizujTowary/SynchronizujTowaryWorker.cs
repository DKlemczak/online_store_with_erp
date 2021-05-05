using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Newtonsoft.Json;
using Soneta.Business;
using Soneta.Towary;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryWorker
    {
        public static object SynchronizujTowaryMethod(Context context, Towar[] towary)
        {
            EnovaConfig config = new EnovaConfig(context.Session);

            JSONSynchronizujTowary jsonObject = new JSONSynchronizujTowary(towary.ToList(), config.Grupy);
            string JSON = JsonConvert.SerializeObject(jsonObject);

            return StoreTools.MBox("JSON", JSON);
        }
    }
}