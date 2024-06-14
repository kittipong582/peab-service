<?php include('header.php'); ?>
<style>
    .classmodal1 {
        max-width: 1000px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รอบ(PM)</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>รอบ(PM)</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd();">
                    <i class="fa fa-plus"></i> ประเภทเครื่อง
                </button>
            </div>
        </div>
        <div class="ibox-content" id="show_data">

        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>


<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-lg modal-dialog-centered classmodal1" id="modal1" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>


<?php include('import_script.php'); ?>

<script>
    $(document).ready(function () {
        GetTable();
    });

    function GetTable() {
        $.ajax({
            url: "ajax/pm_setting/GetTable.php",
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            url: "ajax/pm_setting/ModalAdd.php",
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }


    function ModalEdit(pm_setting_id) {
        $.ajax({
            type: "POST",
            url: "ajax/pm_setting/ModalEdit.php",
            data: {
                pm_setting_id: pm_setting_id
            },
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }






    function Add() {

        var setting_name = $("#setting_name").val();

        var type_id = $("#type_id").val();

        if (setting_name == "" || type_id == "") {
            swal("", "ไม่สามารถทำรายการได้กรุณากรอกข้อมูลให้ครบ", "error");
            return false;
        }

        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function () {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/pm_setting/Add.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {


                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            GetTable();
                            $("#modal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function Delete_Pm(pm_setting_id) {
        swal({
            title: "แจ้งเตือน",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5564",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function () {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/pm_setting/Delete.php",
                data: {
                    pm_setting_id: pm_setting_id
                },
                beforeSend: function () {
                    swal({
                        title: "กำลังทำการบันทึก",
                        text: "กรุณารอสักครู่",
                        imageUrl: "ajax/ajax-loader.gif",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                },
                error: function (jqXHR, exception) {
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
                },
                success: function (response) {
                    if (response.result == 1) {
                        swal({
                            title: "แจ้งเตือน",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            GetTable();
                        });
                    } else if (response.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ',
                            type: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            });
        });
    }



    function Update() {

        const setting_name = $("#setting_name").val();

        if (setting_name == "") {
            swal("", "ไม่สามารถทำรายการได้กรุณากรอกรายละเอียด", "error");
            return false;
        }

        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function () {

            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/pm_setting/Update.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    console.log(response);

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();

                            $("#modal").modal('hide');
                            GetTable();
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }




</script>