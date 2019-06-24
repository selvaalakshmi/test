// {namespace name=backend/plugins/external_order/view/detail/overview}
Ext.define('Shopware.apps.ExternalOrder.view.detail.Overview', {
    extend: 'Ext.form.Panel',
    alias: 'widget.externalorder-detail-overview',
	autoScroll: true,
	bodyPadding: 10,
	
	snippets: {
        title: '{s name=titleWindow}Übersicht{/s}',
		container: {
            billing: '{s name=containerBilling}Rechnung{/s}',
            shipping: '{s name=containerShipping}Versand{/s}',
			payment: '{s name=containerPayment}Zahlungsart{/s}',
			details: '{s name=containerDetails}Bestellung-Details{/s}',
			communication: '{s name=containerCommunication}Kommunikation{/s}'
        },
		account: {
            label: '{s name=fieldLabelMarketplace}Marktplatz{/s}'
        },
		external_order_number: {
            label: '{s name=fieldLabelExternalOrderNumber}Externe Bestellnummer{/s}'
        },
		ordernumber: {
            label: '{s name=fieldLabelOrdernumber}Shop Bestellnummer{/s}'
        },
		invoice_shipping: {
            label: '{s name=fieldLabelInvoiceShipping}Versandkosten{/s}'
        },
		created: {
            label: '{s name=fieldLabelCreated}Bestellung Datum{/s}'
        },
		imported: {
            label: '{s name=fieldLabelImported}Import Datum{/s}'
        },
		ordertime: {
            label: '{s name=fieldLabelOrdertime}Export Datum{/s}'
        },
		invoice_amount: {
            label: '{s name=fieldLabelInvoiceAmount}Gesamtbetrag{/s}'
        },
		customercomment: {
            label: '{s name=fieldLabelCustomerComment}Kunden-Kommentar{/s}',
            support: '{s name=supportTextCustomerComment}Kommentar des Kunden vom jeweiligen Marktplatz{/s}'
        },
		internalcomment: {
            label: '{s name=fieldLabelInternalComment}Interner-Kommentar{/s}',
            support: '{s name=supportTextInternalComment}Interner Kommentar vom jeweiligen Marktplatz{/s}'
        }
    },
	
    initComponent : function () {
        var me = this;
		me.title = me.snippets.title;
        me.items = me.createFormPanel();
        me.callParent(arguments);
		me.loadRecord(me.record);
    },

    createFormPanel: function() 
    {
        var me = this;
        return Ext.create('Ext.container.Container', {
            region: 'center',
            width: '100%',
            items: [
				me.createTopElement(),
				me.createDetailsElement(),
				me.createCommentElement()
			],
        });
    },
	
	createTopElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.container.Container', {
			layout: {
                type: 'hbox',
                align: 'stretch'
            },
			height: 150,
			items:[{
				xtype: 'form',
				title: me.snippets.container.billing,
				bodyPadding: 10,
				bodyStyle: 'background-color: #fff',
				flex: 1,
            	layout: 'anchor',
				defaults: {
                	hideLabel: true,
					margin: '0',
                	anchor: '100%'
            	},
				items:[{
					fieldLabel: 'Company',
					xtype: 'displayfield',
					value: me.record.get('b_company')
				},{
					fieldLabel: 'Name',
					xtype: 'displayfield',
					value: me.record.get('b_firstname') + ' ' + me.record.get('b_lastname')
				},{
					fieldLabel: 'Street',
					xtype: 'displayfield',
					value: me.record.get('b_street') + ' ' + me.record.get('b_streetnumber')
				},{
					fieldLabel: 'City',
					xtype: 'displayfield',
					value: me.record.get('b_zipcode') + ' ' + me.record.get('b_city')
				},{
					fieldLabel: 'Country',
					xtype: 'displayfield',
					value: me.record.get('b_country')
				}]
			},{
				xtype: 'form',
				title: me.snippets.container.shipping,
				bodyPadding: 10,
				bodyStyle: 'background-color: #fff',
				margin: '0 10 0 10',
				flex: 1,
            	layout: 'anchor',
				defaults: {
                	hideLabel: true,
					margin: '0',
                	anchor: '100%'
            	},
				items:[{
					fieldLabel: 'Company',
					xtype: 'displayfield',
					value: me.record.get('s_company')
				},{
					fieldLabel: 'Name',
					xtype: 'displayfield',
					value: me.record.get('s_firstname') + ' ' + me.record.get('s_lastname')
				},{
					fieldLabel: 'Street',
					xtype: 'displayfield',
					value: me.record.get('s_street') + ' ' + me.record.get('s_streetnumber')
				},{
					fieldLabel: 'City',
					xtype: 'displayfield',
					value: me.record.get('s_zipcode') + ' ' + me.record.get('s_city')
				},{
					fieldLabel: 'Country',
					xtype: 'displayfield',
					value: me.record.get('s_country')
				}]
			},{
				xtype: 'form',
				title: me.snippets.container.payment,
				bodyPadding: 10,
				bodyStyle: 'background-color: #fff',
				flex: 1,
            	layout: 'anchor',
				defaults: {
                	hideLabel: true,
					margin: '0',
                	anchor: '100%'
            	},
				items:[{
					fieldLabel: 'Payment',
					xtype: 'displayfield',
					value: me.record.get('payment')
				}]
			}]
		});
		
		return itemsData;
	},
	
	createDetailsElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.form.Panel', {
			title: me.snippets.container.details,
			layout: 'column',
			bodyPadding: 10,
			margin: '10 0',
			items:[{
				xtype: 'container',
				columnWidth: .5,
            	border: false,
            	layout: 'anchor',
				defaults: {
                	labelWidth: 150,
                	anchor: '100%'
            	},
				items:[{
					fieldLabel: me.snippets.account.label,
					xtype: 'displayfield',
					name: 'account'
				},{
					fieldLabel: me.snippets.external_order_number.label,
					xtype: 'displayfield',
					name: 'external_order_number'
				},{
					fieldLabel: me.snippets.ordernumber.label,
					xtype: 'displayfield',
					name: 'ordernumber'
				},{
					fieldLabel: me.snippets.invoice_shipping.label,
					xtype: 'displayfield',
					name: 'invoice_shipping',
					renderer: me.renderInvoiceSum
				}]
			},{
				xtype: 'container',
				columnWidth: .5,
            	border: false,
            	layout: 'anchor',
				defaults: {
                	labelWidth: 150,
                	anchor: '100%'
            	},
				items:[{
					fieldLabel: me.snippets.created.label,
					xtype: 'displayfield',
					name: 'created'
				},{
					fieldLabel: me.snippets.imported.label,
					xtype: 'displayfield',
					name: 'imported'
				},{
					fieldLabel: me.snippets.ordertime.label,
					xtype: 'displayfield',
					name: 'ordertime'
				},{
					fieldLabel: me.snippets.invoice_amount.label,
					xtype: 'displayfield',
					name: 'invoice_amount',
					renderer: me.renderInvoiceSum
				}]
			}]
		});
		
		return itemsData;
	},
	
	createCommentElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.form.Panel', {
			title: me.snippets.container.communication,
			layout: 'anchor',
			bodyPadding: 10,
			defaults: {
				labelWidth: 120,
				height: 100,
				anchor: '100%'
            },
			items:[{
				fieldLabel: me.snippets.customercomment.label,
            	xtype: 'textarea',
            	name: 'customercomment',
            	grow: true,
            	supportText: me.snippets.customercomment.support
			},{
				fieldLabel: me.snippets.internalcomment.label,
            	xtype: 'textarea',
            	name: 'internalcomment',
				margin: '0 0 20 0',
            	grow: true,
            	supportText: me.snippets.internalcomment.support
			}]
		});
		
		return itemsData;
	},
	
	renderInvoiceSum: function(value) {
        if ( value === Ext.undefined ) {
            return value;
        }
        return Ext.util.Format.currency(value);
    },
});