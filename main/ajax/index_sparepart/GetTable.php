<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$search_month = $_POST['search_month'];
$search_branch = $_POST['search_branch'];
$search_type = $_POST['search_type'];

$thaimonth = array("00" => "", "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
$engmonth = array("00" => "", "01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");

$sql_team = "SELECT team_number,branch_name FROM tbl_branch WHERE branch_id = '$search_branch'";
$rs_team = mysqli_query($connect_db, $sql_team);
$row_team = mysqli_fetch_assoc($rs_team);

$sql_spare = "SELECT spare_part_code,spare_part_name,spare_part_id FROM tbl_spare_part WHERE active_status = 1 and spare_type_id = '$search_type' ORDER BY spare_part_code ";
$rs_spare = mysqli_query($connect_db, $sql_spare);

?>


<style>
table {
  table-layout: fixed;
  width: 200px;
  height: 400px;

}

th,
td {
    
  width: 100px;
  overflow: auto;
}



</style>


    <div class="table-responsive">
        <table class=" table table-striped table-hover" >
            <thead>
                <tr>
                    <th class="text-center " style="width: 120px">รหัสอะไหล่</th>
                    <th class="text-center" style="width: 120px">ชื่ออะไหล่</th>
                    <?php for ($i = 1; $i < date('t', strtotime($engmonth[$search_month])); $i++) { ?>

                        <th class="text-center " style="width: 70px"><?php echo "วันที่ " . $i; ?></th>
                    <?php  } ?>
                    <th class="text-left">รวม</th>
                </tr>

            </thead>
            <tbody>



                <?php while ($row_spare = mysqli_fetch_assoc($rs_spare)) { ?>
                    <tr>
                        <th class="text-center " style="width: 15%"><?php echo $row_spare['spare_part_code'] ?></th>
                        <th class="text-center " style="width: 15%"><?php echo $row_spare['spare_part_name'] ?></th>
                        <?php $total_spare = 0;
                        for ($i = 1; $i < date('t', strtotime($engmonth[$search_month])); $i++) {
                            $sql_spare_used = "SELECT quantity FROM tbl_job_spare_used WHERE MONTH(create_datetime) = '$search_month' AND DAY(create_datetime) = '$i' AND spare_part_id = '{$row_spare['spare_part_id']}' ";
                            $rs_spare_used = mysqli_query($connect_db, $sql_spare_used);
                            $row_spare_used = mysqli_fetch_assoc($rs_spare_used);

                        ?>
                            <td class="long" style="width: 70px"><?php echo ($row_spare_used['quantity'] != "") ? $row_spare_used['quantity'] : 0; ?></td>
                        <?php  } ?>
                        <td class="text-center"></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
