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
        <div class="text-center mb-3">
            <label for="profile_image">
                รูปโปรไฟล์
            </label>
            <p><img src="upload/user icon.png" id="show_file" class="w-50"></p>
            <input type="file" class="form-control" name="profile_image" id="profile_image" onchange="ImageReadURL(this,value,'#show_file','upload/user icon.png');">
        </div>
        <label for="full_name">
            ชื่อ-นามสกุล ผู้ใช้งาน
        </label>
        <input type="text" class="form-control mb-3" id="full_name" name="full_name">

        <label for="mobile_phone">
            เบอร์มือถือ
        </label>
        <input type="text" class="form-control mb-3" id="mobile_phone" name="mobile_phone">

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
            ตำแหน่ง
        </label>
        <select class="form-control mb-3" name="user_level" id="user_level" onchange="setUserLevel(value)">
            <option value="">กรุณาเลือก</option>
            <option value="9">Admin</option>
            <option value="1">Staff</option>
            <option value="2">หัวหน้าสาขา</option>
            <option value="4">พนักงานส่วนกลาง</option>
        </select>

        <div id="select_branch" style="display:none">
            <label for="branch_id">
                สาขา
            </label>
            <select name="branch_id" id="branch_id" class="form-control mb-3">
                <option value="">กรุณาเลือกสาขา</option>
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <option value="<?php echo $row['branch_id']; ?>"><?php echo $row['branch_name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <label for="username">
            Username
        </label>
        <input type="text" class="form-control mb-3" id="username" name="username">

        <label for="password">
            Password
        </label>
        <input type="password" class="form-control mb-3" id="password" name="password">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>