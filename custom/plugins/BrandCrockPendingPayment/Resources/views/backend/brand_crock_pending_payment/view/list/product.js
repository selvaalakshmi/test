//{namespace name="backend/brand_crock_pending_payment/view/main"}
//{block name="backend/brand_crock_pending_payment/view/list/product"}
Ext.define('Shopware.apps.BrandCrockPendingPayment.view.list.Product', {
    extend: 'Shopware.grid.Panel',
    alias:  'widget.product-listing-grid',
    region: 'center',
    configure: function() {
        return {
            detailWindow: 'Shopware.apps.BrandCrockPendingPayment.view.detail.Window',
            columns: {
					documentDate: { header: '{s name=bcdocumentDate}Document Date{/s}' },
					number: { header: '{s name=bcordernumber}Invoice Number{/s}' },
					invoiceAmount: { header: '{s name=bcinvoiceAmount}Invoice Amount{/s}' },
					invoiceAmountNet: { header: '{s name=bcinvoiceAmountNet}Invoice AmountNet{/s}' },
					orderTime: { header: '{s name=bcordertime}Order Time{/s}' },
					customerComment: { header: '{s name=bccustomercomment}Customer Comment{/s}' },
					customerFirstName: { header: '{s name=bccustomerfirstname}Customer FirstName{/s}' },
					customerLastName: { header: '{s name=bccustomerlastname}Customer LastName{/s}' },
					payment: { header: '{s name=bcpaymenttypes}Payment Types{/s}' },
					company: { header: '{s name=bccompany}Company{/s}' },
					invoiceNumber: { header: '{s name=bcinvoicenumber}Invoice Number{/s}' },
					overdue: { header: '{s name=bcoverdue}Overdue{/s}' },
					bcPaidAmount: { header: '{s name=bcpaidamount}Payment Made{/s}' },
					bcPendingAmount: { header: '{s name=bcPendingAmount}Payment Expected{/s}' },
					customerReferenceNumber: { header: '{s name=bccustomerReferenceNumber}Reference Number{/s}' },
					},
            addButton: false,
            deleteButton: false,
            editColumn: true,
            deleteColumn: false,
        };
    },

    createToolbarItems: function () {
        var me = this, items = [];
		if (me.getConfig('searchField')) {
            items.push('->');
            items.push(me.createSearchField());
        }
        if (me.getConfig('editColumn')) {
            items.push(me.createEditColumn());
        }
        items.push(me.createCsvButton());

        return items;
    },
      createEditColumn: function () {
        var me = this, column;

        column = {
            action: 'edit',
            iconCls: 'sprite-pencil',
            handler: function (view, rowIndex, colIndex, item, opts, record) {
                Shopware.app.Application.addSubApplication({
                    name: 'Shopware.apps.Order',
                    action: 'detail',
                    params: {
                        orderId: record.get('id')
                    }
                });
            }
        };

        me.fireEvent(me.eventAlias + '-edit-action-column-created', me, column);

        return column;
    },
    createCsvButton: function () {
        var me = this;

        me.addButton = Ext.create('Ext.button.Button', {
            text: '{s name="bcdownloadcsv"}Download CSV{/s}',
            iconCls: 'sprite-drive-download',
              listeners: {
                click: function () {
                    var url = '{url controller=BrandCrockPendingPayment action=list}';
                    url += '?format=csv';
                    var form = Ext.create('Ext.form.Panel', {
                        standardSubmit: true,
                        target: 'iframe'
                    });

                    form.submit({
                        method: 'POST',
                        url: url
                    });
                    },
                }
        });

        me.fireEvent(me.eventAlias + '-add-button-created', me, me.addButton);

        return me.addButton;
    },
    
});
//{/block}
