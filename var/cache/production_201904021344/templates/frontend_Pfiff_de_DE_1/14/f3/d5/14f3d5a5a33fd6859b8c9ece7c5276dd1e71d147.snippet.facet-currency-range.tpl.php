<?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:25
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/filter/facet-currency-range.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2136169965d039109de08e8-83660878%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14f3d5a5a33fd6859b8c9ece7c5276dd1e71d147' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/filter/facet-currency-range.tpl',
      1 => 1554192886,
      2 => 'file',
    ),
    'fd4107093ab59be084f387fcf51196a8bdc24722' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/filter/facet-range.tpl',
      1 => 1554192886,
      2 => 'parent',
    ),
  ),
  'nocache_hash' => '2136169965d039109de08e8-83660878',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'facet' => 0,
    'roundPretty' => 0,
    'format' => 0,
    'suffix' => 0,
    'stepCount' => 0,
    'stepCurve' => 0,
    'startMin' => 0,
    'digits' => 0,
    'startMax' => 0,
    'rangeMin' => 0,
    'rangeMax' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5d039109e0f714_21825711',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d039109e0f714_21825711')) {function content_5d039109e0f714_21825711($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_number')) include '/var/www/selvakumar/shopsystem/install_558/engine/Library/Enlight/Template/Plugins/modifier.number.php';
if (!is_callable('smarty_modifier_currency')) include '/var/www/selvakumar/shopsystem/install_558/engine/Library/Enlight/Template/Plugins/modifier.currency.php';
?>


    <div class="filter-panel filter--range facet--<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getFacetName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
"
         data-filter-type="range"
         data-facet-name="<?php echo $_smarty_tpl->tpl_vars['facet']->value->getFacetName();?>
"
         data-field-name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getFacetName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
">

        
            <div class="filter-panel--flyout">

                
                    <label class="filter-panel--title" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getLabel(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
">
                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getLabel(), ENT_QUOTES, 'utf-8', true);?>

                    </label>
                

                
                    <span class="filter-panel--icon"></span>
                

                
                    <div class="filter-panel--content">

                        

                            
    <?php $_smarty_tpl->tpl_vars['startMin'] = new Smarty_variable($_smarty_tpl->tpl_vars['facet']->value->getActiveMin(), null, 0);?>
    <?php $_smarty_tpl->tpl_vars['startMax'] = new Smarty_variable($_smarty_tpl->tpl_vars['facet']->value->getActiveMax(), null, 0);?>
    <?php $_smarty_tpl->tpl_vars['rangeMin'] = new Smarty_variable($_smarty_tpl->tpl_vars['facet']->value->getMin(), null, 0);?>
    <?php $_smarty_tpl->tpl_vars['rangeMax'] = new Smarty_variable($_smarty_tpl->tpl_vars['facet']->value->getMax(), null, 0);?>
    <?php $_smarty_tpl->tpl_vars['roundPretty'] = new Smarty_variable('false', null, 0);?>
    <?php ob_start();?><?php echo smarty_modifier_currency('0');?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['format'] = new Smarty_variable($_tmp1, null, 0);?>
    <?php $_smarty_tpl->tpl_vars['stepCount'] = new Smarty_variable(100, null, 0);?>
    <?php $_smarty_tpl->tpl_vars['digits'] = new Smarty_variable(2, null, 0);?>
    <?php $_smarty_tpl->tpl_vars['stepCurve'] = new Smarty_variable('linear', null, 0);?>


                            <div class="range-slider"
                                 data-range-slider="true"
                                 data-roundPretty="<?php echo $_smarty_tpl->tpl_vars['roundPretty']->value;?>
"
                                 data-labelFormat="<?php echo $_smarty_tpl->tpl_vars['format']->value;?>
"
                                 data-suffix="<?php echo $_smarty_tpl->tpl_vars['suffix']->value;?>
"
                                 data-stepCount="<?php echo $_smarty_tpl->tpl_vars['stepCount']->value;?>
"
                                 data-stepCurve="<?php echo $_smarty_tpl->tpl_vars['stepCurve']->value;?>
"
                                 data-startMin="<?php echo $_smarty_tpl->tpl_vars['startMin']->value;?>
"
                                 data-digits="<?php echo $_smarty_tpl->tpl_vars['digits']->value;?>
"
                                 data-startMax="<?php echo $_smarty_tpl->tpl_vars['startMax']->value;?>
"
                                 data-rangeMin="<?php echo $_smarty_tpl->tpl_vars['rangeMin']->value;?>
"
                                 data-rangeMax="<?php echo $_smarty_tpl->tpl_vars['rangeMax']->value;?>
">

                                
                                    <input type="hidden"
                                           id="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getMinFieldName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
"
                                           name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getMinFieldName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
"
                                           data-range-input="min"
                                           value="<?php echo $_smarty_tpl->tpl_vars['startMin']->value;?>
" <?php if (!$_smarty_tpl->tpl_vars['facet']->value->isActive()||$_smarty_tpl->tpl_vars['startMin']->value==0){?>disabled="disabled" <?php }?>/>
                                

                                
                                    <input type="hidden"
                                           id="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getMaxFieldName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
"
                                           name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getMaxFieldName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
"
                                           data-range-input="max"
                                           value="<?php echo $_smarty_tpl->tpl_vars['startMax']->value;?>
" <?php if (!$_smarty_tpl->tpl_vars['facet']->value->isActive()||$_smarty_tpl->tpl_vars['startMax']->value==0){?>disabled="disabled" <?php }?>/>
                                

                                
                                    <div class="filter-panel--range-info">

                                        
                                            <span class="range-info--min">
                                                <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingFilterRangeFrom','namespace'=>'frontend/listing/listing_actions')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingFilterRangeFrom','namespace'=>'frontend/listing/listing_actions'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
von<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingFilterRangeFrom','namespace'=>'frontend/listing/listing_actions'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                            </span>
                                        

                                        
                                            <label class="range-info--label"
                                                   for="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getMinFieldName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
"
                                                   data-range-label="min">
                                                <?php echo $_smarty_tpl->tpl_vars['startMin']->value;?>

                                            </label>
                                        

                                        
                                            <span class="range-info--max">
                                                <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingFilterRangeTo','namespace'=>'frontend/listing/listing_actions')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingFilterRangeTo','namespace'=>'frontend/listing/listing_actions'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bis<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingFilterRangeTo','namespace'=>'frontend/listing/listing_actions'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                            </span>
                                        

                                        
                                            <label class="range-info--label"
                                                   for="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['facet']->value->getMaxFieldName(), ENT_QUOTES, 'utf-8', true), "HTML-ENTITIES", 'utf-8');?>
"
                                                   data-range-label="max">
                                                <?php echo $_smarty_tpl->tpl_vars['startMax']->value;?>

                                            </label>
                                        
                                    </div>
                                
                            </div>
                        
                    </div>
                
            </div>
        
    </div>

<?php }} ?>