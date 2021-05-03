using Soneta.Business;
using Soneta.Towary;

namespace enova365.OnlineStoreWithErp.Utils
{
    public static class FeatureName
    {
        public static class Towary
        {
            public const string IsActive = "IsActive";
        }
    }

    public static class StoreFeatures
    {
        #region Pomocnicze

        private static T GetFeatureValue<T>(this Row row, string featureName)
            => (T)row.Features[featureName];

        private static void SetFeatureValue<T>(this Row row, string featureName, T value)
            => row.Features[featureName] = value;

        #endregion Pomocnicze

        #region Towary

        public static bool GetIsActive(this Towar towar)
            => towar.GetFeatureValue<bool>(FeatureName.Towary.IsActive);

        public static void SetIsActive(this Towar towar, bool value)
            => towar.SetFeatureValue(FeatureName.Towary.IsActive, value);

        #endregion Towary
    }
}