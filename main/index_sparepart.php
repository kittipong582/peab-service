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

$sql_team = "SELECT branch_id,team_number,branch_name FROM tbl_branch WHERE active_status = 1 ORDER BY team_number";
$rs_team = mysqli_query($connection, $sql_team);

$sql_type = "SELECT spare_type_id,spare_type_name FROM tbl_spare_type WHERE active_status = 1 ORDER BY spare_type_name";
$rs_type = mysqli_query($connection, $sql_type);

?>




<div class="row">
    <div class="col-12">
        <div class="ibox">

            <div class="ibox-content">
                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <select class="form-control select2" onchange="Change_data();" id="search_type" name="search_type">
                                <?php while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>
                                    <option value="<?php echo $row_type['spare_type_id'] ?>"><?php echo $row_type['spare_type_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <select class="form-control select2" onchange="Change_data();" id="search_month" name="search_month">
                                <?php foreach ($thaimonth  as $key => $value) {
                                    if ($value != "") { ?>
                                        <option value="<?php echo $key ?>" <?php if ($key == $thismonth) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $value ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <select class="form-control select2" onchange="Change_data();" id="search_branch" name="search_branch">
                                <?php while ($row_team = mysqli_fetch_assoc($rs_team)) { ?>
                                    <option value="<?php echo $row_team['branch_id'] ?>"><?php echo $row_team['team_number'] . " - " . $row_team['branch_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
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



<?php include('import_script.php'); ?>

<script>
    $('.chosen-select').chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });

    $(".select2").select2({});

    $(document).ready(function() {
        // $('#table_job_hold').DataTable({
        //     scrollY: '150px',
        //     scrollCollapse: true,
        //     paging: false,
        //     searching: false,
        // });
        Change_data();
    });



    function Change_data() {
        $('#Loading').show();
        $("#show_data").html('');

        var search_branch = $("#search_branch").val();
        var search_month = $("#search_month").val();
        var search_type = $("#search_type").val();
        
        $.ajax({
            type: 'POST',
            url: "ajax/index_sparepart/GetTable.php",
            data: {
                search_month: search_month,
                search_branch: search_branch,
                search_type:search_type
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('#tbl_index_spare').DataTable({
                    searching: false,
                    sort: false,
                    scrollY: '400px',
                    pageLength: 50,
                });
                $('#Loading').hide();
            }
        });
    }
</script>

</body>

</html>