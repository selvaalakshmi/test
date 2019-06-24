Ext.define('Shopware.apps.ConnectorYatego.model.Country', {
    extend: 'Ext.data.Model',
	
	fields: [
        'id',
        'name'
    ],

    idProperty: 'id',

    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller="ExternalOrderBase" action="getCountries"}'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
