<?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:31
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/plugins/seo/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13508540705d03910f8240a7-65745210%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0375a1673ecb3e166d5a56be7a9f7186fcbf8ac' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/plugins/seo/index.tpl',
      1 => 1554192886,
      2 => 'file',
    ),
    '37807cd36ce15bba22fe49344b5610cc53da13b2' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/custom/plugins/CompraSuggestionSearch/Resources/views/frontend/search/ajax.tpl',
      1 => 1560514793,
      2 => 'file',
    ),
    'fa4740f5915ef5c61bcf74407a85b7f5b98c9a2c' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/search/ajax.tpl',
      1 => 1554192886,
      2 => 'parent',
    ),
    '49557a121ef82f3dc9f76bc7a2b34ed80ce5a578' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price.tpl',
      1 => 1559564658,
      2 => 'snippet',
    ),
    'cc4b5218b24f6df6877342cbeb61d53100648db9' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price-unit.tpl',
      1 => 1559564659,
      2 => 'parent',
    ),
    '727a6ab67d4935478362425e1c5fc537054a42c8' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/search/product-price-unit.tpl',
      1 => 1554192886,
      2 => 'snippet',
    ),
  ),
  'nocache_hash' => '13508540705d03910f8240a7-65745210',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sSearchResults' => 0,
    'search_result' => 0,
    'snippetListingBoxNoPicture' => 0,
    'sSearchRequest' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5d03910f9e2508_34037313',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d03910f9e2508_34037313')) {function content_5d03910f9e2508_34037313($_smarty_tpl) {?><?php if (!$_smarty_tpl->tpl_vars['sSearchResults']->value['sResults']){?>

    
    
        <ul class="results--list">
            <li class="list--entry entry--no-results result--item"><?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'SearchAjaxNoResults','namespace'=>'frontend/search/ajax')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxNoResults','namespace'=>'frontend/search/ajax'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Keine Suchergebnisse gefunden<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxNoResults','namespace'=>'frontend/search/ajax'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</li>
        </ul>
    

<?php }else{ ?>

    
    <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['useSuggestionSearch']){?>
        <div class="suggestion--search">
            <div class="results--list <?php if (($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories']||$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer'])){?>results--list-advanced<?php }?>">

                
                
                    
                    <div class="search--results-ajax <?php if (!$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories']&&!$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer']){?>search--results-ajax-only <?php }elseif($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories']&&$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer']){?> search--results-ajax-advanced<?php }?>">

                        
                        
                            <div class="search--results-title">
                                <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchProducts')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchProducts'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Produktvorschläge<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchProducts'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                            </div>
                        

                        <ul>
                            
                            <?php  $_smarty_tpl->tpl_vars['search_result'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['search_result']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sSearchResults']->value['sResults']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['search_result']->key => $_smarty_tpl->tpl_vars['search_result']->value){
$_smarty_tpl->tpl_vars['search_result']->_loop = true;
?>
                                
                                
                                    <li class="list--entry block-group">
                                        
                                        <div class="list--entry-expanded">
                                            <a class="search-result--link" href="<?php echo $_smarty_tpl->tpl_vars['search_result']->value['link'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_result']->value['name'], ENT_QUOTES, 'utf-8', true);?>
">

                                                
                                                
                                                    <span class="entry--media block">
                                                        <?php if ($_smarty_tpl->tpl_vars['search_result']->value['image']['thumbnails'][0]){?>
                                                            <img srcset="<?php echo $_smarty_tpl->tpl_vars['search_result']->value['image']['thumbnails'][0]['sourceSet'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_result']->value['name'], ENT_QUOTES, 'utf-8', true);?>
" class="media--image">
                                                        <?php }else{ ?>
                                                            <img src="/selvakumar/shopsystem/install_558/themes/Frontend/Responsive/frontend/_public/src/img/no-picture.jpg" alt="<?php ob_start();?><?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxNoPicture','namespace'=>'frontend/search/ajax')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxNoPicture','namespace'=>'frontend/search/ajax'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo "Kein Bild";?><?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxNoPicture','namespace'=>'frontend/search/ajax'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_tmp1=ob_get_clean();?><?php echo htmlspecialchars($_tmp1, ENT_QUOTES, 'utf-8', true);?>
"
                                                                 class="media--image">
                                                        <?php }?>
                                                    </span>
                                                

                                                
                                                
                                                    <span class="entry--name block">
                                                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapeHtml'][0][0]->escapeHtml($_smarty_tpl->tpl_vars['search_result']->value['name']);?>

                                                    </span>
                                                

                                                
                                                
                                                    <span class="entry--price block">
                                                        <?php $_smarty_tpl->tpl_vars['sArticle'] = new Smarty_variable($_smarty_tpl->tpl_vars['search_result']->value, null, 0);?>
                                                        
                                                        <?php $_smarty_tpl->createLocalArrayVariable('sArticle', null, 0);
$_smarty_tpl->tpl_vars['sArticle']->value['has_pseudoprice'] = 0;?>
                                                        <?php /*  Call merged included template "frontend/listing/product-box/product-price.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/product-price.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('sArticle'=>$_smarty_tpl->tpl_vars['sArticle']->value), 0, '13508540705d03910f8240a7-65745210');
content_5d03910f9a0fa4_26459453($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/product-price.tpl" */?>
                                                    </span>
                                                
                                            </a>
                                        </div>
                                    </li>
                                
                            <?php } ?>

                            
                            
                                <li class="entry--all-results block-group">

                                    
                                    
                                        <a href="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/search';?>?sSearch=<?php echo $_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch'];?>
" class="search-result--link entry--all-results-link block">
                                            <i class="icon--arrow-right"></i>
                                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'SearchAjaxLinkAllResults','namespace'=>'frontend/search/ajax')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxLinkAllResults','namespace'=>'frontend/search/ajax'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Alle Ergebnisse anzeigen<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxLinkAllResults','namespace'=>'frontend/search/ajax'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                        </a>
                                    

                                    
                                    
                                        <span class="entry--all-results-number block">
                                            <?php echo $_smarty_tpl->tpl_vars['sSearchResults']->value['sArticlesCount'];?>
 <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'SearchAjaxInfoResults','namespace'=>'frontend/search/ajax')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxInfoResults','namespace'=>'frontend/search/ajax'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Treffer<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxInfoResults','namespace'=>'frontend/search/ajax'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                        </span>
                                    
                                </li>
                            
                        </ul>
                    </div>
                

                
                
                    
                    <?php if (($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer']||$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories'])||($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showSearchSuggestions']&&isset($_smarty_tpl->tpl_vars['searchSuggestions']->value))){?>
                        
                        <div class="search--results-expanded <?php if (($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer']&&$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories'])){?>search--results-fully-expanded <?php }elseif((!$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer']&&!$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories'])){?> search--results-suggestions<?php }?>">

                            
                            
                                <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories']){?>
                                    <div class ="search--results-categories <?php if (!$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer']){?> search--results-categories-only<?php }?>">
                                        

                                            
                                            
                                                <div class="search--results-title <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategoriesWithFilter']){?> search--results-title-reduced<?php }?>">
                                                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchCategories')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchCategories'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Kategorien<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchCategories'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                                </div>
                                                
                                                <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategoriesWithFilter']){?>
                                                    <div class="search--results-title search--results-filter-title">
                                                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilter')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilter'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
mit Filter<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilter'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                                    </div>
                                                <?php }?>

                                            
                                            <ul>
                                                <?php  $_smarty_tpl->tpl_vars['categories'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categories']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['compraCategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categories']->key => $_smarty_tpl->tpl_vars['categories']->value){
$_smarty_tpl->tpl_vars['categories']->_loop = true;
?>

                                                    
                                                    
                                                        <li class="list--entry block-group">

                                                            
                                                            
                                                                <div class="<?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategoriesWithFilter']){?>list--entry-expanded-filter <?php }else{ ?> list--entry-expanded<?php }?>">
                                                                    <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['categoriesLinkToSearchResults']){?>
                                                                        
                                                                        <a class="search-result--link" href="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/search';?>?sSearch=<?php echo $_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch'];?>
&c=<?php echo $_smarty_tpl->tpl_vars['categories']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['compraCategoriesPath'][$_smarty_tpl->tpl_vars['categories']->value['id']]['linkTitle'];?>
">
                                                                            <div class="entry--name">
                                                                                <?php echo $_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['compraCategoriesPath'][$_smarty_tpl->tpl_vars['categories']->value['id']]['name'];?>

                                                                            </div>
                                                                        </a>
                                                                    <?php }else{ ?>
                                                                        
                                                                        <a class="search-result--link" href="<?php echo htmlspecialchars(Shopware()->Front()->Router()->assemble(array('controller' => 'cat', 'sCategory' => $_smarty_tpl->tpl_vars['categories']->value['id'], ))); ?>" title="<?php echo $_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['compraCategoriesPath'][$_smarty_tpl->tpl_vars['categories']->value['id']]['linkTitle'];?>
">
                                                                            <div class="entry--name">
                                                                                <?php echo $_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['compraCategoriesPath'][$_smarty_tpl->tpl_vars['categories']->value['id']]['name'];?>

                                                                            </div>
                                                                        </a>
                                                                    <?php }?>
                                                                </div>
                                                            

                                                            
                                                            
                                                                <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategoriesWithFilter']){?>
                                                                    <div class="search--results-icon">
                                                                        <a class="search-result--link" href="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/search';?>?sSearch=<?php echo $_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch'];?>
