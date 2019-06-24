{block name="frontend_plugins_advanced_menu_main_container"}
    <div class="mega_menu_custom_wrap bc-flat">
        <div class="mega_menu_box brand_section">
            {foreach $mainCategory.suppliers as $supplier}

           
                <div class="menu_bc_common_columns">
                <div class="menu_left_colums"><img src="{media path={$supplier.image}}" alt=""/>
              
                    <div class="brand_categories_show"><i class=""></i><p><a href="/{$supplier.name|lower}">ALLES IN {$supplier.name} {$mainCategory.name} ZEIGEN </a></p>
                    </div>
                </div>
                <div class="menu_right_colums">
                    {foreach $supplier.categories as $category}
                       

                        {$categoryLink = $category.link}
                        {if $category.external}
                            {$categoryLink = $category.external}
                        {/if}
                        <div class="menu_right_menu_box">
                            <div class="mega_cate_img"><img src="{$category.media.source}"></div>
                            <h4>

                                <a href="{$categoryLink|escapeHtml}" class="menu--list-item-link"
                                   title="{$category.name|escape}"{if $category.external && $category.externalTarget} target="{$category.externalTarget}"{/if}>{$category.name}</a>
                            </h4>
                            <ul>
                                {foreach $category.articles as $article}
                                    <li>
                                        <a href="{link file={$article.link}}">{$article.name}</a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    {/foreach}

                </div>
                </div>
            {/foreach}
        </div>
    </div>
{/block}

