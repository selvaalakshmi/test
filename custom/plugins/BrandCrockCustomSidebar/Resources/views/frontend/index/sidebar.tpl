{extends file="parent:frontend/index/sidebar.tpl"}

{namespace name="frontend/listing/custom_sidebar"}

{block name='frontend_index_left_categories_inner'}
    <div class="hide_show_sidebar_filter">
        <div class="head_hideshow option-heading">
            FILTER AUSBLENDEN
        </div>
        <div class="sidebar-custom--filter option-content">
            <div class="sidebar--categories-navigation">

                {if $suppliers}
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
               {/if} 
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
                 
  {if $subofCategories}
                <div class="filter-panel filter--multi-selection">
                    <div class="filter-panel--flyout">
                        <label class="filter-panel--title">
                           Themenwelt
                        </label>
                        <div class="filter-panel--content input-type--checkbox">
                            <ul class="filter-panel--option-list">
                                {foreach $subofCategories as $category}
                                    <li class="filter-panel--option">
                                        <div class="option--container">
                                            <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   {if $category.id == $activeSubCategoryId }checked="checked"{/if}>
                                                <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                                <label class="filter-panel--label {if count($subofSubCategories) > 0}  has-sub-level{/if}" for="csb-supplier">
                                               <a href="cat/index/sCategory/{$category.id}">{$category.name}</a> 
                                            </label>
                                            <ul class="filter-panel--option-list newly_added" style="padding-left:15px;">
												{foreach from=$subofSubCategories key=key item=value} 

                {foreach from=$value key=key2 item=value2} 
			{if  $category.id  == $value2.parentId}
                     <li class="filter-panel--option ">
                                        <div class="option--container">
                                            <span class="filter-panel--input filter-panel--checkbox">
                                            <input type="checkbox" id="csb-supplier" name="csb-supplier"
                                                   {if $category.id == $activeSubCategoryId }checked="checked"{/if}>
                                                <span class="input--state checkbox--state">&nbsp;</span>
                                            </span>
                                                <label class="filter-panel--label {*{if count($category.articles) > 0}has-sub-level{/if}*}" for="csb-supplier">
                                                <a href="cat/index/sCategory/{$value2.id}">{$value2.name}</a>
                                            </label>

                                    </li>
{/if}

                {/foreach} 
        {/foreach} 
        </ul>
        {/foreach} 

                            
                        </div>
                    </div>
                </div>
                {/if}    
                           
             
               
                <!-- end custom added-->



            </div>
        </div>
    </div>
{/block}
