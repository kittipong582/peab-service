<?php

session_start();

include('../../../config/main_function.php');

$secure = "je_59MEH5X!-#\z";
$connection = connectDB($secure);

$graph_con = $_POST['graph_con'];
$type = $_POST['type'];
$check = $_POST['check'];
$report_type = $_POST['report_type'];


if ($type == 'all') {

    $condition = "";
} else {
    $condition = "AND b.product_id = '$type'";
}

if ($report_type == 1) { /////////////////////////////ยอดขาย
    // if ($check == 2) { ////////////////////รายเดือน

    //     $array_data = array();

    //     for ($i = 1; $i <= 12; $i++) {

    //         ///ยอดขาย
    //         $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
    //         LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
    //          WHERE YEAR(a.create_datetime) = '$graph_con' AND MONTH(a.create_datetime) = '$i' AND a.cancel_date IS NULL $condition ";
    //         $rs = mysqli_query($connection, $sql) or die($connection->error);
    //         $row = mysqli_fetch_array($rs);

    //         // echo $sql . "<br/>";
    //         $total_seller = $row['total_sum'];

    //         array_push($array_data, ($total_seller == '') ? 0 : $total_seller);
    //     }
    // }

    // if ($check == 1) { ////////////////////รายวัน
    //     $daily = $_POST['daily'];
    //     $array_data = array();
    //     $this_year = date("Y");
    //     for ($i = 1; $i < $daily; $i++) {

    //         ///ยอดขาย
    //         $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
    //         LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
    //          WHERE YEAR(a.create_datetime) = '$this_year' AND MONTH(a.create_datetime) = '$graph_con' AND DAY(a.create_datetime)  = '$i' AND a.cancel_date IS NULL $condition ";
    //         $rs = mysqli_query($connection, $sql) or die($connection->error);
    //         $row = mysqli_fetch_array($rs);
    //         // echo $sql . "<br/>";
    //         $total_seller = $row['total_sum'];

    //         array_push($array_data, ($total_seller == '') ? 0 : $total_seller);
    //     }
    // }

    if ($check == "today") { ////////////////////วันนี้


        $array_data = array();
        $s_today = date("Y-m-d H:i:s", strtotime('today 00:00:01'));
        $e_today = date("Y-m-d H:i:s", strtotime('today 23:59:59'));

        $sql_product = "SELECT * FROM tbl_product WHERE active_status = 1";
        $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
        while ($row_product = mysqli_fetch_array($rs_product)) {

            $product_id = $row_product['product_id'];
            $product_name = $row_product['product_name'];

            ///ยอดขาย
            $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime  BETWEEN '$s_today' AND '$e_today' and a.cancel_date IS NULL AND b.product_id = '$product_id' $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);
            $total_seller = $row['total_sum'];


            $temp3 = array(
                "product_name" => $product_name,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );
            array_push($array_data, $temp3);
        }
    }

    if ($check == "yesterday") { ////////////////////เมื่อวาน


        $array_data = array();
        $s_today = date("Y-m-d H:i:s", strtotime('yesterday 00:00:01'));
        $e_today = date("Y-m-d H:i:s", strtotime('yesterday 23:59:59'));

        $sql_product = "SELECT * FROM tbl_product WHERE active_status = 1";
        $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
        while ($row_product = mysqli_fetch_array($rs_product)) {

            $product_id = $row_product['product_id'];
            $product_name = $row_product['product_name'];

            ///ยอดขาย
            $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime  BETWEEN '$s_today' AND '$e_today' and a.cancel_date IS NULL AND b.product_id = '$product_id' $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);
            $total_seller = $row['total_sum'];


            $temp3 = array(
                "product_name" => $product_name,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );
            array_push($array_data, $temp3);
        }
    }


    if ($check == "7") { ////////////////////7วันย้อนหลัง

        $array_data = array();
        for ($i = 1; $i <= 7; $i++) {

            $sday = "-" . $i . " days 00:00:01";
            $eday = "-" . $i . " days 23:59:59";

            $s_today = date("Y-m-d H:i:s", strtotime($sday));
            $e_today = date("Y-m-d H:i:s", strtotime($eday));

            ///ยอดขาย
            $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime BETWEEN '$s_today' AND'$e_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);

            $total_seller = $row['total_sum'];
            $date = date("d-m-Y", strtotime($s_today));
            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
        }
    }


    if ($check == "30") { ////////////////////30วันย้อนหลัง


        $array_data = array();
        for ($i = 1; $i <= 30; $i++) {


            $sday = "-" . $i . " days 00:00:01";
            $eday = "-" . $i . " days 23:59:59";

            $s_today = date("Y-m-d H:i:s", strtotime($sday));
            $e_today = date("Y-m-d H:i:s", strtotime($eday));

            ///ยอดขาย
            $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime BETWEEN '$s_today' AND'$e_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);
            $total_seller = $row['total_sum'];
            $date = date("d-m-Y", strtotime($s_today));

            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
        }
    }


    if ($check == "last_month") { ////////////////////เดือนที่แล้ว

        $month = date("m", strtotime("last months"));
        $daily = $_POST['daily'];
        $array_data = array();
        $this_year = date("Y");
        for ($i = 1; $i <= $daily; $i++) {
            ///ยอดขาย
            $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE YEAR(a.create_datetime) = '$this_year' AND MONTH(a.create_datetime) = '$month' AND DAY(a.create_datetime)  = '$i' AND a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);
            // echo $sql . "<br/>";
            $total_seller = $row['total_sum'];

            array_push($array_data, ($total_seller == '') ? 0 : $total_seller);
        }
    }

    if ($check == "customize") { ////////////////////เลือกเดือน

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $s_today = date("Y-m-d", strtotime($start_date));
        $e_today = date("Y-m-d", strtotime($end_date));

        $array_data = array();
        $i = 0;
        while ($s_today <= $e_today) {
            ///ยอดขาย
            $sql = "SELECT SUM(b.quantity) as total_sum FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
            WHERE DATE(a.create_datetime) = '$s_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);
            $date = date("d-m-Y", strtotime($s_today));
            $total_seller = $row['total_sum'];
            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
            $s_today = date("Y-m-d", strtotime($s_today . '+ 1 day'));
        }
    }
    echo json_encode($array_data);
}


