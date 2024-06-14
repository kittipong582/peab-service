<?php

echo date("Y-m-d H:i");
session_start();

include("header.php");
$secure = "LM=VjfQ{6rsm&/h`";

$connection = connectDB($secure);
$today = date("Y-m-d");
$thismonth = date("m");
$thisyear = date("Y");
$thaimonth = array("00" => "", "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");


$sql_team1 = "SELECT branch_id,team_number,branch_name FROM tbl_branch WHERE active_status = 1 ORDER BY team_number";
$rs_team1 = mysqli_query($connection, $sql_team1);

$sql_team2 = "SELECT branch_id,team_number,branch_name FROM tbl_branch WHERE active_status = 1 ORDER BY team_number";
$rs_team2 = mysqli_query($connection, $sql_team2);

?>





<div class="row">
    <div class="col-12">
        <div class="ibox">
            <div class="ibox-title">
                <div class="row">
                    <div class="col-6">
                        <h3 class="font-bold"> สรุปงานรายคลังรายเดือน </h3>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control select2" id="team_month1" onchange="Change_team_data()">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($thaimonth  as $key => $value) {
                                        if ($value != "") { ?>
                                            <option value="<?php echo $key ?>" <?php if ($key == $thismonth) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $value ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-control select2" id="team_branch1" onchange="Change_team_data()">
                                    <option value="">ทั้งหมด</option>
                                    <?php while ($row_team1 = mysqli_fetch_assoc($rs_team1)) { ?>
                                        <option value="<?php echo $row_team1['branch_id'] ?>"><?php echo $row_team1['team_number'] . " - " . $row_team1['branch_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-12">
                        <div id="Loading_team">
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
                        <div id="show_team_data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="ibox">
            <div class="ibox-title">
                <div class="row">
                    <div class="col-6">
                        <h3 class="font-bold"> สรุปงานรายพนักงานรายเดือน </h3>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control select2" id="team_month2" onchange="Change_user_data()">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($thaimonth  as $key => $value) {
                                        if ($value != "") { ?>
                                            <option value="<?php echo $key ?>" <?php if ($key == $thismonth) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $value ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-control select2" id="team_branch2" onchange="Change_user_data()">
                                    <option value="">ทั้งหมด</option>
                                    <?php while ($row_team2 = mysqli_fetch_assoc($rs_team2)) { ?>
                                        <option value="<?php echo $row_team2['branch_id'] ?>"><?php echo $row_team2['team_number'] . " - " . $row_team2['branch_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-12">

                        <div id="Loading_user">
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
                        <div id="show_user_data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('import_script.php'); ?>

<script>
    $('.chosen-select').chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });

    $(".select2").select2({});

    $(document).ready(function() {
        Change_team_data();
        Change_user_data();
    });

    function Change_team_data() {
        $('#Loading_team').show();
        $("#show_team_data").html('');

        var team_month1 = $("#team_month1").val();
        var team_branch1 = $("#team_branch1").val();

        $.ajax({
            type: 'POST',
            url: "ajax/index_user_team/GetTable_Team.php",
            data: {
                team_branch1: team_branch1,
                team_month1: team_month1
            },
            dataType: "html",
            success: function(response) {
                $("#show_team_data").html(response);
                $('#table_team').DataTable({
                    paging: false,
                    searching: false,

                });
                $('#Loading_team').hide();
            }
        });
    }

    function Change_user_data() {
        $('#Loading_user').show();
        $("#show_user_data").html('');

        var team_month2 = $("#team_month2").val();
        var team_branch2 = $("#team_branch2").val();

        $.ajax({
            type: 'POST',
            url: "ajax/index_user_team/GetTable_User.php",
            data: {
                team_branch2: team_branch2,
                team_month2: team_month2
            },
            dataType: "html",
            success: function(response) {
                $("#show_user_data").html(response);
                $('#table_user').DataTable({
                    paging: false,
                    searching: false,

                });
                $('#Loading_user').hide();
            }
        });
    }
</script>

</body>

</html>