<?php
require('./fpdf/alphapdf.php');
require("../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connect_db = connectDB($secure);
$user_id = $_GET['user_id'];
$today = date('Y-m-d');


$sql_user = "SELECT a.fullname,b.team_number,b.branch_name FROM tbl_user a
LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id 
WHERE user_id = '$user_id'";
$rs_user = mysqli_query($connect_db, $sql_user);
$row_user = mysqli_fetch_assoc($rs_user);
// $result_remark2 = str_replace(['</p>'],"\r\n",$row_house['condicion']);



$pdf = new FPDF();
$pdf->AliasNbPages();

$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

$array_rows_num = array();

////////////////////count_all job////////////////////
$sql_num = "SELECT * FROM tbl_job a
WHERE responsible_user_id = '$user_id' AND appointment_date = '2022-12-25' ORDER BY a.create_datetime";
$rs_num = mysqli_query($connect_db, $sql_num);
$num_job = mysqli_num_rows($rs_num); //////////////count result////////////////


$count_list = 1; /////////////หน้าแรก
$set_rows_num = 0; //////////นับแถว
$limit_list = 0; //////////////////ลิมิต sql//////////////
$total_job_num = array(); ////////////////////////array sql limit//////////////////
$job_num = 0; ////////////////////////นับจำนวนงาน//////////////////

///////////////////////////count spare
while ($row_num = mysqli_fetch_assoc($rs_num)) {

    
    $set_rows_num = $set_rows_num + 7; /////////////////////+แถวช่วงอะไหล่


    $sql_spare_num = "SELECT spare_used_id FROM tbl_job_spare_used 
                    WHERE job_id = '{$row_num['job_id']}'";
    $rs_spare_num = mysqli_query($connect_db, $sql_spare_num);
    $num_spare = 0;
    while (mysqli_fetch_assoc($rs_spare_num)) {
        $num_spare++;

        if (($num_spare % 2) == 0) {

            $set_rows_num = $set_rows_num + 5;   //////////////แถวอะไหล่///////////
        }
    }

    $set_rows_num = $set_rows_num + 10; ////////////////////////แถวรวมสุทธิ
    $set_rows_num = $set_rows_num + 20; //////////////////////////ระยะห่างงาน



    if ($set_rows_num > 230) { //////////////////ถ้าเกินหน้า
        $count_list++; //////////////////////////////นับหน้า
        $set_rows_num = 0; /////////////////////นับแถวขึ้นหน้าใหม่


        $temp = array(
            "limit_list" => $limit_list,
            "job_num" => $job_num,
        );

        array_push($total_job_num, $temp); /////////////////////////เก็บarray/////////
        $job_num = 0;
    } else { /////////////////////ถ้าไม่เกิน

        $limit_list++;
        $job_num++;
    }
}

// echo $count_list;
var_dump($total_job_num);




$x = $count_list;
$start_job_query = 0;
$page_num = 1;
while ($x > 0) {


    ////////////////////create_query///////////////////

    $sql_main = "SELECT a.customer_branch_id,a.job_no,a.job_id,a.appointment_time_start,a.appointment_time_end FROM tbl_job a
        LEFT JOIN tbl_job_payment_file d ON a.job_id = d.job_id
        LEFT JOIN tbl_user e ON a.responsible_user_id = e.user_id
        LEFT JOIN tbl_branch f ON e.branch_id = f.branch_id 
        WHERE a.responsible_user_id = '$user_id' AND a.appointment_date = '2022-12-25' ORDER BY a.create_datetime LIMIT $start_job_query,5";
    $rs_main = mysqli_query($connect_db, $sql_main);

    // echo $sql_main . "<br/>";
    $pdf->AddPage();

    $pdf->SetFont('THSarabunNew Bold', '', 24);
    $pdf->SetXY(0, 20); //
    $pdf->MultiCell(210, 0, iconv('UTF-8', 'cp874', "รายงาน การปฏิบัติงาน"), 0, 'C', 0);

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->SetXY(0, 20); //
    $pdf->MultiCell(190, 0, iconv('UTF-8', 'cp874', $page_num . "/" . ceil($num_job / 5)), 0, 'R', 0);

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->SetXY(0, 30); //
    $pdf->MultiCell(210, 0, iconv('UTF-8', 'cp874', date("d/m/Y")), 0, 'C', 0);



    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->SetXY(20, 40); //
    $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "ชื่อช่าง :"), 0, 'L', 0);

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->SetXY(35, 40); //
    $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', $row_user['fullname']), 0, 'L', 0);

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->SetXY(100, 40); //
    $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "ทีม : "), 0, 'L', 0);

    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->SetXY(110, 40); //
    $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', $row_user['team_number'] . " - " . $row_user['branch_name']), 0, 'L', 0);





    $row_set = 50;
    $list_job = 1;
    while ($row_main = mysqli_fetch_assoc($rs_main)) {
        ///////////////////////////start_loop_job/////////////////////////


        $all_total1 = 0; ////////////////////จำนวนสุทธิ1
        $all_total2 = 0; ////////////////////จำนวนสุทธิ2

        $sql_branch = "SELECT branch_name FROM tbl_customer_branch WHERE customer_branch_id = '{$row_main['customer_branch_id']}'";
        $rs_branch = mysqli_query($connect_db, $sql_branch);
        $row_branch = mysqli_fetch_assoc($rs_branch);

        $sql_spare = "SELECT b.spare_part_code,a.quantity,a.unit_price FROM tbl_job_spare_used a 
                    LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                    WHERE a.job_id = '{$row_main['job_id']}'";
        $rs_spare = mysqli_query($connect_db, $sql_spare);


        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(20, $row_set); //
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', $list_job . "." . $row_main['job_no'] . " - " . $row_branch['branch_name']), 0, 'L', 0);


        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(0, $row_set); //
        $pdf->MultiCell(190, 0, iconv('UTF-8', 'cp874', date("H:i", strtotime($row_main['appointment_time_start'])) . " - " . date("H:i", strtotime($row_main['appointment_time_end']))), 0, 'R', 0);


        $row_set = $row_set + 7; /////////////////////+แถวช่วงอะไหล่
        ///////////////start///////////////
        // echo $row_set;
        // echo "<br/>";


        $spare_list = 0;
        while ($row_spare = mysqli_fetch_assoc($rs_spare)) {
            $spare_list++;

            if (($spare_list % 2) == 0) {
                $row_data = 120;
                $multi_cell_set = 190;
                $all_total2 += $row_spare['unit_price'];
            } else {
                $row_data = 20;
                $multi_cell_set = 90;
                $all_total1 += $row_spare['unit_price'];
            }


            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->SetXY($row_data, $row_set); //
            $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', $row_spare['spare_part_code'] . " x " . $row_spare['quantity']), 0, 'L', 0);

            $pdf->SetFont('THSarabunNew', '', 16);
            $pdf->SetXY(0, $row_set); //
            $pdf->MultiCell($multi_cell_set, 0, iconv('UTF-8', 'cp874', number_format($row_spare['unit_price'])), 0, 'R', 0);

            if (($spare_list % 2) == 0) {
                //////////////loop///////////
                $row_set = $row_set + 5;
            }
        }

        $row_set = $row_set + 10;


        $pdf->SetFont('THSarabunNew Bold', 'U', 18);
        $pdf->SetXY(50, $row_set); //
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "รวมสุทธิ"), 0, 'L', 0);

        $pdf->SetFont('THSarabunNew Bold', 'U', 18);
        $pdf->SetXY(0, $row_set); //
        $pdf->MultiCell(90, 0, iconv('UTF-8', 'cp874', number_format($all_total1)), 0, 'R', 0);


        $pdf->SetFont('THSarabunNew Bold', 'U', 18);
        $pdf->SetXY(150, $row_set); //
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "รวมสุทธิ"), 0, 'L', 0);

        $pdf->SetFont('THSarabunNew Bold', 'U', 18);
        $pdf->SetXY(0, $row_set); //
        $pdf->MultiCell(190, 0, iconv('UTF-8', 'cp874', number_format($all_total2)), 0, 'R', 0);




        $row_set = $row_set + 20;
        // $num_job = $num_job - $list_job;

        // echo $row_set;
        // echo "<br/>";
        $list_job++;
    }
    //////////////////////////////////////////////end loop///////////////////////////////////////////


    if ($x == 1) {



        $pdf->SetFont('THSarabunNew Bold', '', 18);
        $pdf->SetXY(20, 200); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "รายได้รวม"), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew Bold', '', 18);
        $pdf->SetXY(65, 200); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "วางบิล"), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew Bold', '', 18);
        $pdf->SetXY(110, 200); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "เงินสด"), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew Bold', '', 18);
        $pdf->SetXY(155, 200); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "รอโอน"), 0, 'C', 0);


        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(20, 205); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "10,000"), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(65, 205); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "7,000"), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(110, 205); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "3,000"), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(155, 205); //
        $pdf->MultiCell(20, 0, iconv('UTF-8', 'cp874', "1,500"), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(20, 225); //
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "SP00001 ใช้ไป  คงเหลือ  10"), 0, 'L', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(120, 225); //
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "SP00001 ใช้ไป  คงเหลือ  10"), 0, 'L', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(20, 230); //
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "SP00001 ใช้ไป  คงเหลือ  10"), 0, 'L', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(120, 230); //
        $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "SP00001 ใช้ไป  คงเหลือ  10"), 0, 'L', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(60, 270); //
        $pdf->MultiCell(210, 0, iconv('UTF-8', 'cp874', "......................................."), 0, 'C', 0);

        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetXY(60, 280); //
        $pdf->MultiCell(210, 0, iconv('UTF-8', 'cp874', "(.......................................)"), 0, 'C', 0);
    }

    $page_num++;
    $start_job_query = $start_job_query + 5;
    $x--;
}
////////////////////////////////////end loop job//////////////////////







$pdf->Output();
