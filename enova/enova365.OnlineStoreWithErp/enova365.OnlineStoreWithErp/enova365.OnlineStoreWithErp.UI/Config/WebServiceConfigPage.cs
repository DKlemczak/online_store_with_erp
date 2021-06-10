using enova365.OnlineStoreWithErp.Config;
using enova365.OnlineStoreWithErp.UI.Config;
using Soneta.Business;

[assembly: Worker(typeof(WebServiceConfigPage))]

namespace enova365.OnlineStoreWithErp.UI.Config
{
    public class WebServiceConfigPage : ContextBase
    {
        public WebServiceConfigPage(Context cx) : base(cx) => EnovaConfig = new EnovaConfig(cx.Session);

        private EnovaConfig EnovaConfig { get; }

        public string WebServiceAddress
        {
            get => EnovaConfig.WebServiceAddress;
            set => EnovaConfig.WebServiceAddress = value;
        }

        public string WebServiceToken
        {
            get => EnovaConfig.WebServiceToken;
            set => EnovaConfig.WebServiceToken = value;
        }
    }
}