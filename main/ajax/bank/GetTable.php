<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$sql = "SELECT et.*
        FROM tbl_bank et
        ORDER BY et.bank_name ASC";
$rs = mysqli_query($connection, $sql);
$list = array();
while ($row = mysqli_fetch_array($rs)) {
    $temp_array = array(
        "bank_id" => $row["bank_id"],
        "bank_name" => $row["bank_name"],
        "active_status" => $row["active_status"],
    );
    array_push($list, $temp_array);
}
?>
<table class="table table-bordered border-top" id="myTable" style="width:100%">
    <thead>
        <tr>
        <th style="width:5%;">#</th>
            <th style="width:45%;" >ธนาคาร</th>
            <th class="" style="width:10%;" >สถานะ</th>
            <th class="" style="width:10%;"></th>

        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        foreach ($list as $row) {
            $i++; ?>
            <tr id="tr_<?php echo $row["bank_id"]; ?>">

                <td class="text-center pb-0">
                    <p><?php echo $i; ?></p>
                </td>


                <td class=" pb-0">
                    <p><?php echo ($row["bank_name"] != "" ? $row["bank_name"] : "-"); ?></p>
                </td>

                <td>
                    <div class="onoffswitch">
                        <input type="checkbox" class="onoffswitch-checkbox" <?php if ($row["active_status"] == "1") {
                                                                                echo "checked";
                                                                            } ?> onchange='ChangeStatus(value,"bank_id");' value="<?php echo $row["bank_id"]; ?>" id="StatusReq-<?php echo $row["bank_id"]; ?>">
                        <label class="onoffswitch-label" for="StatusReq-<?php echo $row["bank_id"]; ?>">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </td>
                <td class="text-center pb-0">
                    <button class="btn btn-xs btn-block btn-warning" onclick="EditExpend('<?php echo $row['bank_id']; ?>');"><i class="fa fa-edit"></i>
                        แก้ไข</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php mysqli_close($connection); ?>