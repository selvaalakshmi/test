Ext.define('Shopware.apps.ConnectorYatego.model.ShippingGrid', {
    extend: 'Ext.data.Model',
	
	fields: [
        'id',
        'dispatchID',
		'dispatchname',
		'countryID',
		'countryname',
		'carrier'
    ],
	
	idProperty: 'id',

    proxy: {
        type: 'ajax',
        api: {
            read: '{url controller="ConnectorYatego" action="getShipping"}',
            create: '{url controller="ConnectorYatego" action="saveShipping"}',
            update: '{url controller="ConnectorYatego" action="saveShipping"}',
            destroy: '{url controller="ConnectorYatego" action="deleteShipping"}'
        },
        reader: {
            type: 'json',
            root: 'data',
			totalProperty: 'total'
        }
    }
});
