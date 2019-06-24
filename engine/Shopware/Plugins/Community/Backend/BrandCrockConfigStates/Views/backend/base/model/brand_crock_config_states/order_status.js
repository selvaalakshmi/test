//{namespace name=backend/static/order_status}
//{block name="backend/base/model/order_status" append}
Ext.define("Shopware.apps.Base.model.OrderStatus", {
	extend: "Shopware.apps.Base.model.OrderStatus",
    snippets: {
"cancelled": "{s name=cancelled}{/s}",
"open": "{s name=open}{/s}",
"in_process": "{s name=in_process}{/s}",
"completed": "{s name=completed}{/s}",
"partially_completed": "{s name=partially_completed}{/s}",
"cancelled_rejected": "{s name=cancelled_rejected}{/s}",
"ready_for_delivery": "{s name=ready_for_delivery}{/s}",
"partially_delivered": "{s name=partially_delivered}{/s}",
"completely_delivered": "{s name=completely_delivered}{/s}",
"clarification_required": "{s name=clarification_required}{/s}",
"stateID37": "{s name=stateID37}{/s}",
"stateID38": "{s name=stateID38}{/s}",
"stateID39": "{s name=stateID39}{/s}",
"stateID40": "{s name=stateID40}{/s}",
"stateID41": "{s name=stateID41}{/s}",
"BcStatusID44": "{s name=BcStatusID44}{/s}",

    },
});
//{/block}