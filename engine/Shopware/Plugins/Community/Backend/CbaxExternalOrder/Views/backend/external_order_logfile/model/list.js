Ext.define('Shopware.apps.ExternalOrderLogfile.model.List', {
    extend : 'Ext.data.Model',

    fields : [
        'id',
		'account',
		'account_description',
		'date',
		'type',
		'msg',
		'action',
		'debugdata'
    ],

    proxy : {
        type : 'ajax',
 
        api:{
            read: '{url controller="ExternalOrderLogfile" action=getLogfiles}',
			destroy : '{url controller="ExternalOrderLogfile" action="deleteLogfile"}'
        },
 
        reader : {
            type : 'json',
            root : 'data',
            totalProperty: 'total'
        }
    }
});