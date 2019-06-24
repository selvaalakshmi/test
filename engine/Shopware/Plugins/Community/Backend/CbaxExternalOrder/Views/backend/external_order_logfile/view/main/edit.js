// {namespace name=backend/plugins/external_order_logfile/view/main/edit}
Ext.define('Shopware.apps.ExternalOrderLogfile.view.main.Edit', {
    extend: 'Enlight.app.Window',
    alias: 'widget.externalorderlogfile-edit',
	border: false,
	autoShow: true,
	layout: 'fit',
	width: 700,
	height: 400,
	
	snippets: {
        title: '{s name=titleWindow}Logfile{/s}',
		type: {
            label: '{s name=fieldLabelType}Type{/s}'
        },
		msg: {
            label: '{s name=fieldLabelMsg}Text{/s}'
        },
		action: {
            label: '{s name=fieldLabelAction}Aktion{/s}'
        },
		debugdata: {
            label: '{s name=fieldLabelDebugdata}Debug{/s}'
        },
		buttons: {
			cancel: '{s name=cancelButton}Schließen{/s}'
        }
    },

	initComponent: function () {
		var me = this;
		me.title = me.snippets.title;
		oldTitle = me.title;
		me.title = oldTitle + ' - ' + me.record.get('account_description') + ' - ' + me.record.get('date');

		me.logfileForm = me.createFormPanel();
		me.logfileForm.getForm().loadRecord(me.record);
		me.items = [me.logfileForm];
		me.buttons = me.createButtons();
		me.callParent(arguments);
	},

	createFormPanel: function () {
		var me = this;
		return Ext.create('Ext.form.Panel', {
			region: 'center',
			autoScroll: true,
			bodyPadding: 10,
			defaults: {
				labelWidth: 130,
				anchor: '100%'
			},
			items: [{
				fieldLabel: me.snippets.type.label,
				xtype: 'displayfield',
				name: 'type'
			}, {
				fieldLabel: me.snippets.msg.label,
				xtype: 'displayfield',
				name: 'msg'
			}, {
				fieldLabel: me.snippets.action.label,
				xtype: 'displayfield',
				name: 'action'
			}, {
				fieldLabel: me.snippets.debugdata.label,
				xtype: 'textarea',
				name: 'debugdata',
				anchor: '-20 -104',
				fieldStyle: {
					'fontFamily': 'Consolas, monaco, monospace'
				}
			}]
		});
	},

	createButtons: function () {
		var me = this;
		return [{
			text: me.snippets.buttons.cancel,
			cls: 'secondary',
			scope: me,
			handler: me.destroy
		}];
	}
});