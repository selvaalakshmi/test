// {namespace name=backend/plugins/external_order_logfile/view/main/list}
Ext.define('Shopware.apps.ExternalOrderLogfile.view.main.List', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.externalorderlogfile-main-list',
    autoScroll: true,
	ui: 'shopware-ui',
	
	snippets: {
        grid: {
            toolbar: {
                deleteMultipleLogfile: '{s name=gridDeleteMultipleKeyword}Markierte Logfiles löschen{/s}',
				search: '{s name=gridSearchKeyword}Suche...{/s}'
            },
			columns: {
                account: '{s name=gridLabelMarketplace}Marktplatz{/s}',
                date: '{s name=gridLabelCountDate}Datum{/s}',
                type: '{s name=gridLabelType}Typ{/s}',
				msg: '{s name=gridLabelMsg}Text{/s}',
				action: '{s name=gridLabelAction}Aktion{/s}'
            },
			buttons: {
                delete: '{s name=gridButtonDelete}Logfile löschen{/s}',
				edit: '{s name=gridButtonEdit}Logfile öffnen{/s}'
            },
			accountFilter: {
            	label: '{s name=fieldLabelAccountFilter}Marktplatz{/s}',
				emptyText: '{s name=emptyTextAccountFilter}Alle anzeigen{/s}',
				delete: '{s name=deleteAccountFilter}Filter löschen{/s}'
			}
        }
    },
	
    initComponent:function () {
        var me = this;

 		me.registerEvents();
        me.store = me.logfileStore;
		me.selModel = me.createSelectionModel();
        me.columns = me.getColumns();
        me.dockedItems = [ me.getToolbar(), me.getPagingbar() ];
 
        me.callParent(arguments);
    },

    registerEvents:function () {
        this.addEvents(
			'openColumn',
			'deleteColumn'
        );

        return true;
    },

	/* !!!!!!!!!!!!!!!! nicht getSelectionModel überschreiben !!!!!!!!!!!!!!! */
	createSelectionModel: function(){
		return Ext.create('Ext.selection.CheckboxModel',{
            listeners: {
                selectionchange: function(sm, selections){
                    var owner = this.view.ownerCt,
                            btn = owner.down('button[action=deleteMultipleLogfile]');

                    //If no article is marked
                    if(btn){
                        btn.setDisabled(selections.length === 0);
                    }
                }
            }
        });
    },

    getColumns:function () {
        var me = this;

        return [{
			header: me.snippets.grid.columns.account,
			dataIndex: 'account',
			width: 80,
			renderer: me.accountColumn
		},{
			header: me.snippets.grid.columns.date,
			dataIndex: 'date',
			width: 150
		},{
			header: me.snippets.grid.columns.type,
			dataIndex: 'type',
			renderer: me.colorColumnRenderer,
			width: 100
		},{
			header: me.snippets.grid.columns.msg,
			dataIndex: 'msg',
			flex: 1
		},{
			header: me.snippets.grid.columns.action,
			dataIndex: 'action',
			width: 250
		},{
			xtype: 'actioncolumn',
			width: 60,
			items: [
				{
					iconCls: 'sprite-minus-circle-frame',
					action: 'delete',
					cls: 'delete',
					tooltip: me.snippets.grid.buttons.delete,
                	handler: function (view, rowIndex, colIndex, item) {
						me.fireEvent('deleteColumn', view, rowIndex, colIndex, item);
                	}
				},
				{
					iconCls: 'sprite-magnifier',
					cls: 'editBtn',
					tooltip: me.snippets.grid.buttons.edit,
                	handler: function (view, rowIndex, colIndex, item) {
						me.fireEvent('openColumn', view, rowIndex, colIndex, item);
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
			items: [{
				iconCls: 'sprite-minus-circle-frame',
				text: me.snippets.grid.toolbar.deleteMultipleLogfile,
				disabled: true,
				action: 'deleteMultipleLogfile'
			},
			'->',
			{
				fieldLabel: me.snippets.grid.accountFilter.label,
				xtype: 'combobox',
				name: 'accountFilter',
				emptyText: me.snippets.grid.accountFilter.emptyText,
				store: me.accountStore,
				valueField: 'name',
				displayField: 'description',
				labelWidth: 70,
				margins: '0 40 0 0',
				editable: false,
				listeners: {
					change: {
						fn: me.onFilterComboChange,
						scope: me
					}
				}
			}, {
				xtype: 'textfield',
				name: 'searchLogfile',
				action: 'searchLogfile',
				width: 170,
				cls: 'searchfield',
				enableKeyEvents: true,
				checkChangeBuffer: 500,
				emptyText: me.snippets.grid.toolbar.search
			}, {
				xtype: 'tbspacer',
				width: 6
			}]
		});
	},

    getPagingbar: function () {
        return Ext.create('Ext.toolbar.Paging', {
            store: this.store,
            dock: 'bottom',
            displayInfo: true
        });
    },
	
	colorColumnRenderer: function(value) {
        if (value === 'Erfolg' || value === 'Successful') {
            return '<span style="color:green;">' + value + '</span>';
		} else if (value === 'Warnung' || value === 'Warning') {
            return '<span style="color:orange;">' + value + '</span>';
        } else {
            return '<span style="color:red;">' + value + '</span>';
        }
    },

	onFilterComboChange: function (combo, record, index) {
		var me = this,
			store = me.logfileStore;

		if (record === 'clearFilter') {
			combo.store.removeAt(0);
			combo.setRawValue('');
			record = '';
		} else {
			if (combo.store.getProxy().type === 'memory') {
				// Array Store (local)
				if (combo.store.getAt(0).data.field1 !== 'clearFilter') {
					combo.store.insert(0, [
						['clearFilter', '<span style="color:#d34744">' + me.snippets.grid.accountFilter.delete + '</span>']
					]);
				}
			} else {
				// Data Store (remote)
				if (!combo.store.getById('clearFilter')) {
					combo.store.insert(0, [
						['clearFilter', '<span style="color:#d34744">' + me.snippets.grid.accountFilter.delete + '</span>']
					]);
				}
			}
		}

		switch (combo.name) {
			case 'accountFilter':
				store.getProxy().extraParams.filterByAccount = record;
				break;
		}

		store.currentPage = 1;
		store.load();
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
	}
	
});