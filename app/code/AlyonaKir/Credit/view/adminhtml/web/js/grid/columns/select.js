define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'AlyonaKir_Credit/ui/grid/cells/text'
        },
        getStatusColor: function (row) {

            switch(row.purchase_status) {
                case "0": return '#9d9a06';
                case "1": return '#FFA07A';
                case "2": return '#425d1a';
                case "3": return '#722b0e';
                case "4": return '#1f1d1d';
                default:
                    return '#90EE90';
            }

        }
    });
});
