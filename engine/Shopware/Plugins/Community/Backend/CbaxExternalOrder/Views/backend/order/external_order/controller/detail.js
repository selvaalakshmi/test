// {namespace name=backend/order/external_order/main}
// {block name="backend/order/controller/detail" append}
Ext.define('Shopware.apps.Order.ExternalOrder.controller.Detail', {
	override: 'Shopware.apps.Order.controller.Detail',

	constructor: function () {
		var me = this;

		me.refs = (me.refs || []).concat([{
			ref: 'overviewPanel',
			selector: 'order-detail-window order-overview-panel'
		}]);
		me.callParent(arguments);
	},

	saveRecord: function (order, successMessage, errorMessage, options) {
		var me = this;

		if (options !== Ext.undefined && Ext.isFunction(options.callback)) {
			var originalCallback = options.callback;

			var customCallback = function (order) {
				Ext.callback(originalCallback, this, arguments);

				if (order) {
					var orderId = order.get('id');

					if (orderId) {
						var overviewPanel = me.getOverviewPanel(),
							form = overviewPanel.getForm();

						Ext.Ajax.request({
							method: 'POST',
							url: '{url controller=AttributeData action=saveData}',
							params: {
								_foreignKey: orderId,
								_table: 's_order_attributes',
								__attribute_cbax_external_order_carrier: form.findField('cbaxExternalOrderCarrier').getValue()
							}
						});
					}
				}
			};

			if (!options.callback || options.callback.toString() !== customCallback.toString()) {
				options.callback = customCallback;
			}
		}

		me.callParent(arguments);
	}
});
//{/block}