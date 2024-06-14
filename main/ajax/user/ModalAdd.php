<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$sql = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$result  = mysqli_query($connect_db, $sql);
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มผู้ใช้งานระบบ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="text-center mb-3">
                    <label for="profile_image">
                        รูปโปรไฟล์
                    </label>
                    <p><img src="upload/user icon.png" id="show_file" class="w-50"></p>
                    <input type="file" class="form-control" name="profile_image" id="profile_image" onchange="ImageReadURL(this,value,'#show_file','upload/user icon.png');">
                </div>

                <label for="username">
                    รหัสพนักงาน <span class="text-danger">(ใช้สำหรับเข้าสู่ระบบ)</span>
                </label><font color="red">**</font>
                <input type="text" class="form-control mb-3" id="username" name="username">

                <label for="fullname">
                    ชื่อ-นามสกุล ผู้ใช้งาน
                </label><font color="red">**</font>
                <input type="text" class="form-control mb-3" id="fullname" name="fullname">

                <label for="mobile_phone">
                    เบอร์มือถือ <span class="text-danger">(ใช้สำหรับเป็นรหัสผ่าน)</span>
                </label><font color="red">**</font>
                <input type="text" class="form-control mb-3" id="mobile_phone" name="mobile_phone" $mobile_phone="mobile_phone" $password="password" ;>

                <label for="office_phone">
                    เบอร์ที่ทำงาน
                </label>
                <input type="text" class="form-control mb-3" id="office_phone" name="office_phone">

                <label for="email">
                    อีเมล
                </label>
                <input type="text" class="form-control mb-3" id="email" name="email">

                <label for="line_id">
                    Line ID
                </label>
                <input type="text" class="form-control mb-3" id="line_id" name="line_id">

                <label for="user_level">
                    สิทธิ์การใช้งาน
                </label><font color="red">**</font>
                <select class="form-control mb-3 select2" name="user_level_1" id="user_level_1" onchange="setUserLevel(value)">
                    <option value="">กรุณาเลือก</option>
                    <option value="9">Admin</option>
                    <option value="1">ช่าง</option>
                    <option value="2">หัวหน้าทีม</option>
                    <option value="3">หัวหน้าเขต</option>
                    <option value="4">พนักงานส่วนกลาง</option>
                    <option value="5">ช่าง Dealer</option>
                </select>

            </div>

            <div id="select_branch" class="col-12 mb-3" style="display:none">
                <label for="branch_id">
                    ทีม
                </label><font color="red">**</font>
                <select name="branch_id" id="branch_id" class="form-control select2 mb-3" onchange="choose_team(value)">
                    <option value="">กรุณาเลือกทีม</option>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <option value="<?php echo $row['branch_id']; ?>"><?php echo $row['branch_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            


            <div id="select_zone" class="col-12 mb-3" style="display:none">
                <label for="zone_id">
                    เขต
                </label><font color="red">**</font>
                <select name="zone_id" id="zone_id" class="form-control select2 mb-3">
                    <option value="">กรุณาเลือกเขต</option>
                    <?php
                    $sql_zone = "SELECT * FROM tbl_zone WHERE active_status = 1";
                    $result_zone  = mysqli_query($connect_db, $sql_zone);
                    while ($row_zone = mysqli_fetch_array($result_zone)) { ?>
                        <option value="<?php echo $row_zone['zone_id']; ?>"><?php echo $row_zone['zone_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

    </div>
    <!-- <label for="password">
            Password
        </label>
        <input type="password" class="form-control mb-3" id="password" name="password"> -->

    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>