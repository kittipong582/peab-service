<?php
session_start();
require('main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$id = $_GET['id'];


if (empty($_SESSION['user_id'])) {
    session_destroy();
?>
    <script>
        alert("Session expired, please log in again.");
        location.href = "../";
    </script>
<?php
    exit();
}else{
    session_start();
}




// //กำหนดเวลาที่สามารถอยู่ในระบบ
// $sessionlifetime = 60; //กำหนดเป็นนาที

// if(isset($_SESSION["timeLasetdActive"])){
//     $seclogin = (time()-$_SESSION["timeLasetdActive"])/60;

//     //หากไม่ได้ Active ในเวลาที่กำหนด
//     if($seclogin>$sessionlifetime){
//         header("location:../");
//         exit;
//     }else{
//         $_SESSION["timeLasetdActive"] = time();
//     }
// }else{
//     $_SESSION["timeLasetdActive"] = time();
// }

//if (empty($_SESSION['user_id'])) {
//    session_destroy();
//
?>
<!--<script>-->
<!--    alert('SESSION หมดอายุ กรุณาเข้าสู่ระบบอีกครั้ง');-->
<!--    location.href = '../';-->
<!--</script>-->
<?php
//    exit();
//}
?>