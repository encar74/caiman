export function useCurrency(locales, options) {
    const formatter = new Intl.NumberFormat(locales, options);
    const euro = new Intl.NumberFormat("es-ES", { style: "currency", currency: "EUR" }).format;
    const percentage = new Intl.NumberFormat("es-ES", { style: "percent", minimumFractionDigits: 2, maximumFractionDigits: 2 }).format;
    return { formatter, euro, percentage }
}