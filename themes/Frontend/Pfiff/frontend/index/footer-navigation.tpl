{namespace name="frontend/index/menu_footer"}

<div class="paymentcontainer">
    <div class="paymentcontainer_text">EINFACH BEZAHLEN MIT:</div>
    <img src='{link file='frontend/_public/src/img/paypal-icon.jpg' fullPath}' alt="">
    <img src='{link file='frontend/_public/src/img/visa-icon.jpg' fullPath}' alt="">
    <img src='{link file='frontend/_public/src/img/sofort-icon.jpg' fullPath}' alt="">
</div>

<div class="footer-custom-newsletter_content">
    <div class="custom-newsletter_container">
    <div class="columsleft">
        <h2>NEWSLETTER ABONNIEREN UND VORTEILE SICHERN</h2>
        <ul>
            <li>Exklusive Schnäppchen-Angebote</li>
            <li>Neuheiten</li>
            <li>Gutschein- & Rabattaktionen </li>
            <li>Kostenlos und jederzeit kündbar</li>
        </ul>
    </div>
    <div class="columsright">
        {block name="frontend_index_footer_column_newsletter_form"}
            <form class="newsletter--form" action="{url controller='newsletter'}" method="post">
                <input type="hidden" value="1" name="subscribeToNewsletter" />

                {block name="frontend_index_footer_column_newsletter_form_field_wrapper"}
                    <div class="content">
                        {block name="frontend_index_footer_column_newsletter_form_field"}
                            <input type="email" name="newsletter" class="newsletter--field" placeholder="{s name="IndexFooterNewsletterValue"}{/s}" />
                            {if {config name="newsletterCaptcha"} !== "nocaptcha"}
                                <input type="hidden" name="redirect">
                            {/if}
                        {/block}

                        {block name="frontend_index_footer_column_newsletter_form_submit"}
                            <button type="submit" class="newsletter--button btn">
                                LOS <i class="icon--arrow-right"></i> <span class="button--text">{s name='IndexFooterNewsletterSubmit'}{/s}</span>
                            </button>
                        {/block}
                    </div>
                {/block}

                {* Data protection information *}
                {block name="frontend_index_footer_column_newsletter_privacy"}
                {/block}
            </form>
        {/block}
    </div>
    </div>
</div>


<div class="footerbar_options">
    <div class="option_1"><span><img src='{link file='frontend/_public/src/img/icons/van-f.png' fullPath}' alt=""></span> SCHNELLER STANDARDVERSAND 1-2</div>
    <div class="option_1"><span><img src='{link file='frontend/_public/src/img/icons/tag-icon-f.png' fullPath}' alt=""></span> 2 JAHRE GARANTIE</div>
    <div class="option_1"><span><img src='{link file='frontend/_public/src/img/icons/mail-icon-f.png' fullPath}' alt=""></span> 24 STUNDEN KUNDENSUPPORT </div>
</div>

{* Service hotline *}
<div class="footer_navigation_container">
{block name="frontend_index_footer_column_service_hotline"}

{/block}

    {block name="frontend_index_footer_column_service_menu"}
        <div class="footer--column column--menu block">
            {block name="frontend_index_footer_column_service_menu_headline"}
                <div class="column--headline">{s name="sFooterShopNavi1"}{/s}</div>
            {/block}

            {block name="frontend_index_footer_column_service_menu_content"}
                <nav class="column--navigation column--content">
                    <ul class="navigation--list" role="menu">
                        {block name="frontend_index_footer_column_service_menu_before"}{/block}
                        {foreach $sMenu.bottom as $item}

                            {block name="frontend_index_footer_column_service_menu_entry"}
                                <li class="navigation--entry" role="menuitem">
                                    <a class="navigation--link" href="{if $item.link}{$item.link}{else}{url controller='custom' sCustom=$item.id title=$item.description}{/if}" title="{$item.description|escape}"{if $item.target} target="{$item.target}"{/if}>
                                        {$item.description}
                                    </a>

                                    {* Sub categories *}
                                    {if $item.childrenCount > 0}
                                        <ul class="navigation--list is--level1" role="menu">
                                            {foreach $item.subPages as $subItem}
                                                <li class="navigation--entry" role="menuitem">
                                                    <a class="navigation--link" href="{if $subItem.link}{$subItem.link}{else}{url controller='custom' sCustom=$subItem.id title=$subItem.description}{/if}" title="{$subItem.description|escape}"{if $subItem.target} target="{$subItem.target}"{/if}>
                                                        {$subItem.description}
                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    {/if}
                                </li>
                            {/block}
                        {/foreach}

                        {block name="frontend_index_footer_column_service_menu_after"}{/block}
                    </ul>
                </nav>
            {/block}
        </div>
    {/block}


