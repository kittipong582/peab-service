<?php
session_start();
include('header2.php');
include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$transfer_id = getRandomID(10, 'tbl_transfer', 'transfer_id');
$branch_id = $_SESSION['branch_id'];
?>
<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">โอนย้าย </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_withdraw" method="POST" enctype="multipart/form-data" novalidate>
    <div class="modal-body" style="padding-bottom: 0;">


        <div class="row">

            <div class="ibox">
                <div class="ibox-content">

                    <input type="hidden" id="transfer_id" name="transfer_id" value="<?php echo $transfer_id ?>">

                    <div class="row">

                        <div class="col-md-3 col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label>AX_Ref_TF_No</label>
                                <input type="text" id="ax_ref_no" name="ax_ref_no" class="form-control" placeholder="" autocomplete="off">
                            </div>
                        </div>


                        <div class="col-md-3 col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label>วันที่โอนย้าย AX</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="withdraw_date" id="withdraw_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>ทีม(ผู้โอน)</label>
                                <!-- <font color="red">**</font> -->
                                <select class="form-control select2" id="from_branch" name="from_branch" data-width="100%">
                                    <?php

                                    $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch WHERE branch_id = '$branch_id'";
                                    $rs_b = mysqli_query($connection, $sql_b);
                                    while ($row_b = mysqli_fetch_assoc($rs_b)) {

                                    ?>

                                        <option value="<?php echo $row_b['branch_id'] ?>">
                                            <?php echo $row_b['branch_name'] ?></option>


                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>ทีม(ผู้รับ)</label>
                                <!-- <font color="red">**</font> -->
                                <select class="form-control select2" id="to_branch" name="to_branch" data-width="100%">
                                    <option value="x" selected>กรุณาเลือกทีม </option>

                                    <?php

                                    $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch ;";
                                    $rs_b = mysqli_query($connection, $sql_b);
                                    while ($row_b = mysqli_fetch_assoc($rs_b)) {

                                    ?>

                                        <option value="<?php echo $row_b['branch_id'] ?>">
                                            <?php echo $row_b['branch_name'] ?></option>


                                    <?php } ?>

                                </select>
                            </div>
                        </div>


                    </div>

                </div>

            </div>

            <br>

            <div class="col-12" id="Detail">
            </div>

            <br>

            <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="row">

                    <div class="col-md-12 col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label>หมายเหตุ</label>
                            <textarea class="form-control summernote" rows="10" name="remark" id="remark"></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <br>

            <div class="col-lg-12 col-xs-12 col-sm-12">
                <div class="row">

                    <div class="col-md-12 col-xs-12 col-sm-4 text-center">
                        <div class="form-group">
                            <button type="button" class="btn btn-success btn-md w-100" onclick="submit_withdraw();">ยืนยัน </button>
                        </div>
                    </div>

                </div>
            </div>




        </div>


    </div>

    <div class="row">
        <!-- <div class="col-12" style="text-align:right;">
                <button class="btn btn-success btn-md" type="button"
                    onclick="submit_approve();">ยืนยันการอนุมัติ</button>
            </div> -->
        <div class="col-12" style="text-align:right;">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
        </div>
    </div><br>

    </div>
</form>



<script>
    $(document).ready(function() {

        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $(".select2").select2({});

        
    });

    $('.summernote').summernote({
        toolbar: false,
    });

    $('.transfer_spare_part_tbl').DataTable({
        pageLength: 25,
        responsive: true,
    });


    // function GetUser(branch_id) {

    //     $.ajax({
    //         type: 'POST',
    //         url: 'ajax/transfer/GetUser2.php',
    //         data: {
    //             branch_id: branch_id
    //         },
    //         dataType: 'html',
    //         success: function(response) {
    //             $('#get_user').html(response);
    //             $("#user").select2();

    //         }
    //     });

    // }

    // function GetUser2(branch_id) {

    //     $.ajax({
    //         type: 'POST',
    //         url: 'ajax/transfer/GetUser3.php',
    //         data: {
    //             branch_id: branch_id
    //         },
    //         dataType: 'html',
    //         success: function(response) {
    //             $('#get_user2').html(response);
    //             $("#user2").select2();

    //         }
    //     });

    // }

    function GetDetail() {

        var branch_id = $('#from_branch').val();
        $.ajax({
            type: 'POST',
            url: 'ajax/transfer/GetDetail.php',
            data: {
                branch_id: branch_id
            },
            dataType: 'html',
            success: function(response) {
                $('#Detail').html(response);
            }
        });
    }

    function GetRemain(spare_part_id, i) {

        var from_branch = $('#from_branch').val();
        $.ajax({
            url: 'ajax/transfer/GetRemain.php',
            data: {
                spare_part_id: spare_part_id,
                i: i,
                branch_id: from_branch
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {

                $("#remain_" + i).val(data.remain);
            }
        });
    }

    function GetUnit(spare_part_id, i) {

        $.ajax({
            url: 'ajax/transfer/GetUnit.php',
            data: {
                spare_part_id: spare_part_id,
                i: i
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {

                $("#unit_" + i).val(data.unit);
                $("#code_" + i).val(data.code);
            }
        });
    }


    function check_stock(i) {
        var remain = parseFloat($('#remain_' + i).val());
        var quantity = parseFloat($('#quantity_' + i).val());
        // var check2 = quantity + already;


        if (quantity > remain) {
            swal({
                title: "เกิดข้อผิดพลาด",
                text: "จำนวนสินค้าที่สามารถโอนย้ายได้มีไม่เพียงพอ",
                type: "error",
            });
            $('#quantity_' + i).val(0);
            return false;
        }

    }


    function desty(i) {
        document.getElementById('tr_' + i).remove();
    }

    function chk(tr) {
        var status = 0;
        var temp_list = [];

        $('[name="ax[]"]').each(function() {

            // alert(this.value);
            if (this.value != "x") {
                if (temp_list.includes(this.value)) {

                    // alert('test');
                    swal({
                        title: 'รายการซ้ำ!',
                        text: 'กรุณาเลือกรายการที่ไม่ซ้ำกัน',
                        type: 'warning'
                    });
                    $("#ax_" + tr).val('x');
                    $("#remain_" + tr).val('');
                    $("#quantity_" + tr).val('');
                    $("#ax_" + tr).trigger('change');
                    return false;

                } else {

                    temp_list.push(this.value);
                    // alert('twar1');
                }
            }
        })
    }

    function submit_withdraw() {

        let counter = parseFloat($("#counter").val());
        var transfer_id = $('#transfer_id').val();
        var ax_ref_no = $('#ax_ref_no').val();
        var withdraw_date = $('#withdraw_date').val();
        var remark = $('#remark').val();


        var formData = new FormData($("#frm_withdraw")[0]);


        var check = 0;
        $("[name='quantity[]']").map(function(x, ele) {
            if (ele.value == "") {
                check = 1;
            }
        });
        $("[name='ax[]']").map(function(x, ele) {
            if (ele.value == "x") {
                check = 1;
            }
        });

        var from_branch = $('#from_branch').val();
        var to_branch = $('#to_branch').val();

        if (from_branch == 'x' || $("[name='ax[]']").length == 0) {

            // if (ax_ref_no == "" || withdraw_date == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครับถ้วน',
                type: 'error'
            });
            return false;
            // }

        }



        if (check == 1) {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาระบุสินค้าให้ครบถ้วน',
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
                url: 'ajax/transfer/insert_transfer.php',
                data: formData,
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
                    if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'จำนวนของที่เบิกไม่เพียงพอ',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        // $('#modal').modal('hide');
                        location.href = "transfer.php";
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            })
        });
    }
</script>