<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$sql = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$result = mysqli_query($connect_db, $sql);
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มช่างภายนอก</h5>
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
                    <input type="file" class="form-control" name="profile_image" id="profile_image"
                        onchange="ImageReadURL(this,value,'#show_file','upload/user icon.png');">
                </div>

                <label for="username">
                    รหัสพนักงาน <span class="text-danger">(ใช้สำหรับเข้าสู่ระบบ)</span>
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="username" name="username">

                <label for="fullname">
                    ชื่อ-นามสกุล ผู้ใช้งาน
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="fullname" name="fullname">

                <label for="mobile_phone">
                    เบอร์มือถือ <span class="text-danger">(ใช้สำหรับเป็นรหัสผ่าน)</span>
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="mobile_phone" name="mobile_phone"
                    $mobile_phone="mobile_phone" $password="password" ;>

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