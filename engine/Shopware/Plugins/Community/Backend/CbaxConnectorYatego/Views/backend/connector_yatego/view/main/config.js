// {namespace name=backend/plugins/connector_yatego/view/main/config}
Ext.define('Shopware.apps.ConnectorYatego.view.main.Config', {
	extend: 'Ext.form.Panel',
    alias: 'widget.connectoryatego-view-main-config',
    border: false,
    autoShow : true,
	layout: 'fit',
	autoScroll: true,
	
	snippets: {
		titleFieldSet: {
            access: '{s name=fieldSetAccess}Zugangsdaten{/s}',
            import: '{s name=fieldSetImport}Import{/s}',
			general: '{s name=fieldSetGeneral}Zuordnung Allgemein{/s}',
			payment: '{s name=fieldSetPayment}Zuordnung Zahlungsarten{/s}'
        },
		user: {
            label: '{s name=fieldLabelUser}Benutzername{/s}',
            help: '{s name=helpTextUser}Benutzername zur API von Yatego{/s}'
        },
		pass: {
            label: '{s name=fieldLabelPass}Passwort{/s}',
            help: '{s name=helpTextPass}Passwort zur API von Yatego{/s}'
        },
		url: {
            label: '{s name=fieldLabelUrl}Url{/s}',
            help: '{s name=helpTextUrl}URL zur API von Yatego{/s}'
        },
		buttons: {
            check: '{s name=checkButton}Verbindung überprüfen{/s}'
        },
		last_import_date: {
            label: '{s name=fieldLabelLastImportDate}Letzter automatischer Import{/s}'
        },
		status: {
            label: '{s name=fieldLabelStatus}Bestellstatus nach Import{/s}'
        },
		cleared: {
            label: '{s name=fieldLabelCleared}Zahlstatus nach Import{/s}'
        },
		shop_id: {
            label: '{s name=fieldLabelShopId}Subshop{/s}',
			help: '{s name=helpTextShopId}Welchen Shop sollen die Bestellungen zugeordnet werden{/s}'
        },
		tax_id: {
            label: '{s name=fieldLabelTaxId}Steuersatz{/s}',
			help: '{s name=helpTextTaxId}Welchen Steuersatz sollen die Bestellungen bekommen{/s}'
        },
		dispatch_id: {
            label: '{s name=fieldLabelDispatchId}Versandart{/s}',
			help: '{s name=helpTextDispatchId}Welcher Versandart sollen die Bestellungen zugewiesen werden{/s}'
        },
		dispatch_carrier: {
            label: '{s name=fieldLabelDispatchCarrier}Versand Dienstleister{/s}',
			help: '{s name=helpTextDispatchCarrier}Über welchen Versand Dienstleister werden die Waren versendet{/s}'
        },
		customergroup_key: {
            label: '{s name=fieldLabelCustomergroupKey}Kundengruppe{/s}',
			help: '{s name=helpTextCustomergroupKey}Welcher Kundengruppe sollen die Bestellungen zugewiesen werden? Am besten Sie nehmen eine neue Kundengruppe z.B.: Yatego, dann können Sie auch eigene Preise pflegen und die Bestellungen in der Statistik getrennt auswerten{/s}'
        },
		payment_vorauskasse_id: {
            label: '{s name=fieldLabelPaymentVorauskasseId}Vorauskasse{/s}',
			help: '{s name=helpTextPaymentVorauskasseId}Zuordung Vorauskasse{/s}'
        },
		payment_barzahlung_id: {
            label: '{s name=fieldLabelPaymentBarzahlungId}Barzahlen{/s}',
			help: '{s name=helpTextPaymentBarzahlungId}Zuordung Barzahlen{/s}'
        },
		payment_nachnahme_id: {
            label: '{s name=fieldLabelPaymentNachnahmeId}Nachnahme{/s}',
			help: '{s name=helpTextPaymentNachnahmeId}Zuordung Nachnahme{/s}'
        },
		payment_kreditkarte_id: {
            label: '{s name=fieldLabelPaymentKreditkarteId}Kreditkarte{/s}',
			help: '{s name=helpTextPaymentKreditkarteId}Zuordung Kreditkarte{/s}'
        },
		payment_sofortueberweisung_id: {
            label: '{s name=fieldLabelPaymentSofortueberweisungId}Sofortüberweisung{/s}',
			help: '{s name=helpTextPaymentSofortueberweisungId}Zuordung Sofortüberweisung{/s}'
        },
		payment_paypal_id: {
            label: '{s name=fieldLabelPaymentPaypalId}PayPal{/s}',
			help: '{s name=helpTextPaymentPaypalId}Zuordung PayPal{/s}'
        },
		payment_rechnung_id: {
            label: '{s name=fieldLabelRechnungPaypalId}Rechnung{/s}',
			help: '{s name=helpTextPaymentRechnungId}Zuordung Rechnung{/s}'
        }
    },
	
	registerEvents: function() {
        this.addEvents('recordloaded');
    },
	
    initComponent: function() {
        var me = this;
        me.items = me.createFormPanel();
		
        me.callParent(arguments);
		me.getForm().load({
			url: '{url controller="ConnectorYatego" action="loadConfig"}',
			scope: me,
			success:function(form, action)
			{
				me.fireEvent('recordloaded', me);
			}
		});
    },
	
	createFormPanel: function() 
    {
        var me = this;
        return Ext.create('Ext.form.Panel', {
            region: 'center',
            autoScroll: true,
			bodyPadding: 10,
            items: [
				me.createAccountElement(),
				me.createImportElement(),
				me.createGeneralElement(),
				me.createPaymentElement()
			],
        });
    },
	
	createAccountElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.form.FieldSet', {
			title: me.snippets.titleFieldSet.access,
			bodyPadding: 10,
			layout: 'anchor',
			defaults: {
				labelWidth: 300,
				allowBlank: false,
				anchor: '100%'
			},
			items:[{
				fieldLabel: me.snippets.user.label,
				xtype: 'textfield',
				name: 'user',
				helpText: me.snippets.user.help
			},{
				fieldLabel: me.snippets.pass.label,
				xtype: 'textfield',
				name: 'pass',
				helpText: me.snippets.pass.help
			},{
				fieldLabel: me.snippets.url.label,
				xtype: 'textfield',
				name: 'url',
				vtype: 'url',
				helpText: me.snippets.url.help
			},{
				xtype: 'button',
				text: me.snippets.buttons.check,
				anchor: 'auto',
            	margin: '0 0 0 305',
				cls: 'small primary',
				disabled: true,
				name: 'checkAccess',
				action: 'checkAccess'
			}]
		});
		
		return itemsData;
	},
	
	createImportElement: function () {
        var me = this;
		
		me.orderstateStore.filterBy(function(item) { return item.get("id") > -1; });
		
		var itemsData = Ext.create('Ext.form.FieldSet', {
			title: me.snippets.titleFieldSet.import,
			bodyPadding: 10,
			layout: 'anchor',
			defaults: {
				labelWidth: 300,
				allowBlank: false,
				anchor: '100%'
			},
			items: [{
				xtype: 'container',
				layout: 'column',
				anchor: '100%',
				margin: '0 0 5px 0',
				defaults:{
					labelWidth: 300,
					anchor: '100%',
					allowBlank: false
				},
				items: [{
					fieldLabel: me.snippets.last_import_date.label,
					xtype: 'datefield',
					name: 'last_import_date',
					maxValue: new Date(),
					format: 'd.m.Y',
					altFormats: 'Y-m-d',
					submitFormat: 'Y-m-d',
					editable: false,
					columnWidth: .6
				},{
					xtype: 'timefield',
					name: 'last_import_time',
					columnWidth: .4,
					labelWidth: 0
				}]
			},{
				fieldLabel: me.snippets.status.label,
				xtype: 'combobox',
				name: 'status',
				store: me.orderstateStore,
				valueField: 'id',
				displayField: 'description',
				queryMode: 'local',
				editable: false
			},{
				fieldLabel: me.snippets.cleared.label,
				xtype: 'combobox',
				name: 'cleared',
				store: me.paymentstateStore,
				valueField: 'id',
				displayField: 'description',
				queryMode: 'local',
				editable: false
			}]
		});
		
		return itemsData;
	},
	
	createGeneralElement: function () {
        var me = this;

		me.carrierStore = Ext.create('Shopware.apps.Order.ExternalOrder.store.Carrier');
		me.carrierStore.getProxy().extraParams = {
			account: 'yatego'
		};

		return Ext.create('Ext.form.FieldSet', {
			title: me.snippets.titleFieldSet.general,
			bodyPadding: 10,
			layout: 'anchor',
			defaults: {
				labelWidth: 300,
				allowBlank: false,
				anchor: '100%'
			},
			items: [{
				fieldLabel: me.snippets.shop_id.label,
				xtype: 'combobox',
				name: 'shop_id',
				store: me.subshopStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.shop_id.help
			},{
				fieldLabel: me.snippets.tax_id.label,
				xtype: 'combobox',
				name: 'tax_id',
				store: me.taxStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.tax_id.help
			},{
				fieldLabel: me.snippets.dispatch_id.label,
				xtype: 'combobox',
				name: 'dispatch_id',
				store: me.dispatchStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.dispatch_id.help
			},{
				fieldLabel: me.snippets.dispatch_carrier.label,
				xtype: 'combobox',
				name: 'dispatch_carrier',
				store: me.carrierStore,
				displayField: 'description',
				valueField: 'name',
				editable: false,
				helpText: me.snippets.dispatch_carrier.help
			},{
				fieldLabel: me.snippets.customergroup_key.label,
				xtype: 'combobox',
				name: 'customergroup_key',
				store: me.customergroupStore,
				valueField: 'groupkey',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.customergroup_key.help
			}]
		});
	},
	
	createPaymentElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.form.FieldSet', {
			title: me.snippets.titleFieldSet.payment,
			bodyPadding: 10,
			layout: 'anchor',
			defaults: {
				labelWidth: 300,
				allowBlank: false,
				anchor: '100%'
			},
			items: [{
				fieldLabel: me.snippets.payment_vorauskasse_id.label,
				xtype: 'combobox',
				name: 'payment_vorauskasse_id',
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.payment_vorauskasse_id.help
			},{
				fieldLabel: me.snippets.payment_barzahlung_id.label,
				xtype: 'combobox',
				name: 'payment_barzahlung_id',
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.payment_barzahlung_id.help
			},{
				fieldLabel: me.snippets.payment_nachnahme_id.label,
				xtype: 'combobox',
				name: 'payment_nachnahme_id',
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.payment_nachnahme_id.help
			},{
				fieldLabel: me.snippets.payment_kreditkarte_id.label,
				xtype: 'combobox',
				name: 'payment_kreditkarte_id',
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.payment_kreditkarte_id.help
			},{
				fieldLabel: me.snippets.payment_sofortueberweisung_id.label,
				xtype: 'combobox',
				name: 'payment_sofortueberweisung_id',
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.payment_sofortueberweisung_id.help
			},{
				fieldLabel: me.snippets.payment_paypal_id.label,
				xtype: 'combobox',
				name: 'payment_paypal_id',
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.payment_paypal_id.help
			},{
				fieldLabel: me.snippets.payment_rechnung_id.label,
				xtype: 'combobox',
				name: 'payment_rechnung_id',
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false,
				helpText: me.snippets.payment_rechnung_id.help
			
			}]
		});
		
		return itemsData;
	}
});
