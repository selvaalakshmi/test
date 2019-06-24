{extends file="parent:frontend/listing/product-box/product-badges.tpl"}
{namespace name="frontend/listing/box_article"}

{* Small product badges on the left *}
{block name="frontend_listing_box_article_badges"}
<div class="product--badges">

    {* Discount badge *}
    {block name='frontend_listing_box_article_discount'}
    <!--{if $sArticle.has_pseudoprice}
    <div class="product&#45;&#45;badge badge&#45;&#45;discount">
        <i class="icon&#45;&#45;percent2"></i>
    </div>
    {/if}-->
    {/block}

    {* Highlight badge *}
    {block name='frontend_listing_box_article_hint'}
    <!--{if $sArticle.highlight}
    <div class="product&#45;&#45;badge badge&#45;&#45;recommend">
        {s name="ListingBoxTip"}{/s}
    </div>
    {/if}-->
    {/block}

    {* Newcomer badge *}
    {block name='frontend_listing_box_article_new'}
    <!--{if $sArticle.newArticle}
    <div class="product&#45;&#45;badge badge&#45;&#45;newcomer">
        {s name="ListingBoxNew"}{/s}
    </div>
    {/if}-->
    {/block}

    {* ESD product badge *}
    {block name='frontend_listing_box_article_esd'}
    <!--{if $sArticle.esd}
    <div class="product&#45;&#45;badge badge&#45;&#45;esd">
        <i class="icon&#45;&#45;download"></i>
    </div>
    {/if}-->
    {/block}
</div>
{/block}






