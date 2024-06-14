<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$year_list = date("Y-m-d H:i:s");
$pm_setting_id = mysqli_escape_string($connection, $_POST['pm_setting_id']);



$sql_pm_setting = "SELECT * FROM tbl_pm_setting a WHERE a.pm_setting_id = '$pm_setting_id'";
$res_pm_setting = mysqli_query($connection, $sql_pm_setting);
$row_pm_setting = mysqli_fetch_array($res_pm_setting);


$sql = "SELECT * FROM  tbl_product_type WHERE active_status = 1";
$res = mysqli_query($connection, $sql);

// echo "$sql";
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มประเภทเครื่อง</h5>
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
                    <input type="text" class="form-control mb-3" id="setting_name" name="setting_name"
                        value="<?php echo $row_pm_setting['setting_name']; ?>">
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>ประเภทเครื่อง</strong> <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="type_id" id="type_id" style="width: 100%;">
                        <option value="">กรุณาเลือก</option>
                        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                            <option value="<?php echo $row['type_id'] ?>" <?php echo ($row['type_id'] == $row_pm_setting['product_type_id'] ? "selected" : ""); ?>>
                                <?php echo $row['type_code'] . '' . $row['type_name']; ?>
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
                            $selected = ($i == $row_pm_setting['year_list']) ? 'selected' : ''; // Check if $i matches the selected value
                            echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                        }
                        ?>
                    </select>


                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>
<?php include('import_script.php'); ?>
<Script>
    $(document).ready(function () {

        $(".select2").select2({});
    });
</Script>