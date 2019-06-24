Ext.define('Shopware.apps.ExternalOrder.model.Account', {
    extend: 'Ext.data.Model',

    fields: [
		{ name: 'name', type: 'string' },
		{ name: 'description', type: 'string' }
    ],

    idProperty: 'id',

    proxy: {
        type: 'ajax',
		
        api: {
            read: '{url controller="ExternalOrderBase" action="getAccounts"}'
        },
		
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
