<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");



$status = mysqli_real_escape_string($connection, $_POST['status']);
$topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);


$condition = "";
if ($status != '0') {
    $condition .= "AND active_status = '1' ";
} else if ($status == '0') {
    $condition .= "AND active_status = '0' ";
}

$sql = "SELECT * FROM tbl_audit_checklist WHERE topic_id = '$topic_id'  $condition  ORDER BY list_order ASC";
$res = mysqli_query($connection, $sql);


?>
<div class="row">
    <div class="col-md-12 col-sm-12 mt-1">
        <button type="button" class="btn btn-info btn-sm m-t-n-xs mr-1" id="ShowButton" onclick="ShowButtonSet();"><i
                class="fa fa-cogs"></i> ตั้งค่าจัดลำดับ</button>
        <button type="button" class="btn btn-info btn-sm m-t-n-xs mr-1" id="HideButton" onclick="HideButtonSet();"
            style="display: none;"><i class="fa fa-reply"></i> ยกเลิกจัดลำดับ</button>
        <button type="button" class="btn btn-warning btn-sm m-t-n-xs mr-1" id="SortButton" onclick="SortData();"
            style="display: none;"><i class="fa fa-retweet"></i> จัดลำดับ</button>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="hr-line-dashed mt-3 pt-1"></div>
    </div>
</div>
<div class="table-responsive mt-2">
    <table class="table table-bordered border-top table-hover" id="myTable" style="width:100%">
        <thead>
            <tr>
                <th class="text-center p-2 td_move" style="width: 50px; display: none;">Move</th>
                <th class="text-center" style="width:5%;">ลำดับ</th>
                <th class="text-center" style="width:50%;">หัวข้อ</th>
                <th class="text-center" style="width:25%;">รายละเอียด</th>
                <th class="text-center" style="width:10%;">สถานะ</th>
                <th class="text-center" style="width:10%;">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($res)) {
                $sql_score = "SELECT * FROM tbl_audit_score  WHERE checklist_id = '{$row['checklist_id']}' ORDER BY list_order ASC";
                $res_score = mysqli_query($connection, $sql_score);

                ?>
                <tr id="tr_<?php echo $row["checklist_id"]; ?>" class="tr_move">
                    <td class="text-center align-middle p-2 td_move" style="display: none;">
                        <i class="fa fa-arrows fa-2x"></i>
                    </td>
                    <td class="text-center align-middle p-2 td_move">
                        <?php echo $i += 1; ?>
                    </td>
                    <td class="text-left p-2">
                        <input type="hidden" name="checklist_id[]" value="<?php echo $row['checklist_id']; ?>">
                        <?php echo $row['checklist_name']; ?><br>
                        <!-- ตัวเลือก : พอใช้ / ดี / ดีมาก -->
                        <?php echo ' ตัวเลือก:  ' ?>
                        <?php while ($row_score = mysqli_fetch_assoc($res_score)) {
                            echo $row_score['score_name'] . '/';
                        }
                        ; ?>
                    </td>

                    <td class="text-left p-2">
                        <?php echo $row['description']; ?>
                    </td>

                    <td class="text-center p-2">
                        <button
                            class="btn btn-xs <?php echo ($row['active_status'] == 1) ? 'btn-primary' : 'btn-danger'; ?> w-100"
                            onclick="ChangeStatus(this,'<?php echo $row['checklist_id']; ?>')">
                            <?php echo ($row['active_status'] == 1) ? 'ใช้งาน' : 'ไม่ใช้งาน'; ?>
                    </td>

                    <td class="text-center pl-3 pr-3 pt-2">
                        <button class="btn btn-warning btn-xs w-100 mb-2"
                            onclick="GetModalEdit('<?php echo $row['topic_id']; ?>','<?php echo $row['checklist_id']; ?>')">แก้ไข</button>

                        <button class="btn btn-danger btn-xs w-100 mb-2"
                            onclick="DeleteList('<?php echo $row['checklist_id'] ?>','<?php echo $row['topic_id']; ?>')">ลบ</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>