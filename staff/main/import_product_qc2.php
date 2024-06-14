<?php include('header2.php'); ?>
<style>
    .classmodal1 {
        max-width: 1000px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการสินค้านำเข้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>รายการสินค้านำเข้า</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="m-3">
    <button type="button" class="btn btn-xs btn-primary w-100" onclick="ModalAdd();"><i class="fa fa-plus"></i>
        เพิ่มสินค้า QC</button>
</div>
<div class="ibox-content mt-3" id="show_data"></div>

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
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModal"></div>
        </div>
    </div>
</div>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {
        GetTable();
    });

    function GetTable() {
        $.ajax({
            url: "ajax/import_product_qc/GetTable.php",
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function ImportFile() {

        let file_upload = $('#file_upload').val();
        if (file_upload == "") {
            swal({
                title: 'Notification',
                text: 'Please select the import file.',
                type: "warning",
                showConfirmButton: false
            });
            setTimeout(function() {
                swal.close();
            }, 1500);
            return false;
        }
        swal({
            title: "Confirm import data ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#1AB394",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        }, function() {
            $(".confirm").prop('disabled', true);
            let myForm = document.getElementById('form_import');
            let formData = new FormData(myForm);
            $.ajax({
                url: 'ajax/import_product_qc/Import.php',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function(data) {
                    $(".confirm").prop('disabled', false);
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        GetTable(false, true);
                        swal({
                            title: "Notification",
                            text: "Import data successful.",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 2000);
                        if (data.fail > 0) {
                            window.open('../upload/excel/' + data.file, '_blank');
                        }
                    } else if (data.result == 0) {
                        $('#modal').modal('hide');
                        swal({
                            title: "Notification",
                            text: data.msg,
                            type: "error",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 2000);
                        if (data.fail > 0 || data.duplicate > 0) {
                            window.open('../upload/excel/' + data.file, '_blank');
                        }
                    } else if (data.result == 9) {
                        swal({
                            title: "Notification",
                            text: "Session expired.",
                            type: "error",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            localStorage.clear();
                            window.location.assign("../index.php");
                            swal.close();
                        }, 2000);
                    } else {
                        swal({
                            title: "Notification",
                            text: "Unable to contact the server. Please try again.",
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                    $("#showModal").LoadingOverlay("hide", true);
                }
            });
        });
    }

    function ImportData() {
        $.ajax({
            type: "post",
            url: "ajax/import_product_qc/FormImport.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });

    }

    function readURLxlsx(input, value, show_position) {
        let fty = ["xlsx", "xls"];
        let permiss = 0;
        let file_type = value.split('.');
        file_type = file_type[file_type.length - 1];
        if (jQuery.inArray(file_type, fty) !== -1) {
            $(show_position).html(input.value.replace("C:\\fakepath\\", ''));
        } else if (value == "") {
            $(show_position).html("Select file...");
            $(input).val("");
        } else {
            swal({
                title: "Notification",
                text: "Uploads are limited to files with extensions (.xlsx, .xls) only.",
                type: "warning",
                showConfirmButton: false
            });
            $(show_position).html("Select file...");
            $(input).val("");
            setTimeout(function() {
                swal.close();
            }, 1500);
            return false;
        }
    }

    function ModalEdit() {
        $.ajax({
            type: "post",
            url: "ajax/import_product_qc/ModalEdit.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });

    }

    
    function ModalAdd() {
        $.ajax({
            type: "post",
            url: "ajax/import_product_qc/Modaladd.php",
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });

    }
    
    function Delete_lot(lot_id) {
        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type: "POST",
                url: "ajax/import_product_qc/delete.php",
                data: {
                    lot_id: lot_id
                },
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'ลบข้อมูลสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }, function () {
                            GetTable()
                            swal.close();
                            $("#Modal").modal('hide');
                        });
                    } else if (data.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
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
        })
    }
    function AddList() {
        var ref_number = $("#ref_number").val();
        var model_code = $("#model_code").val();
        var lot_no = $("#lot_no").val();
        var quantity = $("#quantity").val();

        if (ref_number == "" || model_code == "" || lot_no == "" || quantity == "") {
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

            let myForm = document.getElementById('frm_add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/import_product_qc/AddList.php",
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
</script>