&c=<?php echo $_smarty_tpl->tpl_vars['categories']->value['id'];?>
"
                                                                           title="<?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchFirst')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchFirst'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
in<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchFirst'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 &quot;<?php echo $_smarty_tpl->tpl_vars['categories']->value['name'];?>
&quot; <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchMiddle','default'=>'
                                                                              ')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchMiddle','default'=>'
                                                                              '), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
nach<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchMiddle','default'=>'
                                                                              '), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 &quot;<?php echo $_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch'];?>
&quot; <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchLast')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchLast'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
suchen<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchLast'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"
                                                                           data-action-link="true">
                                                                            
                                                                            <span class="entry--name">
                                                                                <i class="icon--search"></i>
                                                                                (<?php echo $_smarty_tpl->tpl_vars['categories']->value['count'];?>
)
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                <?php }?>
                                                            
                                                        </li>
                                                    
                                                <?php } ?>
                                            </ul>
                                        
                                    </div>
                                <?php }?>
                            

                            
                            
                                <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturer']){?>
                                    <div class ="search--results-manufacturer <?php if (!$_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showCategories']){?>search--results-manufacturer-only<?php }?>">

                                        

                                            
                                            
                                                <div class="search--results-title  <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturerWithFilter']){?>search--results-title-reduced<?php }?>">
                                                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchManufacturer')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchManufacturer'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Hersteller<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchManufacturer'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                                </div>
                                                
                                                <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturerWithFilter']){?>
                                                    <div class="search--results-title search--results-filter-title">
                                                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilter')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilter'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
