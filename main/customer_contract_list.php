<?php
include('header.php');
$customer_id = $_GET['id'];
$sql_detail = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
$result_detail  = mysqli_query($connection, $sql_detail);
$row_detail = mysqli_fetch_array($result_detail);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ข้อมูลสาขา</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_list.php">รายการลูกค้า</a>
            </li>
            <li class="breadcrumb-item ">
                <a href="customer_view_detail.php?id=<?php echo $row_detail['customer_id']; ?>"><?php echo $row_detail['customer_name'] ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong>สัญญาบริการ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
                    <div class="row">
                        <div class="col-6">
                            <label>รายการสัญญา</label>
                        </div>
                        <div class="ibox-tools">
                            <button type="button" onclick="modal_contract('<?php echo $row_detail['customer_id']; ?>')" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> เพิ่มสัญญา</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id ?>">

                <div class="ibox-content" id="show_data">

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <?php include 'customer_menu.php'; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {
        GetTable();
    });

    function GetTable() {

        var customer_id = $('#customer_id').val();
        $.ajax({
            type: 'POST',
            url: "ajax/customer_contract/GetTable.php",
            data: {
                customer_id: customer_id
            },
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



    function modal_contract(customer_id) {
        $.ajax({
            type: "post",
            url: "ajax/customer_contract/Modal_customer_contract.php",
            data: {
                customer_id: customer_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }


    function modal_edit_contract(contract_id) {
        $.ajax({
            type: "post",
            url: "ajax/customer_contract/Modal_edit_customer_contract.php",
            data: {
                contract_id: contract_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }

    function modal_cancel(contract_id) {
        $.ajax({
            type: "post",
            url: "ajax/customer_contract/Modal_cancel.php",
            data: {
                contract_id: contract_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }




    function Add() {

        var contract_number = $('#contract_number').val();
        var start_contract_date = $('#start_contract_date').val();
        var end_contract_date = $('#end_contract_date').val();

        var formData = new FormData($("#form-add_contract")[0]);

        if (contract_number == "" || start_contract_date == "" || end_contract_date == "") {
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
                url: 'ajax/customer_contract/Add.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');
                        GetTable();
                    } else if (data.result == 2) {


                        swal({
                            title: 'ผิดพลาด!',
                            text: 'เลขที่สัญญาซ้ำ กรุณาทำรายการใหม่ !!',
                            type: 'warning'
                        });
                        return false;

                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถทำรายการได้ กรุณาทำรายการใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }


    function Update() {

        var contract_number = $('#contract_number').val();
        var start_contract_date = $('#start_contract_date').val();
        var end_contract_date = $('#end_contract_date').val();

        var formData = new FormData($("#form-add_contract")[0]);

        if (contract_number == "" || start_contract_date == "" || end_contract_date == "") {
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
                url: 'ajax/customer_contract/Update.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');
                        GetTable();
                    } else if (data.result == 2) {


                        swal({
                            title: 'ผิดพลาด!',
                            text: 'เลขที่สัญญาซ้ำ กรุณาทำรายการใหม่ !!',
                            type: 'warning'
                        });
                        return false;

                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถทำรายการได้ กรุณาทำรายการใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }



    function cancel() {

        var contract_number = $('#contract_number').val();
        var start_contract_date = $('#start_contract_date').val();
        var end_contract_date = $('#end_contract_date').val();

        var formData = new FormData($("#form-cancel")[0]);

        if (contract_number == "" || start_contract_date == "" || end_contract_date == "") {
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
                url: 'ajax/customer_contract/Cancel.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');
                        GetTable();
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถทำรายการได้ กรุณาทำรายการใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>