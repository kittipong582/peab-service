<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");



$status = mysqli_real_escape_string($connection, $_POST['status']);


$condition = "";
if ($status != '0') {
    $condition .= "WHERE active_status = '1' ";
} else if ($status == '0') {
    $condition .= "WHERE active_status = '0' ";
}

$sql = "SELECT * FROM tbl_machine_status $condition";
$res = mysqli_query($connection, $sql);


?>

<div class="table-responsive mt-2">
    <table class="table table-bordered border-top table-hover" id="myTable" style="width:100%">
        <thead>
            <tr>
                <th class="text-center p-2 td_move" style="width: 50px; display: none;">Move</th>
                <th class="text-center" style="width:5%;">ลำดับ</th>
                <th class="text-center" style="width:50%;">ชื่อสถานะ</th>
                <th class="text-center" style="width:10%;">สถานะ</th>
                <th class="text-center" style="width:10%;">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($res)) {

                ?>
                <tr id="tr_<?php echo $row["status_id"]; ?>" class="tr_move">
                    <td class="text-center align-middle p-2 td_move" style="display: none;">
                        <i class="fa fa-arrows fa-2x"></i>
                    </td>
                    <td class="text-center align-middle p-2 td_move">
                        <?php echo $i += 1; ?>
                    </td>
                    <td class="text-left p-2">
                        <input type="hidden" name="status_id" value="<?php echo $row['status_id']; ?>">
                        <?php echo $row['status_name']; ?>
                    </td>

                    <td class="text-center p-2">
                        <button
                            class="btn btn-xs <?php echo ($row['active_status'] == 1) ? 'btn-primary' : 'btn-danger'; ?> w-100"
                            onclick="ChangeStatus(this,'<?php echo $row['status_id']; ?>')">
                            <?php echo ($row['active_status'] == 1) ? 'ใช้งาน' : 'ไม่ใช้งาน'; ?>
                        </button>
                    </td>

                    <td class="text-center pl-3 pr-3 pt-2">
                        <button class="btn btn-warning btn-xs w-100 mb-2"
                            onclick="GetModalEdit('<?php echo $row['status_id']; ?>')">แก้ไข</button>
                        <button class="btn btn-danger btn-xs w-100 mb-2"
                            onclick="DeleteList('<?php echo $row['status_id'] ?>')">ลบ</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>