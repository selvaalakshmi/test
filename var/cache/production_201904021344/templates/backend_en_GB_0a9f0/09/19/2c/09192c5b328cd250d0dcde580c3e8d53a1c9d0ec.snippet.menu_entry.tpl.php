<?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:17
         compiled from "/var/www/selvakumar/shopsystem/install_558/engine/Shopware/Plugins/Community/Backend/SwagImportExport/Views/backend/swag_import_export/menu_entry.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5868197095d039101578bd6-97466489%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09192c5b328cd250d0dcde580c3e8d53a1c9d0ec' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/engine/Shopware/Plugins/Community/Backend/SwagImportExport/Views/backend/swag_import_export/menu_entry.tpl',
      1 => 1556603450,
      2 => 'file',
    ),
    '6eb69c6ec47a6365fcb75fadd47cc7954d603df7' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/custom/plugins/SwagPaymentPayPalUnified/Resources/views/backend/paypal_unified/menu_icon.tpl',
      1 => 1556022328,
      2 => 'file',
    ),
    'b34e8b588e1688d0370ef98cd195a7329f72540a' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Backend/ExtJs/backend/index/menu.tpl',
      1 => 1554192886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5868197095d039101578bd6-97466489',
  'function' => 
  array (
    'backend_menu' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'menu' => 0,
    'category' => 0,
    'isNotDetailAction' => 0,
    'isDetailActionAndHasPrivilege' => 0,
    'hasReadPrivilegeForController' => 0,
    'level' => 0,
    'name' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5d0391015fc5e3_94485445',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d0391015fc5e3_94485445')) {function content_5d0391015fc5e3_94485445($_smarty_tpl) {?>
    <?php if (!function_exists('smarty_template_function_backend_menu')) {
    function smarty_template_function_backend_menu($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['backend_menu']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
        [<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['category']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['category']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['category']->iteration++;
 $_smarty_tpl->tpl_vars['category']->last = $_smarty_tpl->tpl_vars['category']->iteration === $_smarty_tpl->tpl_vars['category']->total;
?>
            <?php $_smarty_tpl->tpl_vars['isNotDetailAction'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value['action']&&mb_strtolower($_smarty_tpl->tpl_vars['category']->value['action'], 'utf-8')!=='detail', null, 0);?>
            <?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['acl_is_allowed'][0][0]->isAllowed(array('privilege'=>'create','resource'=>mb_strtolower($_smarty_tpl->tpl_vars['category']->value['controller'], 'utf-8')),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['isDetailActionAndHasPrivilege'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['category']->value['action'], 'utf-8')=='detail'&&$_tmp1, null, 0);?>
            <?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['acl_is_allowed'][0][0]->isAllowed(array('privilege'=>'read','resource'=>mb_strtolower($_smarty_tpl->tpl_vars['category']->value['controller'], 'utf-8')),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['hasReadPrivilegeForController'] = new Smarty_variable($_tmp2, null, 0);?>

            <?php if (($_smarty_tpl->tpl_vars['category']->value['onclick']||$_smarty_tpl->tpl_vars['isNotDetailAction']->value||$_smarty_tpl->tpl_vars['isDetailActionAndHasPrivilege']->value||$_smarty_tpl->tpl_vars['category']->value['children'])&&$_smarty_tpl->tpl_vars['hasReadPrivilegeForController']->value){?>
            {
                <?php if ($_smarty_tpl->tpl_vars['level']->value===0){?><?php if ($_smarty_tpl->tpl_vars['category']->value['children']){?>xtype: 'hoverbutton',<?php }else{ ?>xtype: 'button',<?php }?><?php }?>
                <?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable(null, null, 0);?>
                <?php if ($_smarty_tpl->tpl_vars['category']->value['controller']){?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value['controller'], null, 0);?><?php }?>
                <?php if ($_smarty_tpl->tpl_vars['category']->value['action']&&$_smarty_tpl->tpl_vars['category']->value['action']!='Index'){?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['category']->value['controller'])."/".((string)$_smarty_tpl->tpl_vars['category']->value['action']), null, 0);?><?php }?>
                text: "<?php if ($_smarty_tpl->tpl_vars['name']->value){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['snippet'][0][0]->compileSnippetModifier(htmlspecialchars_decode($_smarty_tpl->tpl_vars['category']->value['label'], ENT_QUOTES),$_smarty_tpl->tpl_vars['name']->value,'backend/index/view/main');?>
<?php }else{ ?><?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['category']->value['label'], ENT_QUOTES);?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['category']->value['shortcut']){?>&nbsp;<span class='shortcut'>(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['snippet'][0][0]->compileSnippetModifier($_smarty_tpl->tpl_vars['category']->value['shortcut'],$_smarty_tpl->tpl_vars['name']->value,'backend/index/view/shortcuts');?>
)</span><?php }?>",
                <?php if ($_smarty_tpl->tpl_vars['category']->value['controller']&&$_smarty_tpl->tpl_vars['category']->value['action']){?>handler: function() {
                    Shopware.app.Application.addSubApplication({
                    name: 'Shopware.apps.<?php echo $_smarty_tpl->tpl_vars['category']->value['controller'];?>
',
                    localizedName: "<?php if ($_smarty_tpl->tpl_vars['name']->value){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['snippet'][0][0]->compileSnippetModifier(htmlspecialchars_decode($_smarty_tpl->tpl_vars['category']->value['label'], ENT_QUOTES),$_smarty_tpl->tpl_vars['name']->value,'backend/index/view/main');?>
<?php }else{ ?><?php echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['category']->value['label'], ENT_QUOTES);?>
<?php }?>"
                    <?php if ($_smarty_tpl->tpl_vars['category']->value['action']&&$_smarty_tpl->tpl_vars['category']->value['action']!='Index'){?>, action: '<?php echo $_smarty_tpl->tpl_vars['category']->value['action'];?>
'<?php }?>
                    });
                    },
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['category']->value['onclick']){?>handler: function() { <?php echo $_smarty_tpl->tpl_vars['category']->value['onclick'];?>
 },<?php }?>
                <?php if (substr(htmlspecialchars_decode($_smarty_tpl->tpl_vars['category']->value['label'], ENT_QUOTES),-1)=='*'){?>cls: Ext.baseCSSPrefix +'deprecated-menu-item', overCls: Ext.baseCSSPrefix +'deprecated-menu-item-active',<?php }?>
                iconCls: "<?php echo $_smarty_tpl->tpl_vars['category']->value['class'];?>
"<?php if ($_smarty_tpl->tpl_vars['category']->value['children']){?>,
                menu: Ext.create('Ext.menu.Menu', {
                shadow: false, cls: 'shopware-ui-main-menu',
                showSeparator: false, plain: true, ui: 'shopware-ui', margin: '0 0 0 2',
                items: <?php smarty_template_function_backend_menu($_smarty_tpl,array('menu'=>$_smarty_tpl->tpl_vars['category']->value['children'],'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>

                })
            <?php }?>
                }<?php if (!$_smarty_tpl->tpl_vars['category']->last){?>,{ xtype: 'tbspacer', width: 6 }, { xtype: 'tbseparator' }, { xtype: 'tbspacer', width: 6 }, <?php }?>
            <?php }?>
        <?php } ?>]
    <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


<?php smarty_template_function_backend_menu($_smarty_tpl,array('menu'=>$_smarty_tpl->tpl_vars['menu']->value));?>

<?php }} ?>