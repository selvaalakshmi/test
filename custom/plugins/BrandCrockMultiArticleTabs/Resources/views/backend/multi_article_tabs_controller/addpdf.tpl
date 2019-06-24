{extends file="parent:backend/_base/layout.tpl"}
{block name="content/main"}
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">ADD PDF Data</h3></div>

        <div class="panel-body">
            <form class="form-horizontal"
                  action='{url controller="MultiArticleTabsController" action="savepdf" __csrf_token=$csrfToken}'
                  method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Order number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ordernumber" readonly="" value="{$ordernumber}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">PDF Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pdftitle" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Position</label>
                    <div class="col-sm-10">
                        <select name="position" class="form-control">
                            {for $countdata=1 to 10}
                                <option value="{$countdata}">{$countdata}</option>
                            {/for}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="checkbox" name="sts"
                               value="1" {if $smarty.get.sts} checked="checked" {/if}/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Upload PDF</label>
                    <div class="col-sm-10">
                        <div style="position:relative;">
                            <a class='btn btn-info' href='javascript:;'>
                                Choose File...
                                <input type="file"
                                       style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                                       name="file_source" size="40"
                                       onchange='$("#upload-file-info").html($(this).val());'>
                            </a>
                            &nbsp;
                            <span class='label label-info' id="upload-file-info"></span>
                            <div style="color:black; font-weight:bold
            "> Upload PDF File only
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Select Language</label>
                    <div class="col-sm-10">
                        <select name="localeid" class="form-control">
                            {foreach $FetchLanguageData as $FetchLanguage}
                                <option value="{$FetchLanguage.id}">{$FetchLanguage.locale}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Save</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
{/block}