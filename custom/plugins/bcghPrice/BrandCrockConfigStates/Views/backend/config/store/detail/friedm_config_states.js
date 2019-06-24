//{block name="backend/config/view/form/shop" append}
Ext.define('Shopware.apps.Config.store.detail.FriedmConfigStates', {
    extend: 'Ext.data.Store',
    model:'Shopware.apps.Config.model.form.FriedmConfigStates',
	remoteSort: false,
    remoteFilter: false,
    pageSize: 999,
	autoLoad: false,
});
//{/block}
