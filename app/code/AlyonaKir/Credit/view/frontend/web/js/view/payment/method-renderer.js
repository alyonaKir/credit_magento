define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'credit_payment',
                component: 'AlyonaKir_Credit/js/view/payment/credit_payment'
            }
        );
        return Component.extend({});
    }
);
