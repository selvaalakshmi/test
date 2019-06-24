// {namespace name=backend/plugins/connector_yatego/view/main/shipping_grid}
Ext.define('Shopware.apps.ConnectorYatego.view.main.ShippingGrid', {
	extend: 'Ext.grid.Panel',
	alias: 'widget.connectoryatego-view-main-shipping-grid',
	autoScroll: true,
	ui: 'shopware-ui',
	height: 150,
	sortableColumns: false,

	snippets: {
		grid: {
			toolbar: {
				addEntry: '{s name=gridAddEntry}Hinzufügen{/s}'
			},
			columns: {
				country: '{s name=gridLabelCountry}Land{/s}',
				dispatch: '{s name=gridLabelDispatch}Versandart{/s}',
				carrier: '{s name=gridLabelCarrier}Versand Dienstleister{/s}'
			},
			buttons: {
				delete: '{s name=gridButtonDelete}Eintrag löschen{/s}'
			}
		}
	},

	initComponent: function () {
		var me = this;

		me.registerEvents();
		me.editor = me.getRowEditorPlugin();
		me.plugins = [me.editor];
		me.store = me.shippingStore;
		me.columns = me.getColumns();
		me.dockedItems = [
			me.getToolbar()
		];

		me.callParent(arguments);
	},

	registerEvents: function () {
		var me = this;

		me.addEvents(
			'deleteColumn'
		);

		return true;
	},

	getRowEditorPlugin: function () {
		return Ext.create('Ext.grid.plugin.RowEditing', {
			errorSummary: false,
			pluginId: 'rowEditing'
		});
	},

	getColumns: function () {
		var me = this;

		return [{
			header: me.snippets.grid.columns.country,
			dataIndex: 'countryID',
			width: 200,
			renderer : me.renderCountry,
			editor: {
                xtype: 'combobox',
				store: me.countryStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				allowBlank: false,
				editable: false
            }
		}, {
			header: me.snippets.grid.columns.dispatch,
			dataIndex: 'dispatchID',
			flex: 1,
			renderer : me.renderDispatch,
			editor: {
                xtype: 'combobox',
				store: me.dispatchStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				allowBlank: false,
				editable: false
            }
		}, {
			header: me.snippets.grid.columns.carrier,
			dataIndex: 'carrier',
			width: 200,
			renderer : me.renderCarrier,
			editor: {
                xtype: 'combobox',
				store: me.carrierStore,
				valueField: 'name',
				displayField: 'description',
				queryMode: 'local',
				allowBlank: false,
				editable: false
            }
		}, {
			xtype: 'actioncolumn',
			width: 30,
			items: [
				{
					iconCls: 'sprite-minus-circle-frame',
					cls: 'delete',
					tooltip: me.snippets.grid.buttons.delete,
					handler: function (view, rowIndex, colIndex, item) {
						me.fireEvent('deleteColumn', view, rowIndex, colIndex, item);
					}
				}
			]
		}];
	},

	getToolbar: function () {
		var me = this;

		return Ext.create('Ext.toolbar.Toolbar', {
			dock: 'top',
			ui: 'shopware-ui',
			items: [
				{
					iconCls: 'sprite-plus-circle-frame',
					text: me.snippets.grid.toolbar.addEntry,
					action: 'addEntry'
				}
				]
		});
	},
	
	renderCountry: function (value, metaData, record) {
		var me = this;
		
		if (value === Ext.undefined) {
            return value;
        }
        
        if (record == undefined) {
            return value;
        }
		
        return record.get("countryname");
		
		
    },
	
	renderDispatch: function (value, metaData, record) {
        var me = this;
		
		if (value === Ext.undefined) {
            return value;
        }
        
        if (record == undefined) {
            return value;
        }
		
        return record.get("dispatchname");
    },
	
	renderCarrier: function (value) {
        var me = this, record, index;
		
		if (value === Ext.undefined) {
            return value;
        }
		
		index = me.carrierStore.find('name', value);
		record = me.carrierStore.getAt(index);
        
        if (record == undefined) {
            return value;
        }
		
        return record.get("description");
    }
});