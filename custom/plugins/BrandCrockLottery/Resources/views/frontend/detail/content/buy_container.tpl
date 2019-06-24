{extends file='parent:frontend/detail/content/buy_container.tpl'}
{block name='frontend_detail_index_buy_container_base_info' append}
	 <ul class="product--base-info list--unstyled custom-attr-bc">
		 {if $sArticle.sConfigurator}
		 <li class="base-info--entry ">
			 <strong class="entry--label">Variants</strong>
			 <span class="entry--content">
	{foreach $sArticle.sConfigurator as $sConfigurator}
    {foreach $sConfigurator.values as $configValue}
        {if $configValue.selected}
             {$configValue.optionname}{if $configValue.upprice} {if $configValue.upprice > 0}{/if}{/if}
        {/if}
    {/foreach}
	{/foreach}
</span>
	     </li>

	     {/if}
	 </ul>
{/block}

