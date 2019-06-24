//{namespace name=backend/config/view/main}
//{block name="backend/config/view/form/shop" append}
Ext.define('Shopware.apps.Config.view.BrandCrockConfigStates.Detail', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.config-brandcrockconfigstates-detail',
    

    region: 'east',
    //layout: 'anchor',
    border: false,
    //width: 450,
    title: '{s name=detail/title}Details{/s}',
    autoScroll: true,
    //bodyPadding: '10 10 50 10',
    collapsible: true,
    disabled: true,
    
    viewConfig: {
    	plugins: {
            pluginId: 'my-gridviewdragdrop',
            ptype: 'gridviewdragdrop'
        }
    },
    
    snippets: [{
        hintDragDrop: '{s name=hint_dragdrop}Sie k&ouml;nnen die Felder per Drag & Drop umsortieren{/s}',  
    }],

    initComponent: function() {
        var me = this;
        
        me.editor = me.getRowEditorPlugin();
        me.plugins = [ me.editor ];
        
        me.dockedItems = [me.getToolbar()],
        me.columns = me.getColumns();
        me.store = Ext.create('Shopware.apps.Config.store.detail.BrandCrockConfigStates');
        me.callParent(arguments);
    },
    getColumns: function() {
        var me = this;
        return [{
            header: '&#009868;',
            width: 24,
            hideable: false,
            renderer: me.sortColumnRenderer,
        },{
            dataIndex: 'id',
            header: 'ID',
            width: 42,
        },{
            dataIndex: 'namespace',
            header: '{s name=column_namespace namespace=backend/snippet/view/main}Namespace{/s}',
            flex: 1
        },{
            dataIndex: 'name',
            header: '{s name=column_name namespace=backend/snippet/view/main}Name{/s}',
            flex: 1
        },{
            dataIndex: 'description',
            header: '{s name=column_value namespace=backend/snippet/view/main}Value{/s}',
            flex: 1,
            editor: {
                allowBlank: false,
                enableKeyEvents:true,
                checkChangeBuffer:700
            }
        },/*{
            dataIndex: 'sendMail',
            header: '{s name=sendMail}Mail{/s}',
            width: 42,
            hideable: false,
            align: 'center',
            renderer: me.activeColumnRenderer,
            editor: {
                xtype : 'checkbox',
                allowBlank: false,
                inputValue: 1,
            	uncheckedValue: 0,
                checkChangeBuffer:700
            }
        }*/];
    },
    
    getToolbar: function() {
        var me = this;
        return {
            xtype: 'toolbar',
            ui: 'shopware-ui',
            dock: 'top',
            border: false,
            items: me.getTopBar()
        };
    },

    getTopBar:function () {
        var me = this;
        var items = [];
        items.push({
            iconCls:'sprite-plus-circle-frame',
            text:'{s name=table/add_text}Add entry{/s}',
            tooltip:'{s name=table/add_tooltip}Add (ALT + INSERT){/s}',
            handler: function (view, rowIndex, colIndex, item, opts, record) {
				me.fireEvent('addStates');
            }
        });
        return items;
    },
    
    sortColumnRenderer: function (value,  metadata) {
        var me = this;
        metadata.tdAttr = 'data-qtip="' + me.snippets.hintDragDrop +'"';
        return '<div style="cursor: n-resize;">&#009868;</div>';
    },
    
    activeColumnRenderer: function(value) {
        if (value) {
            return '<div class="sprite-tick-small"  style="width: 16px; height: 16px; margin: 0 auto;">&nbsp;</div>';
        } else {
            return '<div class="sprite-cross-small" style="width: 16px; height: 16px; margin: 0 auto;">&nbsp;</div>';
        }
    },
    
    getRowEditorPlugin: function() {
        return Ext.create('Ext.grid.plugin.RowEditing', {
            clicksToEdit: 2,
            errorSummary: false,
            pluginId: 'rowEditing'
        });
    },
});
//{/block}
