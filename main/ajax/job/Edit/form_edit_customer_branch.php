<?php

$sql_sub_job = "SELECT * FROM tbl_sub_job_type WHERE job_type = '{$row['job_type']}' AND active_status = 1";
$rs_sub_job = mysqli_query($connect_db, $sql_sub_job);

?>



<div class="row mb-3">

    <div class="mb-3 col-3">
        <label>ประเภทงานย่อย</label><br>
        <select id="sub_job_type_id" name="sub_job_type_id" style="width: 100%;" class="form-control select2">

            <option value="">กรุณาเลือก</option>
            <?php while ($row_sub_job = mysqli_fetch_assoc($rs_sub_job)) { ?>
            <option value="<?php echo $row_sub_job['sub_job_type_id'] ?>"
                <?php echo ($row_sub_job['sub_job_type_id'] == $row['sub_job_type_id']) ? "SELECTED" : "" ?>>
                <?php echo $row_sub_job['sub_type_name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3 col-3">
        <label>ค้นหาจาก</label><br>
        <select id="search_type" name="search_type" style="width: 100%;" class="form-control select2">

            <option value="">กรุณาเลือก</option>
            <option value="1">รหัสลูกค้า</option>
            <option value="2">ชื่อลูกค้า</option>

        </select>
    </div>



    <div class="mb-3 col-3">
        <label>คำค้นหา</label><br>
        <div class="input-group">
            <input type="text" class="form-control" id="search_text_customer" name="search_text_customer">
            <span class="input-group-append"><button type="button" id="btn_search" name="btn_search"
                    onclick="Modal_get_customer()" class="btn btn-primary">ค้นหา</button></span>

        </div>
    </div>



    <div class="mb-3 col-3" id="point_branch">

    </div>


</div>