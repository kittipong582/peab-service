<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$value = $_POST['value'];
$month = date("m", strtotime("today"));


?>


<?php if ($value == 1 || $value == 2) { ?>

    



<?php } else if ($value == 3) { ?>
    <div class="form-group">
        <label>เดือน</label>
        <select class="form-control select2 supfliter" id="month" name="month" data-width="100%">

            <option value="1">มกราคม </option>
            <option value="2">กุมภาพันธ์ </option>
            <option value="3">มีนาคม </option>
            <option value="4">เมษายน </option>
            <option value="5">พฤษภาคม </option>
            <option value="6">มิถุนายน </option>
            <option value="7">กรกฎาคม </option>
            <option value="8">สิงหาคม </option>
            <option value="9">กันยายน </option>
            <option value="10">ตุลาคม </option>
            <option value="11">พฤศจิกายน </option>
            <option value="12">ธันวาคม </option>

        </select>
    </div>

<?php } else if ($value == 4) { ?>

    <div class="form-group">
        <label>ไตรมาส</label>
        <select class="form-control select2 supfliter" id="quarter" name="quarter" data-width="100%">
            <option value="1">1 </option>
            <option value="2">2 </option>
            <option value="3">3 </option>
            <option value="4">4 </option>
        </select>
    </div>

<?php } else if ($value == 5) { ?>

    <div class="form-group">
        <label>ราย6เดือน</label>
        <select class="form-control select2 supfliter" id="select_year" name="select_year" data-width="100%">
            <option value="1">ครึ่งปีแรก </option>
            <option value="2">ครึ่งปีหลัง </option>
        </select>
    </div>

<?php }  ?>