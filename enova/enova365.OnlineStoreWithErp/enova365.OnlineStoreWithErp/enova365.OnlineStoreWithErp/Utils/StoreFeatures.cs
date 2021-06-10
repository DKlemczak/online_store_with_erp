using Soneta.Business;
using Soneta.Towary;

namespace enova365.OnlineStoreWithErp.Utils
{
    public static class FeatureName
    {
        public static class Towary
        {
            public const string IsActive = "IsActive";
            public const string GrupaId = "GrupaId";
            public const string Opis = "Opis";
            public const string Tagi = "Tagi";
            public const string Rabat = "Rabat";
            public const string Grupa = "Grupa";
            public const string DictionaryGrupa = "F.Grupa";
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

        public static int GetGrupaId(this Towar towar)
            => towar.GetFeatureValue<int>(FeatureName.Towary.GrupaId);

        public static void SetGrupaId(this Towar towar, int value)
            => towar.SetFeatureValue(FeatureName.Towary.GrupaId, value);

        public static string GetOpis(this Towar towar)
            => towar.GetFeatureValue<string>(FeatureName.Towary.Opis);

        public static void SetOpis(this Towar towar, string value)
            => towar.SetFeatureValue(FeatureName.Towary.Opis, value);

        public static string GetTagi(this Towar towar)
            => towar.GetFeatureValue<string>(FeatureName.Towary.Tagi);

        public static void SetTagi(this Towar towar, string value)
            => towar.SetFeatureValue(FeatureName.Towary.Tagi, value);

        public static int GetRabat(this Towar towar)
            => towar.GetFeatureValue<int>(FeatureName.Towary.Rabat);

        public static void SetRabat(this Towar towar, int value)
            => towar.SetFeatureValue(FeatureName.Towary.Rabat, value);

        public static string GetGrupa(this Towar towar)
            => towar.GetFeatureValue<string>(FeatureName.Towary.Grupa);

        public static void SetGrupa(this Towar towar, string value)
            => towar.SetFeatureValue(FeatureName.Towary.Grupa, value);

        #endregion Towary
    }
}