mit Filter<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilter'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                                    </div>
                                                <?php }?>
                                            
                                            <ul>
                                                <?php  $_smarty_tpl->tpl_vars['suppliers'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['suppliers']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['compraSuppliers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['suppliers']->key => $_smarty_tpl->tpl_vars['suppliers']->value){
$_smarty_tpl->tpl_vars['suppliers']->_loop = true;
?>

                                                    
                                                    
                                                        <li class="list--entry block-group">

                                                            
                                                            
                                                                <div class="<?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturerWithFilter']){?> list--entry-expanded-filter <?php }else{ ?>list--entry-expanded<?php }?>">
                                                                    <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['manufacturerLinkToSearchResults']){?>
                                                                        
                                                                        <a class="search-result--link" href="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/search';?>?sSearch=<?php echo $_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch'];?>
&s=<?php echo $_smarty_tpl->tpl_vars['suppliers']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['suppliers']->value['name'];?>
">
                                                                            <div class="entry--name">
                                                                                <?php echo $_smarty_tpl->tpl_vars['suppliers']->value['name'];?>

                                                                            </div>
                                                                        </a>
                                                                    <?php }else{ ?>
                                                                        
                                                                        <a class="search-result--link" href="<?php echo htmlspecialchars(Shopware()->Front()->Router()->assemble(array('controller' => 'listing', 'action' => 'manufacturer', 'sSupplier' => $_smarty_tpl->tpl_vars['suppliers']->value['id'], ))); ?>" title="<?php echo $_smarty_tpl->tpl_vars['suppliers']->value['name'];?>
">
                                                                            <div class="entry--name">
                                                                                <?php echo $_smarty_tpl->tpl_vars['suppliers']->value['name'];?>

                                                                            </div>
                                                                        </a>
                                                                    <?php }?>
                                                                </div>
                                                            

                                                            
                                                            
                                                                <?php if ($_smarty_tpl->tpl_vars['compraSuggestionSearch']->value['showManufacturerWithFilter']){?>
                                                                    <div class="search--results-icon">
                                                                        <a class="search-result--link" href="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/search';?>?sSearch=<?php echo $_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch'];?>
&s=<?php echo $_smarty_tpl->tpl_vars['suppliers']->value['id'];?>
"
                                                                           title="<?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchFirst')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchFirst'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
in<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchFirst'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 &quot;<?php echo $_smarty_tpl->tpl_vars['suppliers']->value['name'];?>
&quot; <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchMiddle','default'=>'
                                                                              ')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchMiddle','default'=>'
                                                                              '), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
nach<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchMiddle','default'=>'
                                                                              '), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 &quot;<?php echo $_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch'];?>
&quot; <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchLast')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchLast'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
suchen<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/search/ajax','name'=>'compraSuggestionSearchFilterSearchLast'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"
                                                                           data-action-link="true">
                                                                            
                                                                            <span class="entry--name">
                                                                                <i class="icon--search"></i>
                                                                                (<?php echo $_smarty_tpl->tpl_vars['suppliers']->value['count'];?>
)
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                <?php }?>
                                                            
                                                        </li>
                                                    
                                                <?php } ?>
                                            </ul>
                                        
                                    </div>
                                <?php }?>
                            
                        </div>
                    <?php }?>
                
            </div>
        </div>
    <?php }else{ ?>
        
        <ul class="results--list">
            <?php  $_smarty_tpl->tpl_vars['search_result'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['search_result']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sSearchResults']->value['sResults']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['search_result']->key => $_smarty_tpl->tpl_vars['search_result']->value){
$_smarty_tpl->tpl_vars['search_result']->_loop = true;
?>

                
                
                    <li class="list--entry block-group result--item">
                        <a class="search-result--link" href="<?php echo $_smarty_tpl->tpl_vars['search_result']->value['link'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_result']->value['name'], ENT_QUOTES, 'utf-8', true);?>
">

                            
                            
                                <span class="entry--media block">
                                    <?php if ($_smarty_tpl->tpl_vars['search_result']->value['image']['thumbnails'][0]){?>
                                        <img srcset="<?php echo $_smarty_tpl->tpl_vars['search_result']->value['image']['thumbnails'][0]['sourceSet'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_result']->value['name'], ENT_QUOTES, 'utf-8', true);?>
" class="media--image">
                                    <?php }else{ ?>
                                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxNoPicture','assign'=>'snippetListingBoxNoPicture','namespace'=>'frontend/search/ajax')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxNoPicture','assign'=>'snippetListingBoxNoPicture','namespace'=>'frontend/search/ajax'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Kein Bild<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxNoPicture','assign'=>'snippetListingBoxNoPicture','namespace'=>'frontend/search/ajax'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                        <img src="/selvakumar/shopsystem/install_558/themes/Frontend/Responsive/frontend/_public/src/img/no-picture.jpg" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['snippetListingBoxNoPicture']->value, ENT_QUOTES, 'utf-8', true);?>
" class="media--image">
                                    <?php }?>
                                </span>
                            

                            
                            
                                <span class="entry--name block">
                                    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapeHtml'][0][0]->escapeHtml($_smarty_tpl->tpl_vars['search_result']->value['name']);?>

                                </span>
                            

                            
                            
                                <span class="entry--price block">
                                    <?php $_smarty_tpl->tpl_vars['sArticle'] = new Smarty_variable($_smarty_tpl->tpl_vars['search_result']->value, null, 0);?>
                                    
                                    <?php $_smarty_tpl->createLocalArrayVariable('sArticle', null, 0);
$_smarty_tpl->tpl_vars['sArticle']->value['has_pseudoprice'] = 0;?>

                                    
                                        <?php /*  Call merged included template "frontend/listing/product-box/product-price.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/product-price.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '13508540705d03910f8240a7-65745210');
content_5d03910f946d97_14693166($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/product-price.tpl" */?>
                                    

                                    
                                        <?php /*  Call merged included template "frontend/search/product-price-unit.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/search/product-price-unit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '13508540705d03910f8240a7-65745210');
content_5d03910f9683f1_99990026($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/search/product-price-unit.tpl" */?>
                                    
                                </span>
                            
                        </a>
                    </li>
                
            <?php } ?>

            
            
                <li class="entry--all-results block-group result--item">

                    
                    
                        <a href="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/search';?>?sSearch=<?php echo urlencode($_smarty_tpl->tpl_vars['sSearchRequest']->value['sSearch']);?>
" class="search-result--link entry--all-results-link block">
                            <i class="icon--arrow-right"></i>
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'SearchAjaxLinkAllResults','namespace'=>'frontend/search/ajax')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxLinkAllResults','namespace'=>'frontend/search/ajax'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Alle Ergebnisse anzeigen<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxLinkAllResults','namespace'=>'frontend/search/ajax'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        </a>
                    

                    
                    
                        <span class="entry--all-results-number block">
                            <?php echo $_smarty_tpl->tpl_vars['sSearchResults']->value['sArticlesCount'];?>
 <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'SearchAjaxInfoResults','namespace'=>'frontend/search/ajax')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxInfoResults','namespace'=>'frontend/search/ajax'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Treffer<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'SearchAjaxInfoResults','namespace'=>'frontend/search/ajax'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        </span>
                    
                </li>
            
        </ul>
    
    <?php }?>

