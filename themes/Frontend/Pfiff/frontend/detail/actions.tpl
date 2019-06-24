{block name='frontend_detail_actions_notepad'}
    <form action="{url controller='note' action='add' ordernumber=$sArticle.ordernumber}" method="post" class="action--form">
        <button type="submit"
                class="action--link link--notepad"
                title="{"{s name='DetailLinkNotepad'}{/s}"|escape}"
                data-ajaxUrl="{url controller='note' action='ajaxAdd' ordernumber=$sArticle.ordernumber}"
                data-text="{s name="DetailNotepadMarked"}{/s}">
            <i class="icon--heart"></i> <span class="action--text">{s name="DetailLinkNotepadShort"}{/s}</span>
        </button>
    </form>
{/block}

{block name='frontend_detail_actions_compare'}
    {if {config name="compareShow"}}
        <form action="{url controller='compare' action='add_article' articleID=$sArticle.articleID}" method="post" class="action--form">
            <button type="submit" data-product-compare-add="true" title="{"{s name='DetailActionLinkCompare'}{/s}"|escape}" class="action--link action--compare">
                <i class="icon--compare"></i> {s name="DetailActionLinkCompare"}{/s}
            </button>
        </form>
    {/if}
{/block}



{block name='frontend_detail_actions_review'}

{/block}

{block name='frontend_detail_actions_voucher'}

{/block}
