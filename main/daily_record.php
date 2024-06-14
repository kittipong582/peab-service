<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = $_GET['id'];

$sql = "SELECT * FROM tbl_customer_branch WHERE customer_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>



<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>บันทึกประจำวัน : <?php echo $row['branch_name'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_branch_list.php">รายการลูกค้า</a>
            </li>
            <li class="breadcrumb-item">
                <a
                    href="branch_view_detail.php?id=<?php echo $row['branch_care_id'] ?>"><?php echo $row['branch_name'] ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong>บันทึกประจำวัน</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<input type="hidden" name="customer_branch_id" id="customer_branch_id" value="<?php echo $customer_branch_id ?>">

<div class="wrapper wrapper-content">

    <?php include('ajax/menu/branch_customer_menu.php'); ?>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
                        <div class="row">
                            <div class="col-6">
                                <h5>รายการบันทึกประจำวัน</h5>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-info btn-xs"
                                    onclick="modal_add('<?php echo $customer_branch_id ?>');"><i class="fa fa-plus"></i>
                                    เพิ่มบันทึกประจำวัน</button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content" id="show_data">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="show_modal"></div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <script>
    $(document).ready(function() {
        GetTable();
    });

    function modal_detail(daily_id) {
        $('#modal').modal('show');
        $('#show_modal').load("ajax/daily_record/modal_detail.php", {
            daily_id: daily_id
        });
    }

    function modal_add(customer_branch_id) {
        $('#modal').modal('show');
        $('#show_modal').load("ajax/daily_record/modal_add.php", {
            customer_branch_id: customer_branch_id
        });
    }

    function modal_edit(daily_id) {
        $('#modal').modal('show');
        $('#show_modal').load("ajax/daily_record/modal_edit.php", {
            daily_id: daily_id
        });
    }

    function delete_record(daily_id) {

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
                url: 'ajax/daily_record/delete_record.php',
                data: {
                    daily_id: daily_id
                },
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'กรุณาลองใหม่อีกครั้ง',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        location.reload();
                    }
                }
            })
        });
    }

    function GetTable() {

        var customer_branch_id = $("#customer_branch_id").val();

        $.ajax({
            type: 'POST',
            url: "ajax/daily_record/GetTable.php",
            data: {
                customer_branch_id: customer_branch_id,
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true,
                    sorting: disable
                });
            }
        });
    }
    </script>