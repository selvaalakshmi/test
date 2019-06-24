//{namespace name="backend/brand_crock_pending_payment/view/main"}
//{block name="backend/brand_crock_pending_payment/view/list/window"}
Ext.define('Shopware.apps.BrandCrockPendingPayment.view.list.Window', {
    extend: 'Shopware.window.Listing',
    alias: 'widget.product-list-window',
    height: 650,
    width: 1280,
    title : '{s name="bcpendinwindow"}Pending payment details{/s}',

    configure: function() {
        return {
            listingGrid: 'Shopware.apps.BrandCrockPendingPayment.view.list.Product',
            listingStore: 'Shopware.apps.BrandCrockPendingPayment.store.Product',

            extensions: [
                { xtype: 'product-listing-filter-panel' }
            ]
        };
    }
});
//{/block}