<?php }?>
<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:31
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910f946d97_14693166')) {function content_5d03910f946d97_14693166($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_currency')) include '/var/www/selvakumar/shopsystem/install_558/engine/Library/Enlight/Template/Plugins/modifier.currency.php';
?>

<div class="product--price">
    
    
        <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['has_pseudoprice']){?>
            <span class="price--pseudo">

                
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'priceDiscountLabel','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountLabel','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
statt<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountLabel','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                

                <span class="price--discount is--nowrap">
                    <?php echo smarty_modifier_currency($_smarty_tpl->tpl_vars['sArticle']->value['pseudoprice']);?>


                </span>

                
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'priceDiscountInfo','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountInfo','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountInfo','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                
            </span>
        <?php }?>
    
    
    
        <span class="price--default is--nowrap<?php if ($_smarty_tpl->tpl_vars['sArticle']->value['has_pseudoprice']){?> is--discount<?php }?>">
            <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['priceStartingFrom']){?><?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxArticleStartsAt','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleStartsAt','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
ab<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleStartsAt','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <?php }?>
            <?php echo smarty_modifier_currency($_smarty_tpl->tpl_vars['sArticle']->value['price']);?>

        </span>
    


</div>
<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:31
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/search/product-price-unit.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910f9683f1_99990026')) {function content_5d03910f9683f1_99990026($_smarty_tpl) {?>

