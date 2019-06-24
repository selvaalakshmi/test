Ext.define('Shopware.apps.ConnectorYatego.store.Tax', {
    /**
     * Extend for the standard ExtJS 4
     * @string
     */
    extend:'Ext.data.Store',
    /**
     * Auto load the store after the component
     * is initialized
     * @boolean
     */
    autoLoad:true,

    /**
     * to upload all selected items in one request
     * @boolean
     */
    batch: true,
    /**
     * sets remote sorting true
     * @boolean
     */
    remoteSort: false,

    remoteFilter : true,
    /**
     * Define the used model for this store
     * @string
     */
    model:'Shopware.apps.ConnectorYatego.model.Tax'
});
