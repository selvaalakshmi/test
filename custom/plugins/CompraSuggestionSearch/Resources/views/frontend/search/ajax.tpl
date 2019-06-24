{extends file="parent:frontend/search/ajax.tpl"}

{block name="search_ajax_inner"}
    {if $compraSuggestionSearch.useSuggestionSearch}
        <div class="suggestion--search">
            <div class="results--list {if ($compraSuggestionSearch.showCategories || $compraSuggestionSearch.showManufacturer)}results--list-advanced{/if}">

                {* Show productresults *}
                {block name="search_ajax_product_results"}
                    {* Check configuration to format the product results *}
                    <div class="search--results-ajax {if !$compraSuggestionSearch.showCategories && !$compraSuggestionSearch.showManufacturer}search--results-ajax-only {elseif $compraSuggestionSearch.showCategories && $compraSuggestionSearch.showManufacturer} search--results-ajax-advanced{/if}">

                        {* Headline product results *}
                        {block name="search_ajax_headline_products"}
                            <div class="search--results-title">
                                {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchProducts"}{/s}
                            </div>
                        {/block}

                        <ul>
                            {* Origial Search*}
                            {foreach $sSearchResults.sResults as $search_result}
                                {* Each product in the search result *}
                                {block name="search_ajax_list_entry"}
                                    <li class="list--entry block-group">
                                        {* div necessary so results in line *}
                                        <div class="list--entry-expanded">
                                            <a class="search-result--link" href="{$search_result.link}" title="{$search_result.name|escape}">

                                                {* Product image *}
                                                {block name="search_ajax_list_entry_media"}
                                                    <span class="entry--media block">
                                                        {if $search_result.image.thumbnails[0]}
                                                            <img srcset="{$search_result.image.thumbnails[0].sourceSet}" alt="{$search_result.name|escape}" class="media--image">
                                                        {else}
                                                            <img src="{link file='frontend/_public/src/img/no-picture.jpg'}" alt="{"{s name='ListingBoxNoPicture'}{/s}"|escape}"
                                                                 class="media--image">
                                                        {/if}
                                                    </span>
                                                {/block}

                                                {* Product name *}
                                                {block name="search_ajax_list_entry_name"}
                                                    <span class="entry--name block">
                                                        {$search_result.name|escapeHtml}
                                                    </span>
                                                {/block}

                                                {* Product price *}
                                                {block name="search_ajax_list_entry_price"}
                                                    <span class="entry--price block">
                                                        {$sArticle = $search_result}
                                                        {*reset pseudo price value to prevent discount boxes*}
                                                        {$sArticle.has_pseudoprice = 0}
                                                        {include file="frontend/listing/product-box/product-price.tpl" sArticle=$sArticle}
                                                    </span>
                                                {/block}
                                            </a>
                                        </div>
                                    </li>
                                {/block}
                            {/foreach}

                            {* Link to show all founded products using the built-in search *}
                            {block name="search_ajax_all_results"}
                                <li class="entry--all-results block-group">

                                    {* Link to the built-in search *}
                                    {block name="search_ajax_all_results_link"}
                                        <a href="{url controller="search"}?sSearch={$sSearchRequest.sSearch}" class="search-result--link entry--all-results-link block">
                                            <i class="icon--arrow-right"></i>
                                            {s name="SearchAjaxLinkAllResults"}{/s}
                                        </a>
                                    {/block}

                                    {* Result of all founded products *}
                                    {block name="search_ajax_all_results_number"}
                                        <span class="entry--all-results-number block">
                                            {$sSearchResults.sArticlesCount} {s name='SearchAjaxInfoResults'}{/s}
                                        </span>
                                    {/block}
                                </li>
                            {/block}
                        </ul>
                    </div>
                {/block}

                {* Expand SuggestionSearch *}
                {block name ="search_ajax_expanded_results"}
                    {* Show expand suggestion search, if categories, manufacturer or 'Did you mean' - suggestion is activated *}
                    {if ($compraSuggestionSearch.showManufacturer || $compraSuggestionSearch.showCategories) || ($compraSuggestionSearch.showSearchSuggestions && isset($searchSuggestions))}
                        {* Formatting the extended SuggesionSearch depending on what is displayed*}
                        <div class="search--results-expanded {if ($compraSuggestionSearch.showManufacturer && $compraSuggestionSearch.showCategories)}search--results-fully-expanded {elseif (!$compraSuggestionSearch.showManufacturer && !$compraSuggestionSearch.showCategories)} search--results-suggestions{/if}">

                            {* Show categories *}
                            {block name="search_ajax_categories"}
                                {if $compraSuggestionSearch.showCategories}
                                    <div class ="search--results-categories {if !$compraSuggestionSearch.showManufacturer} search--results-categories-only{/if}">
                                        {block name='search_ajax_categories_results'}

                                            {* Headline *}
                                            {block name="search_ajax_categories_headline"}
                                                <div class="search--results-title {if $compraSuggestionSearch.showCategoriesWithFilter} search--results-title-reduced{/if}">
                                                    {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchCategories"}{/s}
                                                </div>
                                                {* Check configuration if searchterm filter for categories is activated *}
                                                {if $compraSuggestionSearch.showCategoriesWithFilter}
                                                    <div class="search--results-title search--results-filter-title">
                                                        {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchFilter"}{/s}
                                                    </div>
                                                {/if}

                                            {/block}
                                            <ul>
                                                {foreach $compraSuggestionSearch.compraCategories as $categories}

                                                    {* Show category results *}
                                                    {block name="search_ajax_categories_results_entry"}
                                                        <li class="list--entry block-group">

                                                            {* show category name *}
                                                            {block name="search_ajax_categories_results_entry_name"}
                                                                <div class="{if $compraSuggestionSearch.showCategoriesWithFilter}list--entry-expanded-filter {else} list--entry-expanded{/if}">
                                                                    {if $compraSuggestionSearch.categoriesLinkToSearchResults}
                                                                        {* category name links to search results page *}
                                                                        <a class="search-result--link" href="{url controller="search"}?sSearch={$sSearchRequest.sSearch}&c={$categories.id}" title="{$compraSuggestionSearch.compraCategoriesPath[$categories.id].linkTitle}">
                                                                            <div class="entry--name">
                                                                                {$compraSuggestionSearch.compraCategoriesPath[$categories.id].name}
                                                                            </div>
                                                                        </a>
                                                                    {else}
                                                                        {* category name links to category page *}
                                                                        <a class="search-result--link" href="{url controller=cat sCategory=$categories.id}" title="{$compraSuggestionSearch.compraCategoriesPath[$categories.id].linkTitle}">
                                                                            <div class="entry--name">
                                                                                {$compraSuggestionSearch.compraCategoriesPath[$categories.id].name}
                                                                            </div>
                                                                        </a>
                                                                    {/if}
                                                                </div>
                                                            {/block}

                                                            {* Show icon if searchterm filter for categories is activated *}
                                                            {block name="search_ajax_categories_results_entry_icon"}
                                                                {if $compraSuggestionSearch.showCategoriesWithFilter}
                                                                    <div class="search--results-icon">
                                                                        <a class="search-result--link" href="{url controller="search"}?sSearch={$sSearchRequest.sSearch}&c={$categories.id}"
                                                                           title="{s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchFilterSearchFirst"}{/s} &quot;{$categories.name}&quot; {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchFilterSearchMiddle"}
                                                                              {/s} &quot;{$sSearchRequest.sSearch}&quot; {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchFilterSearchLast"}{/s}"
                                                                           data-action-link="true">
                                                                            {* Show icon and number results for search with filter *}
                                                                            <span class="entry--name">
                                                                                <i class="icon--search"></i>
                                                                                ({$categories.count})
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                {/if}
                                                            {/block}
                                                        </li>
                                                    {/block}
                                                {/foreach}
                                            </ul>
                                        {/block}
                                    </div>
                                {/if}
                            {/block}

                            {* Show manufacturer *}
                            {block name="search_ajax_manufacturer"}
                                {if $compraSuggestionSearch.showManufacturer}
                                    <div class ="search--results-manufacturer {if !$compraSuggestionSearch.showCategories}search--results-manufacturer-only{/if}">

                                        {block name="search_ajax_manufacturer_results"}

                                            {* Headline *}
                                            {block name="search_ajax_manufacturer_headline"}
                                                <div class="search--results-title  {if $compraSuggestionSearch.showManufacturerWithFilter}search--results-title-reduced{/if}">
                                                    {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchManufacturer"}{/s}
                                                </div>
                                                {* Check configuration if searchterm filter for manufacturer is activated *}
                                                {if $compraSuggestionSearch.showManufacturerWithFilter}
                                                    <div class="search--results-title search--results-filter-title">
                                                        {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchFilter"}{/s}
                                                    </div>
                                                {/if}
                                            {/block}
                                            <ul>
                                                {foreach $compraSuggestionSearch.compraSuppliers as $suppliers}

                                                    {* Show manufacturer results*}
                                                    {block name="search_ajax_manufacturer_results_entry"}
                                                        <li class="list--entry block-group">

                                                            {* show manufacturer name *}
                                                            {block name="search_ajax_manufacturer_results_entry_name"}
                                                                <div class="{if $compraSuggestionSearch.showManufacturerWithFilter} list--entry-expanded-filter {else}list--entry-expanded{/if}">
                                                                    {if $compraSuggestionSearch.manufacturerLinkToSearchResults}
                                                                        {* manufacturer name links to search results page *}
                                                                        <a class="search-result--link" href="{url controller="search"}?sSearch={$sSearchRequest.sSearch}&s={$suppliers.id}" title="{$suppliers.name}">
                                                                            <div class="entry--name">
                                                                                {$suppliers.name}
                                                                            </div>
                                                                        </a>
                                                                    {else}
                                                                        {* manufacturer name links to manufacturer page *}
                                                                        <a class="search-result--link" href="{url controller='listing' action='manufacturer' sSupplier=$suppliers.id}" title="{$suppliers.name}">
                                                                            <div class="entry--name">
                                                                                {$suppliers.name}
                                                                            </div>
                                                                        </a>
                                                                    {/if}
                                                                </div>
                                                            {/block}

                                                            {* Show icon if searchterm filter for manufacturer is activated *}
                                                            {block name="search_ajax_manufacturer_results_entry_icon"}
                                                                {if $compraSuggestionSearch.showManufacturerWithFilter}
                                                                    <div class="search--results-icon">
                                                                        <a class="search-result--link" href="{url controller="search"}?sSearch={$sSearchRequest.sSearch}&s={$suppliers.id}"
                                                                           title="{s namespace='frontend/plugins/CompraSuggestionSearch/main' name='compraSuggestionSearchFilterSearchFirst'}{/s} &quot;{$suppliers.name}&quot; {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchFilterSearchMiddle"}
                                                                              {/s} &quot;{$sSearchRequest.sSearch}&quot; {s namespace="frontend/plugins/CompraSuggestionSearch/main" name="compraSuggestionSearchFilterSearchLast"}{/s}"
                                                                           data-action-link="true">
                                                                            {* Show icon and number results for search with filter *}
                                                                            <span class="entry--name">
                                                                                <i class="icon--search"></i>
                                                                                ({$suppliers.count})
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                {/if}
                                                            {/block}
                                                        </li>
                                                    {/block}
                                                {/foreach}
                                            </ul>
                                        {/block}
                                    </div>
                                {/if}
                            {/block}
                        </div>
                    {/if}
                {/block}
            </div>
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}