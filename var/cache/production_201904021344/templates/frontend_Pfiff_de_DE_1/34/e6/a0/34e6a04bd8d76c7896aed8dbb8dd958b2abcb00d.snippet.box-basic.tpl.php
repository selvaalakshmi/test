<?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/box-basic.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17288006565d03910a168bc7-39148225%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34e6a04bd8d76c7896aed8dbb8dd958b2abcb00d' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/box-basic.tpl',
      1 => 1559568972,
      2 => 'file',
    ),
    '2155f3d7e4c66acd129b2c154353a2360a17c1c0' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/product-box/product-badges.tpl',
      1 => 1554192886,
      2 => 'parent',
    ),
    '3d791f534b176f82980aaf7da2f5e6fab3aca634' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-badges.tpl',
      1 => 1559564659,
      2 => 'snippet',
    ),
    'dc07849f7d73ade5b3a8857f9371dcea67fda1d5' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/product-box/product-image.tpl',
      1 => 1554192886,
      2 => 'snippet',
    ),
    'fbb72d35c5edcb6a95c07be7da893b7404587881' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/_includes/rating.tpl',
      1 => 1554192886,
      2 => 'snippet',
    ),
    'cc4b5218b24f6df6877342cbeb61d53100648db9' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price-unit.tpl',
      1 => 1559564659,
      2 => 'snippet',
    ),
    '49557a121ef82f3dc9f76bc7a2b34ed80ce5a578' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price.tpl',
      1 => 1559564658,
      2 => 'snippet',
    ),
    'c869bfc45a4b6c0deb92491c5eefdc88b0ba6068' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/product-box/button-buy.tpl',
      1 => 1554192886,
      2 => 'parent',
    ),
    'ce2917744314763444d23c19b7629042f1af269b' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/custom/plugins/SwagPaymentPayPalUnified/Resources/views/frontend/paypal_unified/express_checkout/button_detail.tpl',
      1 => 1556022328,
      2 => 'snippet',
    ),
    '59a5a0c84b731d3a7f735f32c8ea59cf3f106384' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/custom/plugins/SwagPaymentPayPalUnified/Resources/views/frontend/listing/product-box/button-buy.tpl',
      1 => 1556022327,
      2 => 'snippet',
    ),
    '673252147442dedcf5fc1166d9541f6ec63e116d' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/product-box/button-detail.tpl',
      1 => 1554192886,
      2 => 'parent',
    ),
    'a5524cefb00d708ba2906c53f048efa3b37ac75a' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/custom/plugins/SwagPaymentPayPalUnified/Resources/views/frontend/listing/product-box/button-detail.tpl',
      1 => 1556022327,
      2 => 'snippet',
    ),
    '0dbdfae0eca98b7c389155e869ba2d695603dab1' => 
    array (
      0 => '/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/product-box/product-actions.tpl',
      1 => 1554192886,
      2 => 'snippet',
    ),
  ),
  'nocache_hash' => '17288006565d03910a168bc7-39148225',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sts' => 0,
    'productLayoutClass' => 0,
    'productBoxLayout' => 0,
    'pageIndex' => 0,
    'sArticle' => 0,
    'sCategoryCurrent' => 0,
    'articleImages' => 0,
    'articleImage' => 0,
    'sendArrayImage' => 0,
    'bcghImageArray' => 0,
    'imageName' => 0,
    'imageArticle' => 0,
    'group' => 0,
    'maxQuantity' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5d03910a1ebd92_09578397',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d03910a1ebd92_09578397')) {function content_5d03910a1ebd92_09578397($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/var/www/selvakumar/shopsystem/install_558/engine/Library/Smarty/plugins/modifier.truncate.php';
?>



    <?php if ($_smarty_tpl->tpl_vars['sts']->value==1){?>
    <div class="product--box box--<?php echo $_smarty_tpl->tpl_vars['productLayoutClass']->value;?>
"
    <?php }else{ ?>
    <div class="product--box box--<?php echo $_smarty_tpl->tpl_vars['productBoxLayout']->value;?>
"
    <?php }?>
         data-page-index="<?php echo $_smarty_tpl->tpl_vars['pageIndex']->value;?>
"
         data-ordernumber="<?php echo $_smarty_tpl->tpl_vars['sArticle']->value['ordernumber'];?>
"
         <?php ob_start();?><?php echo false;?><?php $_tmp1=ob_get_clean();?><?php if (!$_tmp1){?> data-category-id="<?php echo $_smarty_tpl->tpl_vars['sCategoryCurrent']->value;?>
"<?php }?>>


    
        
            <div class="box--content is--rounded">

                
                
                    <?php /*  Call merged included template "frontend/listing/product-box/product-badges.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/product-badges.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a16d1b2_27222832($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/product-badges.tpl" */?>
                

                
                    <div class="product--info">

                        
                        
                            <?php /*  Call merged included template "frontend/listing/product-box/product-image.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/product-image.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a17c717_28614530($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/product-image.tpl" */?>
                            <div class="carousel_listing">
                                <div class="owl-carousel owl-theme">
                                     <script type="text/javascript">
                                     /*   $(document).ready(function(){
                                            $('.owl-carousel').owlCarousel({
                                                    loop:true,
                                                    margin:10,
                                                    nav:true,
                                                    autoplay:true,
                                                    autoplayTimeout:10000,
                                                    autoplayHoverPause:true,
                                                    responsive:{
                                                        0:{
                                                            items:1
                                                        },
                                                        600:{
                                                            items:3
                                                        },
                                                        1000:{
                                                            items:5
                                                        }
                                                    }
                                                   });
                                                 }); */
                                    </script>

                                    <?php if ($_smarty_tpl->tpl_vars['articleImages']->value){?>
                                  
                                       
                                        <?php  $_smarty_tpl->tpl_vars['articleImage'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['articleImage']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['articleImages']->value[$_smarty_tpl->tpl_vars['sArticle']->value['articleID']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['articleImage']->key => $_smarty_tpl->tpl_vars['articleImage']->value){
$_smarty_tpl->tpl_vars['articleImage']->_loop = true;
?>
                                       
                                            <div class="item">
                                                
                                                 <img src='<?php echo $_smarty_tpl->tpl_vars['articleImage']->value;?>
' alt=""> 
                                                
                                            </div>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <?php  $_smarty_tpl->tpl_vars['bcghImageArray'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bcghImageArray']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sendArrayImage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bcghImageArray']->key => $_smarty_tpl->tpl_vars['bcghImageArray']->value){
$_smarty_tpl->tpl_vars['bcghImageArray']->_loop = true;
?>
                                            <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['articleID']==$_smarty_tpl->tpl_vars['bcghImageArray']->value['articles_details_id']){?>
                                                <?php $_smarty_tpl->tpl_vars['imageName'] = new Smarty_variable($_smarty_tpl->tpl_vars['bcghImageArray']->value['image'], null, 0);?>
                                                <?php  $_smarty_tpl->tpl_vars['imageArticle'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['imageArticle']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['imageName']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['imageArticle']->key => $_smarty_tpl->tpl_vars['imageArticle']->value){
$_smarty_tpl->tpl_vars['imageArticle']->_loop = true;
?>
                                                    <div class="item">
                                                        <img src='<?php echo $_smarty_tpl->tpl_vars['imageArticle']->value;?>
' alt="">
                                                    </div>
                                                <?php } ?>
                                            <?php }?>
                                        <?php } ?>
                                    <?php }?>

                                </div>
                            </div>
                        

                        
                        
                            <?php ob_start();?><?php echo false;?><?php $_tmp2=ob_get_clean();?><?php if (!$_tmp2){?>
                                <div class="product--rating-container">
                                    <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['sVoteAverage']['average']){?>
                                        <?php /*  Call merged included template "frontend/_includes/rating.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('frontend/_includes/rating.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('points'=>$_smarty_tpl->tpl_vars['sArticle']->value['sVoteAverage']['average'],'type'=>"aggregated",'label'=>false,'microData'=>false), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a18b142_34360302($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/_includes/rating.tpl" */?>
                                    <?php }?>
                                </div>
                            <?php }?>
                        

                        
                        
                            <a href="<?php echo $_smarty_tpl->tpl_vars['sArticle']->value['linkDetails'];?>
"
                               class="product--title"
                               title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapeHtml'][0][0]->escapeHtml($_smarty_tpl->tpl_vars['sArticle']->value['articleName']);?>
">
                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapeHtml'][0][0]->escapeHtml(smarty_modifier_truncate($_smarty_tpl->tpl_vars['sArticle']->value['articleName'],85));?>

                            </a>
                        

                        
                        
                            <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['attributes']['swagVariantConfiguration']){?>
                                <div class="variant--description">
                                    <span title="
                                        <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sArticle']->value['attributes']['swagVariantConfiguration']->get('value'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['group']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
 $_smarty_tpl->tpl_vars['group']->iteration++;
 $_smarty_tpl->tpl_vars['group']->last = $_smarty_tpl->tpl_vars['group']->iteration === $_smarty_tpl->tpl_vars['group']->total;
?>
                                                <?php echo $_smarty_tpl->tpl_vars['group']->value['groupName'];?>
: <?php echo $_smarty_tpl->tpl_vars['group']->value['optionName'];?>

                                        <?php } ?>
                                        ">
                                        <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sArticle']->value['attributes']['swagVariantConfiguration']->get('value'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['group']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['group']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
 $_smarty_tpl->tpl_vars['group']->iteration++;
 $_smarty_tpl->tpl_vars['group']->last = $_smarty_tpl->tpl_vars['group']->iteration === $_smarty_tpl->tpl_vars['group']->total;
?>
                                            <span class="variant--description--line">
                                                <span class="variant--groupName"><?php echo $_smarty_tpl->tpl_vars['group']->value['groupName'];?>
:</span> <?php echo $_smarty_tpl->tpl_vars['group']->value['optionName'];?>
 <?php if (!$_smarty_tpl->tpl_vars['group']->last){?>|<?php }?>
                                            </span>
                                        <?php } ?>
                                    </span>
                                </div>
                            <?php }?>
                        

                        
                         <?php if ($_smarty_tpl->tpl_vars['sts']->value==1){?>
                        <div class="product--description">

                                <?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['sArticle']->value['description_long']),240);?>

                                
                            </div>
                            <div class="product--description-custon-points">
                                <?php echo $_smarty_tpl->tpl_vars['sArticle']->value['attr1'];?>

                            </div>
                       <?php }else{ ?>     

                         
                           <div class="product--description">

                                <?php echo smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['sArticle']->value['description_long']),240);?>

                                
                            </div>
                            <div class="product--description-custon-points">
                                <?php echo $_smarty_tpl->tpl_vars['sArticle']->value['attr1'];?>

                            </div>
                         
                        <?php }?> 
                        
                            <div class="product--price-info">
                                <img src='http://localhost/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/_public/src/img/ts.png' alt="" class="ts_logo">
                                
                                
                                    <?php /*  Call merged included template "frontend/listing/product-box/product-price-unit.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/product-price-unit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a1ae291_78438350($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/product-price-unit.tpl" */?>
                                

                                
                                
                                    <?php /*  Call merged included template "frontend/listing/product-box/product-price.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/product-price.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a1b3774_13434081($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/product-price.tpl" */?>
                                
                            </div>
                        

                        
                        
                            <div class="buybox--quantity block">
                                <?php $_smarty_tpl->tpl_vars['maxQuantity'] = new Smarty_variable($_smarty_tpl->tpl_vars['sArticle']->value['maxpurchase']+1, null, 0);?>
                                <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['laststock']&&$_smarty_tpl->tpl_vars['sArticle']->value['instock']<$_smarty_tpl->tpl_vars['sArticle']->value['maxpurchase']){?>
                                    <?php $_smarty_tpl->tpl_vars['maxQuantity'] = new Smarty_variable($_smarty_tpl->tpl_vars['sArticle']->value['instock']+1, null, 0);?>
                                <?php }?>

                                
                                    <div class="select-field">
                                        <select id="sQuantity" name="sQuantity"
                                                class="quantity--select">
                                            <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["i"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['name'] = "i";
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = (int)$_smarty_tpl->tpl_vars['sArticle']->value['minpurchase'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['maxQuantity']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] = ((int)$_smarty_tpl->tpl_vars['sArticle']->value['purchasesteps']) == 0 ? 1 : (int)$_smarty_tpl->tpl_vars['sArticle']->value['purchasesteps'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["i"]['total']);
?>
                                                <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['index'];?>
<?php if ($_smarty_tpl->tpl_vars['sArticle']->value['packunit']){?> <?php echo $_smarty_tpl->tpl_vars['sArticle']->value['packunit'];?>
<?php }?></option>
                                            <?php endfor; endif; ?>
                                        </select>
                                    </div>
                                
                            </div>
                        

                        

                            
                            <div class="stock--value">
                                Stück
                            </div>
                            <?php ob_start();?><?php echo true;?><?php $_tmp3=ob_get_clean();?><?php if ($_tmp3){?>
                                <div class="product--btn-container">
                                    <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['allowBuyInListing']){?>
                                        <?php /*  Call merged included template "frontend/listing/product-box/button-buy.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/button-buy.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a1c2272_58822927($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/button-buy.tpl" */?>
                                    <?php }else{ ?>
                                        <?php /*  Call merged included template "frontend/listing/product-box/button-detail.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/button-detail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a1d1f84_89136879($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/button-detail.tpl" */?>
                                    <?php }?>
                                </div>
                            <?php }?>
                        

                        
                        
                            <?php /*  Call merged included template "frontend/listing/product-box/product-actions.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("frontend/listing/product-box/product-actions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a1db072_96031219($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/listing/product-box/product-actions.tpl" */?>
                        

                        <div class="costday">
                            <img src='http://localhost/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/_public/src/img/icons/van.png' alt=""> kostenfreie Rucksendung 30 tag lang moglich
                        </div>
                        
                            
                            
                        
                    </div>
                
            </div>
        
    </div>

