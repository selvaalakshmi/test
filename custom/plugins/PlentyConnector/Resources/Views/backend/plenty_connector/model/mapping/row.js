// {namespace name=backend/plentyconnector/main}
// {block name=backend/plentyconnector/model/mapping/row}

Ext.define('Shopware.apps.PlentyConnector.model.mapping.Row', {
    extend: 'Ext.data.Model',

    fields: [
        // {block name="backend/plentyconnector/model/mapping/row/fields"}{/block}
        {
            name: 'identifier',
            type: 'string'
        },
        {
            name: 'name',
            type: 'string'
        },
        {
            name: 'adapterName',
            type: 'string'
        },
        {
            name: 'originIdentifier',
            type: 'string'
        },
        {
            name: 'originName',
            type: 'string'
        },
        {
            name: 'originAdapterName',
            type: 'string'
        },
        {
            name: 'objectType',
            type: 'string'
        },
        {
            name: 'remove',
            type: 'boolean'
        }
    ],

    idProperty: 'name',

    proxy: {
        type: 'ajax',

        api: {
            update: '{url action=updateIdentities}'
        },

        reader: {
            type: 'json',
            root: 'data'
        }
    }
});

// {/block}
