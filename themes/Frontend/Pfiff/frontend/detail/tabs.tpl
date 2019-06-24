
{* Tab navigation for the product detail page *}
{block name="frontend_detail_tabs"}
    <div class="tab-menu--product">
        {block name="frontend_detail_tabs_inner"}

            {* Tab navigation *}
            {block name="frontend_detail_tabs_navigation"}
                <div class="tab--navigation">
                    {block name="frontend_detail_tabs_navigation_inner"}

                        {* Description tab *}
                        {block name="frontend_detail_tabs_description"}
                            <a href="#" class="tab--link" title="{s name='DetailTabsDescription'}{/s}"
                               data-tabName="description">{s name='DetailTabsDescription'}{/s}</a>
                        {/block}

                        {* Rating tab *}
                       {*{block name="frontend_detail_tabs_rating"}*}
                            {*{if !{config name=VoteDisable}}*}
                                {*<a href="#" class="tab--link" title="{s name='DetailTabsRating'}{/s}"*}
                                   {*data-tabName="rating">*}
                                    {*{s name='DetailTabsRating'}{/s}*}
                                    {*{block name="frontend_detail_tabs_navigation_rating_count"}*}
                                        {*<span class="product--rating-count">{$sArticle.sVoteAverage.count}</span>*}
                                    {*{/block}*}
                                {*</a>*}
                            {*{/if}*}
                        {*{/block}*}

                        {*Custom tabs title Field Data*}
                        {* product info *}
                        {if $product_Info}
                            {block name="frontend_detail_tabs_description"}
                                <a href="#" class="tab--link" title="product-information"
                                   data-tabName="PRODUKTINFORMATIONEN">PRODUKTINFORMATIONEN</a>
                            {/block}
                        {/if}
                        {*PDF Download *}
                        {foreach $FetchArticlesData as $FetchArticleData}
                            {if $FetchArticleData.ordernumber}
                                {block name="frontend_detail_tabs_description"}
                                    <a href="#" class="tab--link" title="DATENBLATT" data-tabName="DATENBLATT">DATENBLATT </a>
                                {/block}
                            {/if}
                            {break}

                        {/foreach}
                        {*FAQ Data*}
                        {foreach $FetchFaqsData as $FetchFaqData}
                            {if $FetchFaqData.ordernumber}
                                {block name="frontend_detail_tabs_description"}
                                    <a href="#" class="tab--link" title="FAQ" data-tabName="FAQ">FAQs</a>
                                {/block}
                            {/if}
                            {break}
                        {/foreach}
                        {* end tabs*}
                    {/block}
                </div>
            {/block}

            {* Content list *}
            {block name="frontend_detail_tabs_content"}
                <div class="tab--container-list tabs_content_container">

                    <div class="tabs_descriptoin_left">
                    {block name="frontend_detail_tabs_content_inner"}


                     {* Description container *}
                    {block name="frontend_detail_tabs_content_description"}
                        <div class="tab--container">
                            {block name="frontend_detail_tabs_content_description_inner"}

                                {* Description title *}
                                {block name="frontend_detail_tabs_content_description_title"}
                                    <div class="tab--header">
                                        {block name="frontend_detail_tabs_content_description_title_inner"}
                                            <a href="#" class="tab--title"
                                               title="{s name='DetailTabsDescription'}{/s}">{s name='DetailTabsDescription'}{/s}</a>
                                        {/block}
                                    </div>
                                {/block}

                                {* Description preview *}
                                {block name="frontend_detail_tabs_description_preview"}
                                    <div class="tab--preview">
                                        {block name="frontend_detail_tabs_content_description_preview_inner"}
                                            {$sArticle.description_long|strip_tags|truncate:100:'...'}<a href="#"
                                                                                                         class="tab--link"
                                                                                                         title="{s name="PreviewTextMore"}{/s}">{s name="PreviewTextMore"}{/s}</a>
                                        {/block}
                                    </div>
                                {/block}

                                {* Description content *}
                                {block name="frontend_detail_tabs_content_description_description"}
                                    <div class="tab--content">
                                                {block name="frontend_detail_tabs_content_description_description_inner"}
                                                    {include file="frontend/detail/tabs/description.tpl"}
                                                {/block}
                                    </div>
                                {/block}

                            {/block}
                        </div>
                    {/block}

                        <!-- {* Rating container *}-->
                        {block name="frontend_detail_tabs_content_rating"}{/block}


                    {*{Product Information*}
                    {if $product_Info}
                    {block name="frontend_detail_tabs_content_description"}
                        <div class="tab--container">
                            {block name="frontend_detail_tabs_content_description_inner"}
                                {* Description title *}
                                {block name="frontend_detail_tabs_content_description_title"}
                                    <div class="tab--header">
                                        {block name="frontend_detail_tabs_content_description_title_inner"}
                                            <a href="#" class="tab--title" title="PRODUKTINFORMATIONEN">PRODUKTINFORMATIONEN</a>
                                        {/block}
                                    </div>
                                {/block}
                                {* Description title *}
                                {block name="frontend_detail_tabs_content_description"}
                                    <div class="tab--content">
                                        <div class="buttons--off-canvas">
                                            {block name='frontend_detail_description_buttons_offcanvas_inner'}
                                                <a href="#" class="close--off-canvas"><i class="icon--arrow-left"></i>
                                                    {s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
                                                </a>
                                            {/block}
                                        </div>
                                        {block name="frontend_detail_tabs_content_installation_description_inner"}
                                            <div id="tab--product-comment--product--description"
                                                 class="content--description--product--description">
                                                <div class="product_tech_info product--description">
                                                    {$product_Info}


                                                </div>
                                            </div>
                                        {/block}
                                    </div>
                                {/block}
                                {*end of description title*}
                            {/block}
                        </div>
                    {/block}
                    {/if}

                    {* PDF Tab*}
                    {if $FetchCountsData.countid != 0}
                    {block name="frontend_detail_tabs_content_description"}
                        <div class="tab--container">
                            {block name="frontend_detail_tabs_content_description_inner"}
                                {* Description title *}
                                {block name="frontend_detail_tabs_content_description_title"}
                                    <div class="tab--header">
                                        {block name="frontend_detail_tabs_content_description_title_inner"}
                                            <a href="#" class="tab--title" title="DATENBLATT">DATENBLATT </a>
                                        {/block}
                                    </div>
                                {/block}
                                {* Description title *}
                                {block name="frontend_detail_tabs_content_description"}
                                    <div class="tab--content">
                                        <div class="buttons--off-canvas">
                                            {block name='frontend_detail_description_buttons_offcanvas_inner'}
                                                <a href="#" class="close--off-canvas"><i class="icon--arrow-left"></i>
                                                    {s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
                                                </a>
                                            {/block}
                                        </div>
                                        {assign var="loopdata" value="0"}
                                        {foreach $FetchArticlesData as $FetchArticleData}
                                            {block name="frontend_detail_tabs_content_installation_description_inner"}
                                                <div id="tab--product-comment--{$loopdata}"
                                                     class="content--description--{$loopdata}">
                                                    <div class="product_tech_info product--description">
                                                        {if $loopdata==0}<h2>DOWNLOAD DATENBLATT</h2>{/if}
                                                        <hr>
                                                        <span class="tabs_pdf_text">{$FetchArticleData.name}</span>
                                                        {if $FetchArticleData.extension =='pdf'}
                                                        <a class="tabs_pdf_icon" href="{$PdfShopUrlData}files/PDF-File/{$FetchArticleData.pdf_file}" download>
                                                            <img src="{$PdfShopUrlData}custom/plugins/BrandCrockMultiArticleTabs/Resources/View/images/pdf-icon.png" alt="">
                                                            {/if} </a>
                                                        <hr>
                                                    </div>
                                                </div>
                                            {/block}
                                            {$loopdata = $loopdata +1}
                                        {/foreach}
                                    </div>
                                {/block}
                                {*end of description title*}
                            {/block}
                        </div>
                    {/block}
                    {/if}

                    {*Faq Data*}
                    {if $FetchFaqCountsData.countid != 0}
                    {block name="frontend_detail_tabs_content_description"}
                        <div class="tab--container">
                            {block name="frontend_detail_tabs_content_description_inner"}
                                {* Description title *}
                                {block name="frontend_detail_tabs_content_description_title"}
                                    <div class="tab--header">
                                        {block name="frontend_detail_tabs_content_description_title_inner"}
                                            <a href="#" class="tab--title" title="FAQs">FAQs</a>
                                        {/block}

                                    </div>
                                {/block}
                                {* Description title *}
                                {block name="frontend_detail_tabs_content_description"}
                                    <div class="tab--content">
                                        <div class="buttons--off-canvas">
                                            {block name='frontend_detail_description_buttons_offcanvas_inner'}
                                                <a href="#" class="close--off-canvas"><i class="icon--arrow-left"></i>
                                                    {s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
                                                </a>
                                            {/block}
                                        </div>
                                        {assign var="loopdata1" value="0"}
                                        <div class="product_tech_info product_tab_faq">
                                        <h2>HEUFIG GESTELLTE FRAGEN:</h2>
                                        {foreach $FetchFaqsData as $FetchFaqData}
                                            {block name="frontend_detail_tabs_content_installation_description_inner"}

                                                <div id="tab--product-comment--{$loopdata1}"
                                                     class="content--description--{$loopdata1}">
                                                    <div class="product--description">
                                                        <p class="accordion {if $loopdata1==0}active{/if}">{$FetchFaqData.question}</p>
                                                        <div class="panel {if $loopdata1==0}show{/if}">{$FetchFaqData.answer}</div>
                                                    </div>
                                                </div>
                                            {/block}
                                            {$loopdata1 = $loopdata1 +1}
                                        {/foreach}
                                        </div>
                                    </div>
                                {/block}
                                {*end of description title*}
                            {/block}
                        </div>
                    {/block}
                    {/if}
                        <script>
                            document.addEventListener("DOMContentLoaded", function (event) {


                                var acc = document.getElementsByClassName("accordion");
                                var panel = document.getElementsByClassName('panel');

                                for (var i = 0; i < acc.length; i++) {
                                    acc[i].onclick = function () {
                                        var setClasses = !this.classList.contains('active');
                                        setClass(acc, 'active', 'remove');
                                        setClass(panel, 'show', 'remove');

                                        if (setClasses) {
                                            this.classList.toggle("active");
                                            this.nextElementSibling.classList.toggle("show");
                                        }
                                    }
                                }

                                function setClass(els, className, fnName) {
                                    for (var i = 0; i < els.length; i++) {
                                        els[i].classList[fnName](className);
                                    }
                                }

                            });
                        </script>
                        {*End Faq Data*}
                        {*End Tabs*}

                    {/block}

                    </div>
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

        {/block}
    </div>
{/block}
