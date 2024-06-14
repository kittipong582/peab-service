<?php include('header.php'); 
$service_id = mysqli_real_escape_string($connect_db, $_POST['service_id']);
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>การบริการ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ประเภทการบริการ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
        <label>ประเภทการบริการ</label>
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd('<?php echo $service_id ?>');">
                    <i class="fa fa-plus"></i> เพิ่มการบริการ
                </button>
            </div>
        </div>
        <input type="hidden" id='service_id' name='service_id' value="<?php echo $service_id ?>">
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

    $.ajax({

        url: "ajax/open_jop_service/GetTable.php",

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

function ModalAdd(service_id) {

    $.ajax({
        type: 'POST',
        url: "ajax/open_jop_service/ModalAdd.php",
        data: {service_id:service_id},
        dataType: "html",
        success: function(response) {
            $("#modal .modal-content").html(response);
            $("#modal").modal('show');
        }
    });
}

function Add() {

    const service_name = $("#service_name").val();
    const unit = $("#unit").val();
    const unit_cost = $("#unit_cost").val();
   

    if (service_name == ""||unit == ""||unit_cost == "") {
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
            url: "ajax/open_jop_service/Add.php",
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

function ModalEdit(service_id) {
    $.ajax({
        type: "post",
        url: "ajax/open_jop_service/ModalEdit.php",
        data: {service_id:service_id},
        dataType: "html",
        success: function (response) {
            $("#modal .modal-content").html(response);
            $("#modal").modal('show');
        }
    });
}

function Update() {

    const service_name = $("#service_name").val();
    const unit = $("#unit").val();
    const unit_cost = $("#unit_cost").val();
    
    if (service_name == ""||unit == ""||unit_cost == "") {
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
            url: "ajax/open_jop_service/Update.php",
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

function ChangeStatus(button,service_id) {
    $.ajax({
        type: "post",
        url: "ajax/open_jop_service/ChangeStatus.php",
        data: {service_id:service_id},
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