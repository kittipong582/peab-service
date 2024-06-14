 <?php

    include("../../../config/main_function.php");
    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");
    if ($connect_db) {

        $status = mysqli_real_escape_string($connect_db, $_POST['status']);
        $search = mysqli_real_escape_string($connect_db, $_POST['search']);
        $search_opt = mysqli_real_escape_string($connect_db, $_POST['search_opt']);
        $customer_group = mysqli_real_escape_string($connect_db, $_POST['customer_group']);

        if ($search_opt == '1') {
            $con_opt = "a.qr_no LIKE '%$search%'";
        } else if ($search_opt == '2') {
            $con_opt = "b.branch_code LIKE '%$search%'";
        } else if ($search_opt == '3') {
            $con_opt = "c.customer_name LIKE '%$search%' OR b.branch_name LIKE '%$search%'";
        }

        if ($status != "x") {
            $condi_status = "register_datetime IS NOT NULL";
        } else {
            $condi_status = "register_datetime IS NULL";
        }

        if ($search != "") {
            $condi_status != "" ? $con_sta = " AND " : "";
            // $condi_search = $con_sta . "qr_no LIKE '%$search%'";
            $condi_search = $con_sta . $con_opt;
        } else {
            $condi_search = "";
        }

        if ($customer_group != "x" &&  $customer_group != 0) {
            $condi_status != "" ? $con_group = " AND " : "";
            $condi_group = $con_group . "c.customer_group = '$customer_group'";
        } else if ($customer_group == 0 && $customer_group != "x") {
            $condi_status != "" ? $con_group = " AND " : "";
            $condi_group = $con_group . "c.customer_group IS NULL";
        } else {
            $condi_group = "";
        }

        $sql = "SELECT a.*
        ,b.branch_name
        ,b.branch_code
        ,c.customer_name
        FROM tbl_qr_code a
        LEFT JOIN tbl_customer_branch b ON b.customer_branch_id = a.branch_id
        LEFT JOIN tbl_customer c ON c.customer_id = b.customer_id
        WHERE $condi_status $condi_search $condi_group $condi_search_opt ORDER BY create_datetime DESC";
        $res = mysqli_query($connect_db, $sql);


    ?>
     <table class="table table-striped table-bordered table-hover">
         <thead>
             <tr>
                 <th style="width:20%;" class="text-center">QR Code</th>
                 <th style="width:10%;" class="text-center">รหัสสาขา</th>
                 <th style="width:10%;" class="text-center">ชื่อสาขา</th>
                 <th style="width:10%;" class="text-center">ชื่อลูกค้า</th>
                 <th style="width:10%;" class="text-center">วันที่ลงทะเบียน</th>
                 <th style="width:10%;"></th>
             </tr>
         </thead>
         <tbody>
             <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                 <tr>
                     <td style="width:20%;" class="text-center"><?php echo $row['qr_no']; ?></td>
                     <td style="width:10%;" class="text-center"><?php echo $row['branch_code'] != '' ? $row['branch_code'] : "-"; ?></td>
                     <td style="width:10%;" class="text-center"><?php echo $row['branch_name'] != '' ? $row['branch_name'] : "-"; ?></td>
                     <td style="width:10%;" class="text-center"><?php echo $row['customer_name'] != '' ? $row['customer_name'] : "-"; ?></td>
                     <td style="width:10%;" class="text-center"><?php echo $row['register_datetime'] != '' ? date('d/m/Y', strtotime($row['register_datetime'])) : "-"; ?></td>
                     <td style="width:10%;"><a href="../../../print/print_qr.php?qr_no=<?php echo $row['qr_no']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a></td>
                 </tr>
             <?php  } ?>
         </tbody>
     </table>
 <?php } ?>