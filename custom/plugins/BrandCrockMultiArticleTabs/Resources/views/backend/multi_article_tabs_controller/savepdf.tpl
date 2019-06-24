{extends file="parent:backend/_base/layout.tpl"}
{block name="content/main"}
{$messagedata} . <a href="{url controller="MultiArticleTabsController" action="listpdf" __csrf_token=$csrfToken}">Back</a>
{/block}