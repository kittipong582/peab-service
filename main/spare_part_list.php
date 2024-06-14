<?php include('header.php');

include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql_type = "SELECT * FROM tbl_spare_type WHERE active_status = 1 ORDER BY spare_type_name";
$result_type  = mysqli_query($connect_db, $sql_type);

?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการอะไหล่</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>รายการอะไหล่</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <div class="row">
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label>ประเภทอะไหล่</label>
                        <select class="form-control select2" id="spare_type" name="spare_type" data-width="100%">
                            <?php while ($row_type = mysqli_fetch_assoc($result_type)) { ?>
                                <option value="<?php echo $row_type['spare_type_id'] ?>"><?php echo $row_type['spare_type_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12">
                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                    <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable();" value="แสดงข้อมูล">
                </div> -->
            </div>
            <div class="ibox-tools">
                <button class="btn btn-xs btn-info" onclick="ModalAdd();">
                    <i class="fa fa-plus"></i> เพิ่มอะไหล่
                </button>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {
        GetTable();


        $(".select2").select2({
            width: "100%"
        });
    });

    function GetTable() {
        // var spare_type = $('#spare_type').val();

        $.ajax({
            type: "POST",
            url: "ajax/sparePart/GetTable.php",
            data: {
                // spare_type: spare_type
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }

    function ModalAdd() {
        $.ajax({
            url: "ajax/sparePart/ModalAdd.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Add() {

        const spare_part_name = $("#spare_part_name").val();
        const spare_part_code = $("#spare_part_code").val();
        const check_code = $("#check_code").val();
        const spare_part_unit = $("#spare_part_unit").val();
        const spare_part_des = $("#spare_part_des").val();

        if (spare_part_name == "" || spare_part_code == "" || spare_part_unit == "") {
            swal("", "ไม่สามารถทำรายการได้กรุณากรอกข้อมูลให้ครบถ้วน", "error");
            return false;
        }

        if (check_code == 0) {
            swal("", "ไม่สามารถทำรายการได้ รหัสไม่สามารถใช้งานได้", "error");
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
                url: "ajax/sparePart/Add.php",
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

    function ModalEdit(spare_part_id) {
        $.ajax({
            type: "post",
            url: "ajax/sparePart/ModalEdit.php",
            data: {
                spare_part_id: spare_part_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }

    function Update() {

        const spare_part_name = $("#spare_part_name").val();
        const spare_part_code = $("#spare_part_code").val();
        const check_code = $("#check_code").val();
        const spare_part_unit = $("#spare_part_unit").val();
        const spare_part_des = $("#spare_part_des").val();

        if (spare_part_name == "" || spare_part_code == "" || spare_part_unit == "") {
            swal("", "ไม่สามารถทำรายการได้กรุณากรอกข้อมูลให้ครบถ้วน", "error");
            return false;
        }

        if (check_code == 0) {
            swal("", "ไม่สามารถทำรายการได้ รหัสไม่สามารถใช้งานได้", "error");
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
                url: "ajax/sparePart/Update.php",
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

    function ChangeStatus(button, spare_part_id) {
        $.ajax({
            type: "post",
            url: "ajax/sparePart/ChangeStatus.php",
            data: {
                spare_part_id: spare_part_id
            },
            dataType: "json",
            success: function(response) {

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

    function setUserLevel(user_level) {
        if (user_level == "" || user_level == 4) {
            $("#select_branch").hide();
        } else {
            $("#select_branch").show();
        }
    }

    function ImageReadURL(input, value, show_position, old_file) {
        let fty = ["jpg", "jpeg", "png"];
        let permiss = 0;
        let file_type = value.split('.');
        file_type = file_type[file_type.length - 1];
        if (jQuery.inArray(file_type, fty) !== -1) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $(show_position).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else if (value == "") {
            $(show_position).attr('src', old_file);
            $(input).val("");
        } else {
            swal({
                title: "เกิดข้อผิดพลาด!",
                text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.jpg .jpeg .png) เท่านั้น!",
                type: "warning"
            });
            $(show_position).attr('src', old_file);
            $(input).val("");
            return false;
        }
    }

    function checkSpareCode(spare_part_id, spare_part_code) {

        if (spare_part_code == "") {
            $("#alert_code").hide();
            $("#check_code").val(0);
        } else {
            $.ajax({
                type: "post",
                url: "ajax/sparePart/checkSpareCode.php",
                data: {
                    spare_part_id: spare_part_id,
                    spare_part_code: spare_part_code
                },
                dataType: "json",
                success: function(response) {

                    if (response == 1) {
                        $("#alert_code").hide();
                        $("#check_code").val(1);
                    } else if (response == 0) {
                        $("#alert_code").show();
                        $("#check_code").val(0);
                    }
                }
            });
        }
    }


    function ModalGroup(spare_part_id) {
        $.ajax({
            type: "post",
            url: "ajax/sparePart/ModalGroup.php",
            data: {
                spare_part_id: spare_part_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal1 .modal-content").html(response);
                $("#modal1").modal('show');

                $('#table_price').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }
</script>