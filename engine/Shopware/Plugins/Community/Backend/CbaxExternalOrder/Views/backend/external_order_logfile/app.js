Ext.define('Shopware.apps.ExternalOrderLogfile', {
    extend:'Enlight.app.SubApplication',
	name:'Shopware.apps.ExternalOrderLogfile',
 
    bulkLoad: true,
    loadPath: '{url action=load}',

    controllers: ['Main', 'List'],
	
	views: [ 'Main', 'main.List', 'main.Edit' ],
	
    models: [ 'Account', 'List' ],

    stores: [ 'Account', 'List' ],

    launch: function() {
        var me = this,
            mainController = me.getController('Main');
 
        return mainController.mainWindow;
    }
});