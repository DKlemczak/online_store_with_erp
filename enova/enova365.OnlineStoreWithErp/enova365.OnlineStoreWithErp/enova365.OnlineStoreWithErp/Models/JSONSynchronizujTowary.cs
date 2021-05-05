using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using enova365.OnlineStoreWithErp.Utils;
using Soneta.Towary;
using System.Collections.Generic;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Models
{
    public class JSONSynchronizujTowary
    {
        public JSONSynchronizujTowary() { }

        public JSONSynchronizujTowary(List<Towar> towary, List<Grupa> grupy)
        {
            Towary = towary.ConvertAll(t => new JSONTowar(t));
            Grupy = grupy.ConvertAll(g => new JSONGrupa(g));
        }

        public List<JSONTowar> Towary { get; set; }
        public List<JSONGrupa> Grupy { get; set; }

        public class JSONTowar
        {
            public JSONTowar() { }

            public JSONTowar(Towar towar)
            {
                Nazwa = towar.Nazwa;
                UUID = towar.ID.ToString();
                Kod = towar.Kod;
                Ilosc = towar.Zasoby.Sum(z => z.Ilosc.Value);
                Cena = 0;
                Opis = towar.GetOpis();
                CzyAktywny = towar.GetIsActive();
                IdGrupy = towar.GetGrupaId();
                Przecena = "";
            }

            public string Nazwa { get; set; }
            public string UUID { get; set; }
            public string Kod { get; set; }
            public double Ilosc { get; set; }
            public double Cena { get; set; }
            public string Opis { get; set; }
            public bool CzyAktywny { get; set; }
            public int IdGrupy { get; set; }
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
            }

            public int Id { get; set; }
            public string Nazwa { get; set; }
            public bool WMenu { get; set; }
            public int ParentId { get; set; }
        }
    }
}