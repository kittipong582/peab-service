<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$spare_used_id = $_POST['spare_used_id'];
$sql = "SELECT *,a.quantity as num FROM tbl_job_spare_used a 
LEFT JOIN tbl_job b ON a.job_id = b.job_id
LEFT JOIN tbl_spare_part e ON a.spare_part_id = e.spare_part_id
LEFT JOIN tbl_spare_type f ON e.spare_type_id = f.spare_type_id
WHERE a.spare_used_id = '$spare_used_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$sql_ax = "SELECT SUM(quantity) as total_ax FROM tbl_spare_used_ax WHERE spare_used_id = '$spare_used_id'";
$result_ax  = mysqli_query($connect_db, $sql_ax);
$row_ax = mysqli_fetch_array($result_ax);

$remain  = $row['num'] - $row_ax['total_ax'];



if ($remain > 0) {
    $remain_ax = "<font color=red>" . number_format($remain) . "</font>";
} else if ($remain == 0) {

    $remain_ax = number_format($remain);
} else {
    $remain_ax = "<font color=red>" . number_format($remain) . "</font>";
}

?>

<form action="" method="post" id="form-add_ax" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong> <?php echo "อ้างอิงการเบิกอะไหล่" . " [ " . $row['spare_type_name'] . " ] " . $row['spare_part_name'] . " ( " . $row['spare_part_code'] . " ) ของงาน " . $row['job_no'] ?></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">

            <div class=" col-md-4 mb-3  text-center">
                <label><strong>จำนวนเบิก</strong></label><br>
                <label class="text-center"><?php echo number_format($row['num']) ?> </label>

            </div>
            <div class=" col-md-4 mb-3  text-center">
                <label><strong>บันทึกแล้ว</strong></label><br>
                <label class="text-center"><?php echo number_format($row_ax['total_ax']) ?> </label>
            </div>
            <div class=" col-md-4 mb-3  text-center">
                <label><strong>ยังไม่บันทึก</strong></label><br>
                <label class="text-center" id="remain_record"><?php echo $remain_ax ?> </label>
            </div>

            <?php if ($remain > 0) { ?>
                <div class=" col-md-3 mb-3 text-center">
                    <label><strong>เลขที่อ้างอิง AX</strong></label>
                    <font color="red"> **</font><br>
                    <input type="text" class="form-control" id="ref_ax" name="ref_ax"></input>
                </div>

                <div class=" col-md-3 mb-3  text-center">
                    <label><strong>วันที่เบิกจาก AX</strong></label><br>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input class="form-control datepicker2" readonly type="text" name="ax_date" id="ax_date" value="<?php echo date('d-m-Y', strtotime('today')); ?>">
                    </div>
                </div>
                <div class=" col-md-3 mb-3  text-center">
                    <label><strong>จำนวน</strong></label>
                    <font color="red"> **</font><br>
                    <input type="text" class="form-control" id="quantity" name="quantity"></input>
                </div>

                <div class="col-md-3 mb-3">
                    <br>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_ax();"><i class="fa fa-plus"></i>
                        เพิ่มรายการ
                    </button>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="spare_used_id" name="spare_used_id" value="<?php echo $spare_used_id ?>" type="hidden">
            <input id="group_id" name="group_id" value="<?php echo $row['customer_group'] ?>" type="hidden">
            <input id="responsible_user_id" name="responsible_user_id" value="<?php echo $row['responsible_user_id'] ?>" type="hidden">

            <div class="col-mb-3 col-12" id="Loading_ax">
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
            <div class="col-mb-3 col-12" id="show_table_ax">
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <!-- <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit()">บันทึก</button> -->
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        load_table_ax();

        $(".datepicker2").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
    });

    function load_table_ax() {

        var spare_used_id = $('#spare_used_id').val();

        $.ajax({
            type: 'POST',
            url: 'ajax/CM_view/getTable_ax.php',
            data: {
                spare_used_id: spare_used_id
            },
            dataType: 'html',
            success: function(response) {
                $('#show_table_ax').html(response);
                // $('.spare_part_tbl').DataTable({
                //     pageLength: 25,
                //     responsive: true,
                // });
                $('#Loading_ax').hide();
            }
        });
    }


    function removeTags(str) {
        if ((str === null) || (str === ''))
            return false;
        else
            str = str.toString();

        // Regular expression to identify HTML tags in 
        // the input string. Replacing the identified 
        // HTML tag with a null string.
        return str.replace(/(<([^>]+)>)/ig, '');
    }

    function add_ax() {

        var ax_date = $('#ax_date').val();
        var quantity = parseFloat($('#quantity').val());
        var ref_ax = $('.ref_ax').val();
        var remain_record = removeTags(document.getElementById("remain_record").innerHTML);
        var formData = new FormData($("#form-add_ax")[0]);
        var check = quantity > parseFloat(remain_record);

        if (ax_date == "" || ref_ax == "" || quantity == "" || check == true) {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ถูกต้อง',
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
                url: 'ajax/CM_view/Add_ax.php',
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

                        view_spare_used(data.spare_used_id);
                        load_table_spare();

                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'จำนวนอะไหล่ไม่พอ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    } else if (data.result == 0) {
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