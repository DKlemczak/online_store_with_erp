using Soneta.Business;
using Soneta.Config;

namespace enova365.OnlineStoreWithErp.Config
{
    public class ConfigMethods
    {
        public ConfigMethods(Session sess) => this.Session = sess;

        public Session Session { get; }

        private const string Prefix = ConfigMethodValue.PREFIX;
        private const string SubNode = ConfigMethodValue.SUBNODE;

        public void SetValue<T>(string name, T value, AttributeType type) => SetValue(Session, name, value, type);

        public T GetValue<T>(string name, T def) => GetValue(Session, name, def);

        public static void SetValue<T>(Session session, string name, T value, AttributeType type)
        {
            using (ITransaction trans = session.Logout(true))
            {
                CfgManager cfgManager = new CfgManager(session);
                //wyszukiwanie gałęzi głównej
                CfgNode node1 = cfgManager.Root.FindSubNode(Prefix, false) ?? cfgManager.Root.AddNode(Prefix, CfgNodeType.Node);

                //wyszukiwanie liścia
                CfgNode node2 = node1.FindSubNode(SubNode, false) ?? node1.AddNode(SubNode, CfgNodeType.Leaf);

                //wyszukiwanie wartosci atrybutu w liściu
                CfgAttribute attr = node2.FindAttribute(name, false);

                if (attr == null)
                    node2.AddAttribute(name, type, value);
                else
                    attr.Value = value;

                trans.CommitUI();
            }
        }

        public static T GetValue<T>(Session session, string name, T defaultValue)
        {
            CfgManager cfgManager = new CfgManager(session);

            CfgNode node1 = cfgManager.Root.FindSubNode(Prefix, false);

            //Jeśli nie znaleziono gałęzi, zwracamy wartosć domyślną
            if (node1 == null)
                return defaultValue;

            CfgNode node2 = node1.FindSubNode(SubNode, false);
            if (node2 == null)
                return defaultValue;

            CfgAttribute attr = node2.FindAttribute(name, false);
            if (attr == null || attr.Value == null)
                return defaultValue;

            return (T)attr.Value;
        }
    }
}