<?php include('header.php'); ?>
<style>
.classmodal1 {
    max-width: 1000px;
    margin: auto;
}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>กลุ่มลูกค้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>กลุ่มลูกค้า</strong>
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
                    <i class="fa fa-plus"></i> เพิ่มกลุ่ม
                </button>
            </div>
        </div>
        <div class="ibox-content" id="show_data">

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
});

function GetTable() {
    $.ajax({
        url: "ajax/customer_group_type/GetTable.php",
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

function ModalAdd() {
    $.ajax({
        url: "ajax/customer_group_type/ModalAdd.php",
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


function ModalEdit(customer_group_type_id) {
    $.ajax({
        type: "POST",
        url: "ajax/customer_group_type/ModalEdit.php",
        data: {
            customer_group_type_id: customer_group_type_id
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


    var customer_group_type_name = $("#customer_group_type_name").val();


    if (customer_group_type_name == "") {
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
    }, function() {

        let myForm = document.getElementById('form-add');
        let formData = new FormData(myForm);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/customer_group_type/Add.php",
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


    var customer_group_type_name = $("#customer_group_type_name").val();

    if (customer_group_type_name == "") {
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
    }, function() {

        let myForm = document.getElementById('form-edit');
        let formData = new FormData(myForm);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/customer_group_type/Update.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {

                console.log(response);

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

function ChangeStatus(customer_group_type_id) {
    $.ajax({
        type: "post",
        url: "ajax/customer_group_type/ChangeStatus.php",
        data: {
            customer_group_type_id: customer_group_type_id,
        },
        dataType: "json",
        success: function(response) {

            GetTable();
        }
    });
}
</script>