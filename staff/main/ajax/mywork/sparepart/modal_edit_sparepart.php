<?php

include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$spare_used_id = $_POST['spare_used_id'];

$sql = "SELECT * FROM tbl_job_spare_used a
LEFT JOIN tbl_spare_part b ON b.spare_part_id = a.spare_part_id
LEFT JOIN tbl_job c ON c.job_id = a.job_id
LEFT JOIN tbl_user d ON c.responsible_user_id = d.user_id
LEFT JOIN tbl_customer_branch e ON c.customer_branch_id = e.customer_branch_id
LEFT JOIN tbl_customer f ON e.customer_id = f.customer_id
WHERE a.spare_used_id = '$spare_used_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
$num_chk = mysqli_num_rows($result);

$job_id = $row['job_id'];
$insurance_status = $row['insurance_status'];
// echo $sql;

$branch_id = $row['branch_id'];

$sql_spare = "SELECT * FROM tbl_branch_stock a 
LEFT JOIN tbl_spare_part b ON b.spare_part_id = a.spare_part_id
WHERE a.branch_id = '$branch_id' and a.spare_part_id = '{$row['spare_part_id']}'";
$result_q_num  = mysqli_query($connect_db, $sql_spare);
$row_q_num  = mysqli_fetch_array($result_q_num);

$on_hand = $row_q_num['remain_stock'];

//////////////////////group_price
$sql_chk = "SELECT * FROM tbl_customer_group_part_price WHERE customer_group_id = '{$row['customer_group']}' AND spare_part_id = '{$row['spare_part_id']}'";
$result_chk  = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_num_rows($result_chk);

if ($row_chk > 0) {

    $sql_group_part = "SELECT expire_date FROM tbl_customer_group WHERE customer_group_id = '{$row['customer_group']}' and active_status = 1";
    $result_group_part  = mysqli_query($connect_db, $sql_group_part);
    $row_group_part = mysqli_fetch_array($result_group_part);

    if ($today < $row_group_part['expire_date']) {

        $sql1 = "SELECT *  FROM tbl_customer_group_part_price WHERE customer_group_id = '{$row['customer_group']}' AND spare_part_id = '{$row['spare_part_id']}'";
        $result1  = mysqli_query($connect_db, $sql1);
        $row1 = mysqli_fetch_array($result1);

        $default_cost = round($row1['unit_price'], 2);
    } else {
        $default_cost = round($row_q_num['default_cost'], 2);
    }
} else {
    $default_cost = round($row_q_num['default_cost'], 2);
}

////////////////option loop//////////////
$result_option  = mysqli_query($connect_db, $sql);

$chk = "";
$insurance = "";
if ($row['insurance_status'] == 1) {
    $chk = "Checked";
}


$sql_wtt = "SELECT * FROM tbl_warranty_type WHERE active_status = 1";
$result_wtt  = mysqli_query($connect_db, $sql_wtt);
?>

<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>

<form action="" method="post" id="form-edit_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการอะไหล่</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input id="spare_used_id" name="spare_used_id" value="<?php echo $spare_used_id ?>" type="hidden">
        <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
        <input id="group_id" name="group_id" value="<?php echo $row['customer_group'] ?>" type="hidden">
        <input id="branch_id" name="branch_id" value="<?php echo $row['branch_id'] ?>" type="hidden">

        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="form-group">
                <div class="row">
                    <label><strong>เพิ่มข้อมูลอะไหล่ </strong></label>
                </div><br>
                <div id="Addform_sparepart" name="Addform_sparepart">

                    <div name="div_ax" id="div" value="<?php echo $i; ?>">

                        <div class="ibox mb-3 d-block border-black">
                            <div class="ibox-content">
                                <div class="row">

                                    <div class="col-8">
                                        <!-- <div class="form-group">
                                        </div> -->
                                    </div>


                                    <div class="col-4">
                                        <label>ประกัน</label>
                                        <select class='form-control select2' style="width:100%;" name='insurance_status' id='insurance_status'>


                                            <?php while ($row_wtt = mysqli_fetch_array($result_wtt)) { ?>
                                                <option value='0' <?php if ($row['insurance_type'] == $row_wtt['warranty_type_id']) {
                                                                        echo "SELECTED";
                                                                    } ?>><?php echo $row_wtt['warranty_type_name'] ?></option>

                                            <?php } ?>

                                            
                                        </select>
                                    </div>

                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-12">
                                        <select name="spare_part" id="spare_part" style="width:100%;" onchange="select_part(this.value,'<?php echo $i ?>');" class="form-control select2 spare_part">

                                            <?php while ($row_spare = mysqli_fetch_array($result_option)) { ?>
                                                <option value="<?php echo $row_spare['spare_part_id'] ?>"><?php echo $row_spare['spare_part_code'] . " " . $row_spare['spare_part_name'] ?></option>
                                            <?php } ?>


                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label>ที่พร้อมใช้งาน</label>
                                        <input type="text" class="form-control Onhand" readonly name="Onhand" id="Onhand" value="<?php echo $on_hand ?>">

                                    </div>

                                    <div class="col-6">
                                        <label>จำนวนที่ใช้</label>
                                        <input type="text" class="form-control quantity" name="quantity" id="quantity" value="<?php echo $row['quantity'] ?>">

                                    </div>


                                    <input type="hidden" class="form-control" readonly name="cost" id="cost" value="<?php echo $default_cost ?>">


                                </div>
                            </div>
                        </div>
                    </div><br>

                </div>
                <!-- <div id="counter" hidden><?php $i ?></div> -->
                <br>

                <!-- <div class="row">
                    
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row2();"><i class="fa fa-plus"></i>
                        เพิ่มรายการ
                    </button>
                
                </div> -->

            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
        <button class="btn btn-primary" type="button" id="submit" onclick="Submit_sparepart()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        // add_row2();

        $('#chkbox').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        }).on('ifChanged', function(e) {
            if ($('#chkbox').is(':checked') == true) {
                $('#insurance_status').val('1');
            } else {
                $('#insurance_status').val('0');
            }
        });

    });

    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })



    function Submit_sparepart() {

        var spare_part = $('.spare_part').val();
        var quantity = $('.quantity').val();
        var Onhand = $('.Onhand').val();

        var formData = new FormData($("#form-edit_spare")[0]);

        if (quantity == "") {
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
                url: 'ajax/mywork/sparepart/update_spare_part.php',
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

                        // $(".tab_head").removeClass("active");
                        // $(".tab_head h4").removeClass("font-weight-bold");
                        // $(".tab_head h4").addClass("text-muted");

                        // $(".tab-pane").removeClass("show");
                        // $(".tab-pane").removeClass("active");
                        // $("#tab_head_1").children("h4").removeClass("text-muted");
                        // $("#tab_head_1").children("h4").addClass("font-weight-bold");
                        // $("#tab_head_1").addClass("active");

                        // current_fs = $(".active");

                        // // next_fs = $(this).attr('id');
                        // // next_fs = "#" + next_fs + "1";

                        // // $(".tab_head").removeClass("show");
                        // $('#tab-1').addClass("active");

                        // current_fs.animate({}, {
                        //     step: function() {
                        //         current_fs.css({
                        //             'display': 'none',
                        //             'position': 'relative'
                        //         });
                        //         next_fs.css({
                        //             'display': 'block'
                        //         });
                        //     }
                        // });
                        record_sparepart();
                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'จำนวนอะไหล่ไม่พอ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>