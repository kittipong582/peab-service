<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$create_user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$staff_id = $_POST['user_id'];
$start_date = date("Y-m-d H:i", strtotime(str_replace('/', '-', $_POST['first_date'])));
$end_date = date("Y-m-d H:i", strtotime(str_replace('/', '-', $_POST['end_date']) . "23:59:59"));

$condition_1 = "WHERE a.create_datetime between '$start_date' and '$end_date'";
$condition_2 = '';
if ($staff_id != 'x') {
    if ($user_level == 2) {
        $condition_2 = "AND create_user_id = '$staff_id'";
    } else if ($user_level == 1) {
        $condition_2 = "AND create_user_id = '$create_user_id'";
    }
} else {

    $condition_2 = "";
}

?>
<style>
    .classmodal {
        max-width: 1200px;
        margin: auto;
    }
</style>


<br>

<div class="ibox mb-3 d-block">
    <div class="ibox-title">
        <div class="row">
            <div class="col-3">
                <input class="btn btn-sm btn-success " type="button" onclick="Modal_payment();" value="ทำรายการ">
            </div>
        </div>

        <div class="ibox-tools">




        </div>
    </div>
    <div class="ibox-content">

        <div class="table-responsive">

            <table class="table table-striped table-hover table-bordered dataTables-example" id="tbl_deposit" style="width: 250%;">

                <thead>

                    <tr>

                        <th width="2%">#</th>

                        <th width="20%" class="text-center">เลขที่รายการ</th>

                        <th width="20%" class="text-center">วันที่เวลาโอน</th>

                        <th width="20%" class="text-center">บัญชีที่รับเงิน</th>

                        <th width="20%" class="text-center">หลักฐานการโอน</th>

                        <th width="35%" class=""></th>



                    </tr>

                </thead>

                <tbody>

                    <?php

                    $sql = "SELECT * FROM tbl_bank_deposit a
                    LEFT JOIN tbl_user d ON a.create_user_id = d.user_id
                    LEFT JOIN tbl_account c ON a.account_id = c.account_id
                    $condition_1 $condition_2 ORDER BY a.create_datetime DESC";

                    $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

                    $i = 0;
                    // echo $sql;
                    while ($row = mysqli_fetch_assoc($rs)) {


                        $sql_user = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['create_user_id']}'";
                        $rs_user = mysqli_query($connect_db, $sql_user) or die($connect_db->error);
                        $row_user = mysqli_fetch_assoc($rs_user);
                        $i++;

                    ?>
                        <tr id="tr_<?php echo $row['deposit_id']; ?>">

                            <td><?php echo $i; ?></td>

                            <td class="text-center"><?php echo $row['deposit_no']; ?></td>

                            <td class="text-center">

                                <?php echo date("d-m-Y", strtotime($row['deposit_date'])) . " " . date("H:i", strtotime($row['deposit_hour'] . $row['deposit_min'])); ?>

                            </td>

                            <td class="text-center">

                                <?php echo  $row['account_name'] . "  " . substr($row['account_no'], 0, 3) . '-' . substr($row['account_no'], 3, 5) . '-' . substr($row['account_no'], 8, 2); ?><br>


                            </td>

                            <td class="text-center">

                                <?php if ($row['deposit_file'] != null) { ?>
                                    <a target="_blank" href="../../../main/upload/payment_img/<?php echo $row['deposit_file']; ?>" data-lity>
                                        คลิก
                                    </a>
                                <?php }else{ echo "-"; } ?>

                            </td>

                            <td class="text-center">

                                <button class="btn btn-sm btn-success " onclick="Modal_view('<?php echo $row['deposit_id']; ?>');">ดูข้อมูล</button>

                                <button class="btn btn-sm btn-danger" onclick="Cancel('<?php echo $row['deposit_id']; ?>');">ยกเลิก</button>


                            </td>





                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>
    </div>
</div>


<!-- <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg classmodal" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div> -->

<script>
    function Modal_payment() {

        $.ajax({
            type: "post",
            url: "ajax/payment_transfer/modal_payment.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('#tbl_payment').DataTable({
                    responsive: true
                });

                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });


            }
        });

    }


    function Modal_view(deposit_id) {

        $.ajax({
            type: "post",
            url: "ajax/payment_transfer/modal_view.php",
            data: {
                deposit_id: deposit_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('#tbl_payment').DataTable({
                    pageLength: 25,
                    responsive: true
                });

                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });


            }
        });

    }
</script>