using Soneta.Business.UI;
using System;
using System.Diagnostics;

namespace enova365.OnlineStoreWithErp.Utils
{
    public static class StoreTools
    {
        public static MessageBoxInformation MBox(string caption, string text, MessageBoxInformationType type = MessageBoxInformationType.Information)
            => new MessageBoxInformation(caption, text) { Type = type };

        public static MessageBoxInformation ExceptionMBox(Exception ex)
            => MBox("Błąd walidacji",
                ex.Message + (ex.InnerException != null ? $"{Environment.NewLine}{ex.InnerException.Message}" : ""),
                MessageBoxInformationType.Error);

        public static void ProgressWrite(string text) => Trace.Write(text, "Progress");

        public static void ProgressWriteLine(string text) => Trace.WriteLine(text, "Progress");

        public static void ProgressBar(double counter, double count) => Trace.WriteLine(GetPercent(counter, count), "Progress");

        private static int GetPercent(double counter, double count) => (int)(counter / count * 100d);
    }
}