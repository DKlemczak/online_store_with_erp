using Newtonsoft.Json;
using Soneta.Business.UI;
using System;
using System.Diagnostics;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

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

        public static HttpResponseMessage GetRequest(string token, string url, string apiAddress)
        {
            using (HttpClient client = new HttpClient())
            {
                client.DefaultRequestHeaders.Add("Authorization", "Bearer " + token);

                Uri address = new Uri(new Uri(url), apiAddress);

                Task<HttpResponseMessage> task = Task.Run(async () => await client.GetAsync(address));
                task.Wait();
                return task.Result;
            }
        }

        public static string GetStringRequest(string token, string url, string apiAddress)
            => StringFromHttpResponseMessage(GetRequest(token, url, apiAddress));

        public static string StringFromHttpResponseMessage(HttpResponseMessage response)
        {
            Task<string> stringTask = Task.Run(async () => await response.Content.ReadAsStringAsync());
            stringTask.Wait();
            return stringTask.Result;
        }

        public static HttpResponseMessage PostRequest(string token, string url, string apiAddress, object sendingObject)
        {
            string json = JsonConvert.SerializeObject(sendingObject);

            using (HttpClient client = new HttpClient())
            {
                client.DefaultRequestHeaders.Add("Authorization", "Bearer " + token);

                Uri address = new Uri(new Uri(url), apiAddress);

                Task<HttpResponseMessage> task = Task.Run(async () => await client.PostAsync(address, new StringContent(json)));
                task.Wait();
                return task.Result;
            }
        }
    }
}