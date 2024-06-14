<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$sql = "SELECT  * FROM tbl_account a
    LEFT JOIN  tbl_bank b on  a.bank_id = b.bank_id ";
$rs = mysqli_query($connection, $sql);

?>
<table class="table table-bordered border-top" id="myTable" style="width:100%">
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:15%;">ธนาคาร</th>
            <th style="width:15%;">เลขบัญชี</th>
            <th class="" style="width:20%;">ชื่อบัญชี</th>
            <th style="width:30%;">สาขาธนาคาร</th>
            <th class="" style="width:10%;">ประเภทบัญชี</th>
            <th class="" style="width:20%;"></th>

        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($rs)) {
            $i++; ?>
            <tr id="tr_<?php echo $row["account_id"]; ?>">

                <td class="text-center pb-0">
                    <p><?php echo $i; ?></p>
                </td>

                <td class=" pb-0">
                    <p><?php echo ($row["bank_name"] != "" ? $row["bank_name"] : "-"); ?></p>
                </td>
                <td class=" pb-0">
                    <p><?php echo ($row["account_no"] != "" ? $row["account_no"] : "-"); ?></p>
                </td>
                <td class=" pb-0">
                    <p><?php echo ($row["account_name"] != "" ? $row["account_name"] : "-"); ?></p>
                </td>
                <td class=" pb-0">
                    <p><?php echo ($row["bank_branch_name"] != "" ? $row["bank_branch_name"] : "-"); ?></p>
                </td>

                <td>
                    <p><?php if ($row["account_type"] == 1) {
                            echo "บัญชี PTT";
                        } else if ($row["account_type"] == 2) {
                            echo "บัญชีทั่วไป";
                        }; ?></p>
                </td>
                <td class="text-center pb-0">
                    <button class="btn btn-xs btn-block btn-warning" onclick="EditExpend('<?php echo $row['account_id']; ?>');"><i class="fa fa-edit"></i>
                        แก้ไข</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php mysqli_close($connection); ?>