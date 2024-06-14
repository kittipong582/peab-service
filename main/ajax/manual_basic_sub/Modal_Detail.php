<?php
include ("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$manual_sub_id = $_POST['manual_sub_id'];

$sql = "SELECT * FROM tbl_spare_broken WHERE manual_sub_id = '$manual_sub_id' ORDER BY 	create_datetime ASC";
$result = mysqli_query($connect_db, $sql); {

    $temp_array = array(
        "spare_broken_id" => $row['spare_broken_id'],
        "spare_type_id" => $row['spare_type_id'],
        "spare_part_id" => $row['spare_part_id']
    );

    array_push($list, $temp_array);
}



?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">รายละเอียด</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table id="table_broken" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th style="width:40%;">ประเภทอะไหล่</th>
                <th style="width:40%;">ชื่ออะไหล่</th>

                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo ++$i; ?></td>

                    <?php $sql_type = "SELECT * FROM tbl_spare_type WHERE spare_type_id = '{$row['spare_type_id']}'";
                    $res_type = mysqli_query($connect_db, $sql_type);
                    $row_type = mysqli_fetch_assoc($res_type); ?>

                    <td><?php echo $row_type['spare_type_name']; ?></td>

                    <?php $sql_spare = "SELECT * FROM tbl_spare_part WHERE spare_part_id = '{$row['spare_part_id']}'";
                    $res_spare = mysqli_query($connect_db, $sql_spare);
                    $row_spare = mysqli_fetch_assoc($res_spare); ?>

                    <td><?php echo $row_spare['spare_part_name']; ?></td>

                    <td>
                        <button class="btn btn-xs btn-danger btn-block" type="button"
                            onclick="Delete('<?php echo $row['spare_broken_id']; ?>')">
                            ลบ
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>