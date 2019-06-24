{extends file="frontend/index/sidebar.tpl"}

{block name="frontend_index_sidebar"}
    {if $theme.sidebarFilter}
        {block name='frontend_listing_sidebar'}
            <div class="listing--sidebar">
                <div class="hide_show_sidebar_filter">
                    <div class="head_hideshow option-heading">
                        FILTER AUSBLENDEN
                    </div>
                    <div class="option-content">
                    {$smarty.block.parent}

                    <div class="sidebar-filter">
                        <div class="sidebar-filter--content">
                            {include file="frontend/listing/actions/action-filter-panel.tpl"}
                        </div>
                    </div>
                </div>
                </div>

            </div>
        {/block}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
