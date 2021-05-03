using Soneta.Business;
using System;
using System.Collections.Generic;

namespace enova365.OnlineStoreWithErp.Models.CustomViewInfos
{
    public abstract class CustomViewInfo<T, A> where A : List<T>
    {
        public CustomViewInfo(string name) => this.Name = name;

        protected string Name { get; }

        private ViewInfo cacheViewInfo = null;

        public ViewInfo CreateViewInfo()
        {
            if (cacheViewInfo == null)
            {
                cacheViewInfo = new ViewInfo();
                cacheViewInfo.InitContext += new ContextEventHandler(InitContextEvent);
                cacheViewInfo.CreateView += new CreateViewEventHandler(CreateViewEvent);
                cacheViewInfo.Action += new EventHandler<ActionEventArgs>(ActionEvent);

                cacheViewInfo.NewRows = new NewRowAttribute[] { new NewRowAttribute(Name, typeof(T)) };
            }
            return cacheViewInfo;
        }

        #region Virtual Methods

        protected virtual void AddNewAction(A list, ActionEventArgs args) => throw new NotImplementedException();

        protected virtual A NewList(Session sess) => throw new NotImplementedException();

        protected virtual void Zapisz(Session sess, A list) => throw new NotImplementedException();

        protected virtual void RemoveAction(A list, ActionEventArgs args)
        {
            list.Remove((T)args.FocusedData);
            args.Context.Set(list);
            Zapisz(args.Context.Session, list);
        }

        #endregion Virtual Methods

        #region Methods

        protected A GetListFromCx(Context cx)
           => cx.Contains(typeof(A)) ? (A)cx[typeof(A)] : null;

        private void InitContextEvent(object sender, ContextEventArgs args)
        {
            if (GetListFromCx(args.Context) == null)
                args.Context.Set(NewList(args.Context.Session));
        }

        public void CreateViewEvent(object sender, CreateViewEventArgs args)
            => args.DataSource = GetListFromCx(args.Context).ToArray();

        private void ActionEvent(object sender, ActionEventArgs args)
        {
            switch (args.Action)
            {
                case ActionEventArgs.Actions.AddNew:
                    AddNewAction(GetListFromCx(args.Context), args);
                    break;

                case ActionEventArgs.Actions.Remove:
                    RemoveAction(GetListFromCx(args.Context), args);
                    break;
            }
        }

        #endregion Methods
    }
}