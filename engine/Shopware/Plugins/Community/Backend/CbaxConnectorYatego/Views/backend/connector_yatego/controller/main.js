// {namespace name=backend/plugins/connector_yatego/controller/main}
Ext.define('Shopware.apps.ConnectorYatego.controller.Main', {

    extend: 'Ext.app.Controller',

    mainWindow: null,
	
	snippets: {
        success: {
            title: '{s name=successTitle}Erfolgreich{/s}',
			checkAccess: '{s name=checkAccess}Die Verbindung wurde erfolgreich hergestellt{/s}',
            Save: '{s name=successSave}Die Einstellungen wurde erfolgreich gespeichert{/s}'
        },
        failure: {
            title: '{s name=failureTitle}Fehler{/s}',
			checkAccess: '{s name=checkAccess}Die Verbindung wurde NICHT hergestellt!{/s}',
            Save: '{s name=failureSave}Die Einstellungen wurde NICHT gespeichert!{/s}'
        }
    },
	
	refs: [{
        ref: 'configForm',
        selector: 'connectoryatego-view-main > connectoryatego-view-main-config'
    },{
		ref: 'checkAccessButton',
		selector: 'connectoryatego-view-main > connectoryatego-view-main-config button[name=checkAccess]'
	}],

    init: function() {
        var me = this;
		
		me.control({
			'connectoryatego-view-main connectoryatego-view-main-config':
			{
                recordloaded : me.onRecordLoaded
            },
			'connectoryatego-view-main connectoryatego-view-main-config button[action=checkAccess]':
            {
                click: me.checkAccess
            },
            'connectoryatego-view-main button[action=save]':
            {
                click: me.saveAccountConfig
            }
		});
		
        me.mainWindow = me.getView('Main').create(
		{
			subshopStore: me.getStore('Subshop'),
			taxStore: me.getStore('Tax'),
			customergroupStore: me.getStore('Customergroup'),
			orderstateStore: Ext.create('Shopware.apps.Base.store.OrderStatus').load(),
			paymentstateStore: Ext.create('Shopware.apps.Base.store.PaymentStatus').load(),
			dispatchStore: me.getStore('Dispatch'),
			paymentStore: me.getStore('Payment')
		}).show();

        me.callParent(arguments);
    },
	
	onRecordLoaded: function()
	{
		var me = this;
			form = me.getConfigForm().getForm(),
			checkAccessButton = me.getCheckAccessButton();
		
		shop = form.findField('shop_id').getValue();
		
		if (!Ext.isEmpty(shop))
		{
			checkAccessButton.enable();
		}
	},
	
	checkAccess: function ()
	{
		var me = this,
			checkAccessButton = me.getCheckAccessButton();
		
		checkAccessButton.disable();
		
		Ext.Ajax.request({
            url: '{url controller="ConnectorYatego" action="checkAccess"}',
            success: function(response)
			{
				checkAccessButton.enable();
				
				var status = Ext.decode(response.responseText);
				if (status.success)
				{
					Shopware.Notification.createGrowlMessage(me.snippets.success.title, me.snippets.success.checkAccess);
				}
				else
				{
					Ext.Msg.show({
						title: me.snippets.failure.title,
						msg: status.message,
						icon: Ext.Msg.ERROR,
						buttons: Ext.Msg.OK
					});
				}
            },
            failure: function(response)
			{
				checkAccessButton.enable();
				
                Ext.Msg.show({
					title: me.snippets.failure.title,
					msg: me.snippets.failure.checkAccess,
					icon: Ext.Msg.ERROR,
					buttons: Ext.Msg.OK
				});
            }
        });
	},
	
	saveAccountConfig: function ()
	{
		var me = this,
			form = me.getConfigForm().getForm(),
			checkAccessButton = me.getCheckAccessButton();
		
		if (form.isValid())
		{
			form.submit(
			{
				url: '{url controller="ConnectorYatego" action="saveConfig"}',
				success: function(form, action)
				{
					if(action.result.success)
					{
						Shopware.Notification.createGrowlMessage(me.snippets.success.title, me.snippets.success.Save);
						checkAccessButton.enable();
					}
					else
					{
						Ext.Msg.show({
							title: me.snippets.failure.title,
							msg: me.snippets.failure.Save,
							icon: Ext.Msg.ERROR,
							buttons: Ext.Msg.OK
						});
					}
				},
				failure: function(response, action)
				{
					Ext.Msg.show({
						title: me.snippets.failure.title,
						msg: me.snippets.failure.Save,
						icon: Ext.Msg.ERROR,
						buttons: Ext.Msg.OK
					});
				}
			});
		}
		else
		{
			Ext.Msg.show({
				title: me.snippets.failure.title,
				msg: me.snippets.failure.Save,
				icon: Ext.Msg.ERROR,
				buttons: Ext.Msg.OK
			});
		}
	}
});
