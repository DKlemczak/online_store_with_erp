using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using enova365.OnlineStoreWithErp.Utils;
using Soneta.Towary;
using System.Collections.Generic;
using System.Linq;
using Newtonsoft.Json;

namespace enova365.OnlineStoreWithErp.Models
{
    public class JSONSynchronizujTowary
    {
        public JSONSynchronizujTowary() { }

        public JSONSynchronizujTowary(List<Towar> towary, List<Grupa> grupy)
        {
            Towary = towary.ConvertAll(t => new JSONTowar(t, grupy));
            Grupy = grupy.ConvertAll(g => new JSONGrupa(g));
        }

        public List<JSONTowar> Towary { get; set; }

        public List<JSONGrupa> Grupy { get; set; }

        //[JsonArray(Description = "products")]
        public class JSONTowar
        {
            public JSONTowar() { }

            public JSONTowar(Towar towar, List<Grupa> grupy)
            {
                Nazwa = towar.Nazwa;
                UUID = towar.ID.ToString();
                Kod = towar.Kod;
                Ilosc = towar.Zasoby.Sum(z => z.Ilosc.Value);
                Cena = 0;
                Opis = towar.GetOpis();
                CzyAktywny = towar.GetIsActive();
                Przecena = "";

                Grupa grupa = grupy.FirstOrDefault(g => g.Id == towar.GetGrupaId());

                if (grupa != null)
                {
                    IdGrupy = grupa.Id;
                    GroupName = grupa.Nazwa;
                }
            }

            [JsonProperty("name")]
            public string Nazwa { get; set; }

            [JsonProperty("uuid")]
            public string UUID { get; set; }

            [JsonProperty("code")]
            public string Kod { get; set; }

            [JsonProperty("amount")]
            public double Ilosc { get; set; }

            [JsonProperty("price")]
            public double Cena { get; set; }

            [JsonProperty("description")]
            public string Opis { get; set; }

            [JsonProperty("is_active")]
            public bool CzyAktywny { get; set; }

            [JsonProperty("group_id")]
            public int IdGrupy { get; set; }

            [JsonProperty("group_name")]
            public string GroupName { get; set; }

            [JsonProperty("discount")]
            public string Przecena { get; set; }
        }

        public class JSONGrupa
        {
            public JSONGrupa() { }

            public JSONGrupa(Grupa grupa)
            {
                Id = grupa.Id;
                Nazwa = grupa.Nazwa;
                WMenu = grupa.WMenu;
                ParentId = grupa.ParentId;

                ParentName = grupa.ParentGrupa != null ? grupa.ParentGrupa.Nazwa : "";
            }

            [JsonProperty("id")]
            public int Id { get; set; }

            [JsonProperty("name")]
            public string Nazwa { get; set; }

            [JsonProperty("on_navbar")]
            public bool WMenu { get; set; }

            [JsonProperty("parent_group_id")]
            public int ParentId { get; set; }

            [JsonProperty("parent_group_name")]
            public string ParentName { get; set; }
        }
    }
}