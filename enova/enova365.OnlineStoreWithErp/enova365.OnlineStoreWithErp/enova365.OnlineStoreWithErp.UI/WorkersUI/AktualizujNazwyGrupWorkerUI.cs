using enova365.OnlineStoreWithErp.UI.WorkersUI;
using enova365.OnlineStoreWithErp.Workers.AktualizujNazwyGrup;
using Soneta.Business;
using Soneta.Towary;
using System;

[assembly: Worker(typeof(AktualizujNazwyGrupWorkerUI), typeof(Towary))]

namespace enova365.OnlineStoreWithErp.UI.WorkersUI
{
    public class AktualizujNazwyGrupWorkerUI : ContextBase
    {
        public AktualizujNazwyGrupWorkerUI(Context cx) : base(cx) { }

        [Action("Aktualizuj nazwy grup",
            Description = "",
            Mode = ActionMode.SingleSession | ActionMode.OnlyTable,
            Target = ActionTarget.Menu | ActionTarget.LocalMenu | ActionTarget.ToolbarWithText,
            Icon = ActionIcon.Wizard,
            Priority = 11)]
        public object AktaulizujNazwyGrupUIMethod()
            => AktualizujNazwyGrupWorker.AktaulizujNazwyGrupMethod(Session);
    }
}