using enova365.OnlineStoreWithErp.UI.WorkersUI;
using enova365.OnlineStoreWithErp.Workers.SynchronizujZamowienia;
using Soneta.Business;
using Soneta.Handel;
using System;

[assembly: Worker(typeof(SynchronizujZamowieniaWorkerUI), typeof(DokHandlowe))]

namespace enova365.OnlineStoreWithErp.UI.WorkersUI
{
    public class SynchronizujZamowieniaWorkerUI : ContextBase
    {
        public SynchronizujZamowieniaWorkerUI(Context cx) : base(cx) { }

        [Action("Synchronizuj zamówienia",
            Description = "",
            Mode = ActionMode.SingleSession | ActionMode.OnlyTable,
            Target = ActionTarget.Menu | ActionTarget.LocalMenu | ActionTarget.ToolbarWithText,
            Icon = ActionIcon.Wizard,
            Priority = 11)]
        public object SynchronizujZamowieniaUIMethod()
            => SynchronizujZamowieniaWorker.SynchronizujZamowienia(Context);
    }
}