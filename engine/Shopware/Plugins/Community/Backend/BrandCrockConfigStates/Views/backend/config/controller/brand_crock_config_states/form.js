//{namespace name=backend/config/view/main}
//{block name="backend/config/controller/form" append}
Ext.define('Shopware.apps.Config.controller.Form', {
	extend: 'Shopware.apps.Config.controller.Form',
	/*
	refs: [
        { ref: 'window', selector: 'config-main-window' },
        { ref: 'detail', selector: 'config-base-detail' },
        { ref: 'table', selector: 'config-base-table' },
        { ref: 'deleteButton', selector: 'config-base-table button[action=delete]' },
        { ref: 'taxRuleAddButton', selector: 'config-tax-rule toolbar button' },
        { ref: 'discountAddButton', selector: 'config-pricegroup-discount toolbar button' },
		{ ref: 'configStates', selector: 'config-form-BrandCrockConfigStates' },
		{ ref: 'configDetail', selector: 'config-BrandCrockConfigStates-detail' }
    ],
    */
    record: null,
    clickEdit: 0,
	init:function () {
        var me = this;
       /*
		me.addRef(
			{ ref: 'configStates', selector: 'config-form-brandcrockconfigstates' },
		);
        */
		me.addRef(
			{ ref: 'configDetail', selector: 'config-brandcrockconfigstates-detail' }
		);
		me.control({
            'config-form-brandcrockconfigstates': {
                editStates: me.editStates
            },
			'config-brandcrockconfigstates-detail': {
                'addStates': me.addStates,
                'edit': me.updateStates,
                'beforeedit': me.beforeEdit,
                'canceledit': me.cancelEdit,
            },
			'config-brandcrockconfigstates-detail dataview': {
                'drop': me.dropField
            },
        });
        me.callParent(arguments);
    },
    
    editStates: function(record){
    	var me = this,
			configDetail = me.getConfigDetail();
    	if(record){
    		me.record = record;
			configDetail.store.load({
	            filters : [{
	                property: 'id',
	                value: record.data.id
	            }],
	            callback: function(records, operation) {
	                configDetail.setDisabled(false);
	            }
	        });
    	}
    },
    
    beforeEdit: function(editor, event) {
		var me = this,
			record = event.record;
		if(!record.phantom){
			me.clickEdit ++;
			console.log(me.clickEdit);
			if(me.clickEdit >= 2){
				me.clickEdit = 0;
				Ext.MessageBox.alert('{s name=configAlertTitle}Hinweis{/s}', '{s name=configAlertMsg}Werte und Übersetzungen werden über Textbausteine geändert!{/s}');
			}
			return false;
		}
		/*
		var me = this,
			record = event.record,
			description = editor.grid.columns[editor.grid.columns.length-1].field;
		//console.log(record.phantom);
		//console.log(editor);
		if(!record.phantom){
			description.setDisabled(true);
		}else{
			description.setDisabled(false);
			
		}
		*/
	},
    cancelEdit: function(editor, event) {
        var grid   = editor.grid,
            record = event.record,
            store  = grid.getStore(),
            view   = grid.getView();

        if (record.phantom) {
            store.remove(record);
        }
    },
	
	updateStates: function(editor, event) {
		var me = this,
            record = event.record;
		if (!record.dirty) {
            return;
        }
        
        //console.log(me.record);
        
		record.set({
			'groupType': me.record.get('id')
		});
        record.save({
            callback: function() {
				me.editStates(me.record);
            }
        });
    },
    
    addStates: function(){
    	var me = this,
			configDetail = me.getConfigDetail();
            editor = configDetail.editor,
            count = configDetail.store.count() + 1,
            fieldPosition = editor.grid.columns.length-1,
            newField = Ext.create('Shopware.apps.Config.model.form.BrandCrockConfigStates', {
                position: count,
                id: null
            });

        configDetail.store.add(newField);
        editor.startEdit(newField, fieldPosition);
    },
    
    dropField: function (node, data, overModel, dropPosition) {
    	var me = this,
        	store = me.getConfigDetail().store,
            orderedItems = new Array(),
            index = 0;
        store.each(function(item) {
            orderedItems[index++] = item.data.id;
        });
        
		Ext.Ajax.request({
            url: '{url controller=BrandCrockConfigStates action=sortList}',
            method: 'POST',
            params: {
                data : JSON.stringify(orderedItems)
            }
        });
    }
});
//{/block}
