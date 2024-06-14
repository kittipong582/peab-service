<?php
session_start();
include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id;

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>คิว</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>คิว</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <form id="form-add" method="POST" enctype="multipart/form-data">
        <div class="row">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">
        </div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox">
                        <div class="ibox-title">
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <strong>ค้นหาจาก</strong>
                                    <font color="red">**</font>
                                    <select name="search_type" id="search_type" style="width: 100%;"
                                        class="form-control select2 mb-3 ">
                                        <option value="2">ชื่อลูกค้า/เบอร์โทร </option>
                                        <option value="3">รหัสสาขา/ชื่อสาขา </option>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <?php

                                    $sql_area = "SELECT * FROM tbl_zone_oh WHERE active_status = 1";
                                    $res_area = mysqli_query($connection, $sql_area) or die($connection->error);

                                    ?>
                                    <strong>ภาค</strong>
                                    <font color="red">**</font>
                                    <select name="area_id" id="area_id" style="width: 100%;" class="form-control select2 mb-3 ">
                                        <option value="">กรุณาเลือก</option>
                                        <?php while ($row_area = mysqli_fetch_assoc($res_area)) { ?>
                                            <option value="<?php echo $row_area['area_id'] ?>">
                                                <?php echo $row_area['area_name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <strong></strong><br>
                                    <div class="input-group">
                                        <input type="text" id="search_value" name="search_value" class="form-control">
                                        <span class="input-group-append">
                                            <button type="button" id="btn_search_PM" class="btn btn-primary"
                                                onclick="ModalSearch()"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <strong>ข้อมูลสาขา</strong>
                                    <input type="hidden" id="customer_branch_id" name="customer_branch_id">
                                    <label for="">รหัสสาขา</label>
                                    <input type="text" name="branch_code" id="branch_code" class="form-control"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <label for="">ชื่อลูกค้า</label>
                                    <input type="hidden" id="customer_id" name="customer_id">
                                    <input type="text" name="customer_name" id="customer_name" class="form-control"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <label for="">ชื่อสาขา</label>
                                    <input type="text" name="branch_name" id="branch_name" class="form-control"
                                        readonly>
                                </div>
                                <div class="col-2 mt-2">
                                    <br>
                                    <button class="btn btn-primary w-100" type="button" id="submit"
                                        onclick="Submit()">เพิ่มคิว</button>
                                </div>
                                <div class="col-2 mt-2">
                                    <br>
                                    <button class="btn btn-primary w-100" type="button" id=""
                                        onclick="ImportData()">import</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ibox-content" id="show_queue">

                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModal"></div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function () {
        GetQueue();

        $(".select2").select2();
    });

    function GetQueue() {
        var search_type = $('#search_type').val();
        var search_value = $('#search_value').val();
        $.ajax({
            type: "POST",
            url: "ajax/customer_queue/get_queue.php",
            data: {
                search_type: search_type,
                search_value: search_value
            },
            dataType: "html",
            success: function (response) {
                $("#show_queue").html(response);
                $('#tbl_queue').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function ModalSearch() {
        let search_type = $("#search_type").val();
        let search_value = $("#search_value").val();
        if (search_value == '') {
            $("#search_value").focus();
            return false;
        }
        $("#myModal").modal("show");
        $.ajax({
            type: "POST",
            url: "ajax/customer_queue/modal_search.php",
            data: {
                search_type: search_type,
                search_value: search_value
            },
            dataType: "html",
            success: function (response) {
                $("#showModal").html(response);
            }
        });
    }



    function Submit() {
        var search_type = $("#search_type").val();

        if (search_type == "") {
            swal({
                title: 'กรุณากรอกข้อมูล',
                text: '',
                type: 'warning',
                showConfirmButton: false,
                timer: 1000
            }, function () {
                swal.close()

            });

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
            let formData = new FormData($("#form-add")[0]);
            $.ajax({
                type: "POST",
                url: "ajax/customer_queue/Add_queue.php",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // เพิ่มการเคลียร์ input fields ที่ต้องการ

                        $("#customer_branch_id").val('');
                        $("#search_value").val('');
                        $("#branch_code").val('');
                        $("#customer_id").val('');
                        $("#customer_name").val('');
                        $("#branch_name").val('');
                        GetQueue();

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
        });
    }

    function Delete_queue(customer_branch_id) {
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
            $.ajax({
                type: "POST",
                url: "ajax/customer_queue/Delete_queue.php",
                data: {
                    customer_branch_id: customer_branch_id
                },
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'ลบคิวงานสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        GetQueue();
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
            setTimeout(function () {
                swal.close();
            }, 1500);
            return false;
        }
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
            setTimeout(function () {
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
        }, function () {
            $(".confirm").prop('disabled', true);
            let myForm = document.getElementById('form_import');
            let formData = new FormData(myForm);
            $.ajax({
                url: 'ajax/customer_queue/import.php',
                type: 'POST',
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function (data) {
                    $(".confirm").prop('disabled', false);
                    if (data.result == 1) {
                        $('#myModal').modal('hide');
                        GetQueue(false, true);
                        swal({
                            title: "บันทึกสำเร็จ",
                            text: "Import data successful.",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        }, 2000);

                    } else if (data.result == 0) {
                        $('#myModal').modal('hide');
                        swal({
                            title: "Notification",
                            text: data.msg,
                            type: "error",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        }, 2000);

                    } else if (data.result == 9) {
                        swal({
                            title: "Notification",
                            text: "Session expired.",
                            type: "error",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
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
                }
            });
        });
    }

    function ImportData() {
        $.ajax({
            type: "post",
            url: "ajax/customer_queue/FormImport.php",
            dataType: "html",
            success: function (response) {
                $("#myModal .modal-content").html(response);
                $("#myModal").modal('show');
            }
        });

    }

    function Modal_edit(queue_id) {
        $("#myModal").modal('show');
        $.ajax({
            type: "post",
            url: "ajax/customer_queue/Modal_edit.php",
            data: {
                queue_id: queue_id
            },
            dataType: "html",
            success: function (response) {
                $("#showModal").html(response);

                $(".select2").select2();
            }
        });
    }

    function Update_Zone() {
        var area_id = $('#area_id').val();

        if (area_id == "") {
            swal({
                title: 'กรุณากรอกข้อมูล',
                text: '',
                type: 'warning',
                showConfirmButton: false,
                timer: 1000
            }, function () {
                swal.close()

            });

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
            let formData = new FormData($("#form_edit")[0]);
            $.ajax({
                type: "POST",
                url: "ajax/customer_queue/Update_Zone.php",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $("#myModal").modal('hide');
                        GetQueue();

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
        });
    }

</script>