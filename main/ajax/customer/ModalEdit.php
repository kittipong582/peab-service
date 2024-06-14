<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = mysqli_real_escape_string($connect_db, $_POST['user_id']);

$sql = "SELECT * FROM tbl_customer WHERE user_id = '$user_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$sql_branch = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$result_branch  = mysqli_query($connect_db, $sql_branch);

$profile_image = ($row['profile_image'] != "") ? $row['profile_image'] : 'user icon.png' ;
?>
<form action="" method="post" id="form-edit"  enctype="multipart/form-data">
    <input type="text" hidden id="user_id" name="user_id" value="<?php echo $user_id; ?>">
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
            <p><img src="upload/<?php echo $profile_image; ?>" id="show_file" class="w-50"></p>
            <input type="file" class="form-control" name="profile_image" id="profile_image" onchange="ImageReadURL(this,value,'#show_file','upload/<?php echo $profile_image; ?>');">
        </div>
        <label for="full_name">
            ชื่อ-นามสกุล ผู้ใช้งาน
        </label>
        <input type="text" class="form-control mb-3" id="full_name" name="full_name" value="<?php echo $row['fullname']; ?>">

        <label for="mobile_phone">
            เบอร์มือถือ
        </label>
        <input type="text" class="form-control mb-3" id="mobile_phone" name="mobile_phone" value="<?php echo $row['mobile_phone']; ?>">

        <label for="office_phone">
            เบอร์ที่ทำงาน
        </label>
        <input type="text" class="form-control mb-3" id="office_phone" name="office_phone" value="<?php echo $row['office_phone']; ?>">

        <label for="email">
            อีเมล
        </label>
        <input type="text" class="form-control mb-3" id="email" name="email" value="<?php echo $row['email']; ?>">

        <label for="line_id">
            Line ID
        </label>
        <input type="text" class="form-control mb-3" id="line_id" name="line_id" value="<?php echo $row['line_id']; ?>">

        <label for="user_level">
            ตำแหน่ง
        </label>
        <select class="form-control mb-3" name="user_level" id="user_level" onchange="setUserLevel(value)">
            <option value="9" <?php echo ($row['admin_status'] == 9) ? 'selected' : '' ; ?>>Admin</option>
            <option value="1" <?php echo ($row['user_level'] == 1) ? 'selected' : '' ; ?>>Staff</option>
            <option value="2" <?php echo ($row['user_level'] == 2) ? 'selected' : '' ; ?>>หัวหน้าสาขา</option>
            <option value="4" <?php echo ($row['user_level'] == 4) ? 'selected' : '' ; ?> >พนักงานส่วนกลาง</option>
        </select>

        <div id="select_branch" style="<?php echo ($row['user_level'] != 4) ? 'display:none' : '' ; ?>">
            <label for="branch_id">
                สาขา
            </label>
            <select name="branch_id" id="branch_id" class="form-control mb-3">
                <option value="">กรุณาเลือกสาขา</option>
                <?php while ($row_branch = mysqli_fetch_array($result_branch)) { ?>
                    <option value="<?php echo $row_branch['branch_id']; ?>" <?php echo ($row['branch_id'] == $row_branch['branch_id']) ? 'selected' : '' ; ?>>
                        <?php echo $row_branch['branch_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>


        <label for="username">
            Username
        </label>
        <input type="text" class="form-control mb-3" id="username" name="username" readonly value="<?php echo $row['username']; ?>">

        <label for="password">
            Password <span class="text-danger">*กรอกกรณีต้องการเปลี่ยนรหัสผ่านเท่านั้น</span>
        </label>
        <input type="password" class="form-control mb-3" id="password" name="password">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>