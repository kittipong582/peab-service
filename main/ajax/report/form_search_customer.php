<?php
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connect_db = connectDB($secure);

$text = $_POST['text'];

?>

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label>ลูกค้า</label>
            <select class="form-control select2" id="customer" name="customer" data-width="100%" onchange="Getcusbranch(this.value),Getteam();">
                <option value="x" selected>ทั้งหมด </option>

                <?php

                $sql_c = "SELECT customer_id,customer_name  FROM tbl_customer WHERE customer_name LIKE '%$text%';";
                $rs_c = mysqli_query($connect_db, $sql_c);

                while ($row_c = mysqli_fetch_assoc($rs_c)) {

                ?>

                    <option value="<?php echo $row_c['customer_id'] ?>">
                        <?php echo $row_c['customer_name'] ?></option>


                <?php } ?>

            </select>
        </div>
    </div>


    <div class="col-md-6" id="getcusbranch">
        <div class="form-group">
            <label>สาขา</label>
            <select class="form-control select2" id="cus_branch" name="cus_branch" data-width="100%" onchange="Getteam(this.value)">
                <option value="x" selected>ทั้งหมด </option>

                <?php

                $sql_cb = "SELECT customer_branch_id,branch_name  FROM tbl_customer_branch ;";
                $rs_cb = mysqli_query($connect_db, $sql_cb);
                while ($row_cb = mysqli_fetch_assoc($rs_cb)) {

                ?>

                    <option value="<?php echo $row_cb['customer_branch_id'] ?>">
                        <?php echo $row_cb['branch_name'] ?></option>


                <?php } ?>

            </select>
        </div>
    </div>


    <div class="col-md-6" id="getteam">
        <div class="form-group">
            <label>ทีมงาน</label>
            <select class="form-control select2" id="team" name="team" data-width="100%" onchange="Getstaff(this.value)">
                <option value="x" selected>ทั้งหมด </option>
            </select>
        </div>
    </div>


    <div class="col-md-6" id="getstaff">
        <div class="form-group">
            <label>ช่างผู้ดูแล</label>
            <select class="form-control select2" id="staff" name="staff" data-width="100%">
                <option value="x" selected>ทั้งหมด </option>

                <?php

                $sql_u = "SELECT user_id,fullname  FROM tbl_user ;";
                $rs_u = mysqli_query($connect_db, $sql_u);
                while ($row_u = mysqli_fetch_assoc($rs_u)) {

                ?>

                    <option value="<?php echo $row_u['user_id'] ?>">
                        <?php echo $row_u['fullname'] ?></option>


                <?php } ?>

            </select>
        </div>
    </div>


</div>