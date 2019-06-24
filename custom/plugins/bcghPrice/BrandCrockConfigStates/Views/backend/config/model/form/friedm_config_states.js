//{block name="backend/config/view/form/shop" append}
Ext.define('Shopware.apps.Config.model.form.FriedmConfigStates', {
    extend: 'Ext.data.Model',
    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller=FriedmConfigStates action=readStates}',
            create: '{url controller=FriedmConfigStates action=createStates}',
            update: '{url controller=FriedmConfigStates action=updateStates}',
            destroy: '{url controller=FriedmConfigStates action=destroyStates}',
        },
        reader: {
            type: 'json',
            root: 'data'
        }
    },
    fields: [
        { name: 'id', type: 'int' },
        { name: 'name', type: 'string' },
        { name: 'namespace', type: 'string' },
        { name: 'description', type: 'string' },
        { name: 'position', type: 'int' },
        { name: 'groupType', type: 'string' },
        { name: 'sendMail', type: 'int' },
    ],
});
//{/block}