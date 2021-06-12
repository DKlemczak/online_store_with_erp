using Newtonsoft.Json;
using Soneta.Handel;

namespace enova365.OnlineStoreWithErp.Models
{
    public class JSONStatusZamowienia
    {
        public JSONStatusZamowienia() { }

        public JSONStatusZamowienia(DokumentHandlowy dokument)
        {
            UUId = dokument.Guid.ToString();
            DocumentNumber = dokument.Numer.ToString();
        }

        [JsonProperty("uuid")]
        public string UUId { get; set; }

        [JsonProperty("document_number")]
        public string DocumentNumber { get; set; }
    }
}