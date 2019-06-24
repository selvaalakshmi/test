Ext.define('Shopware.apps.ConnectorYatego.model.Subshop', {
    extend: 'Ext.data.Model',

    fields: [
        'id',
        'name'
    ],

    idProperty: 'id',

    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller="ExternalOrderBase" action="getShops"}'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
