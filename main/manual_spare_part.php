<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$manual_id = $_GET['id'];
$model_id = $_GET['model_id'];
$sql_head = "SELECT * FROM tbl_spare_part_manual WHERE  manual_id = '$manual_id'";
$rs_head = mysqli_query($connect_db, $sql_head);
$row_head = mysqli_fetch_assoc($rs_head);


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
                <a href="Product_model_manual.php?id=<?php echo $model_id?>">คู่มือ</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo $row_head['manual_name']; ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">

            <div class="ibox-tools">

                <input class="btn btn-xs btn-info btn-block" data-width="70%" type="button" onclick="ModalAdd();" value="เพิ่มคู่มือ">
            </div>
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

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        GetTable();
        $('#Loading').hide();
        $(".select2").select2({
            width: "75%"
        });
    });


    function GetTable() {


        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('id');


        $('#Loading').show();

        $.ajax({
            type: "post",
            url: "ajax/manual_spare_part/GetTable.php",
            dataType: "html",
            data: {
                manual_id: manual_id
            },
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 50,
                    responsive: true,
                    "autoWidth": false
                });
                $('#Loading').hide();
            }
        });
    }


    function ModalAdd() {

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('id');
        $.ajax({
            url: "ajax/manual_spare_part/ModalAdd.php",
            data: {
                manual_id: manual_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }


    function ModalEdit(manual_sub_id) {

        $.ajax({
            type: "post",
            url: "ajax/manual_spare_part/ModalEdit.php",
            data: {
                manual_sub_id: manual_sub_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
            }
        });
    }


    function Changestatus(branch_id)

    {

        $.ajax({

            type: 'POST',

            url: 'ajax/branch/ChangeStatus.php',

            data: {

                branch_id: branch_id

            },

            dataType: 'json',

            success: function(data) {
                if (data.result == 1) {
                    GetTable();
                }
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
        }, function() {

            $.ajax({
                type: 'POST',
                url: 'ajax/manual_spare_part/Add.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
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
        }, function() {

            $.ajax({
                type: 'POST',
                url: 'ajax/manual_spare_part/Update.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
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
</script>