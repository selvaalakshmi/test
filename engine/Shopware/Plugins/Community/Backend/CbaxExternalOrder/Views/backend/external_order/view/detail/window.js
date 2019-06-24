// {namespace name=backend/plugins/external_order/view/detail/window}
Ext.define('Shopware.apps.ExternalOrder.view.detail.Window', {
	extend: 'Enlight.app.Window',
    alias: 'widget.externalorder-detail-window',
    border: false,
    autoShow: true,
    layout: 'fit',
    height: '90%',
    width: 900,
	
	snippets: {
        title: '{s name=titleWindow}Bestellungs-Details: {/s}'
    },
	
    initComponent: function() {
        var me = this;
		me.title = me.snippets.title + me.record.get('account') + ' ' + me.record.get('external_order_number');
        me.items = [{
			region: 'center',
			xtype: 'tabpanel',
			layout: 'border',
			items:[{
				xtype: 'externalorder-detail-overview',
				record: me.record
			},{
				xtype: 'externalorder-detail-detail',
				record: me.record,
				countriesStore: me.countriesStore,
				paymentsStore: me.paymentsStore
			},{
				xtype: "externalorder-detail-position",
				orderStore: me.orderStore,
				record: me.record
			}]
		}];

        me.callParent(arguments);
    }
});
