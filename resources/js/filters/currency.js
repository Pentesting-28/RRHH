/**
 * filtros Moneda
 */

/**
 * [Valor description]
 * @param {number} value [description]
 */
export function currency(value) {
    if (value) {
        const AMOUNT_FORMAT = new Intl.NumberFormat("en-US", {
            currency: "USD",
            style: "currency"
        }).format(value);
        return AMOUNT_FORMAT;
     //    const VALUE_FORMAT = new Intl.NumberFormat("en-US", {
	    //     style: "currency",
	    //     currencyDisplay: "symbol",
	    //     currencySign: "accounting",
	    //     currency: "USD"
	    // }).format(valor);

	    // return VALUE_FORMAT;
    } else {
        return ' ';
    }
}