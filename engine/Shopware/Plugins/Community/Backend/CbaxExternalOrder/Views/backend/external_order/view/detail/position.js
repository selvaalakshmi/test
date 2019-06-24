// {namespace name=backend/plugins/external_order/view/detail/position}
Ext.define('Shopware.apps.ExternalOrder.view.detail.Position', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.externalorder-detail-position',
    autoScroll: true,
	
	snippets: {
        title: '{s name=titleWindow}Positionen{/s}',
		grid: {
            toolbar: {
                openOrder: '{s name=gridOpenOrder}Shop Bestellung öffnen{/s}'
            },
			columns: {
                articleordernumber: '{s name=gridLabelArticleordernumber}Artikelnummer{/s}',
                name: '{s name=gridLabelName}Artikelname{/s}',
                quantity: '{s name=gridLabelQuantity}Anzahl{/s}',
				price: '{s name=gridLabelPrice}Preis{/s}',
				totalprice: '{s name=gridLabelTotalprice}Gesamt{/s}',
				instock: '{s name=gridLabelInstock}Bestand{/s}'
            },
			buttons: {
                openArticle: '{s name=gridButtonOpenArticle}Artikel öffnen{/s}'
            }
        }
    },
	
	initComponent:function () {
        var me = this;
		me.title = me.snippets.title;
        me.store = me.orderStore;
		me.columns = me.getColumns();
		me.dockedItems = [ me.getToolbar(), me.getPagingbar() ];
        me.callParent(arguments);
    },
	
	getColumns:function () {
        var me = this;
		
        var columnsData = [{
			header: 'ID',
			sortable: false,
			hidden: true,
			dataIndex: 'articleID'
		},{
			header: me.snippets.grid.columns.articleordernumber,
			sortable: false,
			dataIndex: 'articleordernumber',
			width: 130
		},{
			header: me.snippets.grid.columns.name,
			sortable: false,
			dataIndex: 'name',
			flex: 1
		},{
			header: me.snippets.grid.columns.quantity,
			sortable: false,
			dataIndex: 'quantity',
			align: 'right',
			width: 60
		},{
			header: me.snippets.grid.columns.price,
			sortable: false,
			dataIndex: 'price',
			align: 'right',
			width: 100,
			renderer:me.amountColumn
		},{
			header: me.snippets.grid.columns.totalprice,
			sortable: false,
			dataIndex: 'totalprice',
			align: 'right',
			width: 100,
			renderer:me.amountColumn
		},{
			header: me.snippets.grid.columns.instock,
			sortable: false,
			dataIndex: 'instock',
			align: 'right',
			width: 80
		},{
			xtype:'actioncolumn',
			width:50,
			items:[{
				iconCls:'sprite-inbox',
				action:'openArticle',
				tooltip: me.snippets.grid.buttons.openArticle,
				handler:function (view, rowIndex, colIndex, item) {
					me.fireEvent('openArticle',view, rowIndex, colIndex, item);
				}
			}]
		}];
		
		return columnsData;
    },
	
	getToolbar: function() {
		var me = this;
        var toolbar = Ext.create('Ext.toolbar.Toolbar', {
            dock: 'top',
            ui : 'shopware-ui',
            items: [
			/*{if {acl_is_allowed privilege=read}}*/
			{
                iconCls: 'sprite-sticky-notes-pin',
                text: me.snippets.grid.toolbar.openOrder,
				disabled: me.record.get('orderID') === null,
				action:'openOrder',
                handler: function() {
                    Shopware.app.Application.addSubApplication({
                        name: 'Shopware.apps.Order',
                        params: {
                			orderId:me.record.get('orderID')
            			}
                    });
                }
            },
			/*{/if}*/
			]
        });

        return toolbar;
    },

    getPagingbar: function () {
		var pagingbar =  Ext.create('Ext.toolbar.Paging', {
			store: this.store,
            dock: 'bottom',
            displayInfo: true
        });

        return pagingbar;
    },
	
	amountColumn:function (value, metaData, record) {
        if ( value === Ext.undefined ) {
            return value;
        }
        return Ext.util.Format.currency(value);
    }
});