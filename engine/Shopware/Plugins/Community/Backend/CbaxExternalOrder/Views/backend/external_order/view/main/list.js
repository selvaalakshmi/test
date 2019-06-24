// {namespace name=backend/plugins/external_order/view/main/list}
Ext.define('Shopware.apps.ExternalOrder.view.main.List', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.externalorder-main-list',
    // autoScroll: true,
	ui: 'shopware-ui',
	
	snippets: {
        grid: {
            toolbar: {
                deleteMultipleOrder: '{s name=gridDeleteMultipleOrder}Markierte Bestellungen löschen{/s}',
				generateMultipleOrder: '{s name=gridGenerateMultipleOrder}Markierte Bestellungen generieren{/s}',
				search: '{s name=gridSearchKeyword}Suche...{/s}'
            },
			columns: {
                account: '{s name=gridLabelMarketplace}Marktplatz{/s}',
                created: '{s name=gridLabelCreated}Zeitpunkt{/s}',
                external_order_number: '{s name=gridLabelMarketplaceOrdernumber}Marktplatz Bestell-Nr{/s}',
				ordernumber: '{s name=gridLabelOrdernumber}Shop Bestell-Nr{/s}',
				invoice_amount: '{s name=gridLabelInvoiceAmount}Betrag{/s}',
				payment: '{s name=gridLabelPayment}Zahlungsart{/s}',
				customer_name: '{s name=gridLabelCustomerName}Kunde{/s}',
				orderStatus: '{s name=gridLabelOrderStatus}Aktueller Bestellstatus{/s}',
				shipped_to_account: '{s name=gridLabelShippedToAccount}Status{/s}'
            },
			buttons: {
                delete: '{s name=gridButtonDelete}Bestellung löschen{/s}',
				edit: '{s name=gridButtonEdit}Bestellung bearbeiten{/s}',
				generate: '{s name=gridButtonGenerate}Shopware Bestellung generieren{/s}',
				send: '{s name=gridButtonSend}Versandstatus senden{/s}'
            },
			paging: {
				pageSize: '{s name=gridPageSize}Anzahl der Bestellungen{/s}'
			}
        }
    },
	
	initComponent:function () {
        var me = this;
		me.registerEvents();
        me.store = me.externalOrderStore;
		me.selModel = me.createSelectionModel();
		me.columns = me.getColumns();
		me.dockedItems = [ me.getToolbar(), me.getPagingbar() ];
        me.callParent(arguments);
    },
	
	registerEvents:function () {
        this.addEvents(
			'editExternalOrder',
			'deleteExternalOrder',
			'generateShopwareOrder',
			'statusSendOrder'
        );

        return true;
    },
	
	/* !!!!!!!!!!!!!!!! nicht getSelectionModel überschreiben !!!!!!!!!!!!!!! */
	createSelectionModel: function(){
		var selModel = Ext.create('Ext.selection.CheckboxModel',{
            listeners: {
                selectionchange: function(sm, selections){
                    var owner = this.view.ownerCt,
                            btn = owner.down('button[action=deleteMultipleOrder]');
							btn2 = owner.down('button[action=generateMultipleOrder]');

                    //If no article is marked
                    if(btn){
                        btn.setDisabled(selections.length == 0);
                    }
					
					if(btn2){
                        btn2.setDisabled(selections.length == 0);
                    }
                }
            }
        });

        return selModel;
    },
	
	getColumns:function () {
        var me = this;
		
        var columnsData = [{
			header: 'ID',
			hidden: true,
			dataIndex: 'id'
		},{
			header: me.snippets.grid.columns.account,
			dataIndex: 'account',
			width: 80,
			renderer: me.accountColumn
		},{
			header: me.snippets.grid.columns.created,
			dataIndex: 'created',
			width: 80
		},{
			header: me.snippets.grid.columns.external_order_number,
			dataIndex: 'external_order_number',
			width: 110
		},{
			header: me.snippets.grid.columns.ordernumber,
			dataIndex: 'ordernumber',
			width: 95
		},{
			header: me.snippets.grid.columns.invoice_amount,
			dataIndex: 'invoice_amount',
			width: 70,
			align: 'right',
			renderer: me.amountColumn
		},{
			header: me.snippets.grid.columns.payment,
			dataIndex: 'payment',
			hidden: true,
			width: 120
		},{
			header: me.snippets.grid.columns.customer_name,
			dataIndex: 'customer_name',
			sortable: false,
			flex: 1
		},{
			header: me.snippets.grid.columns.orderStatus,
			dataIndex: 'orderStatus',
			sortable: false,
			width: 140,
			allowHtml: true,
			renderer: me.orderStatusColumn
		},{
			header: me.snippets.grid.columns.shipped_to_account,
			dataIndex: 'shipped_to_account',
			sortable: false,
			width: 60,
			align: 'center',
			renderer: me.statusColumn
		},{
			xtype: 'actioncolumn',
			width: 100,
			sortable: false,
			items: [
				/*{if {acl_is_allowed privilege=delete}}*/
				{
					iconCls: 'sprite-minus-circle-frame',
					action: 'delete',
					cls: 'deleteBtn',
					tooltip: me.snippets.grid.buttons.delete,
					handler: function (view, rowIndex, colIndex, item) {
						me.fireEvent('deleteExternalOrder',view, rowIndex, colIndex, item);
                	}
				},
				/*{/if}*/
            	/*{if {acl_is_allowed privilege=update}}*/
				{
					iconCls: 'sprite-pencil',
					cls: 'editBtn',
					tooltip: me.snippets.grid.buttons.edit,
                	handler: function (view, rowIndex, colIndex, item) {
						me.fireEvent('editExternalOrder',view, rowIndex, colIndex, item);
                	}
				},
				/*{/if}*/
            	/*{if {acl_is_allowed privilege=generate}}*/
				{
					iconCls: 'sprite-blue-document-copy',
					cls: 'generateBtn',
					tooltip: me.snippets.grid.buttons.generate,
                	handler: function (view, rowIndex, colIndex, item) {
						me.fireEvent('generateShopwareOrder',view, rowIndex, colIndex, item);
                	}
				},
				/*{/if}*/
				/*{if {acl_is_allowed privilege=generate}}*/
				{
					iconCls: 'sprite-lightning',
					cls: 'sendBtn',
					tooltip: me.snippets.grid.buttons.send,
                	handler: function (view, rowIndex, colIndex, item) {
						me.fireEvent('statusSendOrder',view, rowIndex, colIndex, item);
                	}
				}
				/*{/if}*/
			]
		}];
		
		return columnsData;
    },
	
	getToolbar: function() {
		var me = this;
        var toolbar = Ext.create('Ext.toolbar.Toolbar', {
            dock: 'top',
            ui: 'shopware-ui',
            items: [
			/*{if {acl_is_allowed privilege=delete}}*/
			{
                iconCls:'sprite-minus-circle-frame',
                text: me.snippets.grid.toolbar.deleteMultipleOrder,
                disabled: true,
                action: 'deleteMultipleOrder'
            },
			/*{/if}*/
			/*{if {acl_is_allowed privilege=generate}}*/
			{
                iconCls:'sprite-blue-document-copy',
                text: me.snippets.grid.toolbar.generateMultipleOrder,
                disabled: true,
                action: 'generateMultipleOrder'
            },
			/*{/if}*/
			'->',
			{
                xtype: 'textfield',
                name: 'searchOrder',
                action: 'searchOrder',
                width: 170,
				cls: 'searchfield',
                enableKeyEvents: true,
                checkChangeBuffer: 500,
                emptyText: me.snippets.grid.toolbar.search
            },{
                xtype: 'tbspacer',
                width: 6
            }]
        });

        return toolbar;
    },
	
	getPagingbar:function () {
        var me = this;

        var pageSize = Ext.create('Ext.form.field.ComboBox', {
            fieldLabel: me.snippets.grid.paging.pageSize,
            labelWidth: 150,
            cls: Ext.baseCSSPrefix + 'page-size',
            queryMode: 'local',
            width: 210,
            listeners: {
                scope: me,
                select: me.onPageSizeChange
            },
            store: Ext.create('Ext.data.Store', {
                fields: [ 'value' ],
                data: [
                    { value: '25' },
					{ value: '50' },
                    { value: '75' },
                    { value: '100' },
                    { value: '150' },
                    { value: '200' }
                ]
            }),
			editable: false,
            displayField: 'value',
            valueField: 'value'
        });
        pageSize.setValue(me.externalOrderStore.pageSize);

        var pagingBar = Ext.create('Ext.toolbar.Paging', {
            store: me.externalOrderStore,
            dock:'bottom',
            displayInfo:true
        });

        pagingBar.insert(pagingBar.items.length - 2, [ { xtype: 'tbspacer', width: 6 }, pageSize ]);

        return pagingBar;

    },
	
	accountColumn: function (value) {
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
		}

		return value;
	},
	
    onPageSizeChange: function(combo, records) {
        var record = records[0],
            me = this;

        me.externalOrderStore.pageSize = record.get('value');
        me.externalOrderStore.loadPage(1);
    },
	
	amountColumn:function (value) {
        if ( value === Ext.undefined ) {
            return value;
        }
        return Ext.util.Format.currency(value);
    },
	
	orderStatusColumn: function(value, metaData, record) {
        var me = this;
		
		if ( value === Ext.undefined || value === null ) {
            return value;
        }
		
		value = parseInt(value, 10);
		
        if (me.statusStore) {
            var orderStatus = me.statusStore.getById(value);
            return orderStatus.get('description');
        } else {
            return '';
        }
    },
	
	statusColumn: function(value) {
		if ( value === Ext.undefined ) {
            return value;
        }
		if (value == 2) {
            return Ext.String.format('<div style="height:16px; width:16px; margin:auto;" class="sprite-tick-small"></div>')
		} else if  (value == 3) {
            return Ext.String.format('<div style="height:16px; width:16px; margin:auto;" class="sprite-exclamation-small"></div>')
        } else {
            return Ext.String.format('<div style="height:16px; width:16px; margin:auto;" class="sprite-cross-small"></div>')
        }
    }
});