{extends file="parent:backend/_base/layout.tpl"}
{block name="content/main"}
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Upload PDF</h3></div>

        <div class="panel-body">
            <form class="form-horizontal"
                  action='{url controller="MultiArticleTabsController" action="savefaq" __csrf_token=$csrfToken}'
                  method="post">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Order number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ordernumber" readonly="" value="{$ordernumber}">
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
                    <label class="col-sm-2 control-label">Question</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="question" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Answer</label>
                    <div class="col-sm-10">

                        <textarea class="form-control" rows="8" cols="90%" name="answer"></textarea>
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
    <script>

       
        tinymce.init({
            selector: 'textarea',
            plugins: "code",
            toolbar: 'undo redo | link image | code',
            /* enable title field in the Image dialog*/
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
              URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
              images_upload_url: 'postAcceptor.php',
              here we add custom filepicker only to Image dialog
            */
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                /*
                  Note: In modern browsers input[type="file"] is functional without
                  even adding it to the DOM, but that might not be the case in some older
                  or quirky browsers like IE, so you might want to add it to the DOM
                  just in case, and visually hide it. And do not forget do remove it
                  once you do not need it anymore.
                */

                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            }
        });
    </script>
{/block}