<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-badges.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a16d1b2_27222832')) {function content_5d03910a16d1b2_27222832($_smarty_tpl) {?>



<div class="product--badges">

    
    
    <!--<?php if ($_smarty_tpl->tpl_vars['sArticle']->value['has_pseudoprice']){?>
    <div class="product&#45;&#45;badge badge&#45;&#45;discount">
        <i class="icon&#45;&#45;percent2"></i>
    </div>
    <?php }?>-->
    

    
    
    <!--<?php if ($_smarty_tpl->tpl_vars['sArticle']->value['highlight']){?>
    <div class="product&#45;&#45;badge badge&#45;&#45;recommend">
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxTip','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxTip','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
TIPP!<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxTip','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    </div>
    <?php }?>-->
    

    
    
    <!--<?php if ($_smarty_tpl->tpl_vars['sArticle']->value['newArticle']){?>
    <div class="product&#45;&#45;badge badge&#45;&#45;newcomer">
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxNew','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxNew','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
NEU<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxNew','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    </div>
    <?php }?>-->
    

    
    
    <!--<?php if ($_smarty_tpl->tpl_vars['sArticle']->value['esd']){?>
    <div class="product&#45;&#45;badge badge&#45;&#45;esd">
        <i class="icon&#45;&#45;download"></i>
    </div>
    <?php }?>-->
    
