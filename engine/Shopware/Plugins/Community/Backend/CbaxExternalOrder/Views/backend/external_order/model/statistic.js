Ext.define('Shopware.apps.ExternalOrder.model.Statistic', {
    extend: 'Ext.data.Model',

    fields: [
        { name: 'account', type:'string' },
        { name: 'value', type:'float' }
    ],

    proxy: {
        type: 'ajax',
        api: {
            read:'{url controller="ExternalOrder" action="getStatistic"}'
        },
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
