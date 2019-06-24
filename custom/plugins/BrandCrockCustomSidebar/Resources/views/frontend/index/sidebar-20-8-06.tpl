{extends file="parent:frontend/index/sidebar.tpl"}

{namespace name="frontend/listing/custom_sidebar"}

{block name='frontend_index_left_categories_inner'}
    <div class="hide_show_sidebar_filter">
        <div class="head_hideshow option-heading">
            FILTER AUSBLENDEN
        </div>
        <div class="sidebar-custom--filter option-content">
            <div class="sidebar--categories-navigation">

               
                <div class="filter-panel filter--multi-selection">
                    <div class="filter-panel--flyout">
                        <label class="filter-panel--title">
                            {s name="supplier_title"}Hersteller{/s}
                        </label>
                        <div class="filter-panel--content input-type--checkbox">
                            <ul class="filter-panel--option-list">
                                {foreach $mainCategories as $mainCategory}
<pre>
                                {$mainCategory|var_dump}
                            </pre>


                                    <li class="filter-panel--option">
                                        <div class="option--container">
                                        <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   {if $supplier.id == $activeSupplierId }checked="checked"{/if}>
                                           <span class="input--state checkbox--state">&nbsp;</span>
                                        </span>
                                            <label class="filter-panel--label" for="csb-supplier">
                                                <a href="{$supplier.link}">{$mainCategory.name}</a>

                                            </label>

                                        </div>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
               
                {if $mainCategoreis}
                    <div class="filter-panel filter--multi-selection">
                        <div class="filter-panel--flyout">
                            <label class="filter-panel--title">
                                {s name="main_categories_title"}Hauptkategorien{/s}
                            </label>
                            <div class="filter-panel--content input-type--checkbox">
                                <ul class="filter-panel--option-list">
                                    {foreach $mainCategoreis as $category}
                                        <li class="filter-panel--option">
                                            <div class="option--container">
                                            <span class="filter-panel--input filter-panel--checkbox">
                                        <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                               {if $category.id == $activeMainCategoryId }checked="checked"{/if}>
                                                 <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                                <label class="filter-panel--label" for="csb-supplier">
                                                    <a href="{$category.link}">{$category.name}</a>
                                                </label>
                                            </div>
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                        </div>
                    </div>
                {/if}

              {if $subCategories}
                <div class="filter-panel filter--multi-selection">
                    <div class="filter-panel--flyout">
                        <label class="filter-panel--title">
                            {s name="sub_categories_title"}Themenwelt{/s}
                        </label>
                        <div class="filter-panel--content input-type--checkbox">
                            <ul class="filter-panel--option-list">
                                {foreach $subCategories as $category}
                                    <li class="filter-panel--option">
                                        <div class="option--container">
                                            <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   >
                                                <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                            <label class="filter-panel--label {if count($category.articles) > 0}has-sub-level{/if} for="csb-supplier">
                                                <a href="cat/index/sCategory/{$category.id}">{$category.name}</a>
                                            </label>

                                        </div>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
                {/if}
                {if $subCatCategories}
                <div class="filter-panel filter--multi-selection">
                    <div class="filter-panel--flyout">
                        <label class="filter-panel--title">
                            {s name="sub_categories_title"}Themenwelt{/s}
                        </label>
                        <div class="filter-panel--content input-type--checkbox">
                            <ul class="filter-panel--option-list">
                                {foreach $subCatCategories as $category}
                                    <li class="filter-panel--option">
                                        <div class="option--container">
                                            <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   >
                                                <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                            <label class="filter-panel--label {if count($category.articles) > 0}has-sub-level{/if} for="csb-supplier">
                                                <a href="cat/index/sCategory/{$category.id}">{$category.name}</a>
                                            </label>

                                        </div>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
                {/if}

                


            </div>
        </div>
    </div>
{/block}
