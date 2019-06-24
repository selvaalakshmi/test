{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}
    <div class="table-responsive">
        <table id="bcindexTable" class="table table-striped">
            <thead>
            <tr>

                <th>Order number</th>
                <th>Article Name</th>
                <th>stock</th>
                <th>Status</th>
                <th style="text-align:right">Action</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {if $message}
                <tr>
                    <td colspan="7">{$message}</td>
                </tr>
            {else}
                {foreach $ArticleFetchData as $ArticleData}
                    <tr>
                        <td>{$ArticleData.ordernumber}</td>
                        <td>{$ArticleData.name}</td>
                        <td>{$ArticleData.instock}</td>
                        <td>{if {$ArticleData.active}==1}Active{else}Inactive{/if}</td>
                        <form class="form-horizontal"
                              action='{url controller="MultiArticleTabsController" action="addpdf" __csrf_token=$csrfToken}'>
                            <td style="text-align:right">
                                <button type="submit" class="btn btn-primary">Add PDF</button>
                            </td>
                            <input type="hidden" name="ordernumber" value="{$ArticleData.ordernumber}"/>
                        </form>
                        <form class="form-horizontal"
                              action='{url controller="MultiArticleTabsController" action="addfaq" __csrf_token=$csrfToken}'>
                            <td style="text-align:right">
                                <button type="submit" class="btn btn-primary">Add FAQ</button>
                            </td>
                            <input type="hidden" name="ordernumber" value="{$ArticleData.ordernumber}"/>
                        </form>
                    </tr>
                {/foreach}

            {/if}
            </tbody>
        </table>
    </div>
{/block}