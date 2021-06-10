using enova365.OnlineStoreWithErp.Models;
using enova365.OnlineStoreWithErp.Utils;
using Newtonsoft.Json;
using Soneta.Business;
using Soneta.Towary;
using System;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;

namespace enova365.OnlineStoreWithErp.Workers.SynchronizujTowary
{
    public class SynchronizujTowaryWorker
    {
        public SynchronizujTowaryPrms Prms { get; }

        private SynchronizujTowaryWorker(SynchronizujTowaryPrms prms) => Prms = prms;

        public static object SynchronizujTowaryMethod(Session session)
        {
            SynchronizujTowaryPrms prms = new SynchronizujTowaryPrms(session, session.GetTowary().Towary.WgKodu);
            SynchronizujTowaryWorker worker = new SynchronizujTowaryWorker(prms);

            return worker.SynchronizujTowary();
        }

        private object SynchronizujTowary()
        {
            try { SynchronizujTowaryValidation.Validate(this); }
            catch (Exception ex) { return StoreTools.ExceptionMBox(ex); }

            JSONSynchronizujTowary jsonObject = new JSONSynchronizujTowary(Prms.Towary, Prms.Grupy);

            if (PostRequest(jsonObject.Grupy, "api/productsgroup").IsSuccessStatusCode == false)
                throw new Exception();

            if (PostRequest(jsonObject.Towary, "api/products").IsSuccessStatusCode == false)
                throw new Exception();

            return null;
        }

        private HttpResponseMessage PostRequest(object sendingObject, string apiAddress)
        {
            string json = JsonConvert.SerializeObject(sendingObject);

            using (HttpClient client = new HttpClient())
            {
                client.DefaultRequestHeaders.Add("Authorization", "Bearer " + Prms.WebServiceToken);

                Uri address = new Uri(new Uri(Prms.WebServiceAddress), apiAddress);

                Task<HttpResponseMessage> task = Task.Run(async ()
                    => await client.PostAsync(address, new StringContent(json, Encoding.UTF8, apiAddress)));
                task.Wait();
                return task.Result;
            }
        }

        //private string StringFromHttpResponseMessage(HttpResponseMessage response)
        //{
        //    Task<string> stringTask = Task.Run(async () => await response.Content.ReadAsStringAsync());
        //    stringTask.Wait();
        //    return stringTask.Result;
        //}
    }
}