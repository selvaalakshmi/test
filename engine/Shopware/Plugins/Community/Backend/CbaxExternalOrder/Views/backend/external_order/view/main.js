// {namespace name=backend/plugins/external_order/view/main}
Ext.define('Shopware.apps.ExternalOrder.view.Main', {
	extend: 'Enlight.app.Window',
	alias: 'widget.externalorder-view-Main',
    border: false,
    autoShow: true,
    layout: 'border',
    height: '90%',
    width: 1300,
	stateful: true,
    stateId: 'externalorder-view-main-window',
	
	snippets: {
        title: '{s name=titleWindow}Externe Bestellungen{/s}'
    },
	
    initComponent: function() {
		var me = this;
		me.title = me.snippets.title;
        me.items = [{
			region: "west",
			xtype: "externalorder-main-navigation",
			accountStore: me.accountStore,
			paymentStore: me.paymentStore,
			statusStore: me.statusStore,
			statisticStore: me.statisticStore
		},{
			region: "center",
			xtype: "externalorder-main-list",
			externalOrderStore: me.externalOrderStore,
			statusStore: me.statusStore
		}];

        me.callParent(arguments);
    }
});