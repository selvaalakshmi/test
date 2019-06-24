// {namespace name=backend/plugins/connector_yatego/controller/shipping_grid}
Ext.define('Shopware.apps.ConnectorYatego.controller.ShippingGrid', {

    extend: 'Ext.app.Controller',

    mainWindow: null,
	
	snippets: {
        success: {
            title: '{s name=successTitle}Erfolgreich{/s}',
            Save: '{s name=successSave}Die Versandart wurde erfolgreich gespeichert{/s}'
        },
		warning: {
			title: '{s name=warningTitle}Warnung{/s}',
			entryDelete: '{s name=warningEntryDelete}Wollen Sie die Versandart wirklich löschen?{/s}'
		},
        failure: {
            title: '{s name=failureTitle}Fehler{/s}',
			entryAlreadyExists: '{s name=failureEntryAlreadyExists}Ein Eintrag für dieses Land ist schon vorhanden!{/s}',
            Save: '{s name=failureSave}Die Versandart wurde NICHT gespeichert!{/s}'
        }
    },
	
	refs: [{
		ref: 'shippingGrid',
		selector: 'connectoryatego-view-main-shipping-grid'
	}],

    init: function() {
        var me = this;
		
		me.control({
			'connectoryatego-view-main-shipping-grid': {
                beforeedit: me.onBeforeEditField,
                edit: me.onAfterEditField,
				deleteColumn: me.onDeleteField,
                canceledit: me.onCancelEditField

            },
			'connectoryatego-view-main-shipping-grid button[action=addEntry]': {
                click: me.onAddField
            }
		});
		
        me.callParent(arguments);
    },
	
	onAddField: function()
	{
        var me = this,
			grid = me.getShippingGrid(),
            editor = grid.editor,
            count = grid.store.count() + 1,
            newField = Ext.create('Shopware.apps.ConnectorYatego.model.ShippingGrid', {
                position: count
            });

        grid.store.add(newField);
        editor.startEdit(newField, 1);
    },
	
	onBeforeEditField: function(editor)
	{
		var me = this;
		
        var view = editor.grid.getView();

        // disable add button
        view.ownerCt.down('button[action=addEntry]').disable();
    },
	
	onCancelEditField: function(editor, event)
	{
		var me = this
        	grid   = editor.grid,
            record = event.record,
            store  = grid.getStore(),
            view   = grid.getView();

        if (record.phantom) {
            store.remove(record);
        }

        // enable add button
        view.ownerCt.down('button[action=addEntry]').enable();
    },
	
	onAfterEditField: function(editor, event)
	{
		var me = this,
        	grid   = editor.grid,
            record = event.record,
            store  = grid.getStore(),
            view   = grid.getView();
		
		record.save({
			success: function () {
				Shopware.Notification.createGrowlMessage(me.snippets.success.title, me.snippets.success.Save);
				store.load();
			},
			failure: function(result, operation)
			{
				Ext.Msg.show({
					title: me.snippets.failure.title,
					msg: me.snippets.failure.entryAlreadyExists,
					icon: Ext.Msg.ERROR,
					buttons: Ext.Msg.OK
				});
				
				store.load();
			}
		});
        // enable add button
        view.ownerCt.down('button[action=addEntry]').enable();
    },
	
	onDeleteField: function (view, rowIndex, colIndex, item)
	{
		var me = this,
			store = view.getStore(),
			values = store.data.items[rowIndex].data,
			message = Ext.String.format(me.snippets.warning.entryDelete);

		Ext.MessageBox.confirm(me.snippets.warning.title, message, function (response) {
			if (response !== 'yes') {
				return false;
			}

			var model = Ext.create('Shopware.apps.ConnectorYatego.model.ShippingGrid', values);
			model.destroy({
				callback: function () {
					store.load();
				}
			});
		});
	}
});
