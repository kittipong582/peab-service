<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$list = array();

$sql = "SELECT * FROM tbl_spare_type";
$result  = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "spare_type_id" => $row['spare_type_id'],
        "spare_type_name" => $row['spare_type_name'],
        "active_status" => $row['active_status'],
    );

    array_push($list,$temp_array);
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th>ชื่อประเภทอะไหล่</th>
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
                <td><?php echo $row['spare_type_name']; ?></td>
                <td>
                    <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger' ; ?>" onclick="ChangeStatus(this,'<?php echo $row['spare_type_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน' ; ?>
                    </button>
                    <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['spare_type_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>