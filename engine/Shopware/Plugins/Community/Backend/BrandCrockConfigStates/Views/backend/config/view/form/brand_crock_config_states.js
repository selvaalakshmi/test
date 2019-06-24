//{namespace name=backend/config/view/main}
//{block name="backend/config/view/form/shop" append}
Ext.define('Shopware.apps.Config.view.form.BrandCrockConfigStates', {
    extend: 'Shopware.apps.Config.view.base.Form',
    alias: 'widget.config-form-brandcrockconfigstates',
    deletable: false,
    snippets: {
        state: '{s name="column/order_status" namespace="backend/customer/view/order"}Bestellstatus{/s}',
        payment: '{s name="column/payment_status" namespace="backend/customer/view/order"}Zahlstatus{/s}',
    },
    
    initComponent: function() {
        var me = this;
        me.callParent(arguments);

        me.addEvents('editStates');
        /*
        me.on({
        	editStates: me.editStates
        });
        */
    },
    
    getItems: function() {
        var me = this;
		me.statesStore = Ext.create('Ext.data.Store', {
			fields: ['id', 'name'],
			data: [
				{ 'id':'state', 'name':me.snippets.state },
				{ 'id':'payment', 'name':me.snippets.payment },
			]
		});
		me.statesGrid = Ext.create('Shopware.apps.Config.view.base.Table', {
            store: me.statesStore,
            columns: me.getColumns(),
            flex: 1,
            getToolbar: function(){
            	return [];
            },
            getPagingToolbar: function(){
            	return [];
            },
            listeners: {
            	selectionchange: function(_this, records, eOpts){
					record = records.length ? records[0] : null;
            		me.fireEvent('editStates', record);
            	}
            }
		});
		me.statesDetail = Ext.create('Shopware.apps.Config.view.BrandCrockConfigStates.Detail', {
			flex: 2
		});
		
		return [me.statesGrid,me.statesDetail];
    },
    getColumns: function() {
        var me = this;
        return [{
            dataIndex: 'name',
            text: '{s name=states}Status{/s}',
            flex: 1
        }, me.getActionColumn()];
    },
    
    getActionColumn: function() {
        var me = this,
			items = [];
        if(true) {
        /*{if {acl_is_allowed privilege=update}}*/
            items.push({
                iconCls: 'sprite-pencil',
                action: 'edit',
                tooltip: '{s name=form/edit_tooltip}Edit{/s}',
                handler: function (view, rowIndex, colIndex, item, opts, record) {
					me.fireEvent('editStates', record);
                }
            });
        /* {/if} */
        }
        return {
            xtype: 'actioncolumn',
            width: 42,
            items: items
        };
    },
});
//{/block}
