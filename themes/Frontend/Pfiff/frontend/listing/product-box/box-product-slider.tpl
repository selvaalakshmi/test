{extends file="frontend/listing/product-box/box-basic.tpl"}

{block name="frontend_listing_box_article_rating"}{/block}

{block name="frontend_listing_box_article_description"}
{/block}
{block name='frontend_listing_box_article_price_info'}
    <div class="product--price-info">

        {* Product price - Unit price *}
        {block name='frontend_listing_box_article_unit'}

        {/block}

        {* Product price - Default and discount price *}
        {block name='frontend_listing_box_article_price'}
            <div class="cart_btn_custom">
                <img src='{link file='frontend/_public/src/img/cart-icon-2.png' fullPath}'>
            </div>
            <div class="product--price">

                {* Discount price *}
                {block name='frontend_listing_box_article_price_discount'}
                    {if $sArticle.has_pseudoprice}
                        <span class="price--pseudo">
                                                    {block name='frontend_listing_box_article_price_discount_before'}
                                                        {s name="priceDiscountLabel" namespace="frontend/detail/data"}{/s}
                                                    {/block}
                            <span class="price--discount is--nowrap">
                                                        {$sArticle.pseudoprice|currency}
                                {s name="Star"}{/s}
                                                    </span>

                            {block name='frontend_listing_box_article_price_discount_after'}
                                {s name="priceDiscountInfo" namespace="frontend/detail/data"}{/s}
                            {/block}
                                                </span>
                    {/if}
                {/block}
                {* Default price *}
                {block name='frontend_listing_box_article_price_default'}
                    <span class="price--default is--nowrap{if $sArticle.has_pseudoprice} is--discount{/if}">
            {if $sArticle.priceStartingFrom}{s name='ListingBoxArticleStartsAt'}{/s} {/if}
                        {$sArticle.price|currency}
                        {s name="Star"}{/s}
        </span>
                {/block}


            </div>
        {/block}
    </div>
{/block}
{block name="frontend_listing_box_article_actions"}{/block}

{block name="frontend_listing_box_article_buy"}
{/block}