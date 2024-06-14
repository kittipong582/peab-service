<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$list = array();

// $spare_type_id = $_POST['spare_type'];

$sql = "SELECT a.*,b.spare_type_name FROM tbl_spare_part a 
LEFT JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id
WHERE a.active_status = 1 ORDER BY a.spare_part_name";
$result  = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $spare_part_image = ($row['spare_part_image'] != "") ? $row['spare_part_image'] : 'No-Image.png';

    $temp_array = array(
        "spare_part_id" => $row['spare_part_id'],
        "spare_part_name" => $row['spare_part_name'],
        "spare_part_image" => $spare_part_image,
        "spare_part_code" => $row['spare_part_code'],
        "spare_part_unit" => $row['spare_part_unit'],
        "spare_part_des" => $row['spare_part_des'],
        "spare_type_name" => $row['spare_type_name'],
        "active_status" => $row['active_status'],
        "default_cost" => $row['default_cost'],
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:7%;">#</th>
            <!-- <th class="text-center">รูปอะไหล่</th> -->
            <th class="text-center">ประเภทอะไหล่</th>
            <th style="width:12%;" class="text-center">ชื่ออะไหล่</th>
            <th style="width:12%;" class="text-center">รหัสอะไหล่</th>
            <th style="width:10%;" class="text-center">หน่วยนับ</th>
            <th class="text-center">ราคาทั่วไป</th>
            <th class="text-center">คำอธิบาย</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <!-- <td><img src="upload/<?php echo $row['spare_part_image']; ?>" alt="" style="height: 120px;"></td> -->
                <td><?php echo $row['spare_type_name']; ?></td>
                <td><?php echo $row['spare_part_name']; ?></td>
                <td><?php echo $row['spare_part_code']; ?></td>
                <td><?php echo $row['spare_part_unit']; ?></td>
                <td class="text-right"><?php echo number_format($row['default_cost'],2); ?></td>
                <td><?php echo nl2br($row['spare_part_des']); ?></td>
                <td>
                    <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['spare_part_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                    <button class="btn btn-xs btn-success btn-block" type="button" onclick="ModalGroup('<?php echo $row['spare_part_id']; ?>')">
                        กลุ่มราคา
                    </button>
                    <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['spare_part_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>