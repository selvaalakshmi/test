
Ext.define('Shopware.apps.BrandCrockPendingPayment.store.Product', {
    extend:'Shopware.store.Listing',

    configure: function() {
        return {
            controller: 'BrandCrockPendingPayment'
        };
    },
    model: 'Shopware.apps.BrandCrockPendingPayment.model.Product'
});
