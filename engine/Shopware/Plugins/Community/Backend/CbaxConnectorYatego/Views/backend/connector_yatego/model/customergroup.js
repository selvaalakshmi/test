Ext.define('Shopware.apps.ConnectorYatego.model.Customergroup', {
    extend: 'Ext.data.Model',

    fields: [
        'id',
		'groupkey',
        'name'
    ],

    idProperty: 'id',

    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller="ExternalOrderBase" action="getCustomerGroups"}'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
