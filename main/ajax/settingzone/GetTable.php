<?php

session_start();

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

?>
<table class="table table-striped table-bordered table-hover">




    <thead>

        <tr>

            <th style="width:5%;">#</th>

            <th style="width:25%;">ชื่อเขต</th>

            <th style="width:25%;">จำนวนทีม</th>

            <th style="width:25%;">จำนวนพนักงาน</th>


            <th style="width:15%;">สถานะ</th>
            <th style="width:15%;"></th>




        </tr>

    </thead>

    <tbody>

        <?php

            $sql = "SELECT *  FROM tbl_zone a 
            LEFT JOIN tbl_branch b on a.zone_id = b.zone_id ";

            $rs = mysqli_query($connection, $sql) or die($connection->error);

               
            
           

            $i = 0;
            
            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;
                $zone_id = $row['zone_id'];
                $sql_2 ="SELECT COUNT(*) AS num FROM tbl_branch WHERE zone_id='$zone_id'";
                $rs_2  = mysqli_query($connection, $sql_2);
                $row_2 = mysqli_fetch_array($rs_2);


                $branch_id = $row['branch_id'];
                $sql_3 ="SELECT COUNT(*) AS num2 FROM tbl_user WHERE branch_id='$branch_id'";
                $rs_3  = mysqli_query($connection, $sql_3);
                $row_3 = mysqli_fetch_array($rs_3);
                
            ?>

        <tr id="tr_<?php echo $zone_id = $row['zone_id']; ?>">


            <td><?php echo $i; ?></td>

            <td>
                <?php echo $row['zone_name']; ?>
            </td>
            <td>
                <?php echo $row_2['num']; ?>
            </td>
            <td>
                <?php echo $row_3['num2']; ?>
            </td>

            <td> 
                <button
                    class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger' ; ?>"
                    onclick="ChangeStatus(this,'<?php echo $row['zone_id']; ?>')">
                    <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน' ; ?>
                </button>
                <button class="btn btn-xs btn-warning btn-block" type="button"
                    onclick="ModalEdit('<?php echo $row['zone_id']; ?>')">
                    แก้ไขข้อมูล
                </button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
