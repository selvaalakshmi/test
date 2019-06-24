Ext.define('Shopware.apps.ExternalOrder.model.Payment', {
    extend: 'Ext.data.Model',

    fields: [
		{ name: 'id' },
		{ name: 'name', type: 'string' }
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
