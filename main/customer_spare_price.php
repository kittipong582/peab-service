<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$customer_group_id = $_GET['id'];

$sql_group = "SELECT * FROM tbl_customer_group WHERE customer_group_id = '$customer_group_id'";
$result_group  = mysqli_query($connect_db, $sql_group);
$row_group = mysqli_fetch_array($result_group);


$sql_spare = "SELECT * FROM tbl_spare_part a 
LEFT JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id 
 ORDER BY spare_part_code";
$result_spare  = mysqli_query($connect_db, $sql_spare);

?>
<style>
    .classmodal1 {
        max-width: 1000px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>กลุ่ม<?php echo $row_group['customer_group_name'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>

            <li class="breadcrumb-item active">
                <a href="price_group_setting.php">กลุ่มราคา</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>กลุ่ม<?php echo $row_group['customer_group_name'] ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-tools">
                <a href="import_spare_price_group.php?id=<?php echo $customer_group_id ?>">
                    <button class="btn btn-xs btn-info">
                        นำเข้าข้อมูล
                    </button>
                </a>
                <button class="btn btn-xs btn-success" onclick="ModalSetting('<?php echo $customer_group_id ?>');">
                    <i class="fa fa-plus"></i> เพิ่มอะไหล่
                </button>
            </div>
        </div>
        <input type="hidden" id="customer_group_id" name="customer_group_id" value="<?php echo $customer_group_id ?>">
        <div class="ibox-content" id="show_data_spare">

        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>



<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        GetTable_spare();
    });

    function GetTable_spare() {

        var customer_group_id = $('#customer_group_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/customer_group/GetTable_spare.php",
            data: {
                customer_group_id: customer_group_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data_spare").html(response);
                $('#table_spare').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }



    function ModalSetting(customer_group_id) {
        $.ajax({
            type: "POST",
            url: "ajax/customer_group/ModalSetting.php",
            data: {
                customer_group_id: customer_group_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({});
                GetTable_spare(customer_group_id);
            }
        });
    }


    function Add_spare() {

        var spare_part = $("#spare_part").val();
        var customer_group_id = $('#customer_group_id').val();
        var unit_price = $("#unit_price").val();

        if (spare_part == "" || unit_price == "") {
            swal("", "ไม่สามารถทำรายการได้กรุณากรอกข้อมูลให้ครบ", "error");
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

            let myForm = document.getElementById('form-add_spare');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/customer_group/Add_spare.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            GetTable_spare();
                            swal.close();
                            $("#modal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }



    function delete_spare(customer_group_id, spare_part_id) {
        var customer_group_id = $('#customer_group_id').val();
        $.ajax({
            type: "post",
            url: "ajax/customer_group/Delete_spare.php",
            data: {
                customer_group_id: customer_group_id,
                spare_part_id: spare_part_id
            },
            dataType: "json",
            success: function(response) {

                if (response.result == 1) {
                    swal({
                        title: "",
                        text: "ดำเนินการสำเร็จ",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    }, function() {
                        swal.close();
                        GetTable_spare(customer_group_id);
                    });
                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });
    }


    function edit_spare(customer_group_id, spare_part_id) {

        $.ajax({
            type: "POST",
            url: "ajax/customer_group/ModalSetting_edit.php",
            data: {
                customer_group_id: customer_group_id,
                spare_part_id: spare_part_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $(".select2").select2({});
                GetTable_spare(customer_group_id);
            }
        });

    }



    function Update_spare() {

        var spare_part = $("#spare_part").val();
        var customer_group_id = $('#customer_group_id').val();
        var unit_price = $("#unit_price").val();

        if (spare_part == "" || unit_price == "") {
            swal("", "ไม่สามารถทำรายการได้กรุณากรอกข้อมูลให้ครบ", "error");
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

            let myForm = document.getElementById('form-edit_spare');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/customer_group/Update_spare.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            GetTable_spare();
                            swal.close();
                            $("#modal").modal('hide');
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            });

        });
    }
</script>