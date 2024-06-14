<?php
include 'header2.php';
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$manual_id = mysqli_escape_string($connect_db, $_GET['manual_id']);

$sql_manual_sub = "SELECT * FROM tbl_spare_part_manual_sub a WHERE a.manual_id = '$manual_id'";
$res_manual_sub = mysqli_query($connect_db, $sql_manual_sub) or die($connect_db->error);



// echo $sql;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>คู่มือย่อย</h2>
        </center>

    </div>
</div>

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
                        target="_blank" class="btn btn-white btn-sm">ไฟล์</a>
                </div>
            </div>
        </div>

    </div>

<?php } ?>
<?php include 'footer.php'; ?>
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