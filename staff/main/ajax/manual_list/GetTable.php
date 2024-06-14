<?php
include 'header2.php';
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$search = mysqli_real_escape_string($connect_db, $_POST['search']);

$condition="";
if ($search == "") {
   
}else{
    $condition .= "WHERE manual_name LIKE '%$search%'";
}

$sql_manual = "SELECT * FROM tbl_manual $condition LIMIT 10";
$rs_manual = mysqli_query($connect_db, $sql_manual) or die($connect_db->error);


// echo $sql;
?>

<?php while ($row_manual = mysqli_fetch_assoc($rs_manual)) { ?>
    <div class="ibox mb-1 d-block border">
        <div class="ibox-title">
            <b>
                <?php echo $row_manual['manual_name'] ?>
            </b>
            <br>
        </div>
        <div class="ibox-content">
            <table class="w-100">
                <thead>
                    <tr>
                        <td><b>เหตุผล</b></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $row_manual['remark'] ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">

                    <a href="manual_list_sub.php?manual_id=<?php echo $row_manual['manual_id']; ?>"
                        class="btn btn-white btn-sm">ดูเพิ่มเติม</a>
                </div>
            </div>
        </div>

    </div>
<?php } ?>
