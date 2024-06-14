
<?php
session_start();
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$all_pro = array();


$sql_province = "SELECT province_name_th FROM tbl_province ORDER BY province_name_th";
$rs_pro = mysqli_query($connect_db, $sql_province);
while ($row_pro = mysqli_fetch_assoc($rs_pro)) {


    array_push($all_pro, $row_pro['province_name_th']);

    // $all_pro .= $row_pro['province_name_th'] . "|";
}

$data = "108 ซอย รังสิต-นครนายก 63 ต.ประชาธิปัตย์ อ.ธัญบุรี จ.ปทุมธานี";
$delim = '|';

$pattern = "^(?<region>.*?) (?<country>$data)$";

foreach ($all_pro as $d) {
    echo $d;
    echo "<br/>";
    // if (preg_match($delim . $pattern . $delim, $d, $matches)) {
    //     echo sprintf('%1$s, %2$s', $matches['region'], $matches['country']), PHP_EOL;
    // } else {
    //     echo 'NO MATCH: ' . $d, PHP_EOL;
    // }
}

// function matchAndShowData(array $data, array $countries, string $delim, string $countryParts): void
// {
//     $pattern = "^(?<region>.*?) (?<country>$countryParts)$";

//     foreach ($data as $d) {
//         if (preg_match($delim . $pattern . $delim, $d, $matches)) {
//             echo sprintf('%1$s, %2$s', $matches['region'], $matches['country']), PHP_EOL;
//         } else {
//             echo 'NO MATCH: ' . $d, PHP_EOL;
//         }
//     }
// }


// var_dump($all_pro);
