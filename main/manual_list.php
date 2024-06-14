<?php include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql_brand = "SELECT * FROM tbl_product_brand WHERE active_status = 1 ORDER BY brand_code ASC";
$rs_brand = mysqli_query($connect_db, $sql_brand);



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
        <h2>คู่มือ</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>

            <li class="breadcrumb-item active">
                <strong>รายการคู่มือ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">

            <!-- <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>แบรนด์</label>
                        <select class="form-control select2" id="search_brand" name="search_brand" data-width="100%" onchange="GetModel(this.value)">
                            <option value="">เลือกแบรนด์</option>
                            <option value="0">ไม่ระบุ</option>
                            <?php while ($row_brand = mysqli_fetch_assoc($rs_brand)) { ?>
                                <option value="<?php echo $row_brand['brand_id'] ?>"><?php echo $row_brand['brand_code'] . " - " . $row_brand['brand_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group" id="point_model">
                        <label>โมเดล</label>
                        <select class="form-control select2" id="search_model" name="search_model" data-width="100%">
                            <option value="">เลือกโมเดล</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>ค้นหาจาก</label>
                        <select class="form-control select2" id="search_type" name="search_type" data-width="100%">
                            <option value="1">serial no </option>
                            <option value="2">รหัสสาขา </option>
                            <option value="3">ชื่อสาขา </option>
                            <option value="4">รหัสลูกค้า </option>
                            <option value="5">ชื่อลูกค้า </option>


                        </select>
                    </div>
                </div>


                <div class="col-3">
                    <div class="form-group">
                        <label>คำค้นหา</label>
                        <input type="text" class="form-control " id="text_search" name="text_search" data-width="100%">
                    </div>
                </div>

                <div class="col-2">
                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                    <div class="form-group">
                        <input class="btn btn-xs btn-info btn-block" data-width="70%" type="button" onclick="GetTable();" value="แสดงข้อมูล">

                    </div>
                </div>
            </div> -->
            <div class="ibox-tools">

                <input class="btn btn-xs btn-info btn-block" data-width="70%" type="button" onclick="ModalAdd();"
                    value="เพิ่มหัวข้อ">
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

<?php include ('import_script.php'); ?>
<script>
    $(document).ready(function () {
        GetTable();
        $('#Loading').hide();
        $(".select2").select2({
            width: "75%"
        });
    });


    function GetTable() {

        $('#Loading').show();

        $.ajax({
            type: "post",
            url: "ajax/manual_list/GetTable.php",
            dataType: "html",
            data: {

            },
            success: function (response) {
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
        $.ajax({
            url: "ajax/manual_list/ModalAdd.php",
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }


    function ModalEdit(manual_id) {

        $.ajax({
            type: "post",
            url: "ajax/manual_list/ModalEdit.php",
            data: {
                manual_id: manual_id
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


    function Changestatus(branch_id) {

        $.ajax({

            type: 'POST',

            url: 'ajax/branch/ChangeStatus.php',

            data: {

                branch_id: branch_id

            },

            dataType: 'json',

            success: function (data) {
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
        }, function () {

            $.ajax({
                type: 'POST',
                url: 'ajax/manual_list/Add.php',
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
                url: 'ajax/manual_list/Update.php',
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

    function Delete(manual_id) {

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

                url: 'ajax/manual_list/Delete.php',

                data: {

                    manual_id: manual_id

                },

                dataType: 'json',

                success: function (data) {


                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');
                        GetTable();
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: '',
                            type: 'warning'
                        });
                        return false;
                    }
                }

            });
        });

    }
</script>