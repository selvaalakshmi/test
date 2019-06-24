{* Footer menu *}
{block name='frontend_index_footer_menu'}
    <div class="footer--columns block-group">
        {include file='frontend/index/footer-navigation.tpl'}
    </div>
{/block}

{* Copyright in the footer *}
{block name='frontend_index_footer_copyright'}
    <div class="footer--bottom">

        {* Vat info *}
        {block name='frontend_index_footer_vatinfo'}
        {/block}

        {block name='frontend_index_footer_minimal'}
            {include file="frontend/index/footer_minimal.tpl" hideCopyrightNotice=true}
        {/block}

        {* Shopware footer *}
        {block name="frontend_index_shopware_footer"}

            {* Copyright *}
            {block name="frontend_index_shopware_footer_copyright"}
                <div class="bottom_custom_footer">
                <div class="f_left">
                    <strong>PFIFF SOLAR GMBH</strong> – Thurnerweg 33 – 39049 Pfitsch
                </div>
                <div class="m_left footer--copyright">
                    {s name="IndexCopyright"}{/s}
                </div>
                <div class="r_left">
                    © 2019 PRIMADU. ALL RIGHTS RESERVED
                </div>
                </div>
            {/block}

            {* Logo *}
            {block name="frontend_index_shopware_footer_logo"}
            {/block}
        {/block}
    </div>
{/block}
