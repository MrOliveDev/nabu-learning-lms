<?php

// include( dirname( __FILE__ ) . '/../config/config.php' );
include( dirname( __FILE__ ) . './dbModel.php' );
include( dirname( __FILE__ ) . '/fileSearch.php' );
define('FABRIQUE_PRODUCTS_PATH', "/home/sites/default/www/export_online/");
define('PRODUCTS_FABRIQUE_PATH', "/home/sites/default/www/export_fabrique/products/");
define('FABRIQUE_API_PRODUCTS', '/home/sites/default/www/fabrique/api/datas/products/');
class openModel extends dbModel
{
    public function __construct()
    {
        parent::__construct();
    } // eo constructor
} // eo openModel class

$openModel  = new openModel;

$curso_sql = 'select * from tb_lesson';
$curso_result = $openModel->getDatas( $curso_sql );

$fileSearch = new fileSearch;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- META SECTION -->
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- END META SECTION -->

<!-- CSS INCLUDE -->
<link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"/>


<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> -->
<!-- EOF CSS INCLUDE -->
</head>
<body class="page-container-boxed">
<div class="page-content">

  <!-- PAGE CONTENT WRAPPER -->
  <div  style = "margin-top:150px;">
        <div class="row">
      <div class="col-md-12">

        <!-- START CHANNELS TABLE -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title">Nabu-learning FLV to MP4 Converter</h1>
          </div>
          <div class="panel-body">
            <table class="display" id = "table" style = "width:100%">
              <thead>
                <tr style = "text-align: center">
                  <th>COURSE ID</th>
                  <th>COURSE NAME</th>
                  <th>idFabrica</th>
                  <th>export_online(need converted/converted)</th>
                  <th>export_fabrique(need converted/converted)</th>
                  <th>fabrique_api(need converted/converted)</th>
                  <th style = "width: 440px;">ACTION</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    foreach($curso_result as $curso){
                ?>
                <tr style = "text-align: center">
                  <td style="cursor:pointer;"><?php echo $curso['id']; ?></td>
                  <td style="cursor:pointer;"><?php echo $curso['nome']; ?></td>
                  <td style="cursor:pointer;"><?php echo $curso['idFabrica']; ?></td>
                  <td style="cursor:pointer;" id = "online_<?php echo $curso['idFabrica']; ?>">
                  <?php
                    $fileSearch->initialize();
                    $fileSearch->listFolderFiles(FABRIQUE_PRODUCTS_PATH.$curso['idFabrica']);
                    echo count($fileSearch->flvArray).' / '.count($fileSearch->mp4Array);
                  ?>
                  </td>
                  <td style="cursor:pointer;" id = "fabrique_<?php echo $curso['idFabrica']; ?>">
                  <?php
                    $fileSearch->initialize();
                    $fileSearch->listFolderFiles(PRODUCTS_FABRIQUE_PATH.$curso['idFabrica']);
                    echo count($fileSearch->flvArray).' / '.count($fileSearch->mp4Array);
                  ?>
                  </td>
                  <td style="cursor:pointer; " id = "api_<?php echo $curso['idFabrica']; ?>">
                  <?php
                    $fileSearch->initialize();
                    $fileSearch->listFolderFiles(FABRIQUE_API_PRODUCTS.$curso['idFabrica']);
                    echo count($fileSearch->flvArray).' / '.count($fileSearch->mp4Array);
                  ?>
                  </td>
                  <td style="cursor:pointer; display: flex;">
                    <button type="button" class="btn btn-success" onclick="convertModal('<?php echo $curso['idFabrica']; ?>', 'online')" style = "margin-right:5px;">Convert Online</button>
                    <button type="button" class="btn btn-info" onclick="convertModal('<?php echo $curso['idFabrica']; ?>', 'fabrique')" style = "margin-right:5px;">Convert Fabrique</button>
                    <button type="button" class="btn btn-warning" onclick="convertModal('<?php echo $curso['idFabrica']; ?>', 'api')">Convert ApiProduct</button>
                  </td>
                </tr>
                <?php }
                ?>
              </tbody>
            </table>
          </div>

        </div>
        <!-- END CHANNELS TABLE-->
      </div>
    </div>

  </div>
  <!-- END PAGE CONTENT WRAPPER -->

</div>
<!-- END PAGE CONTAINER -->

<!-- MESSAGE BOX-->


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id = "exitBtn">&times;</button>
        <h4 class="modal-title">Convert Progress</h4>
      </div>
      <div class="modal-body">
        <div>
            <label for="comment">File List:</label>
            <textarea style = "height:100px; width:100%; resize: none; overflow-x: auto;" id="fileListBox"></textarea>
        </div>
        <div class="input-group" style = "margin-top: 10px;">
            <span class="input-group-addon" id="inputGroup-sizing-sm">Current File</span>
            <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id = "curFileName">
        </div>
        <div style = "text-align: center;" id = "loadingGIF">
            <img src = "loading.gif" style = "width:100px; height: 100px;">
        </div>
        <div style = "margin-top: 10px;">
            <label for="comment">Current File Progress:</label>
            <div class="progress">
              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
              aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:5%; min-width: 5%;" id = "currentProgress">
                0%
              </div>
            </div>
        </div>
        <div style = "margin-top: 10px;">
            <label for="comment">Total Progress:</label>
            <div class="progress">
              <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar"
              aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:5%; min-width: 5%;" id = "totalProgress">
                0%
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" onclick = "startConvert()" id = "startBtn">Start</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" id = "closeBtn">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- END PRELOADS -->

