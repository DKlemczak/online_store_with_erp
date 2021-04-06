using enova365.OnlineStoreWithErp.UI.ExtViews;
using Soneta.Business;

[assembly: Worker(typeof(TowarExtView))]

namespace enova365.OnlineStoreWithErp.UI.ExtViews
{
    public class TowarExtView : ContextBase
    {
        public TowarExtView(Context cx) : base(cx) { }

        public string Komunikat { get; set; } = "W tym miejscu będzie widok cech z możliwością ich edycji.";
    }
}