</div>







<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/product-box/product-image.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a17c717_28614530')) {function content_5d03910a17c717_28614530($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/var/www/selvakumar/shopsystem/install_558/engine/Library/Smarty/plugins/modifier.truncate.php';
?>
<a href="<?php echo $_smarty_tpl->tpl_vars['sArticle']->value['linkDetails'];?>
"
   title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sArticle']->value['articleName'], ENT_QUOTES, 'utf-8', true);?>
"
   class="product--image"
   
   >
    
        <span class="image--element">
            
                <span class="image--media">

                    <?php $_smarty_tpl->tpl_vars['desc'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['sArticle']->value['articleName'], ENT_QUOTES, 'utf-8', true), null, 0);?>

                    <?php if (isset($_smarty_tpl->tpl_vars['sArticle']->value['image']['thumbnails'])){?>

                        <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['image']['description']){?>
                            <?php $_smarty_tpl->tpl_vars['desc'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['sArticle']->value['image']['description'], ENT_QUOTES, 'utf-8', true), null, 0);?>
                        <?php }?>

                        
                            <img srcset="<?php echo $_smarty_tpl->tpl_vars['sArticle']->value['image']['thumbnails'][0]['sourceSet'];?>
"
                                 alt="<?php echo $_smarty_tpl->tpl_vars['desc']->value;?>
