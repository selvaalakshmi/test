Ext.define('Shopware.apps.ConnectorYatego.model.Payment', {
    extend: 'Ext.data.Model',

    fields: [
        'id',
		'name'
    ],

    idProperty: 'id',

    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller="ExternalOrderBase" action="getPayments"}'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
