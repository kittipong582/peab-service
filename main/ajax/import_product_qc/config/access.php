<?php
    session_start();
    include("function.php");
    include("jwt.php");
    $secure = "VH9l953yXo";
    $connection = connectDB($secure);

    $date = date('Y-m-d');
    $datetime = date('Y-m-d H:i:s');

    if(isset($_POST["finemetal"]) && !empty($_POST["finemetal"])){

        $finemetal = $_POST["finemetal"];
        $token = JWT::decode($finemetal, "LPmcxBTQU5yp4FmdcFq5KX7PP1NedR");
        $user_id = $token->user_id;
        if($user_id != ""){
            $row_finemetal = GetUserData($user_id);
            
            if($row_finemetal["user_id"] != ""){

                $fullname = $row_finemetal["fullname"];
                $position = $row_finemetal["position"];
                $profile_image = $row_finemetal["profile_image"];
                $change_password_status = $row_finemetal["change_password_status"];
                $main_admin_status = ($row_finemetal["main_admin_status"] == "1" ? true : false);

                $list_access = [];
                $sql_access = "SELECT MAX(a.access_id) AS max_access FROM tbl_access a ";
                $rs_access = mysqli_query($connection, $sql_access);
                $row_access = mysqli_fetch_array($rs_access);
                $max_access = $row_access["max_access"];

                for ($i=1; $i <= $max_access; $i++) { 
                    if (check_access_menu($row_finemetal["access_level"], $i) == 1) {
                        array_push($list_access, $i);
                    }
                }

                $result = true;
            }else{
                $list_access = [];
                $fullname = "";
                $position = "";
                $profile_image = "";
                $change_password_status = "";
                $main_admin_status = false;
                $result = false;
            }
        }else{
            $list_access = [];
            $fullname = "";
            $position = "";
            $profile_image = "";
            $change_password_status = "";
            $main_admin_status = false;
            $result = false;
        }
    }else{
        $list_access = [];
        $fullname = "";
        $position = "";
        $profile_image = "";
        $change_password_status = "";
        $main_admin_status = false;
        $result = false;
    }

    mysqli_close($connection);
    $arr['access'] = $list_access;
    $arr['main_admin_status'] = $main_admin_status;
    $arr['change_password_status'] = $change_password_status;
    $arr['profile_image'] = $profile_image;
    $arr['fullname'] = $fullname;
    $arr['position'] = $position;
    $arr['result'] = $result;
    echo json_encode($arr);
?>