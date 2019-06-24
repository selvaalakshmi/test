{block name='frontend_index_content_inner'}
    <div class="content product--details" itemscope
         itemtype="http://schema.org/Product"{if !{config name=disableArticleNavigation}} data-product-navigation="{url module="widgets" controller="listing" action="productNavigation"}" data-category-id="{$sArticle.categoryID}" data-main-ordernumber="{$sArticle.mainVariantNumber}"{/if}
         data-ajax-wishlist="true"
         data-compare-ajax="true"{if $theme.ajaxVariantSwitch} data-ajax-variants-container="true"{/if}>

        {* The configurator selection is checked at this early point
           to use it in different included files in the detail template. *}
        {block name='frontend_detail_index_configurator_settings'}

            {* Variable for tracking active user variant selection *}
            {$activeConfiguratorSelection = true}

            {if $sArticle.sConfigurator && ($sArticle.sConfiguratorSettings.type == 1 || $sArticle.sConfiguratorSettings.type == 2)}
                {* If user has no selection in this group set it to false *}
                {foreach $sArticle.sConfigurator as $configuratorGroup}
                    {if !$configuratorGroup.selected_value}
                        {$activeConfiguratorSelection = false}
                    {/if}
                {/foreach}
            {/if}
        {/block}

        {* Product header *}
        {block name="frontend_detail_index_header_container"}

        {/block}

        <div class="product--detail-upper block-group">
            {* Product image *}
            {block name='frontend_detail_index_image_container'}
                <div class="product--image-container image-slider{if $sArticle.image && {config name=sUSEZOOMPLUS}} product--image-zoom{/if}"
                        {if $sArticle.image}
                    data-image-slider="true"
                    data-image-gallery="true"
                    data-maxZoom="{$theme.lightboxZoomFactor}"
                    data-thumbnails=".image--thumbnails"
                        {/if}>
                    {block name="frontend_detail_index_image"}
                        {include file="frontend/detail/image.tpl"}
                    {/block}
                </div>
            {/block}

            {* "Buy now" box container *}
            {block name="frontend_detail_index_buy_box_container"}
                {include file="frontend/detail/content/buy_container.tpl"}
            {/block}
        </div>

        {* Product bundle hook point *}
        {block name="frontend_detail_index_bundle"}{/block}

        {block name="frontend_detail_index_detail"}

            {* Tab navigation *}
            {block name="frontend_detail_index_tabs"}
                {include file="frontend/detail/tabs.tpl"}
            {/block}
        {/block}

        {* Crossselling tab panel *}
        {block name="frontend_detail_index_tabs_cross_selling"}


            {$showAlsoBought = {config name=alsoBoughtShow}}
            {$showAlsoViewed = {config name=similarViewedShow}}
            <div class="tab-menu--cross-selling"{if $sArticle.relatedProductStreams} data-scrollable="true"{/if}>

                {* Tab navigation *}
                {block name="frontend_detail_index_tabs_navigation_container"}
                    {include file="frontend/detail/content/tab_navigation.tpl"}
                {/block}

                {* Tab content container *}
                {block name="frontend_detail_index_tab_container"}
                    {include file="frontend/detail/content/tab_container.tpl"}
                {/block}
            </div>
        {/block}

        {if $miCountData !=0}
            <div class="menufacturing_data_container tab">
                <input id="tab-1" name="tab" type="checkbox">
                <label for="tab-1">DETAILBESCHREIBUNGEN DES HERSTELLERS</label>
                <div class="manufecturing_container tab-content">

                    {foreach $miFetchArticlesData as $miArticlesData}
                        <div class="manufecturing_box">
                            <div class="manuf_img">
                                <img src='{$mishopUrl}{$miArticlesData.img_path}'>
                            </div>
                            <img class="manufacturer-img"
                                 src='{link file='frontend/_public/src/img/plus_img.jpg' fullPath}'>
                            <span>
                   		{$miArticlesData.description}
                	</span>
                        </div>
                    {/foreach}
                    <div id="myModal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="img0d1">
                        <div id="caption"></div>
                    </div>

                </div>
            </div>
        {/if}

        {* Crossselling tab panel *}
        {block name="frontend_detail_index_tabs_cross_selling"}
            <div class="mobile_view_slider">

                <div class="tabs_descriptoin_right">

                    <div class="tabs_slider_name">{s name='DetailRecommendationAlsoBoughtLabel' namespace="frontend/detail/index"}{/s}</div>
                    <div class="tabs_slider_products">

                        {* "Customers bought also" slider *}
                        <div class="tab--container-list">
                            {block name="frontend_detail_index_tabs_also_bought"}
                                <div class="tab--container_cust0" data-tab-id="alsobought">
                                    {block name="frontend_detail_index_tabs_also_bought_inner"}
                                        <div class="tab--header">
                                            <a href="#" class="tab--title"
                                               title="{s name='DetailRecommendationAlsoBoughtLabel' namespace="frontend/detail/index"}{/s}">{s name='DetailRecommendationAlsoBoughtLabel' namespace="frontend/detail/index"}{/s}</a>
                                        </div>
                                        <div class="tab--content content--also-bought">{action module=widgets controller=recommendation action=bought articleId=$sArticle.articleID}</div>
                                    {/block}
                                </div>
                            {/block}
                        </div>

                    </div>

                    <div class="tabs_slider_name">{s name='DetailRecommendationAlsoViewedLabel' namespace="frontend/detail/index"}{/s}</div>
                    <div class="tabs_slider_products">

                        {* "Customers similar viewed" slider *}
                        <div class="tab--container-list">
                            {block name="frontend_detail_index_tabs_also_viewed"}
                                <div class="tab--container_cust" data-tab-id="alsoviewed">
                                    {block name="frontend_detail_index_tabs_also_viewed_inner"}
                                        <div class="tab--header">
                                            <a href="#" class="tab--title"
                                               title="{s name='DetailRecommendationAlsoViewedLabel' namespace="frontend/detail/index"}{/s}">{s name='DetailRecommendationAlsoViewedLabel' namespace="frontend/detail/index"}{/s}</a>
                                        </div>
                                        <div class="tab--content content--also-viewed">{action module=widgets controller=recommendation action=viewed articleId=$sArticle.articleID}</div>
                                    {/block}
                                </div>
                            {/block}
                        </div>

                    </div>

                </div>
            </div>
        {/block}

    </div>
{/block}
