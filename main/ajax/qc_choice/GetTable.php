<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$topic_qc_id = mysqli_real_escape_string($connection, $_POST['topic_qc_id']);
$status = mysqli_real_escape_string($connection, $_POST['status']);


$condition = "";
if ($status != '0') {
    $condition .= "AND active_status = '1' ";
} else if ($status == '0') {
    $condition;
}

$sql = "SELECT * FROM tbl_qc_checklist WHERE topic_qc_id = '$topic_qc_id' $condition  ORDER BY create_datetime DESC";
$res = mysqli_query($connection, $sql);

?>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="width:20%;">หัวข้อ</th>
            <th class="text-center" style="width:20%;">วิธีการ QC</th>
            <th class="text-center" style="width:20%;">เกณฑ์การยอมรับ QC ผ่าน</th>
            <th class="text-center" style="width:10%;">จำนวนครั้ง QC</th>
            <th class="text-center" style="width:15%;">ใช้เวลา QC (นาที)</th>
            <th class="text-center" style="width:15%;">ประเภทตัวเลือก</th>
            <th class="text-center" style="width:10%;">สถานะ</th>
            <th class="text-center" style="width:15%;">จัดการ</th>
        </tr>
    </thead>
    <tbody>

        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr id="tr_<?php echo $row['checklist_id']; ?>">
                <td class="text-center">
                    <?php echo $row['checklist_name']; ?> <br>
                    <?php
                    $sql_choice = "SELECT * FROM tbl_qc_choicelist WHERE checklist_id = '{$row['checklist_id']}'";
                    $res_choice = mysqli_query($connection, $sql_choice);
                    ?>

                    <?php while ($row_choice = mysqli_fetch_assoc($res_choice)) { ?>

                        <?php echo $row_choice['choice_detail'] ?>/
                    <?php } ?>

                </td>
                <td class="text-center"><?php echo $row['description']; ?></td>
                <td class="text-center"><?php echo $row['description_way']; ?></td>
                <td class="text-center"><?php echo $row['description_acceptance']; ?></td>
                <td class="text-center"><?php echo $row['description_time']; ?></td>

                <td class="text-center">
                    <?php if ($row['checklist_type'] == '1') { ?>
                        <label for="">ช่องกรอกข้อมูล</label>
                        <!-- <input type="text" class="form-control"> -->
                    <?php } else if ($row['checklist_type'] == '2') { ?>
                            <label for="">ตัวเลือก</label>

                    <?php } else if ($row['checklist_type'] == '3') { ?>
                                <label for="">เครื่องหมายเช็ค</label>
                                <!-- <input type="checkbox" class="form-control"> -->
                    <?php } ?>
                </td>
                <td class="text-center">
                    <button
                        class="btn btn-xs <?php echo ($row['active_status'] == 1) ? 'btn-primary' : 'btn-danger'; ?> w-100"
                        onclick="ChangeStatus(this,'<?php echo $row['checklist_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'ใช้งาน' : 'ไม่ใช้งาน'; ?>
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-warning btn-xs w-100 mb-2"
                        onclick="GetModalEdit('<?php echo $row['checklist_id'] ?>','<?php echo $topic_qc_id ?>')">แก้ไข</button>
                    <button class="btn btn-danger btn-xs w-100 mb-2"
                        onclick="DeleteList('<?php echo $row['checklist_id'] ?>')">ลบ</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(".select2").select2();
</script>