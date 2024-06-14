<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$list = array();

$sql = "SELECT * FROM tbl_product_type";
$result = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "type_id" => $row['type_id'],
        "type_code" => $row['type_code'],
        "type_name" => $row['type_name'],
        "active_status" => $row['active_status'],
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th>รหัสประเภท</th>
            <th>ชื่อประเภท</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {
            ?>
            <tr>
                <td>
                    <?php echo ++$i; ?>
                </td>
                <td>
                    <?php echo $row['type_code']; ?>
                </td>
                <td>
                    <?php echo $row['type_name']; ?>
                </td>
                <td>
                    <a href="setting_qc.php?type_id=<?php echo $row['type_id']; ?>"
                        class="btn btn-xs btn-success btn-block">ตั้งค่าQC</a>

                    <button
                        class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>"
                        onclick="ChangeStatus(this,'<?php echo $row['type_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                    <button class="btn btn-xs btn-warning btn-block" type="button"
                        onclick="ModalEdit('<?php echo $row['type_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>