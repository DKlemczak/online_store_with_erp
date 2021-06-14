using Newtonsoft.Json;
using System;
using System.Collections.Generic;

namespace enova365.OnlineStoreWithErp.Models
{
    public class JSONSynchronizujZamowienia
    {
        public JSONSynchronizujZamowienia() { }

        [JsonProperty("id")]
        public int Id { get; set; }

        [JsonProperty("uuid")]
        public string UUId { get; set; }

        [JsonProperty("document_number")]
        public string DocumentNumber { get; set; }

        [JsonProperty("city")]
        public string City { get; set; }

        [JsonProperty("post_code")]
        public string PostCode { get; set; }

        [JsonProperty("street")]
        public string Street { get; set; }

        [JsonProperty("building_number")]
        public string BuildingNumber { get; set; }

        [JsonProperty("email")]
        public string Email { get; set; }

        [JsonProperty("phone_number")]
        public string PhoneNumber { get; set; }

        [JsonProperty("value")]
        public double Value { get; set; }

        [JsonProperty("transport_id")]
        public int TransportId { get; set; }

        [JsonProperty("payment_id")]
        public int PaymentId { get; set; }

        [JsonProperty("user_id")]
        public int UserId { get; set; }

        [JsonProperty("status")]
        public int Status { get; set; }

        [JsonProperty("created_at")]
        public DateTime CreatedAt { get; set; }

        [JsonProperty("positions")]
        public List<JSONPosition> Positions { get; set; }

        [JsonProperty("user")]
        public JSONUser User { get; set; }

        [JsonProperty("transport")]
        public JSONTransport Transport { get; set; }

        [JsonProperty("payment")]
        public JSONPayment Payment { get; set; }

        public class JSONPosition
        {
            [JsonProperty("id")]
            public int Id { get; set; }

            [JsonProperty("product_uuid")]
            public string ProductUUID { get; set; }

            [JsonProperty("amount")]
            public int Amount { get; set; }

            [JsonProperty("price")]
            public double Price { get; set; }

            [JsonProperty("product_id")]
            public int ProductId { get; set; }

            [JsonProperty("order_id")]
            public int OrderId { get; set; }
        }

        public class JSONUser
        {
            [JsonProperty("id")]
            public int Id { get; set; }

            [JsonProperty("name")]
            public string Name { get; set; }

            [JsonProperty("NIP")]
            public string NIP { get; set; }

            [JsonProperty("city")]
            public string City { get; set; }

            [JsonProperty("post_code")]
            public string PostCode { get; set; }

            [JsonProperty("street")]
            public string Street { get; set; }

            [JsonProperty("building_number")]
            public string BuildingNumber { get; set; }

            [JsonProperty("enova_code")]
            public string EnovaCode { get; set; }

            [JsonProperty("email")]
            public string Email { get; set; }
        }

        public class JSONTransport
        {
            [JsonProperty("id")]
            public int Id { get; set; }

            [JsonProperty("price")]
            public double Price { get; set; }

            [JsonProperty("name")]
            public string Name { get; set; }
        }

        public class JSONPayment
        {
            [JsonProperty("id")]
            public int Id { get; set; }

            [JsonProperty("price")]
            public double Price { get; set; }

            [JsonProperty("name")]
            public string Name { get; set; }
        }
    }
}