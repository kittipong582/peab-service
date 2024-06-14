<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

// $audit_id = mysqli_real_escape_string($connection, $_POST['audit_id']);
$status = mysqli_real_escape_string($connection, $_POST['status']);

$qc_id = $_POST['qc_id'];


$condition = "";
if ($status == '0') {
    $condition .= "AND active_status = '0' ";
} else {
    $condition .= "AND active_status = '1' ";
}


$sql = "SELECT * FROM tbl_qc_topic WHERE qc_id = '$qc_id' $condition";
$res = mysqli_query($connection, $sql);

?>
<table class="table table-striped table-bordered table-hover">

    <thead>
        <tr>
            <th class="text-center" style="width:70%;">Qc</th>
            <th class="text-center" style="width:10%;">สถานะ</th>
            <th class="text-center" style="width:10%;">จัดการ</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr id="tr_<?php echo $row['topic_qc_id']; ?>">
                <td>

                    <a onclick="GetChoiceList('<?php echo $row['topic_qc_id']; ?>')">
                        <?php echo $row['topic_detail']; ?>
                    </a>
                </td>
                <td>
                    <button
                        class="btn btn-xs <?php echo ($row['active_status'] == 1) ? 'btn-primary' : 'btn-danger'; ?> w-100"
                        onclick="ChangeStatus(this,'<?php echo $row['topic_qc_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'ใช้งาน' : 'ไม่ใช้งาน'; ?>
                    </button>
                </td>
                <td>

                    <a href="qc_choice.php?topic_qc_id=<?php echo $row['topic_qc_id']; ?>&qc_id=<?php echo $qc_id; ?>"
                        class="btn btn-info btn-xs w-100 mb-2">รายละเอียด</a>


                    <button class="btn btn-warning btn-xs w-100 mb-2"
                        onclick="GetModalEdit('<?php echo $row['topic_qc_id']; ?>')">แก้ไข</button>

                    <button class="btn btn-danger btn-xs w-100 mb-2"
                        onclick="DeleteList('<?php echo $row['topic_qc_id']; ?>')">ลบ</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>