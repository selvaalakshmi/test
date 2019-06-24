{block name='frontend_detail_index_buy_container'}
    <div class="product--buybox block{if $sArticle.sConfigurator && $sArticle.sConfiguratorSettings.type==2} is--wide{/if}">

        {* Product header *}
        {block name="frontend_detail_index_header_container"}
            {include file="frontend/detail/content/header.tpl"}
        {/block}

        {block name="frontend_detail_rich_snippets_brand"}
            <meta itemprop="brand" content="{$sArticle.supplierName|escape}"/>
        {/block}

        {block name="frontend_detail_rich_snippets_weight"}
            {if $sArticle.weight}
                <meta itemprop="weight" content="{$sArticle.weight} kg"/>
            {/if}
        {/block}

        {block name="frontend_detail_rich_snippets_height"}
            {if $sArticle.height}
                <meta itemprop="height" content="{$sArticle.height} cm"/>
            {/if}
        {/block}

        {block name="frontend_detail_rich_snippets_width"}
            {if $sArticle.width}
                <meta itemprop="width" content="{$sArticle.width} cm"/>
            {/if}
        {/block}

        {block name="frontend_detail_rich_snippets_depth"}
            {if $sArticle.length}
                <meta itemprop="depth" content="{$sArticle.length} cm"/>
            {/if}
        {/block}

        {block name="frontend_detail_rich_snippets_release_date"}
            {if $sArticle.sReleasedate}
                <meta itemprop="releaseDate" content="{$sArticle.sReleasedate}"/>
            {/if}
        {/block}

        {block name='frontend_detail_buy_laststock'}
            {if !$sArticle.isAvailable && !$sArticle.sConfigurator}
                {include file="frontend/_includes/messages.tpl" type="error" content="{s name='DetailBuyInfoNotAvailable' namespace='frontend/detail/buy'}{/s}"}

            {elseif !$sArticle.isAvailable && $sArticle.isSelectionSpecified}
                {include file="frontend/_includes/messages.tpl" type="error" content="{s name='DetailBuyInfoNotAvailable' namespace='frontend/detail/buy'}{/s}"}

            {elseif !$sArticle.isAvailable && !$sArticle.hasAvailableVariant}
                {include file="frontend/_includes/messages.tpl" type="error" content="{s name='DetailBuyInfoNotAvailable' namespace='frontend/detail/buy'}{/s}"}
            {/if}
        {/block}

        {* Product email notification *}
        {block name="frontend_detail_index_notification"}
            {if $ShowNotification && $sArticle.notification && $sArticle.instock < $sArticle.minpurchase}
                {* Support products with or without variants *}
                {if ($sArticle.hasAvailableVariant && ($sArticle.isSelectionSpecified || !$sArticle.sConfigurator)) || !$sArticle.hasAvailableVariant}
                    {include file="frontend/plugins/notification/index.tpl"}
                {/if}
            {/if}
        {/block}

        {* Product data *}
        {block name='frontend_detail_index_buy_container_inner'}
            <div class="custom_detail_container">
                <div class="short_detail_container">
                    {$product_desc}
                </div>
                <div itemprop="offers" itemscope
                     itemtype="{if $sArticle.sBlockPrices}http://schema.org/AggregateOffer{else}http://schema.org/Offer{/if}"
                     class="buybox--inner product_detail_container">


                    <div class="product--content--information-right">
                        <img src='{link file='frontend/_public/src/img/ts.png' fullPath}' alt="" class="ts_logo">
                        {block name='frontend_listing_box_article_price_info'}
                            <div class="product--price-info">
                                {block name='frontend_detail_index_data'}
                                    {if $sArticle.sBlockPrices}
                                        {$lowestPrice=false}
                                        {$highestPrice=false}
                                        {foreach $sArticle.sBlockPrices as $blockPrice}
                                            {if $lowestPrice === false || $blockPrice.price < $lowestPrice}
                                                {$lowestPrice=$blockPrice.price}
                                            {/if}
                                            {if $highestPrice === false || $blockPrice.price > $highestPrice}
                                                {$highestPrice=$blockPrice.price}
                                            {/if}
                                        {/foreach}
                                        <meta itemprop="lowPrice" content="{$lowestPrice}"/>
                                        <meta itemprop="highPrice" content="{$highestPrice}"/>
                                        <meta itemprop="offerCount" content="{$sArticle.sBlockPrices|count}"/>
                                    {/if}
                                    <meta itemprop="priceCurrency" content="{$Shop->getCurrency()->getCurrency()}"/>
                                    {include file="frontend/detail/data.tpl" sArticle=$sArticle sView=1}
                                {/block}

                                {block name='frontend_detail_index_after_data'}{/block}

                                {* Configurator drop down menus *}
                                {block name="frontend_detail_index_configurator"}
                                    <div class="product--configurator">
                                        {if $sArticle.sConfigurator}
                                            {if $sArticle.sConfiguratorSettings.type == 1}
                                                {$file = 'frontend/detail/config_step.tpl'}
                                            {elseif $sArticle.sConfiguratorSettings.type == 2}
                                                {$file = 'frontend/detail/config_variant.tpl'}
                                            {else}
                                                {$file = 'frontend/detail/config_upprice.tpl'}
                                            {/if}
                                            {include file=$file}
                                        {/if}
                                    </div>
                                {/block}
                            </div>
                        {/block}

                        <div class="product--shipping-info">
                            <div class="product--shipping-info-text">
                                <div class="delTime">
                                    <div class="countdown">
                                        <i><img src='{link file='frontend/_public/src/img/icons/van.png' fullPath}'
                                                alt=""></i>
                                        <span>Versand: 1 –2 Tage </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {*<div class="product--actions">*}
                        {block name="frontend_listing_box_article_buy"}
                            <div class="product--btn-container">
                                <div class="detail">
                                    <i class="icon--check"></i> Verfügbarkeit: <span>SOFORT VERFÜGBAR</span>
                                </div>

                                {* Include buy button and quantity box *}
                                {block name="frontend_detail_index_buybox"}
                                    {include file="frontend/detail/buy.tpl"}
                                {/block}

                                {* PayPal button *}
                                <!--
                                <a href="#" class="paypal_listing_btn">
                                    Direkt zu <span>PayPal</span>
                                </a>
                                -->
                                {* Product actions *}
                                {block name="frontend_detail_index_actions"}
                                    <nav class="product--actions">
                                        {include file="frontend/detail/actions.tpl"}
                                    </nav>
                                {/block}

                            </div>
                        {/block}
                        <div class="costday">
                            <img src='{link file='frontend/_public/src/img/icons/van.png' fullPath}' alt=""> kostenfreie Rucksendung 30 tag lang moglich
                        </div>
                        <div class="tnc">
                            Bestellen sie innerhalb der nachsten 18 stunde(n) und 48 Minuten und der Versand
                            erfolgt Morgen, den 11.04.
                        </div>
                    </div>




                    {* Include buy button and quantity box
                    {block name="frontend_detail_index_buybox"}
                        {include file="frontend/detail/buy.tpl"}
                    {/block}*}

                    {* Product actions
                    {block name="frontend_detail_index_actions"}
                        <nav class="product--actions">
                            {include file="frontend/detail/actions.tpl"}
                        </nav>
                    {/block}*}
                </div>
            </div>
        {/block}

        {* Product - Base information *}
        {block name='frontend_detail_index_buy_container_base_info'}

        {/block}
    </div>
{/block}
