<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$import_id = $_GET['id'];


$sql = "SELECT a.*,b.fullname,c.branch_id,c.branch_name,d.*,e.spare_part_name FROM tbl_import_stock a 
LEFT JOIN tbl_user b ON a.receive_user_id = b.user_id 
LEFT JOIN tbl_branch c ON b.branch_id = c.branch_id 
LEFT JOIN tbl_import_stock_detail d ON a.import_id = d.import_id 
LEFT JOIN tbl_spare_part e ON d.spare_part_id = e.spare_part_id 
WHERE a.import_id = '$import_id' ;";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

// echo $sql;

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>แก้ไขการนำเข้า เลขที่ : <?php echo $row['import_no'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="import_from_ax.php">Import from AX</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>แก้ไขการนำเข้า</strong>
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
                                        <h3>แก้ไขการนำเข้า</h3>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="ibox-content">

                        <div class="col-lg-12">



                            <form id="frm_import" method="POST" enctype="multipart/form-data">

                                <input type="hidden" id="import_id" name="import_id" value="<?php echo $import_id ?>">
                                <input type="hidden" id="import_no" name="import_no" value="<?php echo $$row['import_no'] ?>">

                                <div class="col-lg-12 col-xs-12 col-sm-12">
                                    <div class="row">

                                        <div class="col-md-3 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label>สาขา</label>
                                                <font color="red">**</font>
                                                <select class="form-control select2" id="branch" name="branch"
                                                    data-width="100%" onchange="GetUser(this.value)">
                                                    <option value="x" selected>ทั้งหมด </option>

                                                    <?php 
                                                        
                                                                $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch ;";
                                                                $rs_b = mysqli_query($connection, $sql_b);
                                                                while($row_b = mysqli_fetch_assoc($rs_b)){
                                                                
                                                                ?>

                                                    <option value="<?php echo $row_b['branch_id'] ?>" <?php if ($row_b['branch_id'] == $row['branch_id']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                                        <?php echo $row_b['branch_name'] ?></option>


                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-2 col-xs-12 col-sm-3">
                                        </div> -->

                                        <div class="col-md-3 col-xs-12 col-sm-12" id="get_user">
                                            <div class="form-group">
                                                <label>ผู้รับ</label>
                                                <font color="red">**</font>
                                                <select class="form-control select2" id="user" name="user"
                                                    data-width="100%">
                                                    <option value="x" selected>กรุณาเลือก </option>

                                                    <?php 
                                                        
                                                                $sql_u = "SELECT user_id,fullname FROM tbl_user ;";
                                                                $rs_u = mysqli_query($connection, $sql_u);
                                                                while($row_u = mysqli_fetch_assoc($rs_u)){
                                                                
                                                                ?>

                                                    <option value="<?php echo $row_u['user_id'] ?>" <?php if ($row_u['user_id'] == $row['receive_user_id']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                                        <?php echo $row_u['fullname'] ?></option>


                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>



                                        <!-- </div> -->

                                        <!-- <div class="row"> -->

                                        <div class="col-md-3 col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <label>AX_Ref_no</label>
                                                <font color="red">**</font>
                                                <input type="text" id="ax_ref_no" name="ax_ref_no" class="form-control"
                                                    placeholder="" value="<?php echo $row['ax_ref_no'] ?>"
                                                    autocomplete="off">
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
                                                    <input class="form-control datepicker" type="text"
                                                        name="withdraw_date" id="withdraw_date"
                                                        value="<?php echo date('d/m/Y', strtotime($row['ax_withdraw_date'])); ?>"
                                                        readonly>
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

                                        <div id="Addform_ax" name="Addform_ax">

                                            <?php 
                                        
                                        $sql2 = "SELECT * FROM tbl_import_stock_detail a 
                                        JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id
                                        WHERE a.import_id = '$import_id'
                                        ;";
                                        $rs2 = mysqli_query($connection, $sql2);

                                        $i=0;

                                        while ($row2 = mysqli_fetch_assoc($rs2)) {

                                            $i++;

                                        ?>

                                            <div name="div_ax[]" id="div_<?php echo $i; ?>" value="<?php echo $i; ?>">
                                                <div class="col-lg-12">
                                                    <div class="row">

                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <button style="width:50px;" type="button"
                                                                    class="btn btn-sm btn-danger" name="button"
                                                                    onclick="desty('<?php echo $i; ?>')"><i
                                                                        class="fa fa-times"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>

                                                        <div class="col-mb-4 col-xs-4 col-sm-4">
                                                            <!-- <label>สิ่งที่ต้องการเบิก</label> -->
                                                            <select name="ax[]" id="ax_<?php echo $i; ?>"
                                                                class="form-control select2">
                                                                <option value="x" selected>กรุณาเลือก </option>

                                                                <?php 
    
                                                                $sql_sp = "SELECT * FROM tbl_spare_part ;";
                                                                $rs_sp = mysqli_query($connection, $sql_sp);
                                                                while($row_sp = mysqli_fetch_assoc($rs_sp)){
                                                                
                                                                ?>

                                                                <option value="<?php echo $row_sp['spare_part_id'] ?>" <?php if ($row_sp['spare_part_id'] == $row2['spare_part_id']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                                                    <?php echo $row_sp['spare_part_name'] ?></option>


                                                                <?php } ?>

                                                            </select>
                                                        </div>

                                                        <div class="col-md-1 col-xs-1 col-sm-1">
                                                        </div>

                                                        <div class="col-mb-4 col-xs-4 col-sm-4">
                                                            <!-- <label>จำนวน</label> -->
                                                            <div class="form-group">
                                                                <input type="text" id="quantity_<?php echo $i; ?>"
                                                                    name="quantity[]" class="form-control"
                                                                    placeholder="" value="<?php echo $row2['quantity'] ?>" autocomplete="off">
                                                            </div>
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>


                                            <?php } ?>

                                        </div>
                                        <div id="counter" hidden><?php echo $rs2->num_rows ?></div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    onclick="add_row();"><i class="fa fa-plus"></i>
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
                                                <textarea class="form-control summernote" rows="3" name="remark"
                                                    id="remark"><?php echo $row['note'] ?></textarea>
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
                                            <button type="button" class="btn btn-success btn-md w-100"
                                                onclick="submit_edit_import();">ยืนยัน </button>
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
<div class="modal hide fade in" id="modal2" role="dialog" data-keyboard="false" data-backdrop="static"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    // add_row();

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


function submit_edit_import() {

    var import_id = $('#import_id').val();
    var import_no = $('#import_no').val();
    var user = $('#user').val();
    var ax_ref_no = $('#ax_ref_no').val();
    var withdraw_date = $('#withdraw_date').val();
    var remark = $('#remark').val();

    // alert(user_id);
    // alert(deli_date);

    var formData = new FormData($("#frm_import")[0]);

    if (user == "x" || ax_ref_no == "") {
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
            url: 'ajax/import_from_ax/edit_import.php',
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