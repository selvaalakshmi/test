Ext.define('Shopware.apps.Order.ExternalOrder.model.Carrier', {
	extend: 'Ext.data.Model',

	fields: [
		{ name: 'name', type: 'string' },
		{ name: 'description', type: 'string' }
	],

	idProperty: 'id',

	proxy: {
		type: 'ajax',

		api: {
			read: '{url controller="ExternalOrderBase" action="getCarriers"}'
		},

		reader: {
			type: 'json',
			root: 'data',
			totalProperty: 'total'
		}
	}
});
