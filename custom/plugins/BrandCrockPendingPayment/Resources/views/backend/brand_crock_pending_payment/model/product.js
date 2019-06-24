
Ext.define('Shopware.apps.BrandCrockPendingPayment.model.Product', {
    extend: 'Shopware.data.Model',

    configure: function() {
        return {
            controller: 'BrandCrockPendingPayment',
            detail: 'Shopware.apps.BrandCrockPendingPayment.view.detail.Product'
        };
    },

    fields: [
        { name : 'id', type: 'int', useNull: true },
        { name : 'documentDate', type: 'date' },
        { name : 'invoiceAmount', type: 'string' },
        { name : 'invoiceAmountNet', type: 'string' },
        { name : 'orderTime', type: 'date' },
        { name : 'customerComment', type: 'string' },
        { name : 'number', type: 'string' },
        { name : 'customerFirstName', type: 'string' },
        { name : 'customerLastName', type: 'string' },
        { name : 'payment', type: 'string' },
        { name : 'company', type: 'string' },
        { name : 'invoiceNumber', type: 'string' },     
        { name : 'overdue', type: 'string' },     
        { name : 'bcPaidAmount', type: 'string' },     
        { name : 'bcPendingAmount', type: 'string' },     
        { name : 'customerReferenceNumber', type: 'string' },     
    ],
    
   });
