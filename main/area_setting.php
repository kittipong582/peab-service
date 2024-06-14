<!-- <meta http-equiv="pragma" content="no-cache" /> -->
<?php
include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12" style="margin-left: 20px;">
        <h2>ตั้งค่าเขต (OH)</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าหลัก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="area_setting.php">เขต (OH)</a>
            </li>

        </ol>
    </div>
</div>


<div id="wrapper">
    <!-- <div id="page-wrapper" class="gray-bg"> -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <label>เขต (OH)</label>
                        <div class="ibox-tools">
                            <button class="btn btn-xs btn-success" onclick="modal_add_zone();"><i
                                    class="fa fa-plus"></i> เพิ่มเขต (OH)</button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12 m-b-xs">
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
                                <div id="showTable">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModal"></div>
        </div>
    </div>
</div>

<?php include ('import_script.php'); ?>
<script>
    $(document).ready(function () {
        GetArea();
    });

    // function GetArea() {
    //     $("#showTable").load("ajax/area_setting/get_table.php", "data", function (response, status, request) {
    //         this; 
    //     });
    // }

    function GetArea() {
        $.ajax({
            type: 'POST',
            url: "ajax/area_setting/get_table.php",
            dataType: "html",
            success: function (response) {
                $("#showTable").html(response);
                $('#table_zone').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }

    function AddArea() {

        let formData = new FormData($("#form_add")[0]);
        var area_name = $('#area_name').val();

        if (area_name == "") {
            swal("", "กรุณากรอกข้อมูล", "error");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "ajax/area_setting/add_area.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                if (data.result == 1) {
                    swal({
                        title: 'บันทึกสำเร็จ',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }, function () {
                        GetArea();
                        swal.close();
                        $("#myModal").modal('hide');
                    });
                } else if (data.result == 0) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'เกิดข้อผิดพลาด กรุณาลองใหม่',
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
    // function modal_add_zone() {
    //     $('#myModal').modal('show');
    //     $('#showModal').load("ajax/area_setting/modal_add_zone.php");
    // }

    function modal_add_zone() {

        $.ajax({
            type: "post",
            url: "ajax/area_setting/modal_add_zone.php",
            dataType: "html",
            success: function (response) {
                $("#myModal .modal-content").html(response);
                $("#myModal").modal('show');
            }
        });
    }


    function ModalEdit(area_id) {

        $.ajax({
            type: "post",
            url: "ajax/area_setting/ModalEdit.php",
            data: {
                area_id: area_id
            },
            dataType: "html",
            success: function (response) {
                $("#myModal .modal-content").html(response);
                $("#myModal").modal('show');
            }
        });
    }


    function ChangeStatus(button, area_id) {
        $.ajax({
            type: "post",
            url: "ajax/area_setting/ChangeStatus.php",
            data: {
                area_id: area_id
            },
            dataType: "json",
            success: function (response) {

                if (response.result == 1) {

                    if (response.status == 1) {
                        $(button).addClass('btn-info').removeClass('btn-danger').html('กำลังใช้งาน');
                    } else if (response.status == 0) {
                        $(button).addClass('btn-danger').removeClass('btn-info').html('ยกเลิกใช้งาน');
                    }

                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });
    }



    function Update() {

        let formData = new FormData($("#form_edit")[0]);

        var area_name = $('#area_name').val();

        if (area_name == "") {
            swal("", "กรุณากรอกข้อมูล", "error");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "ajax/area_setting/Update.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                if (data.result == 1) {
                    swal({
                        title: 'บันทึกสำเร็จ',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }, function () {
                        GetArea();
                        swal.close();
                        $("#myModal").modal('hide');
                    });
                } else if (data.result == 0) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'เกิดข้อผิดพลาด กรุณาลองใหม่',
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
</script>