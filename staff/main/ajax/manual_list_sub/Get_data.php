<?php
include 'header2.php';
include ("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$manual_id = mysqli_escape_string($connect_db, $_POST['manual_id']);
$search = mysqli_real_escape_string($connect_db, $_POST['search']);

$condition = "";
if ($search == "") {

} else {
    $condition .= "AND manual_sub_name LIKE '%$search%'";
}

$sql_manual_sub = "SELECT * FROM tbl_manual_sub WHERE manual_id = '$manual_id' $condition ORDER BY manual_sub_id DESC LIMIT 10";
$res_manual_sub = mysqli_query($connect_db, $sql_manual_sub) or die($connect_db->error);



// echo $sql;
?>


<?php while ($row_manual_sub = mysqli_fetch_assoc($res_manual_sub)) { ?>
    <div class="ibox mb-1 d-block border">
        <div class="ibox-title">
            <b>
                <?php echo $row_manual_sub['manual_sub_name']; ?>
            </b>
            <br>
        </div>
        <div class="ibox-content">
            <table class="">
                <thead>
                    <tr>
                        <td><b>เหตุผล</b></td>
                    </tr>
                </thead>
                <tbody class=" mt-5 text-left">
                    <tr>
                        <td>
                            <?php echo $row_manual_sub['remark']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">

                    <a href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row_manual_sub['file_name']; ?>"
                        target="_blank" class="btn btn-white btn-sm mr-2">ไฟล์</a>
                    <?php if ($row_manual_sub['link_manual'] != "") {
                        ?>
                        <a target="_blank" href="<?php echo $row_manual_sub['link_manual']; ?>"
                            class="btn btn-white btn-sm">วีดีโอ</a>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>

<?php } ?>

<script>
    // function GetTable(manual_id) {
    //     $.ajax({
    //         type: 'POST',
    //         url: "ajax/manual_list/GetTable.php",
    //         data: {
    //             manual_id: manual_id
    //         },
    //         dataType: "html",
    //         success: function (response) {
    //             $("#show_data").html(response);
    //             $('table').DataTable({
    //                 pageLength: 10,
    //                 responsive: true,
    //                 // sorting: disable
    //             });
    //             $('#Loading').hide();
    //         }
    //     });
    // }
</script>