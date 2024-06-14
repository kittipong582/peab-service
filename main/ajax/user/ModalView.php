<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = mysqli_real_escape_string($connect_db, $_POST['user_id']);

$sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$sql_branch = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$result_branch  = mysqli_query($connect_db, $sql_branch);
$row_branch = mysqli_fetch_array($result_branch);

$profile_image = ($row['profile_image'] != "") ? $row['profile_image'] : 'user icon.png';

if ($row['admin_status'] == 9) {
    $user_level = "Admin";
} else if ($row['user_level'] == 1) {
    $user_level = "Staff";
} else if ($row['user_level'] == 2) {
    $user_level = "หัวหน้าสาขา";
} else if ($row['user_level'] == 3) {
    $user_level = "หัวหน้าเขต";
} else if ($row['user_level'] == 4) {
    $user_level = "พนักงานส่วนกลาง";
}
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="user_id" name="user_id" value="<?php echo $user_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">รายละเอียด</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="text-center mb-3">
            <label for="profile_image">
                รูปโปรไฟล์
            </label>
            <p><img src="upload/<?php echo $profile_image; ?>" id="show_file" class="w-50"></p>
        </div>

        <label for="username">
            รหัสพนักงาน <span class="text-danger">(ใช้สำหรับเข้าสู่ระบบ)</span>
        </label>
        <input type="text" class="form-control mb-3" readonly id="username" name="username" value="<?php echo $row['username']; ?>">

        <label for="fullname">
            ชื่อ-นามสกุล ผู้ใช้งาน
        </label>
        <input type="text" class="form-control mb-3" readonly id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>">

        <label for="mobile_phone">
            เบอร์มือถือ <span class="text-danger">(ใช้สำหรับเป็นรหัสผ่าน)</span>
        </label>
        <input type="text" class="form-control mb-3" readonly id="mobile_phone" name="mobile_phone" value="<?php echo $row['mobile_phone']; ?>">

        <label for="office_phone">
            เบอร์ที่ทำงาน
        </label>
        <input type="text" class="form-control mb-3" readonly id="office_phone" name="office_phone" value="<?php echo $row['office_phone']; ?>">

        <label for="email">
            อีเมล
        </label>
        <input type="text" class="form-control mb-3" readonly id="email" name="email" value="<?php echo $row['email']; ?>">

        <label for="line_id">
            Line ID
        </label>
        <input type="text" class="form-control mb-3" readonly id="line_id" name="line_id" value="<?php echo $row['line_id']; ?>">

        <label for="user_level">
            สิทธิ์การใช้งาน
        </label>
        <input type="text" class="form-control mb-3" readonly id="line_id" name="line_id" value="<?php echo $user_level; ?>">

        <div id="select_branch" style="<?php echo ($row['user_level'] != 4) ? 'display:none' : ''; ?>">
            <label for="branch_id">
                สาขา
            </label>
            <input type="text" class="form-control mb-3" readonly id="line_id" name="line_id" value="<?php echo $row_branch['branch_name']; ?>">
        </div>




        <!-- <label for="password">
            Password <span class="text-danger">*กรอกกรณีต้องการเปลี่ยนรหัสผ่านเท่านั้น</span>
        </label>
        <input type="password" class="form-control mb-3" id="password" name="password"> -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <!-- <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button> -->
    </div>
</form>