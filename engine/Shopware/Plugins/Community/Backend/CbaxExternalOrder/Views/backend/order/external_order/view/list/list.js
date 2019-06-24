// {namespace name=backend/order/external_order/view/list/list}
// {block name="backend/order/view/list/list" append}
Ext.define('Shopware.apps.Order.ExternalOrder.view.list.List', {
	override: 'Shopware.apps.Order.view.list.List',

	getColumns: function () {
		var me = this,
			columns = me.callParent(arguments),
			insertIndex = 7;

		columns.forEach(function (column, index, array) {
			switch (column.dataIndex) {
				case 'orderTime':
					column.flex = 0;
					column.width = 100;
					break;
				case 'transactionId':
					/*{if $externalOrder.hide_transactionId}*/
					column.hidden = true;
					/*{/if}*/
					break;
				case 'paymentId':
					/*{if $externalOrder.hide_paymentId}*/
					column.hidden = true;
					/*{/if}*/
					break;
				case 'dispatchId':
					/*{if $externalOrder.hide_dispatchId}*/
					column.hidden = true;
					/*{/if}*/
					break;
				case 'shopId':
					insertIndex = index + 1;
					/*{if $externalOrder.hide_shopId}*/
					column.hidden = true;
					/*{/if}*/
					break;
				case 'partnerId':
					/*{if $externalOrder.hide_partnerId}*/
					column.hidden = true;
					/*{/if}*/
					break;
				case 'customerEmail':
					/*{if $externalOrder.hide_customerEmail}*/
					column.hidden = true;
					/*{/if}*/
					break;
			}
		});

		return Ext.Array.insert(columns, insertIndex, [{
			header: '{s name=column/partner}Marktplatz{/s}',
			dataIndex: 'partnerId',
			flex: 1,
			renderer: me.partnerColumn
		}]);
	},

	partnerColumn: function (value) {
		var logos = [
			'allyouneed',
			'amazon',
			'amazon_two',
			'amazon_three',
			'dawanda',
			'ebay',
			'ebay_two',
			'ebay_three',
			'hitmeister',
			'hood',
			'idealo',
			'limango',
			'locamo',
			'rakuten',
			'real',
			'yatego'
		];

		if (value !== '' && logos.indexOf(Ext.util.Format.lowercase(value)) >= 0) {
			value = '<img src="../engine/Shopware/Plugins/Community/Backend/CbaxExternalOrder/Views/backend/_resources/images/order/' + value.toLowerCase() + '.png" data-qtip="' + value + '" style="margin:auto;display:block;" />';
		} else {
			value = '';
		}

		return value;
	}
});
//{/block}