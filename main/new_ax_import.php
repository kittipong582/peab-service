<?php
session_start();
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];


$import_id = getRandomID(10, 'tbl_import_stock', 'import_id');
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>เพิ่มการนำเข้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="import_from_ax.php">Import from AX</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>เพิ่มการนำเข้า</strong>
            </li>
        </ol>
    </div>
    <!-- <div class="col-lg-2"></div> -->
</div>

<div class="col-lg-12">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 0px 8px 15px;">
                        <div class="col-lg-12">

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <h3>เพิ่มการนำเข้า</h3>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="ibox-content">

                        <div class="col-lg-12">



                            <form id="frm_import" method="POST" enctype="multipart/form-data">

                                <input type="hidden" id="import_id" name="import_id" value="<?php echo $import_id ?>">

                                <div class="col-lg-12 col-xs-12 col-sm-12">
                                    <div class="row">

                                        <div class="col-md-3 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label>ทีม</label>
                                                <font color="red">**</font>
                                                <select class="form-control select2" id="branch" name="branch" data-width="100%" >
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

                                        <!-- <div class="col-md-2 col-xs-12 col-sm-3">
                                        </div> -->

                                        <!-- <div class="col-md-3 col-xs-12 col-sm-12" id="get_user">
                                            <div class="form-group">
                                                <label>ผู้รับ</label>
                                                <font color="red">**</font>
                                                <select class="form-control select2" id="user" name="user" data-width="100%">
                                                    <option value="x" selected>กรุณาเลือก </option>

                                                    <?php

                                                    $sql_b = "SELECT user_id,fullname  FROM tbl_user ;";
                                                    $rs_b = mysqli_query($connection, $sql_b);
                                                    while ($row_b = mysqli_fetch_assoc($rs_b)) {

                                                    ?>

                                                        <option value="<?php echo $row_b['user_id'] ?>">
                                                            <?php echo $row_b['fullname'] ?></option>


                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div> -->



                                        <!-- </div> -->

                                        <!-- <div class="row"> -->

                                        <div class="col-md-3 col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>AX_Ref_TRO_no</label>
                                                <font color="red">**</font>
                                                <input type="text" id="ax_ref_no" name="ax_ref_no" class="form-control" placeholder="" autocomplete="off">
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-2 col-xs-12 col-sm-3">
                                        </div> -->

                                        <div class="col-md-3 col-xs-12 col-sm-3">
                                            <div class="form-group">
                                                <label>วันที่เบิกจาก AX</label>
                                                <font color="red">**</font>
                                                <div class="input-group date">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input class="form-control datepicker" type="text" name="withdraw_date" id="withdraw_date" value="<?php echo date('d/m/Y'); ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <br>

                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">

                                        <!-- <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="table-responsive">
                                                    <table class="table table-hover" id="table_person"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th width="50%">รายการ <font color="red">**</font>
                                                                </th>
                                                                <th>หน่วยนับ</th>
                                                                <th style="text-align: right;">จำนวน <font color="red">
                                                                        **</font>
                                                                </th>     
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                    </table>
                                                    <div id="counter" hidden>0</div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row">

                                            <div class="col-md-1"></div>
                                            <div class="col-md-2 col-xs-2 col-sm-2 text-center"><label>รหัสอะไหล่</label></div>
                                            <div class="col-mb-4 col-xs-4 col-sm-4 text-center"><label>รายการอะไหล่</label></div>
                                            <div class="col-md-2 col-xs-2 col-sm-2 text-center"></div>

                                            <div class="col-mb-3 col-xs-3 col-sm-3 text-center" ><label>จำนวนเบิก</label></div>

                                        </div>
                                        <div id="Addform_ax" name="Addform_ax">
                                        </div>
                                        <div id="counter" hidden>0</div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row();"><i class="fa fa-plus"></i>
                                                    เพิ่มรายการ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-lg-12 col-xs-12 col-sm-12">
                                                <div class="row">

                                                    <div class="col-lg-4 col-xs-12 col-sm-4">
                                                    </div>
                                                    <div class="col-lg-4 col-xs-12 col-sm-4 text-right">
                                                        <label>รวมสุทธิ</label>
                                                    </div>
                                                    <div class="col-lg-4 col-xs-12 col-sm-4">


                                                        <input id="final" name="final" value="" class="form-control TextBoxShortNumber" type="text" autocomplete="off" style="text-align: right;" readonly>

                                                    </div>


                                                </div>
                                            </div> --><br>

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

                                <!-- <input type="text" id="count_report" value="5" hidden> -->

                            </form>
                            <br>

                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="row">

                                    <div class="col-md-12 col-xs-12 col-sm-4 text-center">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success btn-md w-100" onclick="submit_import();">ยืนยัน </button>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- addmodal -->
<div class="modal hide fade in" id="modal2" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        add_row();

    });

    $(".select2").select2({
        width: "100%"
    });

    $('.summernote').summernote({
        toolbar: false,
    });

    $(".datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        format: 'dd/mm/yyyy',
        thaiyear: false,
        language: 'th', //Set เป็นปี พ.ศ.
        autoclose: true
    });


    function GetUser(branch_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/import_from_ax/GetUser.php',
            data: {
                branch_id: branch_id
            },
            dataType: 'html',
            success: function(response) {
                $('#get_user').html(response);
                $("#user").select2();

            }
        });

    }


    function add_row() {
        $('#counter').html(function(i, val) {
            return +val + 1
        });
        var increment = $('#counter').html();
        $.ajax({
            url: 'ajax/import_from_ax/add_row.php',
            type: 'POST',
            dataType: 'html',
            data: {
                rowCount: increment
            },
            success: function(data) {

                $('#Addform_ax').append(data);
                $(".select2").select2({
                    width: "100%"
                });
            }
        });
    }

    function desty(i) {
        document.getElementById('div_' + i).remove();
    }

    function GetUnit(spare_part_id, i) {

        $.ajax({
            url: 'ajax/import_from_ax/GetUnit.php',
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


    function submit_import() {

        var import_id = $('#import_id').val();
        var branch = $('#branch').val();
        var ax_ref_no = $('#ax_ref_no').val();
        var withdraw_date = $('#withdraw_date').val();
        var remark = $('#remark').val();

        // alert(user_id);
        // alert(deli_date);

        var formData = new FormData($("#frm_import")[0]);

        if (branch == "x" || ax_ref_no == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

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
                url: 'ajax/import_from_ax/insert_import.php',
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
                        // $('#modal').modal('hide');
                        location.href = "import_from_ax.php";
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

</body>

</html>