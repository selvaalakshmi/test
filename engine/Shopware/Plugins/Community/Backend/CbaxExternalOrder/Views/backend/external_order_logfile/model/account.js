Ext.define('Shopware.apps.ExternalOrderLogfile.model.Account', {
    extend: 'Ext.data.Model',

    fields: [
		{ name: 'name', type: 'string' },
		{ name: 'description', type: 'string' }
    ],

    idProperty: 'name',

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
