<?php
	function connectDB($secure) { 
		if($secure == "VH9l953yXo"){	
		
            $dbhost="localhost";
            $dbuser="fordev_finemetal";
            $dbpass="DoonongcG";
            $dbname="fordev_finemetal";
			
			$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
			mysqli_set_charset($connection,"utf8");
			if (!$connection) {
				die("Connection failed: " . mysqli_connect_error());
			} else {
				return $connection;
			}
		}else{
			return false;
		}
	}
	function getRandomID($size,$table,$column_name){
		$check_status = 0;
		$secure = "VH9l953yXo";
		$connection = connectDB($secure);
		
		while($check_status == 0){
		$random_id = randomCode($size);
		
		$sql = "SELECT count(*) as count FROM $table WHERE $column_name = '$random_id';";
		$rs_check = mysqli_query($connection,$sql);
		$row_check = mysqli_fetch_assoc($rs_check);
		$check_repeat = $row_check['count'];
		
			if($check_repeat == 0){
				
				$check_status = 1;
			}
		
		}
		return $random_id;
	}
    function stringInsert($str,$insertstr,$pos){
        $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
        return $str;
    }
	function randomCode($length){
		$possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghigklmnopqrstuvwxyz"; //ตัวอักษรที่ต้องการสุ่ม
		$str = "";
		while(strlen($str)<$length){
			$str.=substr($possible,(rand()%strlen($possible)),1);
		}
		return $str;
	}
	function randomCode2($length){
		$possible = "0123456789"; //ตัวอักษรที่ต้องการสุ่ม
		$str = "";
		while(strlen($str)<$length){
			$str.=substr($possible,(rand()%strlen($possible)),1);
		}
		return $str;
	}

    function check_access_menu($access_role, $access_id){
        $page_id = $access_id;
        $level = $access_role;
        $access_code = strrev(decbin($level));
        $accessible = substr($access_code, $page_id - 1, 1);
        if ($accessible) {
            return 1;
        } else {
            return 0;
        }
    }
    function check_access_arrray($access_role, $array_access){
        foreach($array_access as $access_id){
            $page_id = $access_id;
            $level = $access_role;
            $access_code = strrev(decbin($level));
            $accessible = substr($access_code, $page_id - 1, 1);
            if ($accessible) {
                return 1;
            }
        }
        return 0;
    }
    function check_access_loop($access_role, $access_loop){
        foreach ($access_loop as $access_id) {
            $page_id = $access_id;
            $level = $access_role;
            $access_code = strrev(decbin($level));
            $accessible = substr($access_code, $page_id - 1, 1);
            if ($accessible) {
                return 1;
            }
        }
        return 0;
    }

    //วันที่
    $dayTH = ["อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"];
    $monthTH = [null,"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
    $monthTH_brev = [null,"ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];
    function thai_date_and_time($time){   // 19 ธันวาคม 2556 เวลา 10:10:43
        global $dayTH,$monthTH;   
        $thai_date_return = date("j",$time);   
        $thai_date_return.=" ".$monthTH[date("n",$time)];   
        $thai_date_return.= " ".(date("Y",$time)+543);   
        $thai_date_return.= " เวลา ".date("H:i:s",$time);
        return $thai_date_return;   
    } 
    function thai_date_and_time_short($time){   // 19  ธ.ค. 2556 10:10:4
        global $dayTH,$monthTH_brev;   
        $thai_date_return = date("j",$time);   
        $thai_date_return.=" ".$monthTH_brev[date("n",$time)];   
        $thai_date_return.= " ".(date("Y",$time)+543);   
        $thai_date_return.= " ".date("H:i:s",$time);
        return $thai_date_return;   
    } 
    function thai_date_short($time){   // 19  ธ.ค. 2556a
        global $dayTH,$monthTH_brev;   
        $thai_date_return = date("j",$time);   
        $thai_date_return.=" ".$monthTH_brev[date("n",$time)];   
        $thai_date_return.= " ".(date("Y",$time)+543);   
        return $thai_date_return;   
    } 
    function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
        global $dayTH,$monthTH;   
        $thai_date_return = date("j",$time);   
        $thai_date_return.=" ".$monthTH[date("n",$time)];   
        $thai_date_return.= " ".(date("Y",$time)+543);   
        return $thai_date_return;   
    } 
    function thai_date_short_number($time){   // 19-12-56
        global $dayTH,$monthTH;   
        $thai_date_return = date("d",$time);   
        $thai_date_return.="-".date("m",$time);   
        $thai_date_return.= "-".substr((date("Y",$time)+543),-2);   
        return $thai_date_return;   
    } 
    function thai_date_short_slc($time){   // 19/12/2556
        global $dayTH,$monthTH_brev;   
        $thai_date_return = date("d",$time);   
        $thai_date_return.="/".date("m",$time);   
        $thai_date_return.= "/".(date("Y",$time)+543);   
        return $thai_date_return;   
    } 
    function thai_date_short_back_slc($time){   // 19  ธ.ค. 2556a
        global $dayTH,$monthTH_brev;   
        $thai_date_return = (date("Y",$time)-543);  
        $thai_date_return.= "-".date("m",$time);    
        $thai_date_return.= "-".date("d",$time);  
        return $thai_date_return;   
    } 
    function thai_date_reset_back_slc($date){
        $date = str_replace('/', '-', $date);
        $temp_date = explode('-', $date);
        $day   = $temp_date[0];
        $month = $temp_date[1];
        $year  = ($temp_date[2] - 543);
        return date("Y-m-d", strtotime($day."-".$month."-".$year));
    }
    function thai_no_date_short_year($time){   // 19 ธันวาคม 2556
        global $monthTH;   
        $thai_date_return = $monthTH[date("n",$time)];   
        $thai_date_return.= " ".(date("y",$time)+43);   
        return $thai_date_return;   
    } 
    function thai_no_date_fullmonth($time){   // ธันวาคม 2556
        global $monthTH;   
        $thai_date_return = $monthTH[date("n",$time)];   
        $thai_date_return.= " ".(date("Y",$time)+543);   
        return $thai_date_return;   
    } 
    
    function cutContent($content,$countWord){
        return mb_strimwidth(strip_tags($content),0,$countWord,'...','utf-8');
    }
    function dateDifferenceInMinutes($dateStr1, $dateStr2) {
        $date1 = new DateTime($dateStr1);
        $date2 = new DateTime($dateStr2);
    
        $interval = date_diff($date1, $date2);
    
        $minutes = $interval->days * 24 * 60;
        $minutes += $interval->h * 60;
        $minutes += $interval->i;
    
        return $minutes;
    }
    function convertDateYear($inputDate) {
        if (empty($inputDate)) {
            return false;
        }
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $inputDate)) {
            return false; 
        }
        $dateParts = explode("-", $inputDate);
        $year = $dateParts[0];
        if ($year > 2200) {
            $year = $year - 543;
        }
        return $year . "-" . $dateParts[1] . "-" . $dateParts[2];
    }
    function checkDateExcel($temp_date){
        $temp = explode(".", $temp_date);
        if ($temp[0] <= 0 || $temp[0] > 31) {
			return false;
		}
        if ($temp[1] <= 0 || $temp[1] > 12) {
			return false;
		}
        if ($temp[2] <= 2020 || $temp[2] > 2100 || strlen($temp[2]) != 4) {
			return false;
        }
        return true;     
    }
    function GetUserData($user_id){
		$secure = "VH9l953yXo";
		$connection = connectDB($secure);

        $sql_ccc = "SELECT u.user_id, u.fullname, u.position, u.profile_image, u.main_admin_status, u.access_level, u.change_password_status FROM tbl_user u WHERE u.user_id = '$user_id';";
        $rs_ccc = mysqli_query($connection, $sql_ccc);
        $cmt_ccc = mysqli_num_rows($rs_ccc);
        $row_ccc = mysqli_fetch_array($rs_ccc);
        if($cmt_ccc > 0){
            return $row_ccc;
        }else{
            return [];
        }
    }
?>