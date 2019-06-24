// {namespace name=backend/plugins/external_order/view/detail/detail}
Ext.define('Shopware.apps.ExternalOrder.view.detail.Detail', {
    extend: 'Ext.form.Panel',
    alias: 'widget.externalorder-detail-detail',
	autoScroll: true,
	bodyPadding: 10,
	
	snippets: {
        title: '{s name=titleWindow}Detail{/s}',
		titleFieldSet: {
            billing: '{s name=fieldSetBilling}Rechnungs-Daten{/s}',
            shipping: '{s name=fieldSetShipping}Alternative Lieferadresse{/s}',
			payment: '{s name=fieldSetPayment}Zahlungs-Daten{/s}'
        },
		salutation: {
            label: '{s name=fieldLabelSalutation}Anrede{/s}',
			comboMr: '{s name=comboMrSalutation}Herr{/s}',
			comboMs: '{s name=comboMsSalutation}Frau{/s}',
			comboCompany: '{s name=comboCompanySalutation}Firma{/s}'
        },
		firstname: {
            label: '{s name=fieldLabelFirstname}Vorname{/s}'
        },
		lastname: {
            label: '{s name=fieldLabelLastname}Nachname{/s}'
        },
		street: {
            label: '{s name=fieldLabelStreet}Straße{/s}'
        },
		streetnumber: {
            label: '{s name=fieldLabelStreetnumber}Straßennummer{/s}'
        },
		additionalAddressLine1: {
            label: '{s name=fieldLabelAdditionalAddressLine1}Adresszusatz 1{/s}'
        },
		additionalAddressLine2: {
            label: '{s name=fieldLabelAdditionalAddressLine2}Adresszusatz 2{/s}'
        },
		zipcode: {
            label: '{s name=fieldLabelZipcode}Postleitzahl{/s}'
        },
		city: {
            label: '{s name=fieldLabelCity}Stadt{/s}'
        },
		countryID: {
            label: '{s name=fieldLabelCountryID}Land{/s}'
        },
		company: {
            label: '{s name=fieldLabelCompany}Firma{/s}'
        },
		email: {
            label: '{s name=fieldLabelEmail}Email{/s}'
        },
		phone: {
            label: '{s name=fieldLabelPhone}Telefon{/s}'
        },
		fax: {
            label: '{s name=fieldLabelFax}Fax{/s}'
        },
		birthday: {
            label: '{s name=fieldLabelBirthday}Geburtstag{/s}'
        },
		paymentID: {
            label: '{s name=fieldLabelPaymentID}Zahlungsart{/s}',
			help: '{s name=helpTextPaymentID}Bei einer Änderung wird der Gesamtbetrag NICHT neu berechnet{/s}'
        },
		buttons: {
            save: '{s name=saveButton}Speichern{/s}',
			cancel: '{s name=cancelButton}Abbrechen{/s}',
			copy: '{s name=copyButton}Daten kopieren{/s}',
        },
		notice: '{s name=notice}Für Usability Zwecke, klicken Sie hier, um die Rechnungsadresse als Lieferadresse verwenden.{/s}'
    },
	
    initComponent : function () {
        var me = this;
		me.title = me.snippets.title;
		me.registerEvents();
        me.items = me.createFormPanel();
		me.buttons = me.createButtons();
        me.callParent(arguments);
		me.loadRecord(me.record);
    },
	
	registerEvents:function () {
        this.addEvents(
			'updateCustomer',
			'copyAddress'
        );

        return true;
    },

    createFormPanel: function() 
    {
        var me = this;
        return Ext.create('Ext.container.Container', {
            region: 'center',
            width: '100%',
            items: [
				me.createBillingElement(),
				me.createShippingElement(),
				me.createPaymentElement()
			],
        });
    },
	
	createBillingElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.form.FieldSet', {
			title: me.snippets.titleFieldSet.billing,
			layout: 'column',
			bodyPadding: 10,
			items:[{
				xtype: 'container',
				columnWidth:.5,
            	border: false,
            	layout: 'anchor',
					defaults: {
						labelWidth: 120,
						anchor: '95%'
            	},
				items:[{
					fieldLabel: me.snippets.salutation.label,
					xtype: 'combobox',
					name: 'b_salutation',
					store: [
						['mr', me.snippets.salutation.comboMr],
						['ms', me.snippets.salutation.comboMs],
						['company', me.snippets.salutation.comboCompany]
					],
					allowBlank: false,
					editable: false
				},{
					fieldLabel: me.snippets.firstname.label,
					xtype: 'textfield',
					name: 'b_firstname',
					allowBlank: false
				},{
					fieldLabel: me.snippets.lastname.label,
					xtype: 'textfield',
					name: 'b_lastname',
					allowBlank: false
				},{
					fieldLabel: me.snippets.street.label,
					xtype: 'textfield',
					name: 'b_street',
					allowBlank: false
				},{
					fieldLabel: me.snippets.streetnumber.label,
					xtype: 'textfield',
					name: 'b_streetnumber',
					allowBlank: false
				},{
					fieldLabel: me.snippets.additionalAddressLine1.label,
					xtype: 'textfield',
					name: 'b_additionalAddressLine1'
				},{
					fieldLabel: me.snippets.additionalAddressLine2.label,
					xtype: 'textfield',
					name: 'b_additionalAddressLine2'
				},{
					fieldLabel: me.snippets.zipcode.label,
					xtype: 'textfield',
					name: 'b_zipcode',
					allowBlank: false
				},{
					fieldLabel: me.snippets.city.label,
					xtype: 'textfield',
					name: 'b_city',
					allowBlank: false
				},{
					fieldLabel: me.snippets.countryID.label,
					xtype: 'combobox',
					name: 'b_countryID',
					store: me.countriesStore,
					valueField: 'id',
					displayField: 'name',
					queryMode: 'local',
					allowBlank: false,
					editable: false
				}]
			},{
				xtype: 'container',
				columnWidth:.5,
            	border: false,
            	layout: 'anchor',
					defaults: {
						labelWidth: 120,
						anchor: '100%'
            	},
				items:[{
					fieldLabel: me.snippets.company.label,
					xtype: 'textfield',
					name: 'b_company'
				},{
					fieldLabel: me.snippets.email.label,
					xtype: 'textfield',
					name: 'b_email',
					allowBlank: false
				},{
					fieldLabel: me.snippets.phone.label,
					xtype: 'textfield',
					name: 'b_phone'
				},{
					fieldLabel: me.snippets.fax.label,
					xtype: 'textfield',
					name: 'b_fax'
				},{
					fieldLabel: me.snippets.birthday.label,
					xtype: 'datefield',
					name: 'b_birthday',
					maxValue: new Date(),
					format: 'd.m.Y',
					altFormats: 'Y-m-d',
					submitFormat: 'Y-m-d',
					editable: false
				}]
			}]
		});
		
		return itemsData;
	},
	
	createShippingElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.form.FieldSet', {
			title: me.snippets.titleFieldSet.shipping,
			layout: 'column',
			collapsible: true,
    		collapsed: false,
			bodyPadding: 10,
			items:[{
				xtype: 'container',
				columnWidth: 1,
            	border: false,
            	layout: 'anchor',
					defaults: {
                		labelWidth: 120,
						anchor: '100%'
            	},
				items:[{
					border: false,
                	cls: Ext.baseCSSPrefix + 'copy-billing-label small',
					margin: '0 0 10px 0',
					html: me.snippets.notice
				},{
					xtype: 'button',
					iconCls: 'sprite-blue-document-copy',
					cls: Ext.baseCSSPrefix + 'copy-billing-button',
					text: me.snippets.buttons.copy,
					action: 'copy-data',
					margin: '0 0 10px 0',
					anchor: '15%',
					handler:function () {
						me.fireEvent('copyAddress');
					}
				}]
			},{
				xtype: 'container',
				columnWidth:.5,
            	border: false,
            	layout: 'anchor',
					defaults: {
						labelWidth: 120,
						anchor: '95%'
            	},
				items:[{
					fieldLabel: me.snippets.salutation.label,
					xtype: 'combobox',
					name: 's_salutation',
					store: [
						['mr', me.snippets.salutation.comboMr],
						['ms', me.snippets.salutation.comboMs],
						['company', me.snippets.salutation.comboCompany]
					],
					allowBlank: false,
					editable: false
				},{
					fieldLabel: me.snippets.firstname.label,
					xtype: 'textfield',
					name: 's_firstname',
					allowBlank: false
				},{
					fieldLabel: me.snippets.lastname.label,
					xtype: 'textfield',
					name: 's_lastname',
					allowBlank: false
				},{
					fieldLabel: me.snippets.street.label,
					xtype: 'textfield',
					name: 's_street',
					allowBlank: false
				},{
					fieldLabel: me.snippets.streetnumber.label,
					xtype: 'textfield',
					name: 's_streetnumber',
					allowBlank: false
				},{
					fieldLabel: me.snippets.additionalAddressLine1.label,
					xtype: 'textfield',
					name: 's_additionalAddressLine1'
				},{
					fieldLabel: me.snippets.additionalAddressLine2.label,
					xtype: 'textfield',
					name: 's_additionalAddressLine2'
				}]
			},{
				xtype: 'container',
				columnWidth:.5,
            	border: false,
            	layout: 'anchor',
					defaults: {
						labelWidth: 120,
						anchor: '100%'
            	},
				items:[{
					fieldLabel: me.snippets.zipcode.label,
					xtype: 'textfield',
					name: 's_zipcode',
					allowBlank:false
				},{
					fieldLabel: me.snippets.city.label,
					xtype: 'textfield',
					name: 's_city',
					allowBlank: false
				},{
					fieldLabel: me.snippets.countryID.label,
					xtype: 'combobox',
					name: 's_countryID',
					store: me.countriesStore,
					valueField: 'id',
					displayField: 'name',
					queryMode: 'local',
					allowBlank: false,
					editable: false
				},{
					fieldLabel: me.snippets.company.label,
					xtype: 'textfield',
					name: 's_company'
				},{
					fieldLabel: me.snippets.phone.label,
					xtype: 'textfield',
					name: 's_phone'
				}]
			}]
		});
		
		return itemsData;
	},
	
	createPaymentElement: function () {
        var me = this;
		var itemsData = Ext.create('Ext.form.FieldSet', {
			title: me.snippets.titleFieldSet.payment,
			layout: 'fit',
			bodyPadding: 10,
				defaults: {
					labelWidth: 120,
					anchor: '100%'
            },
			items:[{
				xtype: 'hiddenfield',
				name: 'id',
			},{
				fieldLabel: me.snippets.paymentID.label,
				xtype: 'combobox',
				name: 'paymentID',
				store: me.paymentsStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				allowBlank: false,
				editable: false,
				helpText: me.snippets.paymentID.help
			}]
		});
		
		return itemsData;
	},
	
    createButtons: function() 
    {
        var me = this;
        return [{
			text: me.snippets.buttons.cancel,
			cls: 'secondary',
			scope: me,
            handler: function () {
                me.up('window').destroy();
            }
		},{
			text: me.snippets.buttons.save,
			cls: 'primary',
			action: 'updateCustomer',
			handler: function() {
				me.fireEvent('updateCustomer');
            }
		}];
    }
});