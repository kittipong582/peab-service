<?php include('header.php'); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ยี่ห้อ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ยี่ห้อ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <h5>รายชื่อยี่ห้อ</h5>
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd();">
                    <i class="fa fa-plus"></i> เพิ่มยี่ห้อ
                </button>
            </div>
        </div>
        <div class="ibox-content" id="show_data">

        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
    var brand_id = $('#brand_id').val();
    $.ajax({
        type: 'POST',
        url: "ajax/poduct_brand/GetTable.php",
        data: {brand_id:brand_id},
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
        url: "ajax/poduct_brand/ModalAdd.php",
        dataType: "html",
        success: function(response) {
            $("#modal .modal-content").html(response);
            $("#modal").modal('show');
        }
    });
}

function Add() {

    const brand_name = $("#brand_name").val();

    if (brand_name == "") {
        swal("", "ไม่สามารถทำรายการได้กรุณากรอกชื่อประเภทอะไหล่", "error");
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
            url: "ajax/poduct_brand/Add.php",
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

function ModalEdit(brand_id) {
    $.ajax({
        type: "post",
        url: "ajax/poduct_brand/ModalEdit.php",
        data: {brand_id:brand_id},
        dataType: "html",
        success: function (response) {
            $("#modal .modal-content").html(response);
            $("#modal").modal('show');
        }
    });
}

function Update() {

    const brand_name = $("#brand_name").val();

    if (brand_name == "") {
        swal("", "ไม่สามารถทำรายการได้กรุณากรอกชื่อประเภทอะไหล่", "error");
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
            url: "ajax/poduct_brand/Update.php",
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

function ChangeStatus(button,brand_id) {
    $.ajax({
        type: "post",
        url: "ajax/poduct_brand/ChangeStatus.php",
        data: {brand_id:brand_id},
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

</script>