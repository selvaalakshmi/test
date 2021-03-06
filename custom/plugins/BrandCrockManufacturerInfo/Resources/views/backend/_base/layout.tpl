<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/jquery.dataTables.min.css"}"><!--for add data tables -->

</head>
<body role="document" style="padding-top: 80px">

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id="test" class="navbar-brand" href="#">Manufacturer Info</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                 <li{if {controllerAction} === 'index'} class="active"{/if}><a href="{url controller="ManufacturerInfoController" action="index" __csrf_token=$csrfToken}">Homepage</a></li>
                <li{if {controllerAction} === 'listmanufacturer'} class="active"{/if}><a href="{url controller="ManufacturerInfoController" action="listmanufacturer" __csrf_token=$csrfToken}">Manufacturer Info List</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container theme-showcase" role="main">
    {block name="content/main"}{/block}
</div> <!-- /container -->

<script type="text/javascript" src="{link file="backend/base/frame/postmessage-api.js"}"></script>
<script type="text/javascript" src="{link file="backend/_resources/js/jquery-2.1.4.min.js"}"></script>
<script type="text/javascript" src="{link file="backend/_resources/js/bootstrap.min.js"}"></script>

<script type="text/javascript" src="{link file="backend/_resources/js/jquery.dataTables.min.js"}"></script><!-- data tables -->


{block name="content/layout/javascript"}
<script type="text/javascript">
        $(document).ready(function() {
        $('#bcmiTable').DataTable();
    });
        $(document).ready(function() {
            $('#milistTable').DataTable();
        });

</script>
{/block}
{block name="content/javascript"}{/block}
</body>
</html>