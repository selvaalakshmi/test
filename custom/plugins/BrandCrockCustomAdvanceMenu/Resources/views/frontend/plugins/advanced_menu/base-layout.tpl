<div class="advanced-menu" data-advanced-menu="true" data-hoverDelay="{$hoverDelay}">
    {block name="frontend_plugins_advanced_menu"}
        {foreach $sAdvancedMenu as $mainCategory}
            {if !$mainCategory.active || $mainCategory.hideTop}
                {continue}
            {/if}

            {$link = $mainCategory.link}
            {if $mainCategory.external}
                {$link = $mainCategory.external}
            {/if}

            {$hasCategories = $mainCategory.activeCategories > 0  && $columnAmount < 4}
            {$hasTeaser = (!empty($mainCategory.media) || !empty($mainCategory.cmsHeadline) || !empty($mainCategory.cmsText)) && $columnAmount > 0}
            <div class="menu--container">
                {if $hasCategories}
                    {if in_array($mainCategory.name, $flatLayoutCategories)}
                        {include file="frontend/plugins/advanced_menu/flat-layout.tpl"}
                    {/if}

                    {if in_array($mainCategory.name, $tabLayoutCategories)}
                        {include file="frontend/plugins/advanced_menu/tab-layout.tpl"}
                    {/if}
                {/if}
            </div>
        {/foreach}
    {/block}
</div>

