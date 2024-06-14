<?php
include 'header2.php';
// include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

// session_start();
// $user_id = $_SESSION['user_id'];

$date = date('Y-m-d');
$sql = "SELECT COUNT(job_id) AS c_job FROM tbl_job WHERE responsible_user_id = '$user_id' AND appointment_date = '$date' ;";
// echo $sql;
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>
<div class="row m-0 p-1">
    <div class="col-12 p-2">
        <a href="my_work2.php" class="widget style1 bg-success m-0 block">
            <div class="row">
                <div class="col-4">
                    <i class="fa fa-cloud fa-5x"></i>
                </div>
                <div class="col-8 text-right">
                    <span> งานวันนี้ </span>
                    <h2 class="font-bold"><?php echo $row['c_job'] ?></h2>
                </div>
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="my_work2.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-tasks"></i></span><br>
                งานของฉัน
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="#" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-calendar"></i></span><br>
                ปฏิทินงาน
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="on_hand.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cubes"></i></span><br>
                คลังอุปกรณ์
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="confirm_import.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                ยืนยันรับ
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="transfer.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                โอนย้าย
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="confirm_transfer.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                รับโอนย้าย
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="adjust_stock.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                ปรับสต๊อก
            </div>
        </a>
    </div>


    <div class="col-4 p-2">
        <a href="transfer_notice.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                แจ้งโอน
            </div>
        </a>
    </div>




    <div class="col-4 p-2">
        <a href="#" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cog"></i></span><br>
                ตั้งค่า
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a href="#" class="ibox pointer box-menu" onclick="SetNewPass();">
            <div class="ibox-content text-center">
                <span><i class="fa fa-key"></i></span><br>
                แก้ไขรหัสผ่าน
            </div>
        </a>
    </div>

    <div class="col-4 p-2">
        <a onclick="LogoutConfirm();" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-sign-out"></i></span><br>
                ออกจากระบบ
            </div>
        </a>
    </div>




</div>
<?php include 'footer.php'; ?>

<script>
    function LogoutConfirm() {
        swal({
            title: "คุณต้องการออกจากระบบ ?",
            showCancelButton: true,
            confirmButtonColor: "#3244a8",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยังไม่ใช่ตอนนี้",
            closeOnConfirm: false
        }, function() {

            window.location.href = 'logout.php';


        })


    }
</script>