{extends file="parent:backend/_base/layout.tpl"}
{block name="content/main"}
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Edit Manufacturer Info</h3></div>

        <div class="panel-body">
            <form class="form-horizontal"
                  action='{url controller="ManufacturerInfoController" action="updatemanufacturer" __csrf_token=$csrfToken}'
                  method="post" enctype="multipart/form-data">
                {foreach $miEditFetchData as $miEditData}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ordernumber</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="miordernumber"
                                   value="{$miEditData.ordernumber}" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Select Language</label>
                        <div class="col-sm-10">
                            <select name="milocaleid" class="form-control">
                                {foreach $miFetchLanguageData as $miFetchLanguage}
                                    <option value="{$miFetchLanguage.id}"
                                            {if $miFetchLanguage.locale == $miEditData.language}selected {/if}>{$miFetchLanguage.locale}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-10">
                            <select name="miposition" class="form-control">
                                {for $micountdata=1 to 10}
                                    <option value="{$micountdata}"
                                            {if $micountdata == $miEditData.position}selected {/if}>{$micountdata}</option>
                                {/for}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="checkbox" name="mists"
                                   value="1" {if $miEditData.active} checked="checked" {/if}/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Upload PDF</label>
                        <div class="col-sm-10">
                            <div>
                                <span style="color: black; font-weight: bold">Exist File Name:</span> {$miEditData.img_path}
                            </div>
                            <div style="position:relative;">
                                <a class='btn btn-info' href='javascript:;'>
                                    Choose File...
                                    <input type="file"
                                           style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                                           name="mifile_source" size="40"
                                           onchange='$("#upload-file-info").html($(this).val());'>
                                </a>
                                &nbsp;
                                <span class='label label-info' id="upload-file-info"></span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">

                            <textarea class="form-control" rows="5" cols="90%"
                                      name="midesc">{$miEditData.description}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <input type="hidden" name="miid" value="{$miEditData.id}"/>
                            <input type="hidden" name="mifiledata" value="{$miEditData.img_path}"/>
                        </div>
                    </div>
                {/foreach}
            </form>
        </div>
    </div>
{/block}