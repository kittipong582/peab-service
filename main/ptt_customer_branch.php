<?php
    include('header.php');
    include("../../config/main_function.php");
    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>PTT customer branch</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="#">PTT customer branch</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <h5>รายการ Test</h5>
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd()">
                    <i class="fa fa-plus"></i> เพิ่ม
                </button>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>ค้นหาจาก</label>
                        <select class="form-control select2" id="search_opt" name="search_opt" data-width="100%">
                            <option value="1">หมายเลข QR Code</option>
                            <option value="2">รหัสสาขา</option>
                            <option value="3">ชื่อ ลูกค้า / สาขา</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <br>
                    <div class="input-group">
                        <input type="text" id="search" name="search" class="form-control">
                        <button type="button" class="btn btn-primary" onclick="GetTable()"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div id="loading">
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="showData"></div>
        </div>
    </div>
</div>

<!-- addmodal -->
<div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function () { 
        $("#loading").hide();
    });
    $(".select2").select2({
        width: "75%"
    });
    function GetTable() { 
        $("#loading").show();
        $("#showData").hide();
        $("#showData").html('');

        let search = $("#search").val();
        let search_opt = $("#search_opt").val();
        console.log(search_opt);
        $.ajax({
            type: "POST",
            url: "ajax/ptt_customer_branch/get_table.php",
            dataType: "html",
            data: {
                search_opt: search_opt,
                search: search
            },
            success: function (response) {
                $("#showData").html(response);
                $("#loading").hide();
                $("#showData").show();
                $("table").DataTable({
                    pageLength: 25,
                    responsive: true
                });
            },error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect. Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error. ' + jqXHR.responseText;
                    }
                swal({
                    title: "แจ้งเตือน",
                     text: "พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ" + msg,
                     type: "error",
                     showConfirmButton: true
                 });
            }
        });
    }
    function ModalAdd() { 
        $("#modal").modal("show");
        $.ajax({
            type: "POST",
            url: "ajax/ptt_customer_branch/modal_add.php",
            dataType: "html",
            success: function (response) {
                $("#show_modal").html(response);
            }
        });
     }
</script>
