// {namespace name=backend/plugins/external_order_logfile/controller/main}
Ext.define('Shopware.apps.ExternalOrderLogfile.controller.List', {
    extend:'Ext.app.Controller',
	
	snippets: {
		warning: {
            title: '{s name=warningTitle}Warnung{/s}',
			logfileDelete: '{s name=warningLogfileDelete}Wollen Sie das Logfile wirklich löschen?{/s}',
			multipleLogfileDelete: '{s name=warningMultipleLogfileDelete}Sie haben <b>[0]</b> Logfiles markiert. Wollen Sie wirklich diese Logfiles löschen?{/s}'
        }
    },
	
	refs : [{
		ref: 'textfieldSearchArticle',
		selector: 'externalorderlogfile-view-main > externalorderlogfile-main-list > toolbar > textfield[name=searchLogfile]'
	}],
	
    init:function () {
        var me = this;
 
        me.control({
			'externalorderlogfile-main-list button[action=deleteMultipleLogfile]' : {
				click: me.onDeleteMultipleLogfile
            },
            'externalorderlogfile-main-list textfield[action=searchLogfile]' : {
                change: me.onSearch
            },
			'externalorderlogfile-main-list': {
                deleteColumn: me.onDeleteLogfile,
                openColumn: me.onOpenLogfile
            }
        });
    },

	onSearch: function () {
		var me = this,
			store = me.getStore('List'),
			searchVal = me.getTextfieldSearchArticle().getValue();

		store.currentPage = 1;
		store.filters.clear();

		store.filter('search', searchVal);
	},

	onOpenLogfile: function (view, rowIndex, colIndex, item) {
		var	me = this,
			store = view.getStore(),
			record = store.getAt(rowIndex);

		Ext.Ajax.request({
			url: '{url controller="ExternalOrderLogfile" action="getDebugData"}',
			params: {
				'id': record.get('id')
			},
			success: function (response) {
				var json = Ext.decode(response.responseText);

				if (Ext.isDefined(json.debugData)) {
					record.set('debugdata', json.debugData);
				}

				Ext.create('Shopware.apps.ExternalOrderLogfile.view.main.Edit', {
					record: record,
					mainStore: store
				});
			}
		});
	},

	onDeleteLogfile: function (view, rowIndex, colIndex, item) {
		var me = this,
			store = view.getStore(),
			values = store.data.items[rowIndex].data,
			message = Ext.String.format(me.snippets.warning.logfileDelete);

		//Create a message-box, which has to be confirmed by the user
		Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response) {
			//If the user doesn't want to delete the article
			if (response !== 'yes') {
				return false;
			}
			var model = Ext.create('Shopware.apps.ExternalOrderLogfile.model.List', values);
			model.destroy({
				callback: function () {
					store.load();
				}
			});
		});
	},

	onDeleteMultipleLogfile: function (btn) {
		var	me = this,
			win = btn.up('window'),
			grid = win.down('grid'),
			selModel = grid.selModel,
			index = 0,
			selection = selModel.getSelection(),
			message = Ext.String.format(me.snippets.warning.multipleLogfileDelete, selection.length);

		//Create a message-box, which has to be confirmed by the user
		Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response) {
			//If the user doesn't want to delete the articles
			if (response !== 'yes') {
				return false;
			}

			Ext.each(selection, function (item) {
				item.destroy({
					callback: function () {
						index++;
						if (index == selection.length) {
							grid.getStore().load();
						}
					}
				})
			});
		});
	}
});