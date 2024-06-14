<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
?>

<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered dataTables-example income_tbl">

        <thead>

            <tr>

                <th width="2%">#</th>

                <th width="35%" class="text-center">ประเภทรายรับ</th>

                <th width="5%" class="text-center">จำนวน</th>

                <th width="5%" class="text-center">ราคา</th>

                <th width="5%" class="text-center">รวม</th>

                <th width="5%"></th>

            </tr>

        </thead>

        <tbody>

            <?php

            $sql = "SELECT * FROM tbl_job_income a
            LEFT JOIN tbl_income_type b ON a.income_type_id = b.income_type_id
            LEFT JOIN tbl_user c ON a.create_user_id = c.user_id
             WHERE a.job_id = '$job_id'";

            $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

            $i = 0;

            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;

                $total_income = $row['quantity'] * $row['income_amount'];

            ?>
                <tr id="tr_<?php echo $row['job_income_id']; ?>">

                    <td><?php echo $i; ?></td>

                    <td>

                        <?php echo $row['income_type_name']; ?>

                    </td>

                    <td class="text_right">

                        <?php echo $row['quantity']; ?>

                    </td>

                    <td class="text_right">

                        <?php echo $row['income_amount']; ?>

                    </td>

                    <td class="text_right">

                        <?php echo $total_income; ?>

                    </td>

                    <td class="text-center">

                        <div class="form-group">
                            <button class="btn btn-sm btn-danger " onclick="delete_item_income('<?php echo $row['job_income_id']; ?>');">ลบ</button>
                        </div>
                    </td>



                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<script>
   
</script>