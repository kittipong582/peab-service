<?php

include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$sql_team = "SELECT * FROM tbl_branch WHERE active_status = 1";
$result_team = mysqli_query($connect_db, $sql_team);

$sql_create = "SELECT * FROM tbl_user WHERE admin_status = 9";
$result_create = mysqli_query($connect_db, $sql_create);

$sql_group = "SELECT * FROM tbl_customer_group WHERE active_status = 1";
$res_group = mysqli_query($connect_db, $sql_group);


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>QR Code</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="job_list.php">QR Code</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <h5>รายการ QR Code</h5>
            <div class="ibox-tools">

                <!-- <a href="../../../print/print_qr_all.php" target="_blank"><button type="button" class="btn btn-xs btn-info"><i class="fa fa-print"></i> ปริ้นทั้งหมด</button> </a> -->
                <button type="button" class="btn btn-xs btn-info" onclick="GetModalPrint()"><i class="fa fa-print"></i> ปริ้นทั้งหมด</button>

                <button class="btn btn-xs btn-info" onclick="NewQrcode();">
                    <i class="fa fa-plus"></i> เพิ่ม QR Code
                </button>

                <button class="btn btn-xs btn-info" onclick="GetModalDownload();">
                    <i class="fa fa-download"></i> Download Qr Code
                </button>
            </div>

        </div>

        <div class="ibox-content">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>สถานะ</label>
                        <select class="form-control select2" id="status" name="status" data-width="100%">
                            <option value="x">ว่าง</option>
                            <option value="1">ลงทะเบียนแล้ว </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>กลุ่มลูกค้า</label>
                        <select class="form-control select2" id="customer_group" name="customer_group" data-width="100%">
                            <option value="x">ทั้งหมด</option>
                            <?php while ($row_group = mysqli_fetch_assoc($res_group)) { ?>
                                <option value="<?php echo $row_group['customer_group_id']; ?>"><?php echo $row_group['customer_group_name']; ?> </option>
                            <?php  } ?>
                            <option value="0">ไม่ระบุกลุ่ม</option>
                        </select>
                    </div>
                </div>

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
                <div id="Loading">
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
    $(document).ready(function() {
        GetTable()
    });

    $(".select2").select2({
        width: "75%"
    });

    function GetTable() {
        $("#Loading").show();
        $("#showData").hide();
        $("#showData").html('');

        let status = $("#status").val();
        let search = $("#search").val();
        let search_opt = $("#search_opt").val();
        console.log(search_opt);
        let customer_group = $("#customer_group").val();

        $.ajax({
            type: "POST",
            url: "ajax/qrcode_generate/get_table.php",
            data: {
                status: status,
                search: search,
                search_opt: search_opt,
                customer_group: customer_group
            },
            dataType: "html",
            success: function(response) {
                $("#showData").html(response);
                $("#Loading").hide();
                $("#showData").show();
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            },
            error: function(jqXHR, exception) {
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

    function GetModalPrint() {
        $("#modal").modal("show");
        $.ajax({
            type: "POST",
            url: "ajax/qrcode_generate/print_all.php",
            data: "data",
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
            }
        });
    }



    function NewQrcode() {
        $("#modal").modal("show");
        $.ajax({
            type: "POST",
            url: "ajax/qrcode_generate/modal_add.php",
            data: "data",
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
            }
        });

    }

    function AddQrcode() {
        let qty_qrcode = $("#qty_qrcode").val();
        if (qty_qrcode == "") {
            swal({
                title: 'แจ้งเตือน',
                text: 'กรุณากรอกจำนวน',
                type: 'warning',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            $.ajax({
                type: "POST",
                url: "ajax/qrcode_generate/add_qrcode.php",
                data: {
                    qty_qrcode: qty_qrcode
                },
                dataType: "json",
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }, function() {
                            swal.close();
                            GetTable()
                            $("#modal").modal('hide');
                        });
                    } else if (data.result == 9) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        }

    }

    function GetModalDownload() {
        $("#modal").modal("show");
        $.ajax({
            type: "POST",
            url: "ajax/qrcode_generate/modal_download.php",
            data: "data",
            dataType: "html",
            success: function(response) {
                $("#show_modal").html(response);
            }
        });
    }

    $.extend({
        redirectPost: function(location, args) {
            var form = '';
            $.each(args, function(key, value) {
                form += '<input type="hidden" name="' + key + '" value="' + value + '">';
            });
            $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body')
                .submit();
        }
    });

    function DownloadCheck() {
        let qty_download = $("#qty_download").val();
        if (qty_download == '') {
            swal({
                title: 'แจ้งเตือน',
                text: 'กรุณากรอกจำนวน',
                type: 'warning',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            $.ajax({
                type: "POST",
                url: "ajax/qrcode_generate/download_check.php",
                data: {
                    qty_download: qty_download
                },
                dataType: "json",
                success: function(data) {
                    if (data.result == 1) {
                        DownloadQrcode()
                        $("#show_modal").modal('hide');

                    } else if (data.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'QR Code ที่ว่างไม่เพียงพอ',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (data.result == 9) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                }
            });
        }
        // let redirect = 'ajax/qrcode_generate/download_check.php';
        // $.redirectPost(redirect, {
        //     qty_download: qty_download,
        // });

    }

    function DownloadQrcode() {
        let qty_download = $("#qty_download").val();
        let redirect = 'ajax/qrcode_generate/download_qrcode.php';
        $.redirectPost(redirect, {
            qty_download: qty_download,
        });
    }

    function PreviewQrcode(qr_no) {
        let redirect = '../../../print/print_qr.php?qr_id=';
        $.redirectPost(redirect, {
            qr_no: qr_no,
        });
    }
</script>