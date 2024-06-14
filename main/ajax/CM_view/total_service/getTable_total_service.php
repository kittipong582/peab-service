<?php
session_start();

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$current_user_id = $_SESSION['user_id'];
$admin_status = $_SESSION['admin_status'];
$sql_current = "SELECT responsible_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_current = mysqli_query($connect_db, $sql_current) or die($connect_db->error);
$row_current = mysqli_fetch_assoc($rs_current);


$sql_count = "SELECT COUNT(*) AS num FROM tbl_job_spare_used b 
LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id
WHERE b.job_id = '$job_id'";
$rs_count = mysqli_query($connect_db, $sql_count) or die($connect_db->error);
$row_count = mysqli_fetch_assoc($rs_count);

$sql_count_id = "SELECT count(*) as num_in FROM tbl_job_income b 
LEFT JOIN tbl_income_type c ON b.income_type_id = c.income_type_id
 WHERE b.job_id = '$job_id'";
$rs_count_id = mysqli_query($connect_db, $sql_count_id) or die($connect_db->error);
$row_count_in = mysqli_fetch_assoc($rs_count_id);

?>

<div class="table-responsive">

    <table class="table total_service_tbl table-striped table-hover table-bordered">

        <thead>

            <tr>

                <th width="2%">#</th>

                <th width="35%" class="text-left">รายการ</th>

                <th width="5%" class="text-center">จำนวน</th>

                <th width="5%" class="text-center">ราคา</th>

                <th width="5%" class="text-center">รวม</th>

                <th width="5%" class="text-center"></th>


            </tr>

        </thead>

        <tbody>

            <?php



            $i = 0;

            if ($row_count['num'] > 0) {

                $sql = "SELECT * FROM tbl_job a
LEFT JOIN tbl_job_spare_used b ON b.job_id = a.job_id
LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id
LEFT JOIN tbl_warranty_type d ON d.warranty_type_id = b.insurance_type
WHERE a.job_id = '$job_id'";

                $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
                while ($row = mysqli_fetch_assoc($rs)) {

                    $insurance = $row['warranty_type_name'];
                    $i++;
                    if ($row['insurance_status'] == 1) {
                        $unit_price = 0;

                        $cost = 0;

                        if ($row['insurance_type'] == 1) {
                        } else if ($row['insurance_type'] == 2) {
                        }
                    } else {

                        $unit_price = $row['unit_price'];

                        $cost = $unit_price / $row['quantity'];
                    }
            ?>
                    <tr id="tr_<?php echo $row['spare_used_id']; ?>">

                        <td><?php echo $i; ?></td>

                        <td>
                            <?php echo " ( " . $row['spare_part_code'] . " ) " . "<br>" . $row['spare_part_name']; ?>
                            <?php echo "</br> " . $insurance; ?>
                        </td>

                        <td class="text-right">
                            <?php echo number_format($row['quantity']); ?>
                        </td>

                        <td class="text-right">
                            <?php echo number_format($cost, 2); ?>
                        </td>

                        <td class="text-right total">
                            <?php echo number_format($unit_price, 2); ?>
                        </td>

                        <td class="text-center">
                            <?php if ($current_user_id == $row['responsible_user_id'] || $admin_status == 9) { ?>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-warning btn-block " onclick="edit_item_spare('<?php echo $row['spare_used_id']; ?>','<?php echo $row['job_id'] ?>');">แก้ไข</button>

                                    <button class="btn btn-sm btn-danger  btn-block " onclick="delete_item_spare('<?php echo $row['spare_used_id']; ?>','<?php echo $row['job_id'] ?>');">ลบ</button>
                                </div>
                            <?php } ?>
                        </td>

                    </tr>

            <?php }
            } ?>

            <?php

            if ($row_count_in['num_in'] > 0) {

                $sql_income = "SELECT * FROM tbl_job a
LEFT JOIN tbl_job_income b ON b.job_id = a.job_id
LEFT JOIN tbl_income_type c ON b.income_type_id = c.income_type_id
 WHERE a.job_id = '$job_id'";

                $rs_income = mysqli_query($connect_db, $sql_income) or die($connect_db->error);

                while ($row = mysqli_fetch_assoc($rs_income)) {

                    $i++;

                    $total_service = $row['quantity'] * $row['income_amount']

            ?>
                    <tr id="tr_<?php echo $row['job_income_id']; ?>">

                        <td><?php echo $i; ?></td>

                        <td>

                            <?php echo $row['income_type_name']; ?>

                        </td>

                        <td class="text-right">

                            <?php echo number_format($row['quantity']); ?>

                        </td>

                        <td class="text-right">

                            <?php echo number_format($row['income_amount'], 2); ?>

                        </td>

                        <td class="text-right total">
                            <?php echo number_format($total_service,2) ?>

                        </td>


                        <td class="text-center">

                            <div class="form-group">
                                <button class="btn btn-sm btn-warning btn-block " onclick="edit_item_income('<?php echo $row['job_income_id']; ?>');">แก้ไข</button>
                                <button class="btn btn-sm btn-danger btn-block " onclick="delete_item_income('<?php echo $row['job_income_id']; ?>');">ลบ</button>
                            </div>
                        </td>


                    </tr>

            <?php }
            } ?>

            <tr>
                <td>


                </td>

                <td class="">

                    รวม


                </td>

                <td class="text-right">

                </td>

                <td class="text-right">
                </td>

                <td class="text-right" id="td_total"></td>


                <td class="text-center">


                </td>

            </tr>

        </tbody>

    </table>

</div>

<script>
    $(document).ready(function() {

        var final = 0;

        $(".total").each(function() {
            final += parseFloat(CutCommas($(this).html()) || 0);

        });

        $("#td_total").html(addCommas(final));
    });


    function addCommas(nStr)

    {

        if (isNaN(nStr)) {



            return 0;

        } else {

            nStr = Math.round(nStr * 100) / 100;

            nStr += '';

            x = nStr.split('.');

            x1 = x[0];

            x2 = x.length > 1 ? '.' + x[1] : '';

            var rgx = /(\d+)(\d{3})/;

            while (rgx.test(x1)) {

                x1 = x1.replace(rgx, '$1' + ',' + '$2');

            }

            return x1 + x2;

        }

    }


    function CutCommas(nStr) {

        var replaced = nStr.replace(/\,/g, '');

        return replaced;

    }



    function edit_item_income(job_income_id) {
        $.ajax({
            type: "post",
            url: "ajax/CM_view/income/Modal_edit_income.php",
            data: {
                job_income_id: job_income_id
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

            }
        });
    }
</script>