"
                                 title="<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['desc']->value,160);?>
" />
                        
                    <?php }else{ ?>
                        <img src="/selvakumar/shopsystem/install_558/themes/Frontend/Responsive/frontend/_public/src/img/no-picture.jpg"
                             alt="<?php echo $_smarty_tpl->tpl_vars['desc']->value;?>
"
                             title="<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['desc']->value,160);?>
" />
                    <?php }?>
                </span>
            
        </span>
    
</a>
<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/_includes/rating.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a18b142_34360302')) {function content_5d03910a18b142_34360302($_smarty_tpl) {?>

    <?php $_smarty_tpl->tpl_vars['isType'] = new Smarty_variable('single', null, 0);?> 
    <?php if (isset($_smarty_tpl->tpl_vars['type']->value)){?>
        <?php $_smarty_tpl->tpl_vars['isType'] = new Smarty_variable($_smarty_tpl->tpl_vars['type']->value, null, 0);?>
    <?php }?>




    <?php $_smarty_tpl->tpl_vars['isBase'] = new Smarty_variable(10, null, 0);?> 
    <?php if (isset($_smarty_tpl->tpl_vars['base']->value)){?>
        <?php $_smarty_tpl->tpl_vars['isBase'] = new Smarty_variable($_smarty_tpl->tpl_vars['base']->value, null, 0);?>
    <?php }?>




    <?php $_smarty_tpl->tpl_vars['hasMicroData'] = new Smarty_variable(true, null, 0);?>
    <?php if (isset($_smarty_tpl->tpl_vars['microData']->value)){?>
        <?php $_smarty_tpl->tpl_vars['hasMicroData'] = new Smarty_variable($_smarty_tpl->tpl_vars['microData']->value, null, 0);?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['hasMicroData']->value&&$_smarty_tpl->tpl_vars['isType']->value==='aggregated'&&$_smarty_tpl->tpl_vars['count']->value===0){?> 
        <?php $_smarty_tpl->tpl_vars['hasMicroData'] = new Smarty_variable(false, null, 0);?>
    <?php }?>




    <?php if ($_smarty_tpl->tpl_vars['isType']->value==='single'){?>
        <?php $_smarty_tpl->tpl_vars['data'] = new Smarty_variable('itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"', null, 0);?>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['data'] = new Smarty_variable('itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"', null, 0);?>
    <?php }?>




    <?php if (isset($_smarty_tpl->tpl_vars['label']->value)){?>
        <?php $_smarty_tpl->tpl_vars['hasLabel'] = new Smarty_variable($_smarty_tpl->tpl_vars['label']->value, null, 0);?>
    <?php }?>




    <?php if ($_smarty_tpl->tpl_vars['isType']->value==='aggregated'){?>
        <?php $_smarty_tpl->tpl_vars['hasLabel'] = new Smarty_variable(true, null, 0);?>
    <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['hasLabel'] = new Smarty_variable(false, null, 0);?>
    <?php }?>




    <span class="product--rating"<?php if ($_smarty_tpl->tpl_vars['hasMicroData']->value){?> <?php echo $_smarty_tpl->tpl_vars['data']->value;?>
<?php }?>>

        
        
            <?php $_smarty_tpl->tpl_vars['average'] = new Smarty_variable($_smarty_tpl->tpl_vars['points']->value/2, null, 0);?>
            <?php if ($_smarty_tpl->tpl_vars['isBase']->value==5){?>
                <?php $_smarty_tpl->tpl_vars['average'] = new Smarty_variable($_smarty_tpl->tpl_vars['points']->value, null, 0);?>
            <?php }?>
        

        
        
            <?php if ($_smarty_tpl->tpl_vars['hasMicroData']->value){?>
                <meta itemprop="ratingValue" content="<?php echo $_smarty_tpl->tpl_vars['points']->value;?>
">
                <meta itemprop="worstRating" content="1">
                <meta itemprop="bestRating" content="<?php echo $_smarty_tpl->tpl_vars['isBase']->value;?>
">
                <?php if ($_smarty_tpl->tpl_vars['isType']->value==='aggregated'){?>
                    <meta itemprop="ratingCount" content="<?php echo $_smarty_tpl->tpl_vars['count']->value;?>
">
                <?php }?>
            <?php }?>
        

        
        
            <?php if ($_smarty_tpl->tpl_vars['points']->value!=0){?>
                <?php $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['value']->step = 1;$_smarty_tpl->tpl_vars['value']->total = (int)ceil(($_smarty_tpl->tpl_vars['value']->step > 0 ? 5+1 - (1) : 1-(5)+1)/abs($_smarty_tpl->tpl_vars['value']->step));
if ($_smarty_tpl->tpl_vars['value']->total > 0){
for ($_smarty_tpl->tpl_vars['value']->value = 1, $_smarty_tpl->tpl_vars['value']->iteration = 1;$_smarty_tpl->tpl_vars['value']->iteration <= $_smarty_tpl->tpl_vars['value']->total;$_smarty_tpl->tpl_vars['value']->value += $_smarty_tpl->tpl_vars['value']->step, $_smarty_tpl->tpl_vars['value']->iteration++){
$_smarty_tpl->tpl_vars['value']->first = $_smarty_tpl->tpl_vars['value']->iteration == 1;$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration == $_smarty_tpl->tpl_vars['value']->total;?>
                    <?php $_smarty_tpl->tpl_vars['cls'] = new Smarty_variable('icon--star', null, 0);?>

                    <?php if ($_smarty_tpl->tpl_vars['value']->value>$_smarty_tpl->tpl_vars['average']->value){?>
                        <?php $_smarty_tpl->tpl_vars['diff'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value-$_smarty_tpl->tpl_vars['average']->value, null, 0);?>

                        <?php if ($_smarty_tpl->tpl_vars['diff']->value>0&&$_smarty_tpl->tpl_vars['diff']->value<=0.5){?>
                            <?php $_smarty_tpl->tpl_vars['cls'] = new Smarty_variable('icon--star-half', null, 0);?>
                        <?php }else{ ?>
                            <?php $_smarty_tpl->tpl_vars['cls'] = new Smarty_variable('icon--star-empty', null, 0);?>
                        <?php }?>
                    <?php }?>

                    <i class="<?php echo $_smarty_tpl->tpl_vars['cls']->value;?>
"></i>
                <?php }} ?>
            <?php }?>
        

        
        
            <?php if ($_smarty_tpl->tpl_vars['hasLabel']->value&&$_smarty_tpl->tpl_vars['count']->value){?>
                <span class="rating--count-wrapper">
                    (<span class="rating--count"><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</span>)
                </span>
            <?php }?>
        
    </span>
