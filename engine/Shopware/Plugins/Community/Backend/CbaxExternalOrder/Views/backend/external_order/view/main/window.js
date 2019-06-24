// {namespace name=backend/plugins/external_order/view/main/import}
Ext.define('Shopware.apps.ExternalOrder.view.main.Window', {
    extend: 'Enlight.app.Window',
    alias: 'widget.externalorder-main-window',
    layout: 'border',
	autoShow: true,
    width: 500,
    height: 230,
	maximizable: false,
	minimizable: false,
	resizable: false,
	
	snippets: {
        title: '{s name=titleWindow}Externe Bestellung importieren{/s}',
		account: {
            label: '{s name=fieldLabelMarketplace}Marktplatz{/s}',
			emptyText: '{s name=emptyTextMarketplace}Bitte wählen{/s}',
			help: '{s name=helpTextMarketplace}Bitte einen Marktplatz wählen{/s}'
        },
		order_number: {
            label: '{s name=fieldLabelOrdernumber}Bestellnummer{/s}',
            support: '{s name=supportTextOrdernumber}Mehrere Bestellnummern untereinander{/s}'
        },
		buttons: {
            import: '{s name=importButton}Importieren{/s}',
			cancel: '{s name=cancelButton}Abbrechen{/s}'
        }
    },
	
    initComponent : function () {
        var me = this;
		me.title = me.snippets.title;
        me.items = me.createFormPanel();
        me.buttons = me.createButtons();
        me.callParent(arguments);
    },

    createFormPanel: function() 
    {
        var me = this;
        return Ext.create('Ext.form.Panel', {
            region: 'center',
            width: '100%',
            defaults: {
                labelStyle: 'font-weight: 700; text-align: right;',
                labelWidth: 130,
                anchor: '100%'
            },
            bodyPadding : 10,
            items: [{
				fieldLabel: me.snippets.account.label,
				xtype: 'combobox',
				name: 'account',
				emptyText: me.snippets.account.emptyText,
				store: me.accountStore,
				valueField: 'name',
				displayField: 'description',
				queryMode: 'local',
				editable: false,
				allowBlank: false,
				helpText: me.snippets.account.help
			},{
				fieldLabel: me.snippets.order_number.label,
				xtype: 'textarea',
				name: 'order_number',
				allowBlank: false,
				supportText: me.snippets.order_number.support,
			}]
        });
    },
	
    createButtons: function() 
    {
        var me = this;
        return [{
			text: me.snippets.buttons.cancel,
			cls: 'secondary',
			scope: me,
			handler: me.destroy
		},{
			text: me.snippets.buttons.import,
			cls: 'primary',
			action: 'importOrder'
		}];
    }
});