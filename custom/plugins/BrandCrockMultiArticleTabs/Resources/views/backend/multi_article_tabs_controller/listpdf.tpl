{extends file="parent:backend/_base/layout.tpl"}
{block name="content/main"}
    <div class="table-responsive">
        <table id="pdfTable" class="table table-striped">
            <thead>
            <tr>
                <th>Ordernumber</th>
                <th>PDF Name</th>
                <th>File Path</th>
                <th>Status</th>
                <th>Position</th>
                <th>language</th>
                <th style="text-align:right">Action</th>

                <th></th>

            </tr>
            </thead>
            <tbody>
            {if $message}
                <tr>
                    <td colspan="9">{$message}</td>
                </tr>
            {else}

                {foreach $PdfFetchData as $PdfData}
                    <tr>
                        <td>{$PdfData.ordernumber}</td>
                        <td>{$PdfData.name}</td>
                        <td>{$PdfData.pdf_file}</td>
                        <td>{if {$PdfData.active}==1}Active{else}Inactive{/if}</td>
                        <td>{$PdfData.position}</td>
                        <td>{$PdfData.language}</td>

                        <form class="form-horizontal"
                              action='{url controller="MultiArticleTabsController" action="editpdf" __csrf_token=$csrfToken}'>
                            <input type="hidden" name="pdfid" value="{$PdfData.id}"/>
                            <td style="text-align:right">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </td>
                        </form>

                        <td style="text-align:right">
                            <a href="#deletePdfModal-{$PdfData.id}" class="delete btn btn-warning" data-toggle="modal">Delete</a>
                        </td>
                        <div id="deletePdfModal-{$PdfData.id}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal"
                                          action='{url controller="MultiArticleTabsController" action="deletepdf" __csrf_token=$csrfToken}'>
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete PDF Data</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete Data?</p>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                   value="Cancel">
                                            <input type="submit" class="btn btn-danger" value="Delete">
                                            <input type="hidden" name="pdfid" value="{$PdfData.id}"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </tr>
                {/foreach}
            {/if}

            </tbody>

        </table>
    </div>
    <style>

        /* Modal styles */
        .modal .modal-dialog {
            max-width: 400px;
        }

        .modal .modal-header, .modal .modal-body, .modal .modal-footer {
            padding: 20px 30px;
        }

        .modal .modal-content {
            border-radius: 3px;
        }

        .modal .modal-footer {
            background: #ecf0f1;
            border-radius: 0 0 3px 3px;
        }

        .modal .modal-title {
            display: inline-block;
        }

        .modal .form-control {
            border-radius: 2px;
            box-shadow: none;
            border-color: #dddddd;
        }

        .modal textarea.form-control {
            resize: vertical;
        }

        .modal .btn {
            border-radius: 2px;
            min-width: 100px;
        }

        .modal form label {
            font-weight: normal;
        }
    </style>
{/block}