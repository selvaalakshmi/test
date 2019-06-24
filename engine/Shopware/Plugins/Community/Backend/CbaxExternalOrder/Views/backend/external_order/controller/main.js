// {namespace name=backend/plugins/external_order/controller/main}
Ext.define('Shopware.apps.ExternalOrder.controller.Main', {
    extend: 'Ext.app.Controller',
	
	mainWindow: null,
	
	snippets: {
    	loading: {
    		importOrder: '{s name=loadingImportOrder}Importiere Bestellungen...{/s}'
		},
		success: {
			title: '{s name=successTitle}Erfolgreich{/s}',
			generateShopwareOrder: '{s name=successGenerateShopwareOrder}Die Shopware Bestellung wurde erfolgreich erstellt{/s}',
			statusSendOrder: '{s name=successStatusSendOrder}Der Versandstatus wurde erfolgreich aktualisiert{/s}',
			updateCustomer: '{s name=successUpdateCustomer}Die Daten wurden erfolgreich gespeichert{/s}',
			importOrder: '{s name=successImportOrder}Die Bestellung wurde erfolgreich importiert{/s}'
		},
		failure: {
			title: '{s name=failureTitle}Fehler{/s}',
			generateShopwareOrder: '{s name=failureGenerateShopwareOrder}Die Shopware Bestellung konnte NICHT erstellt werden!<br />{/s}',
			generateShopwareOrder2: '{s name=failureGenerateShopwareOrder2}Diese Bestellung wurde bereits in eine Shopware Bestellung umgewandelt!{/s}',
			statusSendOrder: '{s name=failureStatusSendOrder}Der Versandstatus wurde NICHT aktualisiert!<br />{/s}',
			statusSendOrder2: '{s name=failureStatusSendOrder2}Diese Bestellung wurde noch nicht in eine Shopware-Bestellung umgewandelt!{/s}',
			statusSendOrder3: '{s name=failureStatusSendOrder3}Der Versandstatus der Bestellung wurde schon gesendet!{/s}',
			statusSendOrder4: '{s name=failureStatusSendOrder4}Diese Bestellung wurde noch nicht versendet!{/s}',
			updateCustomer: '{s name=failureUpdateCustomer}Die Daten wurden NICHT gespeichert!{/s}',
			importOrder: '{s name=failureImportOrder}Die Bestellung wurde NICHT importiert!{/s}'
		},
		warning: {
			title: '{s name=warningTitle}Warnung{/s}',
			generateShopwareOrder: '{s name=warningGenerateShopwareOrder}Möchten Sie wirklich die Bestellung <b> [0] </b> in eine Shopware Bestellung umwandeln?{/s}',
			statusSendOrder: '{s name=warningStatusSendOrder}Möchten Sie wirklich den Versandstatus der Bestellung <b> [0] </b> aktualisieren?{/s}',
			orderDelete: '{s name=warningOrderDelete}Möchten Sie die Bestellung <b>[0]</b> wirklich löschen?{/s}',
			multipleOrderDelete: '{s name=warningMultipleOrderDelete}Sie haben <b>[0]</b> Bestellungen markiert. Möchten Sie wirklich diese Bestellungen löschen?{/s}',
			multipleOrderGenerate: '{s name=warningMultipleOrderGenerate}Sie haben <b>[0]</b> Bestellungen markiert. Möchten Sie wirklich diese Bestellungen generieren?{/s}'
		}
	},
	
	refs: [{
		ref: 'filterPanel',
		selector: 'externalorder-view-Main > externalorder-main-navigation > externalorder-main-filterpanel'
	},{
        ref: 'formDetail',
        selector: 'externalorder-detail-window > tabpanel > externalorder-detail-detail'
    },{
        ref: 'windowImport',
        selector: 'externalorder-main-window'
    },{
        ref: 'formImport',
        selector: 'externalorder-main-window > form'
    },{
		ref: 'textfieldExternalOrderSearch',
		selector: 'externalorder-view-Main > externalorder-main-list > toolbar > textfield[name=searchOrder]'
	}],

    init: function() {
        var me = this;
		
		me.control({
            'externalorder-main-list' : {
				generateShopwareOrder: me.onGenerateShopwareOrder,
				deleteExternalOrder: me.onDeleteExternalOrder,
				editExternalOrder: me.onEditExternalOrder,
				statusSendOrder: me.onStatusSendOrder,
				// Store laden ohne Filter
				beforerender: me.filterExternalOrder
			},
			'externalorder-main-list button[action=deleteMultipleOrder]' : {
				click: me.onDeleteMultipleOrder
            },
			'externalorder-main-list button[action=generateMultipleOrder]' : {
				click: me.onGenerateMultipleOrder
            },
			'externalorder-main-list textfield[action=searchOrder]' : {
                change: me.onSearch
            },
			'externalorder-main-filterpanel button[action=filterExternalOrder]':
			{
				click: me.filterExternalOrder
			},
			'externalorder-main-filterpanel button[action=clearFilterExternalOrder]':
			{
				click: me.clearFilterExternalOrder
			},
			'externalorder-main-filterpanel button[action=importExternalOrder]' : {
				click: me.onImportExternalOrder
            },
			'externalorder-main-window button[action=importOrder]' : {
				click: me.onImportOrder
            },
			'externalorder-detail-position' : {
				openArticle: me.onOpenArticle
            },
			'externalorder-detail-detail' : {
				copyAddress: me.onCopyAddress,
				updateCustomer: me.onUpdateCustomer
            }
		});
		
		me.mainWindow = me.getView('Main').create({
            externalOrderStore: me.getStore('List'),
			accountStore: me.getStore('Account'),
			paymentStore: me.getStore('Payment'),
			statusStore:  Ext.create('Shopware.apps.Base.store.OrderStatus').load(),
			statisticStore: me.getStore('Statistic').load()
        });

        me.callParent(arguments);
    },
	
	onEditExternalOrder: function(view, rowIndex, colIndex, item)
	{
		 var me = this,
            customerStore = me.getStore('Customer'),
			orderStore = me.getStore('Order'),
            record = me.getStore('List').getAt(rowIndex);

        customerStore.getProxy().extraParams = {
            id: record.get('id')
        };
		
		orderStore.getProxy().extraParams = {
            id: record.get('id')
        };
		
        customerStore.load({
            callback:function (records, operation, success) {
                var record = records[0];

                Ext.create('Shopware.apps.ExternalOrder.view.detail.Window', {
                    record: record,
					orderStore: orderStore.load(),
					countriesStore: me.getStore('Country'),
					paymentsStore: me.getStore('Payment')
                });
            }
        });
	},
	
	onGenerateShopwareOrder: function(view, rowIndex, colIndex, item)
	{
		var store = view.getStore(),
			me = this,
			values = store.data.items[rowIndex].data;
		
		if((values.ordernumber !== undefined) && (values.ordernumber !== null) && (values.ordernumber != ''))
		{
			Ext.Msg.show({
				title: me.snippets.failure.title,
				msg: me.snippets.failure.generateShopwareOrder2,
				icon: Ext.Msg.ERROR,
				buttons: Ext.Msg.OK
			});
			return;
		}
		
		message = Ext.String.format(me.snippets.warning.generateShopwareOrder, values.external_order_number);

        //Create a message-box, which has to be confirmed by the user
        Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response){
            //If the user doesn't want to generate the order
            if(response !== 'yes')
            {
                return false;
            }
            Ext.Ajax.request(
			{
				url: '{url controller="ExternalOrder" action="generateShopwareOrder"}',
				params:
				{
					'id': values.id
				},
				success: function(response)
				{
					var status = Ext.decode(response.responseText),
						errorMsg = (status.errorMsg) ? status.errorMsg : me.snippets.failure.generateShopwareOrder;
					
					if (status.success)
					{
						Shopware.Notification.createGrowlMessage(me.snippets.success.title, me.snippets.success.generateShopwareOrder);
						store.load();
					}
					else
					{
						Ext.Msg.show({
							title: me.snippets.failure.title,
							msg: errorMsg,
							icon: Ext.Msg.ERROR,
							buttons: Ext.Msg.OK
						});
					}
				},
				failure: function(response)
				{
					var status = Ext.decode(response.responseText),
						errorMsg = (status.errorMsg) ? status.errorMsg : me.snippets.failure.generateShopwareOrder;
					
					Ext.Msg.show({
						title: me.snippets.failure.title,
						msg: errorMsg,
						icon: Ext.Msg.ERROR,
						buttons: Ext.Msg.OK
					});		
				}
			});
        });
	},
	
	onStatusSendOrder: function(view, rowIndex, colIndex, item)
	{
		var store = view.getStore(),
			me = this,
			values = store.data.items[rowIndex].data;
		
		if((values.ordernumber == undefined) || (values.ordernumber == null) || (values.ordernumber == ''))
		{
			Ext.Msg.show({
				title: me.snippets.failure.title,
				msg: me.snippets.failure.statusSendOrder2,
				icon: Ext.Msg.ERROR,
				buttons: Ext.Msg.OK
			});
			return;
		}
		
		if(values.shipped_to_account > 1)
		{
			Ext.Msg.show({
				title: me.snippets.failure.title,
				msg: me.snippets.failure.statusSendOrder3,
				icon: Ext.Msg.ERROR,
				buttons: Ext.Msg.OK
			});
			return;
		}
		
		if(values.shipped_to_account < 1)
		{
			Ext.Msg.show({
				title: me.snippets.failure.title,
				msg: me.snippets.failure.statusSendOrder4,
				icon: Ext.Msg.ERROR,
				buttons: Ext.Msg.OK
			});
			return;
		}
		
		message = Ext.String.format(me.snippets.warning.statusSendOrder, values.external_order_number);

        //Create a message-box, which has to be confirmed by the user
        Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response){
            //If the user doesn't want to send the status
            if(response != 'yes')
            {
                return false;
            }
            Ext.Ajax.request(
			{
				url: '{url controller="ExternalOrder" action="statusSendOrder"}',
				params:
				{
					'id': values.id,
					'account': values.account
				},
				success: function(response)
				{
					var status = Ext.decode(response.responseText),
						errorMsg = (status.errorMsg) ? status.errorMsg : me.snippets.failure.statusSendOrder;
					
					if (status.success)
					{
						Shopware.Notification.createGrowlMessage(me.snippets.success.title, me.snippets.success.statusSendOrder);
						store.load();
					}
					else
					{
						Ext.Msg.show({
							title: me.snippets.failure.title,
							msg: errorMsg,
							icon: Ext.Msg.ERROR,
							buttons: Ext.Msg.OK
						});
					}
				},
				failure: function(response)
				{
					var status = Ext.decode(response.responseText),
						errorMsg = (status.errorMsg) ? status.errorMsg : me.snippets.failure.statusSendOrder;
					
					Ext.Msg.show({
						title: me.snippets.failure.title,
						msg: errorMsg,
						icon: Ext.Msg.ERROR,
						buttons: Ext.Msg.OK
					});
				}
			});
        });
	},
	
	onDeleteExternalOrder: function(view, rowIndex, colIndex, item)
	{
		var store = view.getStore(),
			values = store.data.items[rowIndex].data,
			me = this,
			message = Ext.String.format(me.snippets.warning.orderDelete, values.external_order_number);

        //Create a message-box, which has to be confirmed by the user
        Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response){
            //If the user doesn't want to delete the order
            if(response != 'yes')
            {
                return false;
            }
            var model = Ext.create('Shopware.apps.ExternalOrder.model.List', values);
            model.destroy({
                callback: function(){
                    store.load();
                }
            });
        });
	},
	
	onDeleteMultipleOrder: function (btn)
	{
		var win = btn.up('window'),
			grid = win.down('externalorder-main-list'),
			selModel = grid.selModel,
			index = 0,
			selection = selModel.getSelection(),
			me = this,
			message = Ext.String.format(me.snippets.warning.multipleOrderDelete, selection.length);

		//Create a message-box, which has to be confirmed by the user
        Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response){
            //If the user doesn't want to delete the order
            if (response !== 'yes')
            {
                return false;
            }

            Ext.each(selection, function(item){
                item.destroy({
                    callback: function() {
                        index++;
                        if (index == selection.length) {
							grid.getStore().load();
                        }
                    }
                })
            });
        });
    },
	
	onGenerateMultipleOrder: function (btn)
	{
		var win = btn.up('window'),
			grid = win.down('externalorder-main-list'),
			selModel = grid.selModel,
			index = 0,
			selection = selModel.getSelection(),
			me = this,
			message = Ext.String.format(me.snippets.warning.multipleOrderGenerate, selection.length);

		//Create a message-box, which has to be confirmed by the user
        Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response){
            //If the user doesn't want to generate the order
            if (response !== 'yes')
            {
                return false;
            }
			var records = [];
            Ext.each(selection, function(item){
				
				records.push(selection[index].get('id'));
				index++;
            });
			
			var params = {};
			params['id'] = Ext.JSON.encode(records);
			
			Ext.Ajax.request(
			{
				url: '{url controller="ExternalOrder" action="generateShopwareOrders"}',
				params: params,
				success: function(response)
				{
					grid.getStore().load();
				},
				failure: function(response)
				{
	
				}
			});
        });
    },
	
	onOpenArticle: function (view, rowIndex, colIndex, item)
	{
		var store = view.getStore(),
			record = store.getAt(rowIndex);
			
		Shopware.app.Application.addSubApplication({
            name: 'Shopware.apps.Article',
            action: 'detail',
            params: {
                articleId: record.get('articleID')
            }
        });
    },
	
	onUpdateCustomer: function() {
		var me = this,
			store = me.getStore('List'),
			form = me.getFormDetail().getForm();

		if (!form.isValid()) {
			return;
		}

		form.submit({
			url: '{url controller="ExternalOrder" action="updateCustomer"}',
			success: function (form, action) {
				if (action.result.success) {
					Shopware.Notification.createGrowlMessage(me.snippets.success.title, me.snippets.success.updateCustomer);
					store.load();
				}
				else {
					Ext.Msg.show({
						title: me.snippets.failure.title,
						msg: me.snippets.failure.updateCustomer,
						icon: Ext.Msg.ERROR,
						buttons: Ext.Msg.OK
					});
				}
			},
			failure: function (response, action) {
				Ext.Msg.show({
					title: me.snippets.failure.title,
					msg: me.snippets.failure.updateCustomer,
					icon: Ext.Msg.ERROR,
					buttons: Ext.Msg.OK
				});
			}
		});
	},
	
	onCopyAddress: function () {
		var me = this,
			basic = me.getFormDetail().getForm(),
            values = basic.getValues();

        //i tried to realise this over the form record, but the last overrides from the basic form and the form panel prevent it.
		values['s_salutation'] 				= values['b_salutation'];
        values['s_firstname'] 				= values['b_firstname'];
		values['s_lastname'] 				= values['b_lastname'];
		values['s_street'] 					= values['b_street'];
		values['s_streetnumber'] 			= values['b_streetnumber'];
		values['s_additionalAddressLine1'] 	= values['b_additionalAddressLine1'];
		values['s_additionalAddressLine2'] 	= values['b_additionalAddressLine2'];
		values['s_zipcode'] 				= values['b_zipcode'];
		values['s_city'] 					= values['b_city'];
		values['s_countryID'] 				= values['b_countryID'];
		values['s_company'] 				= values['b_company'];
		values['s_email'] 					= values['b_email'];
		values['s_email'] 					= values['b_phone'];
		
		basic.setValues(values);
    },

	onImportExternalOrder: function () {
		var me = this;

		me.getView('main.Window').create({
			accountStore: me.getStore('Account')
		}).show();
	},

	onImportOrder: function () {
		var me = this,
			store = me.getStore('List'),
			importWindow = me.getWindowImport(),
			importForm = me.getFormImport(),
			form = importForm.getForm();

		if (!form.isValid()) {
			return;
		}

		importWindow.setLoading(me.snippets.loading.importOrder);

		form.submit({
			url: '{url controller="ExternalOrder" action="importExternalOrder"}',
			success: function (form, action) {
				var status = Ext.JSON.decode(action.response.responseText),
					successmessage = (status.successmsg) ? status.successmsg : me.snippets.success.importOrder;

				importWindow.setLoading(false);

				if (status.success) {
					Shopware.Notification.createGrowlMessage(me.snippets.success.title, successmessage);
					store.load();
					importWindow.destroy();
				} else {
					Ext.Msg.show({
						title: me.snippets.failure.title,
						msg: me.snippets.failure.importOrder,
						icon: Ext.Msg.ERROR,
						buttons: Ext.Msg.OK
					});
				}
			},
			failure: function (form, action) {
				var status = Ext.JSON.decode(action.response.responseText),
					errorMsg = (status.errorMsg) ? status.errorMsg : me.snippets.failure.importOrder;

				importWindow.setLoading(false);

				Ext.Msg.show({
					title: me.snippets.failure.title,
					msg: errorMsg,
					icon: Ext.Msg.ERROR,
					buttons: Ext.Msg.OK
				});
			}
		});
	},

	onSearch: function (field) {
		var me = this,
			store = me.getStore('List'),
			searchVal = me.getTextfieldExternalOrderSearch().getValue();

		store.currentPage = 1;
		store.filters.clear();

		store.filter('search', searchVal);
	},

	filterExternalOrder: function () {
		var me = this,
			form = me.getFilterPanel().getForm(),
			store = me.getStore('List');

		var from = form.findField('from').getValue(),
			to = form.findField('to').getValue(),
			account = form.findField('account').getValue(),
			statusid = form.findField('status').getValue(),
			paymentid = form.findField('payment').getValue(),
			generate = form.findField('generate').getValue(),
			shipped = form.findField('shipped').getValue(),
			searcharticle = form.findField('searcharticle').getValue();
		
		store.getProxy().extraParams = {
            'fromDate': from,
			'toDate': to,
			'account': account,
			'status': statusid,
			'payment': paymentid,
			'generate': generate,
			'shipped': shipped,
			'searcharticle': searcharticle
        };
		store.currentPage = 1;
		store.load();
	},

	clearFilterExternalOrder: function () {
		var me = this,
			form = me.getFilterPanel().getForm(),
			store = me.getStore('List');

		if (!form) {
			return;
		}
		form.reset();

		var from = form.findField('from').getValue();
		var to = form.findField('to').getValue();
		var account = form.findField('account').getValue();
		var statusid = form.findField('status').getValue();
		var paymentid = form.findField('payment').getValue();
		var generate = form.findField('generate').getValue();
		var shipped = form.findField('shipped').getValue();
		var searcharticle = form.findField('searcharticle').getValue();

		store.getProxy().extraParams = {
			'fromDate': from,
			'toDate': to,
			'account': account,
			'status': statusid,
			'payment': paymentid,
			'generate': generate,
			'shipped': shipped,
			'searcharticle': searcharticle
		};
		store.currentPage = 1;
		store.load();
	}
});
