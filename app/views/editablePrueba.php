<html lang="en"><head>
<meta charset="utf-8">
<meta name="author" content="Vitaliy Potapov">
<meta http-equiv="cache-control" content="max-age=0">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">

<title>X-editable Demo</title>

<style type="text/css">       
    #comments:hover {
        background-color: #FFFFC0;
        cursor: text; 
    }
</style>

<script>
	var f = 'bootstrap3';
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- x-editable (bootstrap 3) -->
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

 <style type="text/css">
            body {
                padding-top: 50px;
                padding-bottom: 30px;
            }
            
            table.table > tbody > tr > td {
                height: 30px;
                vertical-align: middle;
            }
        </style>         

    <style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
.en-markup-crop-options {
    top: 18px !important;
    left: 50% !important;
    margin-left: -100px !important;
    width: 200px !important;
    border: 2px rgba(255,255,255,.38) solid !important;
    border-radius: 4px !important;
}

.en-markup-crop-options div div:first-of-type {
    margin-left: 0px !important;
}
</style></head>

    <body class="wysihtml5-supported"> 

        <div style="width: 80%; margin: auto;"> 
            <h1>X-editable Demo</h1>
            <hr>

            <h2>Settings</h2>
             <form method="get" id="frm" class="form-inline" action="demo.html">
                
                <label>
                    <span>Form style:</span>
                    <select id="f" class="form-control">
                        <option value="bootstrap3">Bootstrap 3</option>
                        <option value="bootstrap2">Bootstrap 2</option>
                        <option value="jqueryui">jQuery UI</option>
                        <option value="plain">Plain</option>
                    </select>
                </label>

                <label style="margin-left: 30px">Mode:
                    <select name="c" id="c" class="form-control">
                        <option value="popup">Popup</option>
                        <option value="inline">Inline</option>
                    </select>
                </label>

                <button type="submit" class="btn btn-primary" style="margin-left: 30px">refresh</button>
            </form>

            <hr>

            <h2>Example</h2>   
            <div style="float: right; margin-bottom: 10px">
            <label style="display: inline-block; margin-right: 50px"><input type="checkbox" id="autoopen" style="vertical-align: baseline">&nbsp;auto-open next field</label>
            <button id="enable" class="btn btn-default">enable / disable</button>
            </div>
            <p>Click to edit</p>
            <table id="user" class="table table-bordered table-striped" style="clear: both">
                <tbody> 
                    <tr>         
                        <td width="35%">Simple text field</td>
                        <td width="65%"><a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username" class="editable editable-click" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);">whatttatata</a></td>
                    </tr>
                    <tr>         
                        <td>Empty text field, required</td>
                        <td><a href="#" id="firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname" class="editable editable-click editable-empty">Empty</a></td>
                    </tr>

                </tbody>
            </table>
</body></html>