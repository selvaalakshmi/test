{namespace name="frontend/listing/box_article"}


{block name="frontend_listing_box_article"}
    {if $sts == 1}
    <div class="product--box box--{$productLayoutClass}"
    {else}
    <div class="product--box box--{$productBoxLayout}"
    {/if}
         data-page-index="{$pageIndex}"
         data-ordernumber="{$sArticle.ordernumber}"
         {if !{config name=disableArticleNavigation}} data-category-id="{$sCategoryCurrent}"{/if}>


    
        {block name="frontend_listing_box_article_content"}
            <div class="box--content is--rounded">

                {* Product box badges - highlight, newcomer, ESD product and discount *}
                {block name='frontend_listing_box_article_badges'}
                    {include file="frontend/listing/product-box/product-badges.tpl"}
                {/block}

                {block name='frontend_listing_box_article_info_container'}
                    <div class="product--info">

                        {* Product image *}
                        {block name='frontend_listing_box_article_picture'}
                            {include file="frontend/listing/product-box/product-image.tpl"}
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

                                    {if $articleImages}
                                  
                                       
                                        {foreach $articleImages[$sArticle.articleID] as $articleImage}
                                       
                                            <div class="item">
                                                
                                                 <img src='{$articleImage}' alt=""> 
                                                
                                            </div>
                                        {/foreach}
                                    {else}
                                        {foreach $sendArrayImage as $bcghImageArray}
                                            {if $sArticle.articleID == $bcghImageArray.articles_details_id}
                                                {assign var='imageName' value=$bcghImageArray.image}
                                                {foreach $imageName as $imageArticle}
                                                    <div class="item">
                                                        <img src='{$imageArticle}' alt="">
                                                    </div>
                                                {/foreach}
                                            {/if}
                                        {/foreach}
                                    {/if}

                                </div>
                            </div>
                        {/block}

                        {* Customer rating for the product *}
                        {block name='frontend_listing_box_article_rating'}
                            {if !{config name=VoteDisable}}
                                <div class="product--rating-container">
                                    {if $sArticle.sVoteAverage.average}
                                        {include file='frontend/_includes/rating.tpl' points=$sArticle.sVoteAverage.average type="aggregated" label=false microData=false}
                                    {/if}
                                </div>
                            {/if}
                        {/block}

                        {* Product name *}
                        {block name='frontend_listing_box_article_name'}
                            <a href="{$sArticle.linkDetails}"
                               class="product--title"
                               title="{$sArticle.articleName|escapeHtml}">
                                {$sArticle.articleName|truncate:85|escapeHtml}
                            </a>
                        {/block}

                        {* Variant description *}
                        {block name='frontend_listing_box_variant_description'}
                            {if $sArticle.attributes.swagVariantConfiguration}
                                <div class="variant--description">
                                    <span title="
                                        {foreach $sArticle.attributes.swagVariantConfiguration->get('value') as $group}
                                                {$group.groupName}: {$group.optionName}
                                        {/foreach}
                                        ">
                                        {foreach $sArticle.attributes.swagVariantConfiguration->get('value') as $group}
                                            <span class="variant--description--line">
                                                <span class="variant--groupName">{$group.groupName}:</span> {$group.optionName} {if !$group@last}|{/if}
                                            </span>
                                        {/foreach}
                                    </span>
                                </div>
                            {/if}
                        {/block}

                        {* Product description *}
                         {if $sts ==1}
                        <div class="product--description">

                                {$sArticle.description_long|strip_tags|truncate:240}
                                
                            </div>
                            <div class="product--description-custon-points">
                                {$sArticle.attr1}
                            </div>
                       {else}     

                         {block name='frontend_listing_box_article_description'}
                           <div class="product--description">

                                {$sArticle.description_long|strip_tags|truncate:240}
                                
                            </div>
                            <div class="product--description-custon-points">
                                {$sArticle.attr1}
                            </div>
                        {/block} 
                        {/if} 
                        {block name='frontend_listing_box_article_price_info'}
                            <div class="product--price-info">
                                <img src='{link file='frontend/_public/src/img/ts.png' fullPath}' alt="" class="ts_logo">
                                {* Product price - Unit price *}
                                {block name='frontend_listing_box_article_unit'}
                                    {include file="frontend/listing/product-box/product-price-unit.tpl"}
                                {/block}

                                {* Product price - Default and discount price *}
                                {block name='frontend_listing_box_article_price'}
                                    {include file="frontend/listing/product-box/product-price.tpl"}
                                {/block}
                            </div>
                        {/block}

                        {* Quantity selection *}
                        {block name='frontend_detail_buy_quantity'}
                            <div class="buybox--quantity block">
                                {$maxQuantity=$sArticle.maxpurchase+1}
                                {if $sArticle.laststock && $sArticle.instock < $sArticle.maxpurchase}
                                    {$maxQuantity=$sArticle.instock+1}
                                {/if}

                                {block name='frontend_detail_buy_quantity_select'}
                                    <div class="select-field">
                                        <select id="sQuantity" name="sQuantity"
                                                class="quantity--select">
                                            {section name="i" start=$sArticle.minpurchase loop=$maxQuantity step=$sArticle.purchasesteps}
                                                <option value="{$smarty.section.i.index}">{$smarty.section.i.index}{if $sArticle.packunit} {$sArticle.packunit}{/if}</option>
                                            {/section}
                                        </select>
                                    </div>
                                {/block}
                            </div>
                        {/block}

                        {block name="frontend_listing_box_article_buy"}

                            {* "stock *}
                            <div class="stock--value">
                                Stück
                            </div>
                            {if {config name="displayListingBuyButton"}}
                                <div class="product--btn-container">
                                    {if $sArticle.allowBuyInListing}
                                        {include file="frontend/listing/product-box/button-buy.tpl"}
                                    {else}
                                        {include file="frontend/listing/product-box/button-detail.tpl"}
                                    {/if}
                                </div>
                            {/if}
                        {/block}

                        {* Product actions - Compare product, more information *}
                        {block name='frontend_listing_box_article_actions'}
                            {include file="frontend/listing/product-box/product-actions.tpl"}
                        {/block}

                        <div class="costday">
                            <img src='{link file='frontend/_public/src/img/icons/van.png' fullPath}' alt=""> kostenfreie Rucksendung 30 tag lang moglich
                        </div>
                        {*<div class="tnc">*}
                            {*Bestellen sie innerhalb der nachsten 18 stunde(n) und 48 Minuten und der Versand*}
                            {*erfolgt Morgen, den 11.04.*}
                        {*</div>*}
                    </div>
                {/block}
            </div>
        {/block}
    </div>
{/block}
