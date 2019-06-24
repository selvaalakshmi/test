{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}
    <div class="table-responsive">
        <table id="bcmiTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Order number</th>
                    <th>Article Name</th>
                    <th>stock</th>
                    <th>Status</th>
                    <th style="text-align:right">Action</th>

                </tr>
            </thead>
            <tbody>
           {if $message}
           <tr>
                <td colspan="7">{$message}</td>
           </tr>             
           {else}
                {foreach $miArticleFetchData as $miArticleData}
                    <tr>
                        <td>{$miArticleData.ordernumber}</td>
                        <td>{$miArticleData.name}</td>
                        <td>{$miArticleData.instock}</td>
                        <td>{if {$miArticleData.active}==1}Active{else}Inactive{/if}</td>
                        <form class="form-horizontal"  action='{url controller="ManufacturerInfoController" action="addmanufacturer" __csrf_token=$csrfToken}'>
                            <td style="text-align:right"><button type="submit" class="btn btn-primary">Add Manufacturer</button></td>
                            <input type="hidden" name="miordernumber" value="{$miArticleData.ordernumber}"/>
                        </form>

                    </tr>
                {/foreach}
         
           {/if}
            </tbody>
        </table>
    </div>

{/block}