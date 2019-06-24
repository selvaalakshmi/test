Ext.define('Shopware.apps.ConnectorYatego.model.Dispatch', {
    extend: 'Ext.data.Model',

    fields: [
        'id',
		'name'
    ],

    idProperty: 'id',

    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller="ExternalOrderBase" action="getDispatches"}'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
