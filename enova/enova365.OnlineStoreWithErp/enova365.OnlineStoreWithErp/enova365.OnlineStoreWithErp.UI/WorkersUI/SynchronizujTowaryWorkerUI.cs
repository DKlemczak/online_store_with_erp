using enova365.OnlineStoreWithErp.UI.WorkersUI;
using enova365.OnlineStoreWithErp.Workers;
using Soneta.Business;
using Soneta.Towary;
using System;

[assembly: Worker(typeof(SynchronizujTowaryWorkerUI), typeof(Towary))]

namespace enova365.OnlineStoreWithErp.UI.WorkersUI
{
    public class SynchronizujTowaryWorkerUI : ContextBase
    {
        public SynchronizujTowaryWorkerUI(Context cx) : base(cx) { }

        [Context]
        public Towar[] Towary { get; set; }

        [Action("Synchronizuj towary",
            Description = "",
            Mode = ActionMode.SingleSession | ActionMode.OnlyTable,
            Target = ActionTarget.Menu | ActionTarget.LocalMenu | ActionTarget.ToolbarWithText,
            Icon = ActionIcon.Wizard,
            Priority = 11)]
        public object SynchronizujTowaryUIMethod()
            => SynchronizujTowaryWorker.SynchronizujTowaryMethod(Towary);
    }
}