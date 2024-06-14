<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$spare_used_id = $_POST['spare_used_id'];
$job_id = $_POST['job_id'];


$sql = "SELECT * FROM tbl_job_spare_used a
LEFT JOIN tbl_spare_part b ON b.spare_part_id = a.spare_part_id
LEFT JOIN tbl_job c ON c.job_id = a.job_id
LEFT JOIN tbl_user d ON c.responsible_user_id = d.user_id
LEFT JOIN tbl_customer_branch e ON c.customer_branch_id = e.customer_branch_id
LEFT JOIN tbl_customer f ON e.customer_id = f.customer_id
WHERE a.spare_used_id = '$spare_used_id' AND c.job_id = '$job_id'";
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
$sql_chk = "SELECT * FROM tbl_customer_group_part_price WHERE customer_group_id = '{$row['customer_group']}' AND spare_part_id = '{$row['spare_part_id']}' ";
$result_chk  = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_num_rows($result_chk);

if ($row_chk > 0) {

    $sql_group_part = "SELECT expire_date FROM tbl_customer_group WHERE customer_group_id = '{$row['customer_group']}' AND active_status = 1";
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


if ($row['insurance_status'] == 1) {
    $chk = "Checked";
} else {
    $chk = "";
}

////////////////option loop//////////////
$result_option  = mysqli_query($connect_db, $sql);


$sql_wtt = "SELECT * FROM tbl_warranty_type WHERE active_status = 1";
$result_wtt  = mysqli_query($connect_db, $sql_wtt);

?>
<form action="" method="post" id="form-edit_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input id="spare_used_id" name="spare_used_id" value="<?php echo $spare_used_id ?>" type="hidden">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="group_id" name="group_id" value="<?php echo $row_q_num['customer_group'] ?>" type="hidden">
            <input id="branch_id" name="branch_id" value="<?php echo $branch_id ?>" type="hidden">
            <div class="col-mb-3 col-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>

                            <th style="width:5%;">ประกัน</th>
                            <th style="width:20%;" class="text-center">อะไหล่</th>
                            <th style="width:10%;" class="text-center">on hand</th>
                            <th style="width:10%;" class="text-center">จำนวนใช้</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr name="" id="" value="<?php echo $i; ?>">
                            <input type="hidden" id="spare_used_id" name="spare_used_id" value="<?php echo $spare_used_id; ?>">

                            <td>


                                <select class='form-control select2' style="width:100%;" name='insurance_status' id='insurance_status'>
                                    <?php while ($row_wtt = mysqli_fetch_array($result_wtt)) { ?>
                                        <option value='0' <?php if ($row['insurance_type'] == $row_wtt['warranty_type_id']) {
                                                                echo "SELECTED";
                                                            } ?>><?php echo $row_wtt['warranty_type_name'] ?></option>
                                    <?php } ?>


                                </select>

                            </td>
                            <td>
                                <select name="spare_part" id="spare_part" style="width: 100%;" onchange="select_part_edit(this.value);" class="form-control select2 spare_part">
                                    <?php $i = 1;
                                    while ($row_option = mysqli_fetch_array($result_option)) { ?>
                                        <option value="<?php echo $row_option['spare_part_id'] ?>" <?php echo ($row_option['spare_part_id'] == $spare_used_id) ? '' : 'SELECTED' ?>><?php echo $row_option['spare_part_code'] . " " . $row_option['spare_part_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control Onhand" readonly name="Onhand" id="Onhand" value="<?php echo $on_hand ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control quantity" name="quantity" id="quantity" value="<?php echo $row['quantity'] ?>">
                            </td>
                            <input type="hidden" class="form-control" readonly name="cost" id="cost" value="<?php echo $default_cost ?>">
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="update_spare()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {


        // var insurance_status = <?= $insurance_status ?>;
        // if (insurance_status == 1) {

        //     $('#chkbox_edit').iCheck({
        //         checkboxClass: 'icheckbox_square-green checked',
        //     });
        // } else {
        //     $('#chkbox_edit').iCheck('uncheck');
        // }

        $('#chkbox_edit').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        }).on('ifChanged', function(e) {
            if ($('#chkbox_edit').is(':checked') == true) {
                $('#insurance_status').val('1');
            } else {
                $('#insurance_status').val('0');
            }
        });


    });







    function select_part_edit(part_id) {

        var group_id = $('#group_id').val();
        var responsible_user_id = $('#responsible_user_id').val();

        $.ajax({
            url: 'ajax/CM_view/Get_part.php',
            type: 'POST',
            dataType: 'json',
            data: {
                part_id: part_id,
                group_id: group_id,
                responsible_user_id: responsible_user_id
            },
            success: function(data) {

                $('#Onhand').val(data.remain_stock);
                $('#cost').val(data.unit_price);

            }
        });

    }


    function update_spare() {

        var spare_part = $('.spare_part').val();
        var quantity = $('.quantity').val();
        var Onhand = $('.Onhand').val();

        var formData = new FormData($("#form-edit_spare")[0]);

        if (spare_part == "" || quantity == "" || Onhand == "") {
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
                url: 'ajax/CM_view/update_spare_part.php',
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

                        $(".tab_head").removeClass("active");
                        $(".tab_head h4").removeClass("font-weight-bold");
                        $(".tab_head h4").addClass("text-muted");

                        $(".tab-pane").removeClass("show");
                        $(".tab-pane").removeClass("active");
                        $("#tab_head_1").children("h4").removeClass("text-muted");
                        $("#tab_head_1").children("h4").addClass("font-weight-bold");
                        $("#tab_head_1").addClass("active");

                        current_fs = $(".active");

                        // next_fs = $(this).attr('id');
                        // next_fs = "#" + next_fs + "1";

                        // $(".tab_head").removeClass("show");
                        $('#tab-1').addClass("active");

                        current_fs.animate({}, {
                            step: function() {
                                current_fs.css({
                                    'display': 'none',
                                    'position': 'relative'
                                });
                                next_fs.css({
                                    'display': 'block'
                                });
                            }
                        });
                        load_table_total_service();
                        document.getElementById("spare_quantity").innerHTML = data.spare_quantity
                        document.getElementById("total_spare").innerHTML = data.total_spare
                        document.getElementById("td_total").innerHTML = data.td_total
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