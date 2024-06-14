<?php include('header.php'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12" style="margin-left: 20px;">
        <h2>ตั้งค่าวันหยุด</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าหลัก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="holiday_setting.php">ตั้งค่าวันหยุด</a>
            </li>

        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <div>
                <div id="show_select"></div>
            </div>

            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd();">
                    <i class="fa fa-plus"></i> เพิ่มวันหยุด
                </button>
            </div>
        </div>
        <div class="ibox-content" id="show_table">

        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
    $(document).ready(function() {
        GetTable();
        GetYear();
    });

    function GetYear() {
        $.ajax({
            url: "ajax/holiday_setting/GetYear.php",
            dataType: "html",
            success: function(response) {
                $("#show_select").html(response);
                $(".select2").select2({
                });
            }
        });
    }

    function GetTable() {
        $.ajax({
            url: "ajax/holiday_setting/GetTable.php",
            dataType: "html",
            success: function(response) {
                $("#show_table").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true,
                    ordering: false,
                });
            }
        });

    }

    function ModalSearch() {
        var year = $("#year").val();
        $.ajax({
            type: "POST",
            url: "ajax/holiday_setting/GetTable.php",
            data: {
                year: year
            },
            dataType: "html",
            success: function(response) {
                $("#show_table").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true,
                    ordering: false,
                });
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            type: "POST",
            url: "ajax/holiday_setting/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
            }
        });
    }

    function ModalEdit(holiday_id) {
        $.ajax({
            type: "POST",
            url: "ajax/holiday_setting/ModalEdit.php",
            data: {
                holiday_id: holiday_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
            }
        });
    }

    function Add() {
        var holiday_name = $("#holiday_name").val();
        var holiday_datetime = $("#holiday_datetime").val();
        var note = $("#note").val();

        if (holiday_name == "" || holiday_datetime == "") {
            swal("", "ไม่สามารถทำรายการไได้กรุณากรอกข้อมูลให้ครบ", "error");
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
        }, function() {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/holiday_setting/Add.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
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

    function Update() {
        var holiday_name = $("#holiday_name").val();
        var holiday_datetime = $("#holiday_datetime").val();
        var note = $("note").val();

        if (holiday_name == "" || holiday_datetime == "") {
            swal("", "ไม่สามารถทำรายการไได้กรุณากรอกข้อมูลให้ครบ", "error");
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
        }, function() {

            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/holiday_setting/Update.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.result != 0) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            GetTable();
                            $("#modal").modal('hide');
                        });
                    } else if (response.result == 0) {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function Delete(id) {
        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ed5564",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function() {

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/holiday_setting/Delete.php",
                data: {
                    holiday_id: id
                },
                success: function(response) {
                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            GetTable();
                        });
                    } else if (response.result == 0) {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }
                }
            });

        });
    }
</script>