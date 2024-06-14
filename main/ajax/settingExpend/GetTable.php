<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $sql = "SELECT et.*
        FROM tbl_expend_type et
        ORDER BY et.expend_type_name ASC";
    $rs = mysqli_query($connection, $sql);
    $list = array();
    while ($row = mysqli_fetch_array($rs)) {
        $temp_array = array(
            "expend_type_id" => $row["expend_type_id"],
            "expend_code" => $row["expend_code"],
            "create_datetime" => $row["create_datetime"],
            "active_status" => $row["active_status"],
            "expend_type_name" => $row["expend_type_name"],
            "description" => $row["description"],
        );
        array_push($list, $temp_array);
    }
?>
<table class="table table-bordered border-top" id="myTable" style="width:100%">
    <thead>
        <tr>
            <th class="text-center">รหัส</th>
            <th class="text-center">ประเภทค่าใช้จ่าย</th>
            <th class="text-center">รายละเอียด</th>
            <th class="text-center" style="width:60px;">สถานะ</th>
            <th class="text-center" style="width:100px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $row) { ?>
        <tr id="tr_<?php echo $row["expend_type_id"]; ?>">
            <td class="text-center pb-0">
                <p><?php echo ($row["expend_code"] != "" ? $row["expend_code"] : "-"); ?></p>
            </td>
            <td class="text-center pb-0">
                <p><?php echo ($row["expend_type_name"] != "" ? $row["expend_type_name"] : "-"); ?></p>
            </td>
            <td class="text-center pb-0">
                <p><?php echo ($row["description"] != "" ? $row["description"] : "-"); ?></p>
            </td>
            <td>
                <div class="onoffswitch">
                    <input type="checkbox" class="onoffswitch-checkbox"
                        <?php if($row["active_status"] == "1"){ echo "checked"; } ?>
                        onchange='ChangeStatus(value,"expend_type_id","tbl_expend_type");'
                        value="<?php echo $row["expend_type_id"]; ?>"
                        id="StatusReq-<?php echo $row["expend_type_id"]; ?>">
                    <label class="onoffswitch-label" for="StatusReq-<?php echo $row["expend_type_id"]; ?>">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>
            </td>
            <td class="text-center pb-0">
                <button class="btn btn-xs btn-block btn-warning"
                    onclick="EditExpend('<?php echo $row['expend_type_id']; ?>');"><i class="fa fa-edit"></i>
                    แก้ไข</button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php mysqli_close($connection); ?>