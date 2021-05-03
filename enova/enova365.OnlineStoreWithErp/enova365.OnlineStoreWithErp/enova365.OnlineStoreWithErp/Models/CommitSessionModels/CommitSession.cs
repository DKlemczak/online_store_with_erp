using Soneta.Business;
using Soneta.Business.UI;

namespace enova365.OnlineStoreWithErp.Models.CommitSessionModels
{
    public abstract class CommitSession : ISessionable, ICommittable
    {
        private readonly Session _Session;
        public Session Session => _Session;

        protected void RefreshSession()
        {
            if (_Session != null)
                _Session.InvokeChanged();
        }

        public CommitSession(Session session) => _Session = session;

        public object OnCommitted(Context cx) => null;

        public virtual object OnCommitting(Context cx)
        {
            RefreshSession();
            return null;
        }
    }
}