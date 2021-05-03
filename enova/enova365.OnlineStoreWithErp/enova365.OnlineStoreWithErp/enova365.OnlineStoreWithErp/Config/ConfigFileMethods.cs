using Soneta.Business;
using Soneta.Tools;
using System.IO;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Config
{
    public class ConfigFileMethods
    {
        public ConfigFileMethods(Session sess) => this.Session = sess;

        public Session Session { get; }
        private const string FolderName = ConfigMethodValue.FOLDERNAME;

        private static string GetFilePath(string fileName) => $"{FolderName}/{fileName}";

        public void SetValue(string fileName, string value) => SetValue(Session, fileName, value);

        public string GetValue(string fileName, string def = "") => GetValue(Session, fileName, def);

        public static void SetValue(Session session, string fileName, string value)
        {
            try
            {
                IStorageProvider storage = session.Login.StorageProvider;
                IStorageContext storCX = storage.GetContexts(false).Where(icx => icx.Name == "Wszyscy operatorzy").FirstOrDefault();
                Stream writer = storage.GetStreamWriter(GetFilePath(fileName), storCX);

                using (StreamWriter sw = new StreamWriter(writer))
                    sw.Write(value);
            }
            catch { }
        }

        public static string GetValue(Session session, string fileName, string defaultValue = "")
        {
            try
            {
                IStorageProvider storage = session.Login.StorageProvider;
                Stream reader = storage.GetStreamReader(GetFilePath(fileName));

                using (StreamReader sr = new StreamReader(reader))
                    return sr.ReadToEnd();
            }
            catch
            {
                return defaultValue;
            }
        }
    }
}