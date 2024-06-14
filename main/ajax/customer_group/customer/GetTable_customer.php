<?php
include("../../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_id = $_POST['customer_group_id'];

$list = array();

$sql = "SELECT * FROM tbl_customer 
 WHERE customer_group = '$customer_group_id' ORDER BY customer_code";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;
while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "customer_id" => $row['customer_id'],
        "customer_code" => $row['customer_code'],
        "customer_name" => $row['customer_name'],
        "email" => $row['email'],
        "phone" => $row['phone'],
        "address" => $row['address']
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover" id="table_customer">
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:10%;" class="text-center">รหัสลูกค้า</th>
            <th class="text-left">ชื่อลูกค้า</th>
            <th class="text-left" style="width:20%;">การติดต่อ</th>
            <th class="text-left" style="width:20%;">ที่อยู่</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $row['customer_code']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['email']."<br/>".$row['phone']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td>

                    <button class="btn btn-xs btn-danger btn-block" onclick="remove_customer('<?php echo  $row['customer_id'] ?>');" type="button">
                        นำออก
                    </button>

                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>