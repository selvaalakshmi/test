{extends file="parent:frontend/listing/listing_ajax.tpl"}
{block name="frontend_listing_list_inline_ajax"}
    {* Actual listing *}
    {foreach $sArticles as $sArticle}

        {include file="frontend/listing/box_article.tpl"}
    {/foreach}
{/block}