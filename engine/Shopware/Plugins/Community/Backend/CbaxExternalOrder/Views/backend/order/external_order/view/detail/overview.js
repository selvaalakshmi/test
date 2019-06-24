// {namespace name=backend/order/external_order/main}
// {block name="backend/order/view/detail/overview" append}
Ext.define('Shopware.apps.Order.ExternalOrder.view.detail.Overview', {
	override: 'Shopware.apps.Order.view.detail.Overview',

	accounts: [
		'amazon',
		'dawanda',
		'ebay',
		'hitmeister',
		'hood',
		'idealo',
		'locamo',
		'rakuten',
		'real',
		'yatego'
	],

	initComponent:function () {
		var me = this;

		me.callParent(arguments);

		var orderId = me.record.get('id');

		if (orderId) {
			var editForm = me.editForm.getForm(),
				detailsForm = me.detailsForm.getForm();

			Ext.Ajax.request({
				url: '{url controller=AttributeData action=loadData}',
				params: {
					_foreignKey: orderId,
					_table: 's_order_attributes'
				},
				success: function (responseData) {
					var response = Ext.JSON.decode(responseData.responseText);
					
					if (editForm.findField('cbaxExternalOrderCarrier')) {
						editForm.findField('cbaxExternalOrderCarrier').setValue(response.data['__attribute_cbax_external_order_carrier']);
					}
					if (detailsForm.findField('cbaxExternalOrderOrdernumber')) {
						detailsForm.findField('cbaxExternalOrderOrdernumber').setValue(response.data['__attribute_cbax_external_order_ordernumber']);
					}
				}
			});
		}
	},

	createEditContainer: function() {
		var me = this,
			editForm = me.callParent(arguments),
			trackingCode = editForm.getForm().findField('trackingCode'),
			partnerId = me.record.get('partnerId');

		if (partnerId !== '' && me.accounts.indexOf(Ext.util.Format.lowercase(partnerId)) >= 0) {

			me.carrierStore = Ext.create('Shopware.apps.Order.ExternalOrder.store.Carrier');
			me.carrierStore.getProxy().extraParams = {
				account: partnerId
			};

			me.dispatchCarrier = {
				xtype: 'combobox',
				queryMode: 'local',
				name: 'cbaxExternalOrderCarrier',
				fieldLabel: 'Versand Dienstleister',
				store: me.carrierStore,
				displayField: 'description',
				valueField: 'name',
				emptyText: 'Standard Dienstleister',
				editable: false
			}
		} else {
			me.dispatchCarrier = {
				xtype: 'textfield',
				name: 'cbaxExternalOrderCarrier',
				fieldLabel: 'Versand Dienstleister'
			}
		}

		trackingIndex = editForm.items.indexOf(trackingCode);
		editForm.insert(trackingIndex + 1, me.dispatchCarrier);

		return editForm;
	},

	createRightDetailElements: function() {
		var me = this,
			elements = me.callParent(arguments),
			partnerId = me.record.get('partnerId');

		if (partnerId !== '' && me.accounts.indexOf(Ext.util.Format.lowercase(partnerId)) >= 0) {
			Ext.Array.insert(elements, 3, [{
				name: 'cbaxExternalOrderOrdernumber',
				fieldLabel: 'Marktplatz Bestellnummer'
			}]);
		}

		return elements;
	}
});
//{/block}
