{* Listing actions *}
{block name='frontend_listing_actions_top'}
    {$listingMode = {config name=listingMode}}

    {block name="frontend_listing_actions_top_hide_detection"}
        {$class = 'listing--actions is--rounded'}

        {if ($sCategoryContent.hide_sortings || $sortings|count == 0)}
            {$class = "{$class} without-sortings"}
        {/if}

        {if ($theme.sidebarFilter || $facets|count == 0)}
            {$class = "{$class} without-facets"}
        {/if}

        {if $theme.infiniteScrolling}
            {$class = "{$class} without-pagination"}
        {/if}
    {/block}

    <div data-listing-actions="true"
         {if $listingMode != 'full_page_reload'}data-bufferTime="0"{/if}
         class="{$class}{block name='frontend_listing_actions_class'}{/block}">
        <div class="trefer_result">{$fetchCatCount} TREFFER</div>

        {* Filter action button *}
        {block name="frontend_listing_actions_filter"}
            {include file="frontend/listing/actions/action-filter-button.tpl"}
        {/block}

        {* Order by selection *}
        {block name='frontend_listing_actions_sort'}

            {include file="frontend/listing/actions/action-sorting.tpl"}
             {if $categoryID}
             <form action="{url controller='listing' action='index' sCategory=$categoryID}"  method="post" class="list-select-form">
                <div class="listing-options">

                    <button type="submit" name="listlayout" class="list-button {if $sts==1 && $productLayoutClass=='list'}active{/if}" value="list"><img src="{$bclistShopUrl}list-icon.png" title="List"></button>
                    <button type="submit" name="listlayout" class="list-button {if $sts==1 && $productLayoutClass=='basic'}active{/if}" value="basic"><img src="{$bclistShopUrl}basic-icon.png" title="Basic"></button>
                </div>
                <input type="hidden" name="categoryID" value="{$categoryID}">
                <input type="hidden" name="sts" value="1">
            </form>
            {/if}
        {/block}

        {* Filter options *}
        {block name="frontend_listing_actions_filter_options"}
            {if !$theme.sidebarFilter}
                {include file="frontend/listing/actions/action-filter-panel.tpl"}
            {/if}
        {/block}

        {* Listing pagination *}
        {block name='frontend_listing_actions_paging'}
            {include file="frontend/listing/actions/action-pagination.tpl"}
        {/block}

        {block name="frontend_listing_actions_close"}{/block}
    </div>
{/block}
