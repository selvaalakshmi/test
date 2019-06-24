Ext.define('Shopware.apps.ExternalOrder.model.Customer', {
    extend: 'Ext.data.Model',

    fields: [
		'id',
		'account',
		'external_order_number',
		'created',
		'paymentID',
		'payment',
		'invoice_amount',
		'invoice_shipping',
		'comment',
		'customercomment',
		'internalcomment',
		'imported',
		'ordertime',
		'orderID',
		'ordernumber',
		'b_salutation',
		'b_company',
		'b_firstname',
		'b_lastname',
		'b_street',
		'b_streetnumber',
		'b_additionalAddressLine1',
		'b_additionalAddressLine2',
		'b_zipcode',
		'b_city',
		'b_countryID',
		'b_country',
		'b_email',
		'b_phone',
		'b_fax',
		'b_birthday',
		's_company',
		's_salutation',
		's_firstname',
		's_lastname',
		's_street',
		's_streetnumber',
		's_additionalAddressLine1',
		's_additionalAddressLine2',
		's_zipcode',
		's_city',
		's_countryID',
		's_country',
		's_phone',
		's_fax'
    ],
	
	idProperty: 'id',

    proxy: {
        type: 'ajax',
 
        api: {
            read: '{url controller="ExternalOrder" action="getCustomer"}',
			update: '{url controller="ExternalOrder" action="updateCustomer"}',
        },
 
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});