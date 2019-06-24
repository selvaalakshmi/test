
Ext.define('Shopware.apps.BrandCrockPendingPayment', {
    extend: 'Enlight.app.SubApplication',

    name:'Shopware.apps.BrandCrockPendingPayment',

    loadPath: '{url action=load}',
    bulkLoad: true,

    controllers: [ 'Main' ],

    views: [
        'list.Window',
        'list.Product',
        'list.extensions.Filter',
    ],

    models: [
        'Product',
    ],
    stores: [
        'Product',
    ],

    launch: function() {
        return this.getController('Main').mainWindow;
    }
});
