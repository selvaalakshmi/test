// {namespace name=backend/plugins/connector_yatego/view/main}
Ext.define('Shopware.apps.ConnectorYatego.view.Main', {
	extend: 'Enlight.app.Window',
    title: 'Einstellungen Yatego',
    alias: 'widget.connectoryatego-view-main',
    layout: 'border',
	border: false,
    autoShow: true,
    height: '90%',
    width: 925,
	stateful: true,
    stateId: 'connectoryatego-view-main-window',
	
	snippets: {
        title: '{s name=titleWindow}Einstellungen Yatego{/s}',
		buttons: {
            save: '{s name=saveButton}Speichern{/s}',
			cancel: '{s name=cancelButton}Abbrechen{/s}'
        }
    },
	
    initComponent: function() {
        var me = this;
		me.title = me.snippets.title;
		me.items = [{
            xtype: 'connectoryatego-view-main-config',
			region: 'center',
            subshopStore: me.subshopStore,
			taxStore: me.taxStore,
			customergroupStore: me.customergroupStore,
			orderstateStore: me.orderstateStore,
			paymentstateStore: me.paymentstateStore,
			dispatchStore: me.dispatchStore,
			paymentStore: me.paymentStore
        }];
		me.buttons = me.createButtons();
        me.callParent(arguments);
    },
	
	createButtons: function() {
        var me = this;
        return [{
			text: me.snippets.buttons.cancel,
			cls: 'secondary',
			scope: me,
            handler: function () {
                me.destroy();
            }
		},{
			text: me.snippets.buttons.save,
			cls: 'primary',
			action: 'save'
		}];
    }
});
