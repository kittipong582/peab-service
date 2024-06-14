<?php include 'header3.php';

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_GET['id'];
$create_user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tbl_user a WHERE a.audit_status = 1";
$res = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_assoc($res);

$date = date('Y-m-d');
$sql_job = "SELECT COUNT(job_id) AS c_job FROM tbl_job_audit WHERE create_user_id = '$create_user_id' AND appointment_date = '$date' ;";
// echo $sql;
$res_job = mysqli_query($connect_db, $sql_job);
$row_job = mysqli_fetch_array($res_job);

$url = '../asset/peaberry.jpg';

?>

<div class="mt-2"></div>
<style>

    .container {
        height: 85vh;
        background-color: #fff;
    }
</style>

<body>
    <div class="container">
        <div class="row bg">
            <input type="text" hidden id="user_id" name="user_id" value="<?php echo $row['user_id'] ?>">
            <div class="col text-center">
                <img src="<?php echo $url; ?>" alt="" class="w-75 img-1"><br><br>
            </div>
        </div>

        <div class="row m-0">

            <div class="col-4 p-2">
                <a href="audit_work.php" class="ibox pointer box-menu">
                    <div class="ibox-content text-center">
                        <span><i class="fa fa-cube"></i></span><br>
                        เปิดงาน
                    </div>
                </a>
            </div>

            <div class="col-4 p-2">
                <a href="my_work.php" class="ibox pointer box-menu">
                    <div class="ibox-content text-center">
                        <span><i class="fa fa-tasks"></i></span><br>
                        งานของฉัน
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
    </div>
</body>

<!-- </div> -->
<?php include 'footer.php'; ?>
<script>
    function LogoutConfirm() {
        location.href = "logout.php";
    }
</script>