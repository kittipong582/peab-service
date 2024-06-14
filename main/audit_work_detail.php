<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$group_id = mysqli_real_escape_string($connect_db, $_GET['group_id']);


$sql_audit_id = "SELECT a.* , b.signature_image FROM tbl_job_audit a JOIN tbl_job_audit_group b ON a.group_id = b.group_id WHERE a.group_id = '$group_id'";
$res_audit_id = mysqli_query($connect_db, $sql_audit_id);

$total_score = 0;

?>
<style>
    .container {
        background-color: #fff;
    }
</style>

<body>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>รายงานผล Audit</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">หน้าแรก</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="audit_report.php">รายการงาน Audit</a>
                </li>
                <li class="breadcrumb-item active">
                    <a>รายงานผล</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>


    <div class="container mt-3">
        <div class="row m-0 p-1">
            <div class="col-12 p-2">

                <?php $sql_dd = "SELECT a.*,b.audit_name FROM tbl_job_audit a
                                    JOIN tbl_audit_form b ON a.audit_id = b.audit_id
                                    WHERE a.group_id ='$group_id'";
                $res_dd = mysqli_query($connect_db, $sql_dd);
                ?>
                <label for="">เลือกแบบฟอร์ม</label>
                <select class="form-control select2" name="job_id" id="job_id" onchange="GetForm()">
                    <?php while ($row_dd = mysqli_fetch_assoc($res_dd)) { ?>
                        <option value="<?php echo $row_dd['job_id'] ?>">
                            <?php echo $row_dd['audit_name'] ?>
                        </option>
                    <?php } ?>
                </select>
                <div id="show_data"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content animated fadeIn">
                <div id="showModal"></div>
            </div>
        </div>
    </div>
</body>

<?php include 'footer.php'; ?>
<script>
    // function ModalImage(record_id) {
    //     $("#myModal").modal("show");
    //     $("#showModal").load("ajax/audit_report/modal_image.php", {
    //         record_id: record_id
    //     });
    // }

    $(document).ready(function() {
        GetForm();
        $(".select2").select2({});
    });

    function ModalImage(record_id) {
        $("#myModal").modal("show");
        $("#showModal").load("ajax/audit_report/modal_image.php", {
            record_id: record_id
        });
    }

    function GetForm(job_id) {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const group_id = urlParams.get('group_id');
        var job_id = $('#job_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/audit_work_detail/get_table.php",
            data: {
                group_id: group_id,
                job_id: job_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $(".select2").select2();
            }
        });
    }
</script>