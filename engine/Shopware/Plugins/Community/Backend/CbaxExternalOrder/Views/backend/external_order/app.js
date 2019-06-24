Ext.define('Shopware.apps.ExternalOrder', {
    extend:'Enlight.app.SubApplication',
    name:'Shopware.apps.ExternalOrder',

    bulkLoad: true,
    loadPath:'{url action=load}',

    controllers: [ 'Main' ],

    views: [ 'Main', 'main.Window', 'main.Navigation', 'main.Filterpanel', 'main.Statistic', 'main.List', 'detail.Window', 'detail.Overview', 'detail.Detail', 'detail.Position' ],
	
	models: [ 'Account', 'Customer', 'List', 'Order', 'Payment', 'Statistic' ],

    stores: [ 'Account', 'Customer', 'List', 'Order', 'Payment', 'Statistic' ],

    launch: function() {
        var me = this,
            mainController = me.getController('Main');
        return mainController.mainWindow;
    }
});