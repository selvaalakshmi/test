
Ext.define('Shopware.apps.BrandCrockPendingPayment.controller.Main', {
    extend: 'Enlight.app.Controller',

    init: function() {
        var me = this;

        me.mainWindow = me.getView('list.Window').create({ }).show();
    }
});
