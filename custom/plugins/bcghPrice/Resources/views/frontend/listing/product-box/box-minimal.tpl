{extends file="parent:frontend/listing/product-box/box-minimal.tpl"}
{* Default price *}
{block name='frontend_listing_box_article_price_default'}
<span class="price--default is--nowrap{if $sArticle.has_pseudoprice} is--discount{/if}">
{if $sArticle.priceStartingFrom && !$sArticle.liveshoppingData}{s name='ListingBoxArticleStartsAt'}{/s} {/if}
    {assign var=lPrice value={action module=frontend controller=bcghPrice
		action=bclisting sArticleId=$sArticle.articleID sArticleTax=$sArticle.tax}|trim}
    {assign var=gPrice value=$lPrice|trim}
{if $lPrice && $lPrice neq ' ' && $sArticle.sConfigurator}
    {s name="fromTitle" namespace="frontend/listing/productPrice"}From{/s} {$sArticle.price|currency} - {$lPrice}
{else}
    {$sArticle.price|currency}
{/if}
{s name="Star"}{/s}
</span>
{/block}

