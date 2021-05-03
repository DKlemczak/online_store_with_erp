using enova365.OnlineStoreWithErp.Models.CommitSessionModels;
using enova365.OnlineStoreWithErp.Models.CustomViewInfos;
using Newtonsoft.Json;
using Soneta.Business;
using System.Collections.Generic;

namespace enova365.OnlineStoreWithErp.Config
{
    public class EnovaConfig
    {
        public EnovaConfig(Session sess)
        {
            //ConfigMethods = new ConfigMethods(sess);
            ConfigFileMethods = new ConfigFileMethods(sess);
        }

        //private ConfigMethods ConfigMethods { get; }
        private ConfigFileMethods ConfigFileMethods { get; }

        #region Grupy

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

        #endregion Grupy
    }
}