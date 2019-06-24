{namespace name="frontend/listing/box_article"}

<div class="price--unit">
    {s name="ListingBoxArticleContent"}{/s}
    {* Price is based on the purchase unit *}
    {if $sArticle.purchaseunit && $sArticle.purchaseunit != 0}

        {* Unit price label *}
        {block name='frontend_listing_box_article_unit_label'}
            {*<span class="price--label label--purchase-unit is--bold is--nowrap">*}
                {*{s name="ListingBoxArticleContent"}{/s}*}
            {*</span>*}
        {/block}

        {* Unit price content *}
        {block name='frontend_listing_box_article_unit_content'}

        {/block}
    {/if}

    {* Unit price is based on a reference unit *}
    {if $sArticle.purchaseunit && $sArticle.referenceunit && $sArticle.purchaseunit != $sArticle.referenceunit}

        {* Reference unit price content *}
        {block name='frontend_listing_box_article_unit_reference_content'}

        {/block}
    {/if}
</div>