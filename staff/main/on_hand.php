<?php
session_start();
include 'header2.php';

$user_id = $_SESSION['user_id'];
$sql_user_branch  = "SELECT branch_id FROM tbl_user WHERE user_id = '$user_id'";
$rs_user_branch = mysqli_query($connect_db, $sql_user_branch);
$row_user_branch = mysqli_fetch_assoc($rs_user_branch);

if ($_SESSION['user_level'] == 2) {

    $condition = "branch_id = '{$row_user_branch['branch_id']}'";
} else if ($_SESSION['user_level'] == 1) {
    $condition = "user_id = '$user_id'";
}
?>
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>On-hand</h2>
        </center>
    </div>
</div>

<div class="p-1">
    <div class="my-3">
        <div class="col-lg-12">
            <div class="form-group">
                <label>ประเภทอะไหล่</label>
                <select class="form-control select2" id="spare_type" name="spare_type" data-width="100%" onchange="GetTable();">
                    <option value="x" selected>ทั้งหมด </option>

                    <?php

                    $sql_st = "SELECT spare_type_id,spare_type_name  FROM tbl_spare_type ;";
                    $rs_st = mysqli_query($connect_db, $sql_st);
                    while ($row_st = mysqli_fetch_assoc($rs_st)) {

                    ?>

                        <option value="<?php echo $row_st['spare_type_id'] ?>">
                            <?php echo $row_st['spare_type_name'] ?></option>


                    <?php } ?>

                </select>
            </div>
        </div>

        <!-- <div class="col-md-12">
            <div class="form-group">
                <label>ช่าง</label>
                <select class="form-control select2" id="user" name="user" data-width="100%" onchange="GetTable();">
                    <option value="x" selected>ทั้งหมด </option>

                    <?php

                    $sql_u = "SELECT user_id,fullname FROM tbl_user WHERE $condition";
                    $rs_u = mysqli_query($connect_db, $sql_u);
                    while ($row_u = mysqli_fetch_assoc($rs_u)) {

                    ?>

                        <option value="<?php echo $row_u['user_id'] ?>">
                            <?php echo $row_u['fullname'] ?></option>


                    <?php } ?>

                </select>
            </div>
        </div> -->
    </div>
    <div class="wrapper wrapper-content" style="padding: 15px 0px 0px 0px;">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div id="Loading">
                                <div class="spiner-example">
                                    <div class="sk-spinner sk-spinner-wave">
                                        <div class="sk-rect1"></div>
                                        <div class="sk-rect2"></div>
                                        <div class="sk-rect3"></div>
                                        <div class="sk-rect4"></div>
                                        <div class="sk-rect5"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div id="show_data"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="show_modal"></div>
            </div>
        </div>
    </div>



</div>

<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        GetTable();
    });

    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    }).datepicker("setDate", 'now');



    function GetTable() {

        var spare_type = $("#spare_type").val();
        var user = $("#user").val();
        $.ajax({
            type: 'POST',
            url: "ajax/on_hand/GetTable.php",
            data: {
                spare_type: spare_type,
                user: user
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 10,
                    responsive: true,
                    // sorting: disable
                });
                $('#Loading').hide();
            }
        });
    }
</script>