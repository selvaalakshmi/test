Ext.define('Shopware.apps.App', {
	name: 'Shopware.apps.App',
    extend:'Enlight.app.SubApplication',
    bulkLoad: true,
    loadPath:'{url action=load}',
	controllers: ['Main'],
	stores: [],
	models: [],
	views: ['main.Window'],
	launch: function() {
		var me = this;		
		mainController = me.getController('Main');
		return mainController.mainWindow;
	}
});
