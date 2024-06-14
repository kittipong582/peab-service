<?php 
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



$sql = "SELECT * FROM tbl_oth_open_job_service ";
$result  = mysqli_query($connect_db, $sql);{

    $temp_array = array(
        "service_id" => $row['service_id'],
        "service_name" => $row['service_name'],
        "unit" => $row['unit'],
        "unit_cost" => $row['unit_cost'],
        "active_status" => $row['active_status'],
    );

    array_push($list,$temp_array);
}
?>

<table class="table table-striped table-bordered table-hover dataTables-example">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:20%;">การบริการ</th>
            <th style="width:20%;">หน่วย</th>
            <th style="width:40%;">ต้นทุนต่อหน่วย</th>
            <th style="width:10%;">สถานะ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 0;
        while($row = mysqli_fetch_array($result)) { 
            ?>
        <tr>
            <td><?php echo ++$i; ?></td>

            <td><?php echo $row['service_name']; ?></td>

            <td><?php echo $row['unit']; ?></td>

            <td><?php echo $row['unit_cost']; ?></td>
            <td>
                <button
                    class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger' ; ?>"
                    onclick="ChangeStatus(this,'<?php echo $row['service_id']; ?>')">
                    <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน' ; ?>
                </button>

            </td>

            <td>

                <button class="btn btn-xs btn-warning btn-block" type="button"
                    onclick="ModalEdit('<?php echo $row['service_id']; ?>')">
                    แก้ไขข้อมูล
                </button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>