// {namespace name=backend/plugins/external_order/view/main/filterpanel}
// {block name="backend/plugins/external_order/view/filterpanel"}
Ext.define('Shopware.apps.ExternalOrder.view.main.Filterpanel', {
	extend: 'Ext.form.Panel',
	alias: 'widget.externalorder-main-filterpanel',
	autoScroll: false,
	layout: 'border',
	width: 300,
	
	snippets: {
        title: '{s name=titleWindow}Filter Optionen{/s}',
		from: {
            label: '{s name=fieldLabelFrom}Von{/s}'
        },
		to: {
            label: '{s name=fieldLabelTo}Bis{/s}'
        },
		account: {
            label: '{s name=fieldLabelMarketplace}Marktplatz{/s}',
			emptyText: '{s name=emptyTextMarketplace}Alle anzeigen{/s}'
        },
		status: {
            label: '{s name=fieldLabelStatus}Bestellstatus{/s}',
			emptyText: '{s name=emptyTextStatus}Alle anzeigen{/s}'
        },
		payment: {
            label: '{s name=fieldLabelPayment}Zahlungsart{/s}',
			emptyText: '{s name=emptyTextPayment}Alle anzeigen{/s}'
        },
		generate: {
            label: '{s name=fieldLabelGenerate}Generiert{/s}',
			emptyText: '{s name=emptyTextGenerate}Alle anzeigen{/s}',
			comboYes: '{s name=comboYesGenerate}Ja{/s}',
			comboNo: '{s name=comboNoGenerate}Nein{/s}'
        },
		shipped: {
            label: '{s name=fieldLabelShipped}Status{/s}',
			emptyText: '{s name=emptyTextShipped}Alle anzeigen{/s}',
			comboSent: '{s name=comboSentShipped}Versendet{/s}',
			comboNotSent: '{s name=comboNotSentShipped}Nicht Versendet{/s}',
			comboError: '{s name=comboErrorShipped}Fehler{/s}'
        },
		searcharticle: {
            label: '{s name=fieldLabelSearcharticle}Artikel{/s}'
        },
		buttons: {
            clearFilterExternalOrder: '{s name=clearFilterExternalOrderButton}Zurücksetzen{/s}',
			filterExternalOrder: '{s name=filterExternalOrderButton}Ausführen{/s}',
			importExternalOrder: '{s name=importExternalOrderButton}Neue Bestellung importieren{/s}'
        }
    },
	
	initComponent:function () {
        var me = this;
		me.title = me.snippets.title;
        me.items = me.getPanel();
        me.callParent(arguments);
    },

	getPanel:function () {
        var me = this;
		
		me.statusStore.filterBy(function(item) { return item.get("id") > -1; });
		
		var itemsData = [{
			xtype: 'container',
			border: false,
			padding: 10,
			defaults: {
				anchor:'98%',
                labelWidth:95
			},
			items: [{
				fieldLabel: me.snippets.from.label,
				xtype: 'datefield',
				name: 'from'
			},{
				fieldLabel: me.snippets.to.label,
				xtype: 'datefield',
				name: 'to'
			},{
				fieldLabel: me.snippets.account.label,
				xtype: 'combobox',
				name: 'account',
				emptyText: me.snippets.account.emptyText,
				store: me.accountStore,
				valueField: 'name',
				displayField: 'description',
				queryMode: 'local',
				editable: false
			},{
				fieldLabel: me.snippets.status.label,
				xtype: 'combobox',
				name: 'status',
				emptyText: me.snippets.status.emptyText,
				store: me.statusStore,
				valueField: 'id',
				displayField: 'description',
				queryMode: 'local',
				editable: false
			},{
				fieldLabel: me.snippets.payment.label,
				xtype: 'combobox',
				name: 'payment',
				emptyText: me.snippets.payment.emptyText,
				store: me.paymentStore,
				valueField: 'id',
				displayField: 'name',
				queryMode: 'local',
				editable: false
			},{
				fieldLabel: me.snippets.generate.label,
				xtype: 'combobox',
				name: 'generate',
				emptyText: me.snippets.generate.emptyText,
				store: [
					['1', me.snippets.generate.comboYes],
					['2', me.snippets.generate.comboNo]
				],
				editable: false
			},{
				fieldLabel: me.snippets.shipped.label,
				xtype: 'combobox',
				name: 'shipped',
				emptyText: me.snippets.shipped.emptyText,
				store: [
					['1', me.snippets.shipped.comboSent],
					['2', me.snippets.shipped.comboNotSent],
					['3', me.snippets.shipped.comboError]
				],
				editable: false
			},{
				fieldLabel: me.snippets.searcharticle.label,
				xtype: 'articlesearchfield',
				name: 'searcharticle',
				searchFieldName: 'searcharticle',
            	articleStore: Ext.create('Shopware.store.Article'),
				dropDownOffset: [ 100, 8 ],
				formFieldConfig: {
                    labelWidth: 95,
                    fieldStyle: 'width: 159px'
                }
			},{
				margin: '10px 0 0 0',
				xtype: 'button',
				cls: 'small secondary',
				action: 'clearFilterExternalOrder',
				text: me.snippets.buttons.clearFilterExternalOrder,
			},{
				margin: '10px 0 0 0',
				xtype: 'button',
				cls: 'small primary',
				action: 'filterExternalOrder',
				style: 'float: right;',
				text: me.snippets.buttons.filterExternalOrder,
			},
			/*{if {acl_is_allowed privilege=import}}*/
			{
				margin: '20px 0 0 0',
				width: 280,
				xtype: 'button',
				cls: 'primary',
				action: 'importExternalOrder',
				text: me.snippets.buttons.importExternalOrder,
			}
			/*{/if}*/
			]
		}];
		
		return itemsData;
	}
});
//{/block}