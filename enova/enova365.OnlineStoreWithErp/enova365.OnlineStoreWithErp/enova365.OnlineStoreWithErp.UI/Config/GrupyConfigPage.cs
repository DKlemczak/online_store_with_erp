using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.UI.Config;
using Soneta.Business;

[assembly: Worker(typeof(GrupyConfigPage))]

namespace enova365.OnlineStoreWithErp.UI.Config
{
    public class GrupyConfigPage : ContextBase
    {
        public GrupyConfigPage(Context cx) : base(cx) => EnovaConfig = new EnovaConfig(cx.Session);

        private EnovaConfig EnovaConfig { get; }

        public ViewInfo Grupy => EnovaConfig.CreateGrupyViewInfo();
    }
}