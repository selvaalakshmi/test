{extends file="parent:frontend/detail/data.tpl"}
    {block name='frontend_detail_data_price_default'}
     <script type="text/javascript">
if (typeof(jQuery) == 'undefined') {
﻿   document.write('<scr' + 'ipt src="/custom/plugins/bcghPrice/Resources/views/frontend/_public/src/js/jquery-2.1.4.min.js"></sc' + 'ript>');
}
</script>
<script  type="text/javascript">
	$(document).ready(function(){
		$(".buybox--button").on( "click", function(event) {
				var opt=$('#Choose-opt').val();
				var errorMsg=$('#Choose_opt_error').val();
				if(opt==1){
					event.preventDefault();
					alert(errorMsg); 
				}
		});
		
	});
</script>
        <span class="price--content content--default bcgprice">
            <meta itemprop="price" content="{$sArticle.price|replace:',':'.'}">
            {if $sArticle.priceStartingFrom && !$sArticle.liveshoppingData}{s name='ListingBoxArticleStartsAt'}{/s} {/if}
            
        {assign var=MinPrice value={action module=frontend controller=bcghPrice 
			action=bcdetailmin sArticleDetailsId =$sArticle.price sArticleId=$sArticle.articleID  sArticleTax=$sArticle.tax}}
        
        {assign var=MaxPrice value={action module=frontend controller=bcghPrice 
			action=bcdetailmax sArticleDetailsId =$sArticle.price sArticleId=$sArticle.articleID  sArticleTax=$sArticle.tax}}
       
        {if $MinPrice && $MinPrice|strip neq ' ' && $MaxPrice && $MaxPrice|strip neq ' ' && $sArticle.choose_an_option}
            {s name="fromTitle" namespace="frontend/listing/productPrice"}From{/s}
                 {$MinPrice} - {$MaxPrice} 
                    {else}
            {if $sArticle.priceStartingFrom && !$sArticle.liveshoppingData}{s name='ListingBoxArticleStartsAt' namespace="frontend/listing/box_article"}{/s} {/if}{$sArticle.price|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
        {/if}

        </span>
        <input type="hidden" value="{$sArticle.price}">
        <input type="hidden" id="Choose-opt" name="Choose-opt" value="{$sArticle.choose_an_option}" />
        <input type="hidden" id="Choose_opt_error" value="{s name='chooseOptError' namespace='frontend/detail/data'}Please select the product options before placing the item in the shopping cart.{/s}" />

    {/block}
    {$smarty.block.parent}
	 
