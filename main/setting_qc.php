<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$type_id = mysqli_real_escape_string($connect_db, $_GET['type_id']);
?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>

<style>
    .line-vertical {
        border-left: 1px solid rgba(0, 0, 0, .1);
        ;
        height: 90%;
        position: absolute;
        left: 50%;

    }

    .hidden-color {
        display: none;
    }
    .modal-Xl{
        width: 800px;
        margin: auto;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ตั้งค่า QC</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ตั้งค่า QC</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">

            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd('<?php echo $type_id; ?>');">
                    <i class="fa fa-plus"></i> เพิ่ม
                </button>
            </div>
        </div>
        <div class="ibox-content" id="show_data">

        </div>
    </div>
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="modal fade" id="modalXl">
    <div class="modal-Xl modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function () {
        GetTable();
        $(".select2").select2({
            width: "75%"
        });
    });


    function GetTable() {

        $.ajax({
            type: "post",
            url: "ajax/setting_qc/GetTable.php",
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }



    function ModalAdd(type_id) {
        console.log(type_id)
        $.ajax({
            type: "POST",
            url: "ajax/setting_qc/ModalAdd.php",
            dataType: "html",
            data: {
                type_id: type_id
            },
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });

            }
        });
    }

    function ModalList(checklist_id) {
        console.log(checklist_id)
        $.ajax({
            type: "POST",
            url: "ajax/setting_qc/Modal_Add_List.php",
            dataType: "html",
            data: {
                checklist_id: checklist_id
            },
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });

            }
        });
    }


    function ModalEdit(type_id) {
        $.ajax({
            type: "POST",
            url: "ajax/product_type/ModalEdit.php",
            data: {
                type_id: type_id
            },
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({
                    width: "100%"
                });

            }
        });
    }

    // function ChangeStatus(button, type_id) {
    //     $.ajax({
    //         type: "post",
    //         url: "ajax/product_type/ChangeStatus.php",
    //         data: {
    //             type_id: type_id
    //         },
    //         dataType: "json",
    //         success: function (response) {

    //             if (response.result == 1) {

    //                 if (response.status == 1) {
    //                     $(button).addClass('btn-info').removeClass('btn-danger').html('กำลังใช้งาน');
    //                 } else if (response.status == 0) {
    //                     $(button).addClass('btn-danger').removeClass('btn-info').html('ยกเลิกใช้งาน');
    //                 }

    //             } else {
    //                 swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
    //             }

    //         }
    //     });
    // }
</script>