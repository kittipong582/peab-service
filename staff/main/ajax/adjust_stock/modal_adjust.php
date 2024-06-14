<?php
session_start();
include('header2.php');
include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$adjust_id = getRandomID(10, 'tbl_adjust_head', 'adjust_id');
$branch_id = $_SESSION['branch_id'];
?>
<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">ปรับสต๊อก </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<form id="frm_adjust" method="POST" enctype="multipart/form-data" novalidate>
    <div class="modal-body" style="padding-bottom: 0;">


        <div class="row">

            <div class="ibox">
                <div class="ibox-content">

                    <input type="hidden" id="adjust_id" name="adjust_id" value="<?php echo $adjust_id ?>">

                    <div class="row">

                        <div class="col-md-3 col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label>AX Ref No</label>
                                <input type="text" id="ax_ref_no" name="ax_ref_no" class="form-control" placeholder="" autocomplete="off">
                            </div>
                        </div>


                        <div class="col-md-3 col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label>วันที่ปรับ</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="withdraw_date" id="withdraw_date" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label>ประเภท</label>
                                <font color="red">**</font>
                                <select class="form-control select2" id="adjust_type" name="adjust_type" data-width="100%">
                                    <option value="x" selected>กรุณาเลือก </option>
                                    <option value="1">หัก Stock </option>
                                    <option value="2">เพิ่ม Stock </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>ทีม</label>
                                <!-- <font color="red">**</font> -->
                                <select class="form-control select2" id="branch" name="branch" data-width="100%" onchange="GetDetail(this.value)">
                                    <option value="x" selected>กรุณาเลือกทีม </option>

                                    <?php

                                    $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch WHERE branch_id = '$branch_id';";
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
                            <button type="button" class="btn btn-success btn-md w-100" onclick="submit_adjust();">ยืนยัน </button>
                        </div>
                    </div>

                </div>
            </div>




        </div>


    </div>

    <div class="row">

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

    $('.adjust_spare_part_tbl').DataTable({
        pageLength: 25,
        responsive: true,
    });


    // function GetUser(branch_id) {

    //     $.ajax({
    //         type: 'POST',
    //         url: 'ajax/adjust_stock/GetUser.php',
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

    function GetDetail(branch_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/adjust_stock/GetDetail.php',
            data: {
                branch_id: branch_id
            },
            dataType: 'html',
            success: function(response) {
                $('#Detail').html(response);

            }
        });

    }

    function add_row(branch_id) {

        $('#counter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#counter').html();

        $.ajax({
            url: 'ajax/adjust_stock/add_row.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment,
                branch_id: branch_id
            },
            success: function(data) {

                $('#Addform_ax').append(data);
                $(".select2").select2({
                    width: "200px"
                });
            }
        });
    }

    function GetRemain(spare_part_id, i) {

        var branch = $('#branch').val();
        $.ajax({
            url: 'ajax/adjust_stock/GetRemain.php',
            data: {
                spare_part_id: spare_part_id,
                i: i,
                branch_id: branch
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {

                $("#remain_" + i).val(data.remain);
            }
        });
    }

    function check_stock(i) {
        var remain = parseFloat($('#remain_' + i).val());
        var quantity = parseFloat($('#quantity_' + i).val());
        var adjust_type = $('#adjust_type').val();

        if (adjust_type == "1") {
            if (quantity > remain) {
                swal({
                    title: "เกิดข้อผิดพลาด",
                    text: "จำนวนสินค้าที่สามารถนำออกได้มีไม่เพียงพอ",
                    type: "error",
                });

                $('#quantity_' + i).val(0);
                return false;
            }
        }
    }


    function desty(i) {
        document.getElementById('div_' + i).remove();
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


    function submit_adjust() {

        let counter = parseFloat($("#counter").val());
        var adjust_id = $('#adjust_id').val();
        var user = $('#user').val();
        var ax_ref_no = $('#ax_ref_no').val();
        var withdraw_date = $('#withdraw_date').val();
        var remark = $('#remark').val();
        var adjust_type = $('#adjust_type').val();


        var formData = new FormData($("#frm_adjust")[0]);


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

        if (check == 1) {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาระบุสินค้าให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

        if (user == "x" || adjust_type == "x") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }


        // for (let i = 1; i <= counter; i++) {
        //     if ($('#quantity_' + i).val() == "") {
        //         swal({
        //             title: "แจ้งเตือน!",
        //             text: "กรุณากรอกข้อมูลให้ครบถ้วน",
        //             type: "warning",
        //             showConfirmButton: false
        //         });
        //         setTimeout(function() {
        //             swal.close();
        //         }, 1500);
        //         return false;
        //     }
        // }

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
                url: 'ajax/adjust_stock/insert_adjust.php',
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
                    if (data.result == 1) {

                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#modal').modal('hide');
                        $('.modal-backdrop').remove();
                        Getdata();
                    }
                }
            })
        });
    }
</script>