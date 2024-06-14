<?php include('header.php'); 
$brand_id = $_GET['id'];?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการรุ่น</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>รายการรุ่น</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <h5>รายชื่อรุ่น</h5>
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd('<?php echo $brand_id ?>');">
                    <i class="fa fa-plus"></i> เพิ่มรุ่น
                </button>
            </div>
        </div>
        <input type="hidden" id='brand_id' name='brand_id' value="<?php echo $brand_id ?>">
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
        url: "ajax/product_model/GetTable.php",
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

function ModalAdd(brand_id) {

    $.ajax({
        type: 'POST',
        url: "ajax/product_model/ModalAdd.php",
        data: {brand_id:brand_id},
        dataType: "html",
        success: function(response) {
            $("#modal .modal-content").html(response);
            $("#modal").modal('show');
        }
    });
}

function Add() {

    const model_name = $("#model_name").val();
   

    if (model_name == "") {
        swal("", "ไม่สามารถทำรายการได้กรุณากรอกข้อมูลให้ครบถ้วน", "error");
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
            url: "ajax/product_model/Add.php",
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

function ModalEdit(model_id) {
    $.ajax({
        type: "post",
        url: "ajax/product_model/ModalEdit.php",
        data: {model_id:model_id},
        dataType: "html",
        success: function (response) {
            $("#modal .modal-content").html(response);
            $("#modal").modal('show');
        }
    });
}

function Update() {

    const model_name = $("#model_name").val();
    
    if (model_name == "") {
        swal("", "ไม่สามารถทำรายการได้กรุณากรอกข้อมูลให้ครบถ้วน", "error");
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
            url: "ajax/product_model/Update.php",
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

function ChangeStatus(button,model_id) {
    $.ajax({
        type: "post",
        url: "ajax/product_model/ChangeStatus.php",
        data: {model_id:model_id},
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

// function setUserLevel(user_level) {
//     if (user_level == "" || user_level == 4) {
//         $("#select_branch").hide();
//     } else {
//         $("#select_branch").show();
//     }
// }


</script>