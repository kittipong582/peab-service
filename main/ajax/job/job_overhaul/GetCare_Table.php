<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];

$sql = "SELECT * FROM tbl_branch ORDER BY branch_name";
$result  = mysqli_query($connect_db, $sql);

?>

<table id="tbl_care" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-center">ชื่อทีม</th>
            <th class="text-center">ที่อยู่</th>
            <th class="text-center">ที่อยู่2</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {
         
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="text-left"><?php echo $row['branch_name'] ?></td>
                <td class="text-center"><?php echo $row['address'] ?></td>
                <td class="text-center"><?php echo $row['address2'] ?></td>
                <td>
                    <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_Care('<?php echo $row['branch_id'] ?>');">เลือก</button>
                   
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>