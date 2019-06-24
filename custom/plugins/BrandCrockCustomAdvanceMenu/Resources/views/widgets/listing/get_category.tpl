{extends file="parent:widgets/listing/get_category.tpl"}



{block name="widgets_listing_get_category_categories_item"}
    {if $isSupplier}
        {foreach $suppliers as $supplier}
            <li class="navigation--entry" role="menuitem">
                {block name="widgets_listing_get_category_categories_item_link"}

                    {$link = $supplier.link}
                    {if $supplier.external}
                        {$link = $supplier.external}
                    {/if}
                    <a href="{$link}" title="{$supplier.name|escape}"
                       class="navigation--link link--go-forward"
                        {*data-category-id="{$children.id}"*}
                       data-fetchUrl="{url module=widgets controller=CustomAdvanceMenu action=getSupplierCategory parentCategoryId={$parentCategoryId} supplierId={$supplier.id}}" >

                        {block name="widgets_listing_get_category_categories_item_link_name"}
                            {$supplier.name}
                        {/block}

                        {block name="widgets_listing_get_category_categories_item_link_children"}
                            <span class="is--icon-right">
                                <i class="icon--arrow-right"></i>
                            </span>
                        {/block}
                    </a>
                {/block}
            </li>
        {/foreach}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}



