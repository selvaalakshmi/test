// {namespace name=backend/plugins/external_order/view/main/statistic}
Ext.define('Shopware.apps.ExternalOrder.view.main.Statistic', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.externalorder-main-statistic',
    layout: 'fit',
	
	snippets: {
        title: '{s name=titleWindow}Statistik{/s}',
		grid: {
            toolbar: {
                summary: '{s name=gridSummary}Statistik Details{/s}'
            },
			columns: {
                account: '{s name=gridLabelAccount}Marktplatz{/s}',
                value: '{s name=gridLabelValues}Summe{/s}',
                summaryRenderer: '{s name=gridLabelExternalSummaryRenderer}<b>Gesamt</b>{/s}'
            }
        }
    },
	
    initComponent:function () {
        var me = this;
		me.title = me.snippets.title;
        me.items = [ me.createFieldContainer() ];
        me.callParent(arguments);
    },

    /**
     * Creates the outer field container for the statistic grid and chart.
     * @return Ext.container.Container - Contains the statistic grid and chart
     */
    createFieldContainer: function() {
        var me = this;

        return Ext.create('Ext.container.Container', {
            border: false,
            padding: 10,
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            items: [ me.createChart(), me.createGrid() ]
        });
    },

    createChart: function() {
        var me = this;

        return Ext.create('Ext.chart.Chart', {
            store: me.statisticStore,
            //Specifies whether the floating component should be given a shadow.
            shadow: true,
            //True for the default animation (easing: 'ease' and duration: 500) or a standard animation config object to be used for default chart animations.
            animate: true,
            width: 275,
            height: 250,
            series: [
                {
                    type: 'pie',
                    field: 'value',
                    label: {
                        field: 'account',
                        display: 'rotate',
                        contrast: true,
                        fontSize: 9
                    },
                    //If set to true it will highlight the markers or the series when hovering with the mouse.
                    highlight: {
                        segment: {
                            margin: 20
                        }
                    },
                    //Add tooltips to the visualization's markers. The options for the tips are the same configuration used with Ext.tip.ToolTip
                    tips: {
                        trackMouse: true,
                        width: 180,
                        height: 25,
                        //tip renderer of the chart
                        renderer: function(storeItem, item) {
                            // calculate and display percentage on hover
                            var total = 0;

                            me.statisticStore.each(function(rec) {
                                total += rec.get('value');
                            });

                            this.setTitle(storeItem.get('account') + ': ' + Math.round(storeItem.get('value') / total * 100) + '%');
                        }
                    }
                }
            ]
        });
    },

    /**
     * Creates the gird which displayed in the statistic panel on the left hand of the main window.
     * Displays the order data grouped by payment with an summary row at the end.
     * @return Ext.grid.Panel
     */
    createGrid: function() {
        var me = this;

        return Ext.create('Ext.grid.Panel', {
            //the grid an chart use the same store.
            store: me.statisticStore,
            flex: 1,
            title: me.snippets.grid.toolbar.summary,
            //An array of grid Features to be added to this grid
            features: [{
                ftype: 'summary'
            }],
            columns: [
                {
                    header: me.snippets.grid.columns.account,
                    dataIndex: 'account',
                    flex: 1,
                    summaryType: 'count',
                    summaryRenderer: function() {
                        return me.snippets.grid.columns.summaryRenderer;
                    }
                },
                {
                    header: me.snippets.grid.columns.value,
                    dataIndex: 'value',
                    flex: 1,
                    renderer: me.valueColumn,
                    summaryType: 'sum',
                    summaryRenderer: function(value, summaryData, dataIndex) {
                        return '<b>' + Ext.util.Format.currency(value) + '</b>';
                    }
                }
            ]
        });

    },

    /**
     * Render function for the value column of the statistic grid.
     * @param value
     */
    valueColumn: function(value) {
        return Ext.util.Format.currency(value);
    }


});
