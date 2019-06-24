Ext.define('Shopware.apps.ExternalOrderLogfile.store.Account', {
    /**
     * Extend for the standard ExtJS 4
     * @string
     */
    extend: 'Ext.data.Store',
    /**
     * Auto load the store after the component is initialized
     * @boolean
     */
    autoLoad: true,
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
	/**
     * Amount of data loaded at once
     * @integer
     */
    remoteFilter : true,
    /**
     * Define the used model for this store
     * @string
     */
    model:'Shopware.apps.ExternalOrderLogfile.model.Account'
});
