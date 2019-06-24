Ext.define('Shopware.apps.ExternalOrderLogfile.controller.Main', {
    extend: 'Ext.app.Controller',
	
    mainWindow: null,

    init: function() {
        var me = this;

		me.control({
			'externalorderlogfile-main-list': {
				// Store laden ohne Filter
				beforerender: me.clearFilter
			}
		});
 
        me.mainWindow = me.getView('Main').create({
            logfileStore: me.getStore('List').load(),
			accountStore: me.getStore('Shopware.apps.ExternalOrderLogfile.store.Account').load()
        });
 
        me.callParent(arguments);
    },

	clearFilter: function () {
		var me = this,
			store = me.getStore('List');

		store.getProxy().extraParams = {
			'filterByAccount': ''
		};

		store.load();
	}
});