<!-- START SCRIPTS -->
<!-- START PLUGINS -->

<script type="text/javascript" src="js/jquery.min.js"></script>

<!-- <script type="text/javascript" src="js/general/jquery/dist/jquery.min.js"></script>  -->

<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- END PLUGINS -->

<!-- START THIS PAGE PLUGINS-->
<!-- <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>  -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<!-- <script type="text/javascript" src="js/demo_dashboard.js"></script>  -->

<script>
  $(document).ready(function(){

  var table = $('#table').DataTable( {
        responsive: true,
        "aoColumns":[
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
    ]
    } );
});

function convertModal(idFabrica, mode)
{
    var txt = $("#fileListBox");
    txt.val('');
    $("#currentProgress").css("width", "5%");
    $("#currentProgress").html("0%");
    $("#totalProgress").css("width", "5%");
    $("#totalProgress").html("0%");

    $.ajax({
        type: "POST",
        url: "./getList.php",
        data: {
            idFabrica: idFabrica,
            mode: mode
         },
        dataType: "json",
        success: function(fileList) {

            for(var i = 0; i < fileList.length; i ++)
                txt.val( txt.val() + fileList[i] + "\n");

            if(fileList.length == 0 || (fileList.length == 1 && fileList[0] == ""))
            {
                $("#currentProgress").css("width", "100%");
                $("#currentProgress").html("100%");
                $("#totalProgress").css("width", "100%");
                $("#totalProgress").html("100%");
                $("#startBtn").attr("disabled", true);
            }
            else
                $("#startBtn").attr("disabled", false);
        }

    });

    window.id = idFabrica;
    window.md = mode;
    $('#loadingGIF').hide();
    $('#myModal').modal({backdrop: 'static', keyboard: false});
}

async function startConvert()
{
    var lines = $('#fileListBox').val().split('\n');
    let errorFlag = false;
    if(lines[lines.length - 1] == "")
        lines.pop();
    if(lines.length == 0 || (lines.length == 1 && lines[0] == ""))
    {
        $("#currentProgress").css("width", "100%");
        $("#currentProgress").html("100%");
        $("#totalProgress").css("width", "100%");
        $("#totalProgress").html("100%");
    }
    else
    {
        $('#loadingGIF').show();
        $("#exitBtn").attr("disabled", true);
        $("#startBtn").attr("disabled", true);
        $("#closeBtn").attr("disabled", true);

        for(var i = 0;i < lines.length;i++){
            //code here using lines[i] which will give you each line
            //console.log(lines[i]);
            $("#curFileName").val(lines[i]);
            if(lines[i] != "")
            {
              let global_resolve = null;
              let isFinished = false;
              $("#currentProgress").css("width", "5%");
              $("#currentProgress").html("0%");
                $.ajax({
                    type: "POST",
                    url: "./convert.php",
                    data: {
                        file: lines[i],
                        type: 'mp4'
                     },
                    dataType: "json",
                    success: function(result) {
                      global_resolve();
                      isFinished = true;
                        console.log(result + ' finished');
                        $("#currentProgress").css("width", "100%");
                        $("#currentProgress").html("100%");
                    }
                });
                await new Promise((resolve, reject) => {
                  global_resolve = resolve;
                    function myUpdate() {
                          $.ajax({
                            type: "POST",
                            url: "./convert.php",
                            data: {
                                progress: 'progress'
                            },
                            //dataType: "json",
                            success: function(result) {
                                console.log(result);
                                if(result['result'] == 'success')
                                {
                                    $("#currentProgress").css("width", result['progress'] + "%");
                                    $("#currentProgress").html(result['progress'] + "%");
                                    //if (parseInt(result['progress']) >= 99) {
                                    //    resolve(true);
                                    //} else {
                                      if(!isFinished) {
                                        setTimeout(() => {
                                            myUpdate();
                                        }, 1000);
                                      }
                                    //}
                                }
                                else {
                                  if(result['result'] == 'failed')
                                  {
                                    var txt = $("#fileListBox");
                                    txt.val(txt.val() + lines[i] + "Failed\n");
                                    errorFlag = true;
                                  }
                                  resolve(true);
                                }
                            },
                            error: function(a,b,c){
                                reject(b);
                            }
                        });
                    }
                    myUpdate();
                });
            }

            //while(timer){console.log(timer);}
            $("#totalProgress").css("width", (i + 1) * 100 / lines.length + "%");
            $("#totalProgress").html(parseInt((i + 1) * 100 / lines.length) + "%(" + (i + 1) + " / " + lines.length + ")");
        }
        $('#loadingGIF').hide();
        $("#curFileName").val("");
        $("#exitBtn").attr("disabled", false);
        $("#startBtn").attr("disabled", true);
        $("#closeBtn").attr("disabled", false);
        $("#" + window.md + "_" + window.id).html("Converted");
        if(errorFlag)
          alert('There are some failed files while converting...');
    }
}

</script>

</body>
</html>
