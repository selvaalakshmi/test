//{namespace name="backend/brand_crock_pending_payment/view/main"}
//{block name="backend/brand_crock_pending_payment/view/list/extensions/filter"}
Ext.define('Shopware.apps.BrandCrockPendingPayment.view.list.extensions.Filter', {
    extend: 'Shopware.listing.FilterPanel',
    alias:  'widget.product-listing-filter-panel',
    width: 270,

    configure: function() {
		var paymentStatusStore = Ext.create('Shopware.apps.Base.store.OrderStatus'),
            orderStatusStore = Ext.create('Shopware.apps.Base.store.Payment');
        return {
            controller: 'BrandCrockPendingPayment',
            model: 'Shopware.apps.BrandCrockPendingPayment.model.Product',
            fields: {
                number: '{s name="bcordernumber"}Order Number{/s}',
					documentDate: {
						xtype: 'datefield',
						submitFormat: 'Y-m-d',
						fieldLabel: '{s name="bcdocumentDate"}Document Date{/s}'
					},
                
                
                invoiceAmount: '{s name="bcinvoiceAmount"}Invoice Amount{/s}',
                invoiceAmountNet: '{s name="bcinvoiceAmountNet"}Invoice AmountNet{/s}',
                orderTime: {
						xtype: 'datefield',
						submitFormat: 'Y-m-d',
						fieldLabel: '{s name="bcordertime"}Order Time{/s}'
					},
                customerComment: '{s name="bccustomercomment"}Customer Comment{/s}',
                customerFirstName: '{s name="bccustomerfirstname"}Customer FirstName{/s}',
                customerLastName: '{s name="bccustomerlastname"}Customer LastName{/s}',
                company: '{s name="bccompany"}Company{/s}',
                invoiceNumber: '{s name="bcinvoicenumber"}Invoice Number{/s}',
                payment: {
                    xtype: 'combobox',
                    fieldLabel: '{s name="bcpaymenttypes"}Payment Types{/s}',
                    displayField: 'description',
                    valueField: 'id',
                    store: orderStatusStore,
                    multiSelect: true,
                },
                overdue: {
                    xtype: 'combobox',
                    fieldLabel:'{s name="bcoverdue"}Overdue{/s}',
                    displayField: 'description',
                    valueField: 'id',
                    store: [[1,'{s name="bcno"}No{/s}'],
                    [0,'{s name="bcyes"}Yes{/s}']]
                },
            }
        };
    },
      createInfoText: function() {
        var me = this;

        me.infoText = Ext.create('Ext.container.Container', {
            html: '',
            style: 'color: #6c818f; font-size: 11px; line-height: 14px;',
            margin: '0 0 10'
        });
        return me.infoText;
    }, 
});
//{/block}



