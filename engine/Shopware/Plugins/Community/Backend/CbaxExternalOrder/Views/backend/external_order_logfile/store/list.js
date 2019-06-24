Ext.define('Shopware.apps.ExternalOrderLogfile.store.List', {
    extend:'Ext.data.Store',
    autoLoad: false,
    remoteSort: true,
    remoteFilter : true,
    pageSize: 30,
    model:'Shopware.apps.ExternalOrderLogfile.model.List'
});