<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);


// $year_list = mysqli_real_escape_string($connection, $_POST['year_list']);
$year_list = date("Y-m-d H:i:s");


$pm_setting_id = getRandomID(10, 'tbl_pm_setting', 'pm_setting_id ');

$sql = "SELECT * FROM tbl_product_type WHERE active_status = 1";
$res = mysqli_query($connection, $sql);

$sql_year = "SELECT a.year_list FROM tbl_pm_setting a";
$res_yaer = mysqli_query($connection, $sql_year);


// echo "$sql";
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มรายการ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="text" hidden name="pm_setting_id" value="<?php echo $pm_setting_id; ?>">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ชื่อ</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control mb-3" id="setting_name" name="setting_name">
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ประเภทเครื่อง</strong> <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="type_id" id="type_id" style="width: 100%;">
                        <option value="">กรุณาเลือก</option>
                        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                            <option value="<?php echo $row['type_id'] ?>">
                                <?php echo $row['type_code'] . ' ' . $row['type_name']; ?>

                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ปี</strong> <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="year_list" id="year_list" style="width: 100%;">
                        <?php
                        echo '<option value="">กรุณาเลือก</option>';
                        for ($i = $year_list - 1; $i <= $year_list + 1; $i++) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>
<?php include('import_script.php'); ?>
<Script>
    $(document).ready(function () {

        $(".select2").select2({});
    });
</Script>