<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price-unit.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a1ae291_78438350')) {function content_5d03910a1ae291_78438350($_smarty_tpl) {?>

<div class="price--unit">
    <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxArticleContent','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleContent','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
inkl. MwSt. zzgl. Versand<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxArticleContent','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    
    <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']&&$_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']!=0){?>

        
        
            
                
            
        

        
        

        
    <?php }?>

    
    <?php if ($_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']&&$_smarty_tpl->tpl_vars['sArticle']->value['referenceunit']&&$_smarty_tpl->tpl_vars['sArticle']->value['purchaseunit']!=$_smarty_tpl->tpl_vars['sArticle']->value['referenceunit']){?>

        
        

        
    <?php }?>
</div><?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Pfiff/frontend/listing/product-box/product-price.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a1b3774_13434081')) {function content_5d03910a1b3774_13434081($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_currency')) include '/var/www/selvakumar/shopsystem/install_558/engine/Library/Enlight/Template/Plugins/modifier.currency.php';
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
<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/custom/plugins/SwagPaymentPayPalUnified/Resources/views/frontend/listing/product-box/button-buy.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a1c2272_58822927')) {function content_5d03910a1c2272_58822927($_smarty_tpl) {?>
    

    
        <?php ob_start();?><?php echo 'http://localhost/selvakumar/shopsystem/install_558/checkout/addArticle';?><?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_tmp1, null, 0);?>
    

    
        <form name="sAddToBasket"
              method="post"
              action="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
