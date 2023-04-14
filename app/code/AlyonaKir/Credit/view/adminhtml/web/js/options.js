define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select',
    'Magento_Ui/js/modal/modal',
    'jquery'
], function (_, uiRegistry, select, modal) {
    'use strict';

    return select.extend({

        initialize: function () {
            this._super();
            //this.onUpdate(status);
            return this;
            //console.log(this.initialValue);
        },

        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {
            console.log("On update");
            let sel = document.getElementsByClassName("admin__control-select")[0];

            if (value == 0) {
                hideAllOptions();
                sel[0].style.display = 'contents';
                sel[1].style.display = 'contents';

            } else if (value == 1) {
                sel[0].style.display = 'none';
                showAllOptions();
                hideAllFields();
                uiRegistry.get('index = reason').show();
                uiRegistry.get('index = download').show();

            } else if (value == 2 || value == 3) {
                showAllOptions();
                sel[0].style.display = 'none';
                sel[1].style.display = 'none';
                showAllFields();

            } else {
                showAllOptions();
            }

            return this._super();
        }

    });

    function hideAllOptions() {
        let sel = document.getElementsByClassName("admin__control-select")[0];
        for (let i = 0; i < sel.length; i++) {
            sel[i].style.display = 'none';
        }
    }

    function showAllOptions() {
        let sel = document.getElementsByClassName("admin__control-select")[0];
        for (let i = 0; i < sel.length; i++) {
            sel[i].style.display = 'contents';
        }
    }

    function hideAllFields(){
        uiRegistry.get('index = reason').hide();
        uiRegistry.get('index = lock_credit_limit').hide();
        uiRegistry.get('index = credit_available').hide();
        uiRegistry.get('index = allowable_purchase_time').hide();
        uiRegistry.get('index = credit_limit').hide();
    }

    function showAllFields(){
        uiRegistry.get('index = reason').show();
        uiRegistry.get('index = lock_credit_limit').show();
        uiRegistry.get('index = credit_available').show();
        uiRegistry.get('index = allowable_purchase_time').show();
        uiRegistry.get('index = credit_limit').show();
    }

});
