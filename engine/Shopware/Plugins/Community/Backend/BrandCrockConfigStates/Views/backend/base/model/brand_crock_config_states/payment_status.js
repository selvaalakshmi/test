//{namespace name=backend/static/payment_status}
//{block name="backend/base/model/payment_status" append}
Ext.define("Shopware.apps.Base.model.PaymentStatus", {
	extend: "Shopware.apps.Base.model.PaymentStatus",
    snippets: {
"partially_invoiced": "{s name=partially_invoiced}{/s}",
"completely_invoiced": "{s name=completely_invoiced}{/s}",
"partially_paid": "{s name=partially_paid}{/s}",
"completely_paid": "{s name=completely_paid}{/s}",
"1st_reminder": "{s name=1st_reminder}{/s}",
"2nd_reminder": "{s name=2nd_reminder}{/s}",
"3rd_reminder": "{s name=3rd_reminder}{/s}",
"encashment": "{s name=encashment}{/s}",
"open": "{s name=open}{/s}",
"reserved": "{s name=reserved}{/s}",
"delayed": "{s name=delayed}{/s}",
"re_crediting": "{s name=re_crediting}{/s}",
"review_necessary": "{s name=review_necessary}{/s}",
"no_credit_approved": "{s name=no_credit_approved}{/s}",
"the_credit_has_been_preliminarily_accepted": "{s name=the_credit_has_been_preliminarily_accepted}{/s}",
"the_credit_has_been_accepted": "{s name=the_credit_has_been_accepted}{/s}",
"the_payment_has_been_ordered": "{s name=the_payment_has_been_ordered}{/s}",
"a_time_extension_has_been_registered": "{s name=a_time_extension_has_been_registered}{/s}",
"the_process_has_been_cancelled": "{s name=the_process_has_been_cancelled}{/s}",
"stateID36": "{s name=stateID36}{/s}",
"stateID42": "{s name=stateID42}{/s}",
"stateID43": "{s name=stateID43}{/s}",

    },
});
//{/block}