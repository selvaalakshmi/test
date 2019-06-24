Ext.define('Shopware.apps.ExternalOrder.store.List', {
	/**
     * Extend for the standard ExtJS 4
     * @string
     */
    extend: 'Ext.data.Store',
	/**
     * Auto load the store after the component is initialized
     * @boolean
     */
    autoLoad: false,
	/**
     * Enable remote sort.
     * @boolean
     */
    remoteSort: true,
	/**
     * Enable remote filtering
     * @boolean
     */
    remoteFilter: true,
	/**
     * Amount of data loaded at once
     * @integer
     */
    pageSize: 25,
	/**
     * to upload all selected items in one request
     * @boolean
     */
    batch: true,
	/**
     * Define the used model for this store
     * @string
     */
    model:'Shopware.apps.ExternalOrder.model.List'
});