"
              class="buybox--form"
              data-add-article="true"
              data-eventName="submit"
              <?php if ($_smarty_tpl->tpl_vars['theme']->value['offcanvasCart']){?>
              data-showModal="false"
              data-addArticleUrl="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/checkout/ajaxAddArticleCart';?>"
              <?php }?>>

            
                <input type="hidden" name="sAdd" value="<?php echo $_smarty_tpl->tpl_vars['sArticle']->value['ordernumber'];?>
"/>
            

            
                <button class="buybox--button block btn is--primary is--icon-right is--center is--large">
                    
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('namespace'=>'frontend/listing/product-box/button-buy','name'=>'ListingBuyActionAdd')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/listing/product-box/button-buy','name'=>'ListingBuyActionAdd'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<span class="buy-btn--cart-add">In den</span> <span class="buy-btn--cart-text">Warenkorb</span><?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('namespace'=>'frontend/listing/product-box/button-buy','name'=>'ListingBuyActionAdd'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<i class="icon--basket"></i> <i class="icon--arrow-right"></i>
                    
                </button>
            
        </form>
    


    <?php if ($_smarty_tpl->tpl_vars['paypalUnifiedEcListingActive']->value){?>
        <div class="paypal-unified-ec--button-placeholder">
            <?php /*  Call merged included template "frontend/paypal_unified/express_checkout/button_detail.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('frontend/paypal_unified/express_checkout/button_detail.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '17288006565d03910a168bc7-39148225');
content_5d03910a1cc8d6_35046572($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "frontend/paypal_unified/express_checkout/button_detail.tpl" */?>
        </div>
    <?php }?>

