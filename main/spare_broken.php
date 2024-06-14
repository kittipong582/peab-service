<?php include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$manual_sub_id = $_GET['id'];
$manual_id = $_GET['manual_id'];

$sql_head = "SELECT * FROM tbl_manual_basic_sub WHERE  manual_sub_id = '$manual_sub_id'";
$rs_head = mysqli_query($connect_db, $sql_head);
$row_head = mysqli_fetch_assoc($rs_head);

$sql_head2 = "SELECT * FROM tbl_manual_basic_sub WHERE  manual_id = '$manual_id'";
$rs_head2 = mysqli_query($connect_db, $sql_head2);
$row_head2 = mysqli_fetch_assoc($rs_head2);
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
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $row_head['manual_name']; ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="Product_model_manual.php?id=<?php echo $model_id ?>&#tab-4"
                    onclick="GetTableBasic();">การแก้ไขเบื้องต้น</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo $row_head2['manual_sub_name']; ?></strong>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo $row_head['manual_sub_name']; ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">

            <!-- <div class="ibox-tools">
                <button class="btn btn-xs btn-info btn-block" data-width="70%" type="button" onclick="ModalAdd();"
                    value="">เพิ่มคู่มือ</button>
            </div> -->
        </div>
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
        <div class="ibox-content" id="show_data_broken">

        </div>
    </div>
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="modal fade" id="mymodal">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include ('import_script.php'); ?>
<script>
    $(document).ready(function () {
        GetTableBroken();
        $('#Loading').hide();
        $(".select2").select2({
            width: "75%"
        });
    });


    function GetTableBroken() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_sub_id = urlParams.get('id');

        $.ajax({
            type: "POST",
            url: "ajax/manual_basic_sub/GetTableBroken.php",
            data: {
         
                manual_sub_id: manual_sub_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_data_broken").html(response);
                $('#table_broken').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }


    function ModalAdd() {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('id');
        console.log(manual_id)
        $.ajax({
            url: "ajax/manual_basic_sub/ModalAdd.php",
            data: {
                manual_id: manual_id
            },
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function ModalAddbroken(manual_sub_id) {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('id');
        const model_id = urlParams.get('model_id');
        console.log(model_id);
        console.log(manual_sub_id);
        console.log(manual_id);
        $.ajax({
            url: "ajax/manual_basic_sub/ModalAddbroken.php",
            data: {
                manual_id: manual_id,
                manual_sub_id: manual_sub_id,
                model_id: model_id
            },
            type: "POST",
            success: function (response) {
                $("#mymodal .modal-content").html(response);
                $("#mymodal").modal('show');
                // $(".select2").select2({
                //     width: "100%"
                // });
            }
        });
    }


    function ModalEdit(manual_sub_id) {

        $.ajax({
            type: "post",
            url: "ajax/manual_basic_sub/ModalEdit.php",
            data: {
                manual_sub_id: manual_sub_id
            },
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
            }
        });
    }

    function Add() {

        var manual_name = $('#manual_name').val();
        var formData = new FormData($("#form-add")[0]);

        if (manual_name == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
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
                type: 'POST',
                url: 'ajax/manual_basic_sub/Add.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'กรุณณาติดต่อเจ้าหน้าที่',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });

                        GetTable();
                    }
                }
            })
        });
    }


    function Update() {

        var manual_name = $('#manual_name').val();
        var formData = new FormData($("#form-edit")[0]);

        if (manual_name == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
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
                type: 'POST',
                url: 'ajax/manual_basic_sub/Update.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });

                        GetTable();
                    }
                }
            })
        });
    }
    function Get_spare_type() {
        var spare_type_id = $('#spare_type_id').val();
        $.ajax({
            type: 'POST',
            url: "ajax/manual_basic_sub/Get_spare_type.php",
            data: {
                spare_type_id: spare_type_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_select").html(response);
                $('#Loading').hide();
            }
        });
    }

    function Add_broken() {
        var manual_name = $('#manual_name').val();
        var formData = new FormData($("#form-add-broken")[0]);


        console.log(spare_part_id);

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
                type: 'POST',
                url: 'ajax/manual_basic_sub/Add_broken.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'กรุณณาติดต่อเจ้าหน้าที่',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#mymodal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                    }
                }
            });
        });
    }

</script>