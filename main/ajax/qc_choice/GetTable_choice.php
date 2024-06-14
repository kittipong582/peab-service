<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);

$sql = "SELECT * FROM tbl_qc_choicelist WHERE checklist_id = '$checklist_id' ORDER BY list_order ASC";
$res = mysqli_query($connection, $sql);;

?>
<table class="table table-striped table-bordered table-hover">
    <input type="hidden" id="checklist_id" name="checklist_id" value="<?php echo $checklist_id ?>">

    <div class="input-group mb-3">
        <input type="text" id="choice_detail" name="choice_detail" class="form-control" placeholder="" aria-describedby="button-addon2">
        <button class="btn btn-primary" type="button" id="button-addon2" onclick="AddChoice()">เพิ่ม</button>
    </div>
    <thead>
        <tr>
            <th class="text-center" style="width: 5%;">x</th>
            <th class="text-center" style="width:80%;">ตัวเลือก</th>
        </tr>
    </thead>
    <tbody>
        <tr>

        </tr>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><button type="button" class="btn btn-danger btn-sm w-100" onclick="DeleteChoice('<?php echo $row['choicelist_id']; ?>')">ลบ</button></td>
                <td><?php echo $row['choice_detail']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>