if ($report_type == 3) { /////////////////////////////ยอดขายบาท

    if ($check == "today") { ////////////////////วันนี้

        $array_data = array();
        $s_today = date("Y-m-d H:i:s", strtotime('today 00:00:01'));
        $e_today = date("Y-m-d H:i:s", strtotime('today 23:59:59'));

        $sql_product = "SELECT * FROM tbl_product WHERE active_status = 1";
        $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
        while ($row_product = mysqli_fetch_array($rs_product)) {

            $product_id = $row_product['product_id'];
            $product_name = $row_product['product_name'];

            $quantity_row = 0;
            $unit_price_row = 0;
            $total_seller = 0;
            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE  b.product_id = '$product_id' AND a.create_datetime  BETWEEN '$s_today' AND '$e_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {

                $total_seller += (($row['quantity'] * $row['unit_price']));
            }
            $temp3 = array(
                "product_name" => $product_name,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );
            array_push($array_data, $temp3);
        }
    }
    if ($check == "yesterday") { ////////////////////เมื่อวาน


        $array_data = array();
        $s_today = date("Y-m-d H:i:s", strtotime('yesterday 00:00:01'));
        $e_today = date("Y-m-d H:i:s", strtotime('yesterday 23:59:59'));

        $sql_product = "SELECT * FROM tbl_product WHERE active_status = 1";
        $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
        while ($row_product = mysqli_fetch_array($rs_product)) {

            $product_id = $row_product['product_id'];
            $product_name = $row_product['product_name'];

            $quantity_row = 0;
            $unit_price_row = 0;
            $unit_cost_row = 0;
            $total_seller = 0;
            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE  b.product_id = '$product_id' AND a.create_datetime  BETWEEN '$s_today' AND '$e_today' and a.cancel_date IS NULL  $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {

                $total_seller += (($row['quantity'] * $row['unit_price']));
            }
            $temp3 = array(
                "product_name" => $product_name,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );
            array_push($array_data, $temp3);
        }
    }


    if ($check == "7") { ////////////////////7วันย้อนหลัง

        $array_data = array();
        for ($i = 1; $i <= 7; $i++) {

            $sday = "-" . $i . " days 00:00:01";
            $eday = "-" . $i . " days 23:59:59";

            $s_today = date("Y-m-d H:i:s", strtotime($sday));
            $e_today = date("Y-m-d H:i:s", strtotime($eday));

            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime BETWEEN '$s_today' AND'$e_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {
                $total_seller += (($row['unit_price'] * $row['quantity']));
            }
            $date = date("d-m-Y", strtotime($s_today));

            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
        }
    }


    if ($check == "30") { ////////////////////30วันย้อนหลัง


        $array_data = array();
        for ($i = 1; $i <= 30; $i++) {

            $total_seller = 0;
            $sday = "-" . $i . " days 00:00:01";
            $eday = "-" . $i . " days 23:59:59";

            $s_today = date("Y-m-d H:i:s", strtotime($sday));
            $e_today = date("Y-m-d H:i:s", strtotime($eday));

            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime BETWEEN '$s_today' AND'$e_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {
                $total_seller += (($row['unit_price'] * $row['quantity']));
            }
            $date = date("d-m-Y", strtotime($s_today));

            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
        }
    }


    if ($check == "last_month") { ////////////////////เดือนที่แล้ว

        $month = date("m", strtotime("last months"));
        $daily = $_POST['daily'];
        $array_data = array();
        $this_year = date("Y");
        for ($i = 1; $i <= $daily; $i++) {
            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE YEAR(a.create_datetime) = '$this_year' AND MONTH(a.create_datetime) = '$month' AND DAY(a.create_datetime)  = '$i' AND a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            $row = mysqli_fetch_array($rs);
            // echo $sql . "<br/>";
            $total_seller = (($row['unit_price'] * $row['quantity']));

            array_push($array_data, ($total_seller == '') ? 0 : $total_seller);
        }
    }

    if ($check == "customize") { ////////////////////เลือกเดือน

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $s_today = date("Y-m-d", strtotime($start_date));
        $e_today = date("Y-m-d", strtotime($end_date));

        $array_data = array();
        $i = 0;
        while ($s_today <= $e_today) {
            ///ยอดขาย
            $total_seller = 0;
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
            WHERE DATE(a.create_datetime) = '$s_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {

                $total_seller += (($row['unit_price'] * $row['quantity']));
            }
            $date = date("d-m-Y", strtotime($s_today));
            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
            $s_today = date("Y-m-d", strtotime($s_today . '+ 1 day'));
        }
    }
    echo json_encode($array_data);
}


