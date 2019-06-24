Ext.define('Shopware.apps.ExternalOrder.model.List', {
    extend: 'Ext.data.Model',

    fields: [
        'id',
		'created',
		'account',
		'orderID',
		'ordernumber',
		'invoice_amount',
		'external_order_number',
		'orderStatus',
		'shipped_to_account',
		'payment',
		'customer_name'
    ],
	
	idProperty: 'id',

    proxy: {
        type: 'ajax',
 
        api: {
            read: '{url controller="ExternalOrder" action=getExternalOrders}',
			destroy: '{url controller="ExternalOrder" action="deleteExternalOrder"}'
        },
 
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});