<div class="price--unit">
    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxArticleContent','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleContent','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
inkl. MwSt. zzgl. Versand<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleContent','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    
    <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']&&$_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']!=0){?>

        
        
    <span class="price--label label--purchase-unit">
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'DetailDataInfoContent','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailDataInfoContent','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Inhalt:<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailDataInfoContent','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    </span>


        
        

        
    <?php }?>

    
    <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']&&$_smarty_tpl->tpl_vars['sArticle']->value['referenceunit']&&$_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']!=$_smarty_tpl->tpl_vars['sArticle']->value['referenceunit']){?>

        
        

        
    <?php }?>
</div><?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:31
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910f9a0fa4_26459453')) {function content_5d03910f9a0fa4_26459453($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_currency')) include '/var/www/selvakumar/shopsystem/install_558/engine/Library/Enlight/Template/Plugins/modifier.currency.php';
?>

<div class="product--price">
    
    
        <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['has_pseudoprice']){?>
            <span class="price--pseudo">

                
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'priceDiscountLabel','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountLabel','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
statt<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountLabel','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                

                <span class="price--discount is--nowrap">
                    <?php echo smarty_modifier_currency($_smarty_tpl->tpl_vars['sArticle']->value['pseudoprice']);?>


                </span>

                
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'priceDiscountInfo','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountInfo','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'priceDiscountInfo','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                
            </span>
        <?php }?>
    
    
    
        <span class="price--default is--nowrap<?php if ($_smarty_tpl->tpl_vars['sArticle']->value['has_pseudoprice']){?> is--discount<?php }?>">
            <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['priceStartingFrom']){?><?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxArticleStartsAt','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleStartsAt','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
ab<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleStartsAt','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <?php }?>
            <?php echo smarty_modifier_currency($_smarty_tpl->tpl_vars['sArticle']->value['price']);?>

        </span>
    


</div>
<?php }} ?>