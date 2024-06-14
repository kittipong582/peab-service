<?php
session_start();
include ("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$user_id = $_SESSION['user_id'];

$j_id = mysqli_real_escape_string($connect_db, $_POST['j_id']);


$sql = "SELECT a.*,b.branch_name FROM tbl_user a LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id WHERE NOT user_id = '$user_id' AND a.active_status = 1 ORDER BY branch_name ASC;";
$result = mysqli_query($connect_db, $sql);
?>

<style>
    .border-black {
        border: 1px solid black;
    }

    .select2-dropdown {
        z-index: 9999999;
    }
</style>
<form action="" method="post" id="form-add_staff" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>เพิ่มช่าง</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
        </div>
        <div class="col-12 mb-3">
            <label>รายชื่อช่าง </label>
            <input type="text" hidden name="j_id" id="j_id" value="<?php echo $j_id ?>">
            <font style="color: red;"> **</font>
            <select class="form-control select2 mb-3" style="width: 100%;" name="staff_id" id="staff_id">
                <option value="">กรุณาเลือกช่าง</option>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $row['user_id'] ?>">
                        <?php echo $row['branch_name'] . ' - ' .$row['fullname'];?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-white px-5" data-dismiss="modal">ปิด</button>
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_Staff()">บันทึก</button>
        
    </div>
</form>
<?php include ('import_script.php'); ?>
<script>
    $(document).ready(function () {

        $(".select2").select2({});
    });
</script>