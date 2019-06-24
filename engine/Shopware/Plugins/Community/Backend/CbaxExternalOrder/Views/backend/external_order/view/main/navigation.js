Ext.define('Shopware.apps.ExternalOrder.view.main.Navigation', {
    extend:'Ext.container.Container',
    alias:'widget.externalorder-main-navigation',
    layout:'accordion',
    width:300,
    collapsed:false,
    collapsible:true,

    initComponent:function () {
        var me = this;

        me.items = [{
			xtype: "externalorder-main-filterpanel",
			accountStore: me.accountStore,
			paymentStore: me.paymentStore,
			statusStore: me.statusStore
		},{
			xtype: "externalorder-main-statistic",
			statisticStore: me.statisticStore
		}];

        me.callParent(arguments);
    }
});