if ($report_type == 2) { //////////////////////กำไร

    // if ($check == 2) { ////////////////////รายเดือน

    //     $array_data = array();

    //     for ($i = 1; $i <= 12; $i++) {

    //         ///กำไล
    //         $sql = "SELECT * FROM tbl_order_head a
    //     LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
    //      WHERE YEAR(a.create_datetime) = '$graph_con' AND MONTH(a.create_datetime) = '$i' AND a.cancel_date IS NULL $condition ";
    //         $rs = mysqli_query($connection, $sql) or die($connection->error);
    //         $row = mysqli_fetch_array($rs);

    //         // echo $sql . "<br/>";
    //         $total_seller = (($row['unit_price'] * $row['quantity']) - ($row['quantity'] * $row['unit_cost']));

    //         array_push($array_data, ($total_seller == '') ? 0 : $total_seller);
    //     }
    // } else if ($check == 1) { ////////////////////รายวัน
    //     $daily = $_POST['daily'];
    //     $array_data = array();
    //     $this_year = date("Y");
    //     for ($i = 1; $i <br $daily; $i++) {

    //         ///กำไร
    //         $sql = "SELECT * FROM tbl_order_head a
    //     LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
    //      WHERE YEAR(a.create_datetime) = '$this_year' AND MONTH(a.create_datetime) = '$graph_con' AND DAY(a.create_datetime)  = '$i' AND a.cancel_date IS NULL $condition ";
    //         $rs = mysqli_query($connection, $sql) or die($connection->error);
    //         $row = mysqli_fetch_array($rs);
    //         // echo $sql . "<br/>";
    //         $total_seller = (($row['unit_price'] * $row['quantity']) - ($row['quantity'] * $row['unit_cost']));

    //         array_push($array_data, ($total_seller == '') ? 0 : $total_seller);
    //     }
    // }

    if ($check == "today") { ////////////////////วันนี้

        $array_data = array();
        $s_today = date("Y-m-d H:i:s", strtotime('today 00:00:01'));
        $e_today = date("Y-m-d H:i:s", strtotime('today 23:59:59'));

        $sql_product = "SELECT * FROM tbl_product WHERE active_status = 1";
        $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
        while ($row_product = mysqli_fetch_array($rs_product)) {

            $product_id = $row_product['product_id'];
            $product_name = $row_product['product_name'];

            $quantity_row = 0;
            $price_row = 0;
            $cost_row = 0;
            $total_seller = 0;
            $unit_cost_total = 0;
            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE b.product_id = '$product_id' AND a.create_datetime  BETWEEN '$s_today' AND '$e_today' and a.cancel_date IS NULL  $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {
                $lot_id = $row['lot_id'];

                $sql_lot = "SELECT * FROM tbl_import_lot WHERE lot_id = $lot_id";
                $rs_lot = mysqli_query($connection, $sql_lot) or die($connection->error);
                $row_lot = mysqli_fetch_array($rs_lot);
                // echo $row_lot['unit_cost'] . "<br>";
                $unit_cost_total = (($row_lot['unit_cost'] * $row_lot['exchange_rate']) + ($row_lot['qc_cost'] * $row_lot['exchange_rate']) + ($row_lot['tag_cost'] * $row_lot['exchange_rate']) + ($row_lot['bag_cost'] * $row_lot['exchange_rate']) + $row_lot['shipping_cost']);
                $price_row += $row['unit_price']  * $row['quantity'];
                $cost_row += $unit_cost_total * $row['quantity'];
            }

            $total_seller = ($price_row - $cost_row);
            $temp3 = array(
                "product_name" => $product_name,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );
            array_push($array_data, $temp3);
        }
    }

    if ($check == "yesterday") { ////////////////////เมื่อวาน


        $array_data = array();
        $s_today = date("Y-m-d H:i:s", strtotime('yesterday 00:00:01'));
        $e_today = date("Y-m-d H:i:s", strtotime('yesterday 23:59:59'));

        $sql_product = "SELECT * FROM tbl_product WHERE active_status = 1";
        $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
        while ($row_product = mysqli_fetch_array($rs_product)) {

            $product_id = $row_product['product_id'];
            $product_name = $row_product['product_name'];

            $quantity_row = 0;
            $price_row = 0;
            $cost_row = 0;
            $total_seller = 0;
            $unit_cost_total = 0;
            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime  BETWEEN '$s_today' AND '$e_today' and a.cancel_date IS NULL AND b.product_id = '$product_id' $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {

                $lot_id = $row['lot_id'];

                $sql_lot = "SELECT * FROM tbl_import_lot WHERE lot_id = $lot_id";
                $rs_lot = mysqli_query($connection, $sql_lot) or die($connection->error);
                $row_lot = mysqli_fetch_array($rs_lot);

                $unit_cost_total = (($row_lot['unit_cost'] * $row_lot['exchange_rate']) + ($row_lot['qc_cost'] * $row_lot['exchange_rate']) + ($row_lot['tag_cost'] * $row_lot['exchange_rate']) + ($row_lot['bag_cost'] * $row_lot['exchange_rate']) + $row_lot['shipping_cost']);
                $price_row += $row['unit_price']  * $row['quantity'];
                $cost_row += $unit_cost_total * $row['quantity'];
            }
            $total_seller = ($price_row - $cost_row);
            $temp3 = array(
                "product_name" => $product_name,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );
            array_push($array_data, $temp3);
        }
    }


    if ($check == "7") { ////////////////////7วันย้อนหลัง

        $array_data = array();
        for ($i = 1; $i <= 7; $i++) {

            $sday = "-" . $i . " days 00:00:01";
            $eday = "-" . $i . " days 23:59:59";

            $s_today = date("Y-m-d H:i:s", strtotime($sday));
            $e_today = date("Y-m-d H:i:s", strtotime($eday));

            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime BETWEEN '$s_today' AND'$e_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {

                $lot_id = $row['lot_id'];

                $sql_lot = "SELECT * FROM tbl_import_lot WHERE lot_id = $lot_id";
                $rs_lot = mysqli_query($connection, $sql_lot) or die($connection->error);
                $row_lot = mysqli_fetch_array($rs_lot);

                $unit_cost_total = (($row_lot['unit_cost'] * $row_lot['exchange_rate']) + ($row_lot['qc_cost'] * $row_lot['exchange_rate']) + ($row_lot['tag_cost'] * $row_lot['exchange_rate']) + ($row_lot['bag_cost'] * $row_lot['exchange_rate']) + $row_lot['shipping_cost']);
                $price_row += $row['unit_price']  * $row['quantity'];
                $cost_row += $unit_cost_total * $row['quantity'];
            }
            $date = date("d-m-Y", strtotime($s_today));
            $total_seller = ($price_row - $cost_row);
            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
        }
    }


    if ($check == "30") { ////////////////////30วันย้อนหลัง


        $array_data = array();
        
        for ($i = 1; $i <= 30; $i++) {

            $total_seller = 0;
            $sday = "-" . $i . " days 00:00:01";
            $eday = "-" . $i . " days 23:59:59";

            $s_today = date("Y-m-d H:i:s", strtotime($sday));
            $e_today = date("Y-m-d H:i:s", strtotime($eday));

            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE a.create_datetime BETWEEN '$s_today' AND'$e_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {

                $lot_id = $row['lot_id'];

                $sql_lot = "SELECT * FROM tbl_import_lot WHERE lot_id = $lot_id";
                $rs_lot = mysqli_query($connection, $sql_lot) or die($connection->error);
                $row_lot = mysqli_fetch_array($rs_lot);

                $unit_cost_total = (($row_lot['unit_cost'] * $row_lot['exchange_rate']) + ($row_lot['qc_cost'] * $row_lot['exchange_rate']) + ($row_lot['tag_cost'] * $row_lot['exchange_rate']) + ($row_lot['bag_cost'] * $row_lot['exchange_rate']) + $row_lot['shipping_cost']);
                $price_row += $row['unit_price']  * $row['quantity'];
                $cost_row += $unit_cost_total * $row['quantity'];

                $total_seller = ($price_row - $cost_row);
            }
            $date = date("d-m-Y", strtotime($s_today));


            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
        }
    }


    if ($check == "last_month") { ////////////////////เดือนที่แล้ว

        $month = date("m", strtotime("last months"));
        $daily = $_POST['daily'];
        $array_data = array();
        $this_year = date("Y");
        for ($i = 1; $i <= $daily; $i++) {
            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
             WHERE YEAR(a.create_datetime) = '$this_year' AND MONTH(a.create_datetime) = '$month' AND DAY(a.create_datetime)  = '$i' AND a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {

                $lot_id = $row['lot_id'];

                $sql_lot = "SELECT * FROM tbl_import_lot WHERE lot_id = $lot_id";
                $rs_lot = mysqli_query($connection, $sql_lot) or die($connection->error);
                $row_lot = mysqli_fetch_array($rs_lot);

                $unit_cost_total = (($row_lot['unit_cost'] * $row_lot['exchange_rate']) + ($row_lot['qc_cost'] * $row_lot['exchange_rate']) + ($row_lot['tag_cost'] * $row_lot['exchange_rate']) + ($row_lot['bag_cost'] * $row_lot['exchange_rate']) + $row_lot['shipping_cost']);


                $price_row += $row['unit_price']  * $row['quantity'];
                $cost_row += $unit_cost_total * $row['quantity'];
            }
            array_push($array_data, ($total_seller == '') ? 0 : $total_seller);
        }
    }

    if ($check == "customize") { ////////////////////เลือกเดือน

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $s_today = date("Y-m-d", strtotime($start_date));
        $e_today = date("Y-m-d", strtotime($end_date));

        $array_data = array();
        $i = 0;
        while ($s_today <= $e_today) {


            $quantity_row = 0;
            $price_row = 0;
            $cost_row = 0;
            $total_seller = 0;
            $unit_cost_total = 0;
            ///ยอดขาย
            $sql = "SELECT * FROM tbl_order_head a
            LEFT JOIN tbl_order_detail b ON a.order_id = b.order_id
            WHERE DATE(a.create_datetime) = '$s_today' and a.cancel_date IS NULL $condition ";
            $rs = mysqli_query($connection, $sql) or die($connection->error);
            while ($row = mysqli_fetch_array($rs)) {
                $lot_id = $row['lot_id'];

                $sql_lot = "SELECT * FROM tbl_import_lot WHERE lot_id = $lot_id";
                $rs_lot = mysqli_query($connection, $sql_lot) or die($connection->error);
                $row_lot = mysqli_fetch_array($rs_lot);

                $unit_cost_total = (($row_lot['unit_cost'] * $row_lot['exchange_rate']) + ($row_lot['qc_cost'] * $row_lot['exchange_rate']) + ($row_lot['tag_cost'] * $row_lot['exchange_rate']) + ($row_lot['bag_cost'] * $row_lot['exchange_rate']) + $row_lot['shipping_cost']);


                $price_row += $row['unit_price']  * $row['quantity'];
                $cost_row += $unit_cost_total * $row['quantity'];
            }
            $total_seller = ($price_row - $cost_row);
            $date = date("d-m-Y", strtotime($s_today));
            $temp3 = array(
                "date" => $date,
                "total_seller" => ($total_seller == '') ? 0 : $total_seller
            );

            array_push($array_data, $temp3);
            $s_today = date("Y-m-d", strtotime($s_today . '+ 1 day'));
        }
    }

    echo json_encode($array_data);
}
