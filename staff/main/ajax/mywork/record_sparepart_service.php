<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql_job = "SELECT close_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
$row_job = mysqli_fetch_array($rs_job);

?>


<div class="ibox">
    <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
    <div class="ibox-content">

        <br>

        <div class="row">
        <?php if ($row_job['close_user_id'] == NULL) { ?>
            <div class="col-6 text-center">
                <button class="btn btn-md btn-info" onclick="modal_add_sparepart('<?php echo $job_id ?>');"><i class="fa fa-plus"></i> บันทึกอะไหล่</button>
            </div>

            <div class="col-6 text-center">
                <button class="btn btn-md btn-info" onclick="modal_add_service('<?php echo $job_id ?>');"><i class="fa fa-plus"></i> บันทึกบริการ</button>
            </div>
<?php } ?>
        </div>

        <br>

        <div class="tabs-container" style="margin-top: 2ex;">
            <ul class="nav nav-tabs">
                <li><a class="nav-link tab_head active" id="tab_head_1" onclick="record_sparepart()" href="#tab-1" data-toggle="tab">อะไหล่</a></li>
                <li><a class="nav-link tab_head" id="tab_head_2" onclick="record_service()" href="#tab-2" data-toggle="tab">บริการ</a></li>

            </ul>

            <div class="tab-content">
                <div role="tabpanel" id="tab-1" class="tab-pane active">
                    <div id="Loading_record_sparepart">
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
                    <div class="panel-body" id="show_record_sparepart">
                    </div>
                </div>

                <div role="tabpanel" id="tab-2" class="tab-pane">
                    <div id="Loading_record_service">
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
                    <div class="panel-body" id="show_record_service">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        record_sparepart();
        record_service();
    });

    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })

    function record_sparepart() {

        var job_id = $('#job_id').val();

        $.ajax({
            type: 'POST',
            url: 'ajax/mywork/record/load_record_sparepart.php',
            data: {
                job_id: job_id
            },
            dataType: 'html',
            success: function(response) {
                $('#show_record_sparepart').html(response);
                $('#Loading_record_sparepart').hide();
            }
        });
    }

    function record_service() {

        var job_id = $('#job_id').val();

        $.ajax({
            type: 'POST',
            url: 'ajax/mywork/record/load_record_service.php',
            data: {
                job_id: job_id
            },
            dataType: 'html',
            success: function(response) {
                $('#show_record_service').html(response);
                $('#Loading_record_service').hide();
            }
        });
    }

    function modal_add_service(job_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/service/modal_add_service.php",
            data: {
                job_id: job_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }


    function modal_add_sparepart(job_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/sparepart/modal_add_sparepart.php",
            data: {
                job_id: job_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
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