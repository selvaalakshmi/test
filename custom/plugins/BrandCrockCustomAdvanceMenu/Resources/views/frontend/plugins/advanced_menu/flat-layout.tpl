{block name="frontend_plugins_advanced_menu_main_container"}
    <div class="mega_menu_custom_wrap bc-flat">
        <div class="mega_menu_box brand_section">
            {foreach $mainCategory.suppliers as $supplier}
                <div class="menu_bc_common_columns">
                    <div class="menu_left_colums"><img src="{media path={$supplier.image}}" alt=""/>
                        <div class="brand_categories_show"><i class=""></i>
                            {foreach $supplier.categories as $category}
                                <a href="cat/index/sCategory/{$category.id}?s={$supplier.id}">{$category.name}</a>
                            {/foreach}
                        </div>
                    </div>
                    <div class="menu_right_colums">
                        {foreach $supplier.categories as $category}
                            {$categoryLink = $category.link}
                            {if $category.external}
                                {$categoryLink = $category.external}
                            {/if}
                            <div>
                                {*<div class="mega_cate_img"><img src="{$category.media.source}"></div>*}
                                <ul>
                                    {foreach $category.sub as $categorySub}
                                    <li class="menu_right_menu_box subcatofcat-{$categorySub.id}">
                                        <a href="cat/index/sCategory/{$categorySub.id}" class="menu--list-item-link"
                                           title="{$categorySub.name|escape}">
                                            <div class="mega_cate_img"><img src="{$categorySub.media.source}"></div>
                                            <h4>{$categorySub.name}</h4>
                                        </a>
                                        <ul>
                                            {foreach $categorySub.sub as $catSub}
                                                <li>
                                                    <a href="cat/index/sCategory/{$catSub.id}">{$catSub.name}</a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                        {/foreach}
                                    </li>
                                </ul>

                            </div>
                        {/foreach}
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/block}