{block name="frontend_index_footer_column_service_menu"}
    <div class="footer--column column--menu block">
        {block name="frontend_index_footer_column_service_menu_headline"}
            <div class="column--headline">{s name="sFooterShopNavi1"}{/s}</div>
        {/block}

        {block name="frontend_index_footer_column_service_menu_content"}
            <nav class="column--navigation column--content">
                <ul class="navigation--list" role="menu">
                    {block name="frontend_index_footer_column_service_menu_before"}{/block}
                    {foreach $sMenu.bottom as $item}

                        {block name="frontend_index_footer_column_service_menu_entry"}
                            <li class="navigation--entry" role="menuitem">
                                <a class="navigation--link" href="{if $item.link}{$item.link}{else}{url controller='custom' sCustom=$item.id title=$item.description}{/if}" title="{$item.description|escape}"{if $item.target} target="{$item.target}"{/if}>
                                    {$item.description}
                                </a>

                                {* Sub categories *}
                                {if $item.childrenCount > 0}
                                    <ul class="navigation--list is--level1" role="menu">
                                        {foreach $item.subPages as $subItem}
                                            <li class="navigation--entry" role="menuitem">
                                                <a class="navigation--link" href="{if $subItem.link}{$subItem.link}{else}{url controller='custom' sCustom=$subItem.id title=$subItem.description}{/if}" title="{$subItem.description|escape}"{if $subItem.target} target="{$subItem.target}"{/if}>
                                                    {$subItem.description}
                                                </a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                {/if}
                            </li>
                        {/block}
                    {/foreach}

                    {block name="frontend_index_footer_column_service_menu_after"}{/block}
                </ul>
            </nav>
        {/block}
    </div>
{/block}

{block name="frontend_index_footer_column_information_menu"}
    <div class="footer--column column--menu column--menu1  block">
        {block name="frontend_index_footer_column_information_menu_headline"}
            <div class="column--headline">{s name="sFooterShopNavi2"}{/s}</div>
        {/block}

        {block name="frontend_index_footer_column_information_menu_content"}
            <nav class="column--navigation column--content">
                <ul class="navigation--list" role="menu">
                    {block name="frontend_index_footer_column_information_menu_before"}{/block}
                        {foreach $sMenu.bottom2 as $item}

                            {block name="frontend_index_footer_column_information_menu_entry"}
                                <li class="navigation--entry" role="menuitem">
                                    <a class="navigation--link" href="{if $item.link}{$item.link}{else}{url controller='custom' sCustom=$item.id title=$item.description}{/if}" title="{$item.description|escape}"{if $item.target} target="{$item.target}"{/if}>
                                        {$item.description}
                                    </a>

                                    {* Sub categories *}
                                    {if $item.childrenCount > 0}
                                        <ul class="navigation--list is--level1" role="menu">
                                            {foreach $item.subPages as $subItem}
                                                <li class="navigation--entry" role="menuitem">
                                                    <a class="navigation--link" href="{if $subItem.link}{$subItem.link}{else}{url controller='custom' sCustom=$subItem.id title=$subItem.description}{/if}" title="{$subItem.description|escape}"{if $subItem.target} target="{$subItem.target}"{/if}>
                                                        {$subItem.description}
                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    {/if}
                                </li>
                            {/block}
                        {/foreach}
                    {block name="frontend_index_footer_column_information_menu_after"}{/block}
                </ul>
            </nav>
        {/block}
    </div>
{/block}

<div class="footer--column footer--column--custom column--newsletter shappingbox is--last block">
    {block name="frontend_index_footer_column_newsletter_headline"}
        <div class="column--headline">{s name="sFooterNewsletterHead"}{/s}</div>
    {/block}

    {block name="frontend_index_footer_column_newsletter_content"}
        <div class="column--navigation column--content">
        <div class="column--content" data-newsletter="true">
           <div class="shopping_icon icon1"></div>
            <div class="shopping_icon icon2"></div>
            <div class="shopping_icon icon3"></div>

            {block name="frontend_index_footer_column_newsletter_form"}
            {/block}
        </div>
        </div>
    {/block}
</div>

</div>