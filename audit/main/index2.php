<?php
include 'header2.php';
include("../../config/main_function.php");
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