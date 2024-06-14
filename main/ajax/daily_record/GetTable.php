<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = $_POST['customer_branch_id'];

$sql = "SELECT a.*,b.fullname FROM tbl_customer_daily_record a 
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id 
WHERE a.customer_branch_id = '$customer_branch_id' ORDER BY a.create_datetime DESC";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <!-- <th style="width:5%;" class="text-center">#</th> -->
            <th class="text-center" style="width:15%;">เวลา</th>
            <th class="text-center" style="width:40%;">หัวข้อการบันทึก</th>
            <th class="text-center">ผู้บันทึก</th>
            <!-- <th class="text-center" style="width:18%;">เอกสารประกอบการบันทึก</th> -->
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {

            $i++;


        ?>
        <tr>
            <!-- <td class="text-center"><?php echo $i; ?></td> -->
            <td class="text-center"><?php echo date('d-m-Y H:i',strtotime($row['create_datetime'])); ?></td>
            <td class="text-center"><?php echo $row['record_title']; ?></td>
            <td class="text-center"><?php echo $row['fullname']; ?> </td>
            <!-- <td class="text-center">
            <?php if($row['record_file'] != ""){ ?>
                <a href='upload/<?php echo $row['record_file']?>' target="_blank"
                    class="btn btn-info btn-xs">เอกสารประกอบการบันทึก</a>
                <?php }else{
                    echo "-";
                } ?>
            </td> -->
            
            <td>
                <button class="btn btn-success btn-block btn-xs"
                    onclick="modal_detail('<?php echo $row['daily_id'] ?>');"><i class="fa fa-search"></i>
                    ดูลายละเอียด</button>
                <button class="btn btn-warning btn-block btn-xs"
                    onclick="modal_edit('<?php echo $row['daily_id'] ?>');"><i class="fa fa-pencil-square-o"></i>
                    แก้ไข</button>
                <!-- <button class="btn btn-danger btn-block btn-xs"
                    onclick="delete_record('<?php echo $row['daily_id'] ?>');"><i class="fa fa-times"></i>
                    ลบข้อมูล</button> -->
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>