<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql = "SELECT YEAR(holiday_datetime) AS years FROM tbl_holiday GROUP BY years ORDER BY years ASC;";
$result  = mysqli_query($connect_db, $sql);

?>

<div class="row">
    <div class="col-3">
        <select class="form-control select2" name="year" id="year">
            <option value="<?php echo $row['years'] ; ?>">
                กรุณาเลือกปีเพื่อค้นหา
            </option>
            <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                <option value="<?php echo $row['years'] ; ?>">
                    <?php echo $row['years'] ; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-2 ibox">
        <button class="btn btn-xs btn-success" onclick="ModalSearch();">
            <i class="fa fa-search"></i> ค้นหา
        </button>
    </div>
</div>


