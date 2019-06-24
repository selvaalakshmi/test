{block name="frontend_plugins_advanced_menu_main_container"}
    <div class="mega_menu_custom_wrap">
        <div class="mega_menu_box tabs_section">
            <div class="menu_left_colums">
                <ul class="tabs clearfix" data-tabgroup="first-tab-group-{$mainCategory.id}">
                    {$active = 'active'}
                    {foreach $mainCategory.suppliers as $index => $supplier}
                        <li>
                            <a href="#tab-{$mainCategory.id}-{$index}" class="{$active}">
                                 <img src="{media path={$supplier.image}}" alt="">
                                <div class="brand_categories_show">
                                    {* {$supplier.description}*}
                                    {foreach $supplier.categories as $category}
                                        {$category.name}
                                    {/foreach}
                                </div>
                            </a>
                        </li>
                        {$active = ''}
                    {/foreach}
                </ul>
            </div>
            <div id="first-tab-group-{$mainCategory.id}" class="tabgroup menu_right_colums">
                {foreach $mainCategory.suppliers as $index => $supplier}
                    <div id="tab-{$mainCategory.id}-{$index}" style="">
                        {foreach $supplier.categories as $category}
                            {*{$categoryLink = $category.link}*}
                            {*{if $category.external}*}
                                {*{$categoryLink = $category.external}*}
                            {*{/if}*}
                            {foreach $category.sub as $subs}
                                <div class="menu_right_menu_box">
                                    <div class="mega_cate_img"><img src="{$subs.media.source}"></div>
                                    <a href="{$subs.link}" class="menu--list-item-link"
                                       title="{$category.name}"><h4>{$subs.name}</h4></a>
                                </div>
                            {/foreach}
                        {/foreach}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/block}

