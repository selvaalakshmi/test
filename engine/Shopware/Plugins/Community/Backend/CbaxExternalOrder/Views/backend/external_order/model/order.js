Ext.define('Shopware.apps.ExternalOrder.model.Order', {
    extend: 'Ext.data.Model',

    fields: [
		'id',
		'articleID',
		'articleordernumber',
		'name',
		'quantity',
		'price',
		'totalprice',
		{ name: 'instock',  type: 'int' }
    ],
	
	idProperty: 'id',

    proxy: {
        type: 'ajax',
 
        api: {
            read: '{url controller="ExternalOrder" action="getOrder"}',
        },
 
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});