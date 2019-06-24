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
                                {foreach $suppliers as $supplier}
                                    <li class="filter-panel--option">
                                        <div class="option--container">
                                        <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   {if $supplier.id == $activeSupplierId }checked="checked"{/if}>
                                           <span class="input--state checkbox--state">&nbsp;</span>
                                        </span>
                                            <label class="filter-panel--label" for="csb-supplier">
                                                <a href="{$supplier.link}">{$supplier.name}</a>

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
                                                   {if $category.id == $activeSubCategoryId }checked="checked"{/if}>
                                                <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                            <label class="filter-panel--label {*{if count($category.articles) > 0}has-sub-level{/if}*}" for="csb-supplier">
                                                <a href="{$category.link}">{$category.name}</a>
                                            </label>
                                        </div>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- custom added -->
                <div class="filter-panel filter--multi-selection">
                    <div class="filter-panel--flyout">
                        <label class="filter-panel--title">
                            Step 4
                        </label>
                        <div class="filter-panel--content input-type--checkbox">
                            <ul class="filter-panel--option-list">
                                {foreach $subofCategories as $category}
                               <!--  {$category|var_dump} -->

                                    <li class="filter-panel--option">
                                        <div class="option--container">
                                            <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   {if $category.id == $activeSubCategoryId }checked="checked"{/if}>
                                                <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                                <label class="filter-panel--label {*{if count($category.articles) > 0}has-sub-level{/if}*}" for="csb-supplier">
                                                <a href="{$url}shopware.php?sCategory={$category.id}&sViewport=cat">{$category.name}</a>
                                            </label>

                                    </li>

                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Step 5-->
                 <div class="filter-panel filter--multi-selection">
                    <div class="filter-panel--flyout">
                        <label class="filter-panel--title">
                            Step 5
                        </label>
                        <div class="filter-panel--content input-type--checkbox">
                            <ul class="filter-panel--option-list">
                                {foreach $subofSubCategories as $category}
                                
                                    <li class="filter-panel--option">
                                        <div class="option--container">
                                            <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   {if $category.id == $activeSubCategoryId }checked="checked"{/if}>
                                                <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                                <label class="filter-panel--label {*{if count($category.articles) > 0}has-sub-level{/if}*}" for="csb-supplier">
                                                <a href="{$url}shopware.php?sViewport=cat&sCategory={$category.id}">{$category.name}</a>
                                            </label>

                                    </li>

                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end custom added-->



            </div>
        </div>
    </div>
{/block}
