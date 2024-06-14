<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$sql = "SELECT * FROM tbl_zone_oh";
$res = mysqli_query($connection, $sql) or die($connection->error);

$i = 0;
?>

<table id="table_zone" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:50%;">ชื่อเขต</th>
            <th class="text-center" style="width:10%;">สถานะ</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td>
                    <?php echo $row['area_name'] ?>
                </td>
                <td>
                    <button
                        class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>"
                        onclick="ChangeStatus(this,'<?php echo $row['area_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                    <button class="btn btn-xs btn-warning btn-block" type="button"
                        onclick="ModalEdit('<?php echo $row['area_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