<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/custom/plugins/SwagPaymentPayPalUnified/Resources/views/frontend/paypal_unified/express_checkout/button_detail.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a1cc8d6_35046572')) {function content_5d03910a1cc8d6_35046572($_smarty_tpl) {?>
    <div class="paypal-unified-ec--outer-button-container">
        
            <div class="paypal-unified-ec--button-container right"
                <?php if ($_smarty_tpl->tpl_vars['paypalUnifiedUseInContext']->value){?>
                 data-paypalUnifiedEcButtonInContext="true"
                <?php }else{ ?>
                 data-paypalUnifiedEcButton="true"
                <?php }?>
                 data-paypalMode="<?php if ($_smarty_tpl->tpl_vars['paypalUnifiedModeSandbox']->value){?>sandbox<?php }else{ ?>production<?php }?>"
                 data-createPaymentUrl="<?php echo 'http://localhost/selvakumar/shopsystem/install_558/widgets/PaypalUnifiedExpressCheckout/createPayment';?>"
                 data-color="<?php echo $_smarty_tpl->tpl_vars['paypalUnifiedEcButtonStyleColor']->value;?>
"
                 data-shape="<?php echo $_smarty_tpl->tpl_vars['paypalUnifiedEcButtonStyleShape']->value;?>
"
                 data-size="<?php echo $_smarty_tpl->tpl_vars['paypalUnifiedEcButtonStyleSize']->value;?>
"
                 data-paypalLanguage="<?php echo $_smarty_tpl->tpl_vars['paypalUnifiedLanguageIso']->value;?>
"
                 data-detailPage="true"
                >
            </div>
        
    </div>

