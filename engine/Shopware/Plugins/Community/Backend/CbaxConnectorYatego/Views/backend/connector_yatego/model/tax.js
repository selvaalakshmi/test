Ext.define('Shopware.apps.ConnectorYatego.model.Tax', {
    extend: 'Ext.data.Model',

    fields: [
        'id',
        'name'
    ],

    idProperty: 'id',

    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller="ExternalOrderBase" action="getTaxes"}'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
