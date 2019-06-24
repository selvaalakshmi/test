// {namespace name=backend/plugins/external_order_logfile/view/main}
Ext.define('Shopware.apps.ExternalOrderLogfile.view.Main', {
    extend: 'Enlight.app.Window',
    alias: 'widget.externalorderlogfile-view-main',
    border: false,
    autoShow: true,
    layout: 'border',
    height: '90%',
    width: 1000,
	stateful: true,
    stateId: 'externalorderlogfile-view-main-window',
	
	snippets: {
        title: '{s name=titleWindow}Externe Bestellungen Logfiles{/s}'
    },
	
    initComponent: function() {
        var me = this;
		me.title = me.snippets.title;
		me.items = [{
            xtype: 'externalorderlogfile-main-list',
			region: 'center',
            logfileStore: me.logfileStore,
			accountStore: me.accountStore
        }];
 
        me.callParent(arguments);
    }
});