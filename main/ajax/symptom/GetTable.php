<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$list = array();

$sql = "SELECT * FROM tbl_symptom_type";
$result  = mysqli_query($connect_db, $sql);

while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "symptom_type_id" => $row['symptom_type_id'],
        "symptom_type_name" => $row['type_name'],
        "active_status" => $row['active_status'],
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:50%;">อาการ</th>
            <th style="width:10%;">สถานะ</th>
            <th style="width:10%;"></th>

        </tr>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $row['symptom_type_name']; ?></td>

                <td>
                    <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['symptom_type_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                </td>
                <td>
                    <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['symptom_type_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>