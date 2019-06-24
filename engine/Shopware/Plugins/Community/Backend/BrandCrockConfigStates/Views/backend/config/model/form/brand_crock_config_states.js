//{block name="backend/config/view/form/shop" append}
Ext.define('Shopware.apps.Config.model.form.BrandCrockConfigStates', {
    extend: 'Ext.data.Model',
    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller=BrandCrockConfigStates action=readStates}',
            create: '{url controller=BrandCrockConfigStates action=createStates}',
            update: '{url controller=BrandCrockConfigStates action=updateStates}',
            destroy: '{url controller=BrandCrockConfigStates action=destroyStates}',
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
