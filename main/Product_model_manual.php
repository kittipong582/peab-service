<?php

include ('header.php');
include ("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$model_id = $_GET['id'];

$sql = "SELECT a.*,b.brand_name,b.brand_code FROM tbl_product_model a
LEFT JOIN tbl_product_brand b ON b.brand_id = a.brand_id 
WHERE model_id = '$model_id'";
$res = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_assoc($res);

?>

<style>
    .select2-dropdown {
        z-index: 9999;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการ Manual : <?php echo $row['model_code']; ?> ( <?php echo $row['model_name']; ?> )</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a
                    href="product_model.php?id=<?php echo $row['brand_id'] ?>"><?php echo $row['brand_code'] . " - " . $row['brand_name']; ?></a>
            </li>

            <li class="breadcrumb-item active">
                <strong>รายการ Manual</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="col-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active show" data-toggle="tab" href="#tab-1"> รายการ</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-2" onclick="GetTablePart();">อะไหล่ที่ใช้ได้</a>
                </li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-3" onclick="GetTableManual();"> คู่มือ</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-4" onclick="GetTableBasic();">การแก้ไขเบื้องต้น</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                    <div class="panel-body">
                        <div class="ibox">

                            <h3>รายการ</h3>
                            <div class="ibox-tools">
                                <button class="btn btn-info" onclick="ModalAdd('<?php echo $model_id ?>');">
                                    <i class="fa fa-plus"></i> เพิ่ม
                                </button>
                            </div>

                            <input type="hidden" id='model_id' name='model_id' value="<?php echo $model_id ?>">
                            <div class="ibox-content" id="show_data">
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <div class="ibox">

                            <h3>อะไหล่ที่ใช้ได้</h3>
                            <div class="ibox-tools">
                                <button class="btn btn-info" onclick="ModalAddPart('<?php echo $model_id ?>');">
                                    <i class="fa fa-plus"></i> เพิ่ม
                                </button>
                            </div>

                            <input type="hidden" id='model_id' name='model_id' value="<?php echo $model_id ?>">
                            <div class="ibox-content" id="show_data_part">
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" id="tab-3" class="tab-pane">
                    <div class="panel-body">
                        <div class="ibox">

                            <h3>คู่มือ</h3>
                            <div class="ibox-tools">
                                <button class="btn btn-info" onclick="ModalAddManual('<?php echo $model_id ?>');">
                                    <i class="fa fa-plus"></i> เพิ่ม
                                </button>
                            </div>

                            <input type="hidden" id='model_id' name='model_id' value="<?php echo $model_id ?>">
                            <div class="ibox-content" id="show_data_manual">
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" id="tab-4" class="tab-pane">
                    <div class="panel-body">
                        <div class="ibox">

                            <h3>การแก้ไขเบื้องต้น</h3>
                            <div class="ibox-tools">
                                <button class="btn btn-info" onclick="ModalAddBasic('<?php echo $model_id ?>');">
                                    <i class="fa fa-plus"></i> เพิ่ม
                                </button>
                            </div>

                            <input type="hidden" id='model_id' name='model_id' value="<?php echo $model_id ?>">
                            <div class="ibox-content" id="show_data_basic">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="modal fade" id="mymodal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include ('import_script.php'); ?>

<script>
    $(document).ready(function () {
        GetTable();
        GetTablePart();
        $('table').DataTable({
            pageLength: 25,
            responsive: true
        });
    });

    function GetTable() {
        var model_id = $('#model_id').val();
        $.ajax({
            type: 'POST',
            url: "ajax/product_model_manual/GetTable.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('#table_manual').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function GetTablePart() {
        var model_id = $('#model_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/product_model_manual/GetTableSparePartList.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_data_part").html(response);
                $('#table_part').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function GetTableManual() {
        var model_id = $('#model_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/product_model_manual/GetTableManual.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_data_manual").html(response);
                $('#table_manual_').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function GetTableBasic() {
        var model_id = $('#model_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/product_model_manual/GetTableBasic.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_data_basic").html(response);
                $('#table_basic').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function ModalAdd(model_id) {

        $.ajax({
            type: 'POST',
            url: "ajax/product_model_manual/ModalAdd.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function ModalAddManual(model_id) {

        $.ajax({
            type: 'POST',
            url: "ajax/product_model_manual/ModalAddManual.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#mymodal .modal-content").html(response);
                $("#mymodal").modal('show');
            }
        });
    }

    function ModalAddBasic(model_id) {

        $.ajax({
            type: 'POST',
            url: "ajax/product_model_manual/ModalAddBasic.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#mymodal .modal-content").html(response);
                $("#mymodal").modal('show');
            }
        });
    }
    function Add() {

        const manaul_name = $("#manaul_name").val();


        if (manaul_name == "") {
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
        }, function () {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product_model_manual/Add.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    console.log(response);

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

    function Add_Manual() {

        const manaul_name = $("#manaul_name").val();


        if (manaul_name == "") {
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
        }, function () {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product_model_manual/AddManual.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    console.log(response);

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            GetTableManual();
                            $("#mymodal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function Add_Basic() {

        const manaul_name = $("#manaul_name").val();


        if (manaul_name == "") {
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
        }, function () {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product_model_manual/AddBasic.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    console.log(response);

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            GetTableBasic();
                            $("#mymodal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function ModalEdit(manual_id) {
        $.ajax({
            type: "post",
            url: "ajax/product_model_manual/ModalEdit.php",
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

    function ModalEdit_Manual(manual_id) {
        $.ajax({
            type: "post",
            url: "ajax/product_model_manual/ModalEdit_Manual.php",
            data: {
                manual_id: manual_id
            },
            dataType: "html",
            success: function (response) {
                $("#mymodal .modal-content").html(response);
                $("#mymodal").modal('show');
            }
        });
    }

    function Update() {

        const manaul_name = $("#manaul_name").val();

        if (manaul_name == "") {
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
        }, function () {

            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product_model_manual/Update.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    console.log(response);

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

    function Update_Manual() {

        const manaul_name = $("#manaul_name").val();

        if (manaul_name == "") {
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
        }, function () {

            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product_model_manual/Update_Manual.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    console.log(response);

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            GetTableManual();
                            $("#modal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }

    function ChangeStatus(button, key_value, tab) {
        $.ajax({
            type: "post",
            url: "ajax/product_model_manual/ChangeStatus.php",
            data: {
                key_value: key_value,
                tab: tab
            },
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

    function ModalAddPart(member_id) {
        $("#modal").modal('show');
        $("#modal .modal-content").load("ajax/product_model_manual/ModalAddPart.php", {
            member_id: member_id
        }, function (response, status, request) {
            this; // dom element

        });

    }

    function AddSparePart() {

        let model_id = $("#model_id").val();
        let spare_part_id = $("#spare_part_id").val();

        $.ajax({
            type: "POST",
            url: "ajax/product_model_manual/InsertSparePart.php",
            data: {
                model_id: model_id,
                spare_part_id: spare_part_id
            },
            dataType: "json",
            success: function (response) {
                if (response.result == 1) {
                    swal({
                        title: "ดำเนินการสำเร็จ",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    }, function () {
                        swal.close();
                        GetTablePart()
                        $("#modal").modal('hide');
                    });
                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });
    }

    function DeletePart(product_part_id) {
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
                url: "ajax/product_model_manual/DeletePart.php",
                data: {
                    product_part_id: product_part_id
                },
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'ลบข้อมูลเรียบร้อยแล้ว',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }, function () {
                            swal.close();

                            GetTablePart();
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

    function DeleteManual(manual_id) {
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
                url: "ajax/product_model_manual/DeleteManual.php",
                data: {
                    manual_id: manual_id
                },
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'ลบข้อมูลเรียบร้อย',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }, function () {
                            swal.close();
                            GetTable();
                        });
                    } else if (data.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'เกิดข้อผิดพลาด กรุณาลองใหม่',
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
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect. Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error. ' + jqXHR.responseText;
                    }

                    swal({
                        title: "แจ้งเตือน",
                        text: "พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ" + msg,
                        type: "error",
                        showConfirmButton: true
                    });
                }
            });
        })
    }

    function Delete_Manual(manual_id) {
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
                url: "ajax/product_model_manual/Delete_Manual.php",
                data: {
                    manual_id: manual_id
                },
                dataType: "json",
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: 'ลบข้อมูลเรียบร้อย',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }, function () {
                            swal.close();
                            GetTable();
                        });
                    } else if (data.result == 0) {
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'เกิดข้อผิดพลาด กรุณาลองใหม่',
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
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect. Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error. ' + jqXHR.responseText;
                    }

                    swal({
                        title: "แจ้งเตือน",
                        text: "พบปัญหาการบันทึก กรุณาติดต่อผู้ดูแลระบบ" + msg,
                        type: "error",
                        showConfirmButton: true
                    });
                }
            });
        })
    }
</script>