<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = mysqli_real_escape_string($connect_db, $_POST['user_id']);

$sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$branch_id = $row['branch_id'];
$sql_branch = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$result_branch  = mysqli_query($connect_db, $sql_branch);

$profile_image = ($row['profile_image'] != "") ? $row['profile_image'] : 'user icon.png';
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="user_id" name="user_id" value="<?php echo $user_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขรายละเอียด</h5>
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
                    <p><img src="upload/<?php echo $profile_image; ?>" id="show_file" class="w-50"></p>
                    <input type="file" class="form-control" name="profile_image" id="profile_image" onchange="ImageReadURL(this,value,'#show_file','upload/<?php echo $profile_image; ?>');">
                </div>

                <label for="username">
                    รหัสพนักงาน <span class="text-danger">(ใช้สำหรับเข้าสู่ระบบ)</span>
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="username" name="username" value="<?php echo $row['username']; ?>">

                <label for="fullname">
                    ชื่อ-นามสกุล ผู้ใช้งาน
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>">

                <label for="mobile_phone">
                    เบอร์มือถือ <span class="text-danger">(ใช้สำหรับเป็นรหัสผ่าน)</span>
                </label>
                <font color="red">**</font>
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

                <label for="line_id">
                    Line Token
                </label>
                <input type="text" class="form-control mb-3"  id="line_token" name="line_token" value="<?php echo $row['line_token']; ?>">


                <input class="icheckbox_square-green mb-3" <?php echo ($row['line_active'] == 1) ? 'checked' : ''; ?> type="checkbox" name="chkbox" id="chkbox" value="chkbox">
                <label for="line_active" class="mb-3">
                    รับการแจ้งเตือน
                </label>
                <input type="hidden" id="line_active" name="line_active" value="<?php echo $row['line_active'] ?>" style="position: absolute; opacity: 0;"><br>



                <label for="user_level">
                    สิทธิ์การใช้งาน
                </label>

                <font color="red">**</font>
                <select class="form-control mb-3 select2" name="user_level_1" id="user_level_1" onchange="setUserLevel(value)">
                    <option value="9" <?php echo ($row['admin_status'] == 9) ? 'selected' : ''; ?>>Admin</option>
                    <option value="1" <?php echo ($row['user_level'] == 1) ? 'selected' : ''; ?>>ช่าง</option>
                    <option value="2" <?php echo ($row['user_level'] == 2) ? 'selected' : ''; ?>>หัวหน้าทีม</option>
                    <option value="3" <?php echo ($row['user_level'] == 3) ? 'selected' : ''; ?>>หัวหน้าเขต</option>
                    <option value="4" <?php echo ($row['user_level'] == 4) ? 'selected' : ''; ?>>พนักงานส่วนกลาง</option>
                    <option value="5" <?php echo ($row['user_level'] == 5) ? 'selected' : ''; ?>>ช่าง Dealer</option>
                </select>

            </div>

            <div id="select_branch" class="col-12 mb-3" style="<?php echo ($row['user_level'] != 2 && $row['user_level'] != 1) ? 'display:none' : ''; ?>">
                <label for="branch_id">
                    ทีม
                </label>
                <font color="red">**</font>
                <select name="branch_id" id="branch_id" class="form-control mb-3 select2" onchange="choose_team(value)">
                    <option value="">กรุณาเลือกทีม</option>
                    <?php while ($row_branch = mysqli_fetch_array($result_branch)) { ?>
                        <option value="<?php echo $row_branch['branch_id']; ?>" <?php echo ($row['branch_id'] == $row_branch['branch_id']) ? 'selected' : ''; ?>>
                            <?php echo $row_branch['branch_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>


            <div id="select_zone" class="col-12" style="<?php echo ($row['user_level'] != 3) ? 'display:none' : ''; ?>">
                <label for="zone_id">
                    โซน
                </label>
                <font color="red">**</font>
                <select name="zone_id" id="zone_id" class="form-control mb-3 select2">
                    <option value="">กรุณาเลือกทีม</option>
                    <?php
                    $sql_zone = "SELECT * FROM tbl_zone WHERE active_status = 1";
                    $result_zone  = mysqli_query($connect_db, $sql_zone);
                    while ($row_zone = mysqli_fetch_array($result_zone)) { ?>
                        <option value="<?php echo $row_zone['zone_id']; ?>" <?php echo ($row['zone_id'] == $row_zone['zone_id']) ? 'selected' : ''; ?>><?php echo $row_zone['zone_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>


        <!-- <label for="password">
            Password <span class="text-danger">*กรอกกรณีต้องการเปลี่ยนรหัสผ่านเท่านั้น</span>
        </label>
        <input type="password" class="form-control mb-3" id="password" name="password"> -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>