<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/custom/plugins/SwagPaymentPayPalUnified/Resources/views/frontend/listing/product-box/button-detail.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a1d1f84_89136879')) {function content_5d03910a1d1f84_89136879($_smarty_tpl) {?>

    
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['sArticle']->value['linkDetails'];?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_tmp1, null, 0);?>
    

    
        <?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['escapeHtml'][0][0]->escapeHtml($_smarty_tpl->tpl_vars['sArticle']->value['articleName']);?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable($_tmp2, null, 0);?>
    

    
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingButtonDetail','namespace'=>'frontend/listing/product-box/button-detail','assign'=>'label','default'=>'Details')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingButtonDetail','namespace'=>'frontend/listing/product-box/button-detail','assign'=>'label','default'=>'Details'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Details<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingButtonDetail','namespace'=>'frontend/listing/product-box/button-detail','assign'=>'label','default'=>'Details'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    

    
    
        <div class="product--detail-btn">

            
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" class="buybox--button block btn is--icon-right is--center is--large" title="<?php echo $_smarty_tpl->tpl_vars['label']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
">
                    
                        <?php echo $_smarty_tpl->tpl_vars['label']->value;?>
 <i class="icon--arrow-right"></i>
                    
                </a>
            
        </div>
    

    <?php if ($_smarty_tpl->tpl_vars['paypalUnifiedEcListingActive']->value){?>
        <div class="paypal-unified-ec--button-placeholder"></div>
    <?php }?>


<?php }} ?><?php /* Smarty version Smarty-3.1.12, created on 2019-06-14 14:20:26
         compiled from "/var/www/selvakumar/shopsystem/install_558/themes/Frontend/Bare/frontend/listing/product-box/product-actions.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5d03910a1db072_96031219')) {function content_5d03910a1db072_96031219($_smarty_tpl) {?>



    <div class="product--actions">

        
        
            <?php ob_start();?><?php echo 1;?><?php $_tmp1=ob_get_clean();?><?php if ($_tmp1){?>
                <form action="<?php echo htmlspecialchars(Shopware()->Front()->Router()->assemble(array('controller' => 'compare', 'action' => 'add_article', 'articleID' => $_smarty_tpl->tpl_vars['sArticle']->value['articleID'], '_seo' => false, ))); ?>" method="post">
                    <button type="submit"
                       title="<?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxLinkCompare','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxLinkCompare','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Vergleichen<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxLinkCompare','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"
                       class="product--action action--compare"
                       data-product-compare-add="true">
                        <i class="icon--compare"></i> <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'ListingBoxLinkCompare','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxLinkCompare','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Vergleichen<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'ListingBoxLinkCompare','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    </button>
                </form>
            <?php }?>
        

        
        
            <form action="<?php echo htmlspecialchars(Shopware()->Front()->Router()->assemble(array('controller' => 'note', 'action' => 'add', 'ordernumber' => $_smarty_tpl->tpl_vars['sArticle']->value['ordernumber'], '_seo' => false, ))); ?>" method="post">
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'DetailLinkNotepad','namespace'=>'frontend/listing/box_article','assign'=>'snippetDetailLinkNotepad')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailLinkNotepad','namespace'=>'frontend/listing/box_article','assign'=>'snippetDetailLinkNotepad'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Auf den Merkzettel<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailLinkNotepad','namespace'=>'frontend/listing/box_article','assign'=>'snippetDetailLinkNotepad'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                <button type="submit"
                   title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['snippetDetailLinkNotepad']->value, ENT_QUOTES, 'utf-8', true);?>
"
                   class="product--action action--note"
                   data-ajaxUrl="<?php echo htmlspecialchars(Shopware()->Front()->Router()->assemble(array('controller' => 'note', 'action' => 'ajaxAdd', 'ordernumber' => $_smarty_tpl->tpl_vars['sArticle']->value['ordernumber'], '_seo' => false, ))); ?>"
                   data-text="<?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'DetailNotepadMarked','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailNotepadMarked','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Gemerkt<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailNotepadMarked','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
">
                    <i class="icon--heart"></i> <span class="action--text"><?php $_smarty_tpl->smarty->_tag_stack[] = array('snippet', array('name'=>'DetailLinkNotepadShort','namespace'=>'frontend/listing/box_article')); $_block_repeat=true; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailLinkNotepadShort','namespace'=>'frontend/listing/box_article'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Merken<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo Enlight_Components_Snippet_Resource::compileSnippetBlock(array('name'=>'DetailLinkNotepadShort','namespace'=>'frontend/listing/box_article'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
                </button>
            </form>
        
    </div>

<?php }} ?>