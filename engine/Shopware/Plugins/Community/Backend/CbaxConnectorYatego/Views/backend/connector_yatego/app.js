Ext.define('Shopware.apps.ConnectorYatego', {
    extend:'Enlight.app.SubApplication',
    name:'Shopware.apps.ConnectorYatego',

    bulkLoad: true,
    loadPath:'{url action=load}',

    controllers: [ 'Main' ],

    views: [ 'Main', 'main.Config' ],
	
	stores: [ 'Customergroup', 'Dispatch', 'Payment', 'Subshop', 'Tax' ],

    models: [ 'Customergroup', 'Dispatch', 'Payment', 'Subshop', 'Tax' ],

    launch: function() {
        var me = this,
            mainController = me.getController('Main');
        return mainController.mainWindow;
    }
});
