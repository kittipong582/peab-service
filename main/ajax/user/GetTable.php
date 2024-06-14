<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$zone  = $_POST['zone'];
$branch  = $_POST['branch'];
$user_level  = $_POST['user_level'];
$search  = $_POST['search'];

if ($zone != "x" || $branch != "x" || $user_level != "x" || $search != "") {


    $condition = "";
    if ($zone != "x") {
        $condition .= "AND c.zone_id = '$zone'";
    }

    $condition2 = "";
    if ($branch != "x") {
        $condition2 .= "AND b.branch_id = '$branch'";
    }

    $condition3 = "";
    if ($user_level != "x") {
        $condition3 .= "AND a.user_level = '$user_level'";
    }

    $condition4 = "";
    if ($search != "") {
        $condition4 .= "AND a.fullname LIKE '%$search%' OR a.mobile_phone LIKE '%$search%'";
    }
}

$list = array();

$sql = "SELECT a.*,b.branch_name,c.zone_name FROM tbl_user a 
LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id 
LEFT JOIN tbl_zone c ON a.zone_id = c.zone_id 
WHERE user_id IS NOT NULL $condition $condition2 $condition3 $condition4 AND a.active_status = 1;";
// echo $sql;
$result  = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "user_id" => $row['user_id'],
        "username" => $row['username'],
        "fullname" => $row['fullname'],
        "branch_name" => $row['branch_name'],
        "zone_name" => $row['zone_name'],
        "mobile_phone" => $row['mobile_phone'],
        "office_phone" => $row['office_phone'],
        "email" => $row['email'],
        "line_id" => $row['line_id'],
        "user_level" => $row['user_level'],
        "active_status" => $row['active_status'],
        "admin_status" => $row['admin_status'],
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover" id="table_user">
    <thead>
        <tr>
            <th style="width:15px;">#</th>
            <th style="width:10px;" class="text-center">รหัสพนักงาน</th>
            <th style="width:250px;">ชื่อสกุล</th>
            <th style="width:100px;">การติดต่อ</th>
            <th style="width:45px;">ทีม</th>
            <th style="width:30px;">เขต</th>
            <th style="width:200px;">สิทธิ์การใช้งาน</th>
            <th style="width:20px;" class="text-center">สถานะ</th>
            <th style="width:30px;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {


            $user_level = "-";
            if ($row['user_level'] == 1) {
                $user_level = "ช่าง";
            } else if ($row['user_level'] == 2) {
                $user_level = "หัวหน้าทีม";
            } else if ($row['user_level'] == 3) {
                $user_level = "หัวหน้าเขต";
            } else if ($row['user_level'] == 4) {
                $user_level = "พนักงานส่วนกลาง";
            }else if($user_level == '-' && $row['admin_status'] == 9){
                $user_level = "Admin";
            }

        ?>
            <tr >
                <td><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo $row['username']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td style="width:150px;">
                    <p><?php echo ($row['mobile_phone'] != "") ? "<i class='fa fa-phone'></i> : " . $row['mobile_phone'] . "<br>" : ''; ?></p>
                    <p><?php echo ($row['office_phone'] != "") ? "<i class='fa fa-building'></i> : " . $row['office_phone'] . "<br>" : ''; ?></p>
                    <p><?php echo ($row['email'] != "") ? "<i class='fa fa-envelope'></i> : " . $row['email'] . "<br>" : ''; ?></p>
                    <p><?php echo ($row['line_id'] != "") ? 'LINE : ' . $row['line_id'] : ''; ?></p>
                </td>
                <td><?php echo $row['branch_name']; ?></td>
                <td class="text-center"><?php echo $row['zone_name']; ?></td>
                <td class="text-center"><?php echo $user_level; ?></td>
                <td>
                    <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['user_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'ใช้งาน' : 'ไม่ใช้งาน'; ?>
                    </button>
                </td>
                <td>


                    <a href="view_user.php?id=<?php echo $row['user_id'] ?>"><button class="btn btn-xs btn-success btn-block" type="button">
                            ดูรายละเอียด
                        </button></a> <br>

                    <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['user_id']; ?>')">
                        แก้ไข
                    </button>
                   
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>