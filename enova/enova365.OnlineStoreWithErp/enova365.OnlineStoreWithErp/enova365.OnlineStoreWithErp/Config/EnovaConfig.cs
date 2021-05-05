using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using enova365.OnlineStoreWithErp.Models.CustomViewInfos;
using enova365.OnlineStoreWithErp.Utils;
using Newtonsoft.Json;
using Soneta.Business;
using Soneta.Business.Db;
using System.Collections.Generic;
using System.Linq;

namespace enova365.OnlineStoreWithErp.Config
{
    public class EnovaConfig
    {
        public EnovaConfig(Session sess)
        {
            Session = sess;
            ConfigFileMethods = new ConfigFileMethods(Session);
            //ConfigMethods = new ConfigMethods(Session);
        }

        //private ConfigMethods ConfigMethods { get; }

        private ConfigFileMethods ConfigFileMethods { get; }
        private Session Session { get; }

        public List<Grupa> Grupy
        {
            get
            {
                string JSON = ConfigFileMethods.GetValue(ConfPropName.Grupy, JsonConvert.SerializeObject(new List<JSONGrupa>()));
                List<JSONGrupa> jsonList = JsonConvert.DeserializeObject<List<JSONGrupa>>(JSON);

                return jsonList.ConvertAll(jsonGrupa => new Grupa(ConfigFileMethods.Session, jsonGrupa));
            }
            set
            {
                List<JSONGrupa> jsonList = value.ConvertAll(grupa => new JSONGrupa(grupa));

                string JSON = JsonConvert.SerializeObject(jsonList);
                ConfigFileMethods.SetValue(ConfPropName.Grupy, JSON);
            }
        }

        public ViewInfo CreateGrupyViewInfo() => new GrupaViewInfo().CreateViewInfo();

        public void UpdateDictionaryItems()
        {
            string dictionaryCategory = FeatureName.Towary.DictionaryGrupa;

            using (Session sess = Session.Login.CreateSession(false, true))
            {
                BusinessModule businessModule = sess.GetBusiness();

                using (ITransaction trans = sess.Logout(true))
                {
                    foreach (DictionaryItem dItem in businessModule.Dictionary.WgDataContext[null, dictionaryCategory])
                        try
                        {
                            dItem.Delete();
                        }
                        catch { }

                    List<Grupa> grupaList = Grupy;

                    for (int level = 0; true; level++)
                    {
                        List<Grupa> grupaParentList = grupaList.Where(g => g.ParentLevel == level).ToList();

                        if (grupaParentList.Count == 0)
                            break;

                        foreach (Grupa grupa in grupaParentList)
                        {
                            DictionaryItem newItem = new DictionaryItem(dictionaryCategory, grupa.Id);
                            businessModule.Dictionary.AddRow(newItem);
                            newItem.Value = grupa.Nazwa;

                            if (level > 0)
                                newItem.Parent = businessModule.Dictionary.WgDataContext[null, dictionaryCategory].FirstOrDefault(g => g.Value == grupa.ParentGrupa.Nazwa);
                        }
                    }

                    trans.Commit();
                }

                sess.Save();
            }
        }
    }
}