<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$audit_id = mysqli_real_escape_string($connection, $_POST['audit_id']);
$status = mysqli_real_escape_string($connection, $_POST['status']);


$condition = "";
if ($status != '0') {
    $condition .= "AND active_status = '1' ";
} else if ($status == '0') {
    $condition .= "AND active_status = '0' ";
}

$sql = "SELECT * FROM tbl_audit_topic WHERE audit_id = '$audit_id'$condition";
$res = mysqli_query($connection, $sql);

?>
<table class="table table-striped table-bordered table-hover">

    <thead>
        <tr>
            <th class="text-center" style="width:70%;">หัวข้อ</th>
            <th class="text-center" style="width:10%;">สถานะ</th>
            <th class="text-center" style="width:10%;">จัดการ</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr id="tr_<?php echo $row['topic_id']; ?>">
                <td>
                    <a onclick="GetChoiceList('<?php echo $row['topic_id']; ?>')">
                        <?php echo $row['topic_datail']; ?>
                    </a>
                </td>
                <td>
                    <button
                        class="btn btn-xs <?php echo ($row['active_status'] == 1) ? 'btn-primary' : 'btn-danger'; ?> w-100"
                        onclick="ChangeStatus(this,'<?php echo $row['topic_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'ใช้งาน' : 'ไม่ใช้งาน'; ?>
                    </button>
                </td>
                <td>
                  
                    <a href="audit_choice_list.php?topic_id=<?php echo $row['topic_id']; ?>"
                            class="btn btn-info btn-xs w-100 mb-2">รายละเอียด</a>

                    <button class="btn btn-warning btn-xs w-100 mb-2"
                        onclick="GetModalEdit('<?php echo $row['topic_id']; ?>')">แก้ไข</button>

                    <button class="btn btn-danger btn-xs w-100 mb-2"
                        onclick="DeleteList('<?php echo $row['topic_id']; ?>')">ลบ</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>