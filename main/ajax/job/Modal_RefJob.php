<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];
$appointment_date = $_POST['appointment_date'];

$sql = "SELECT * FROM tbl_customer_branch WHERE customer_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>อ้างอิงงาน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <input type="hidden" id="customer_branch_id" name="customer_branch_id" value="<?php echo $customer_branch_id ?>">
    <input type="hidden" id="appointment_date" name="appointment_date" value="<?php echo $appointment_date ?>">
    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $row['customer_id']; ?>">

    <div class="modal-body">
        <div class="row">
            <div class="col-2 mb-3">

                <div class="i-checks"><label> <input type="radio" value="1" name="check_search"> <i></i> ร้าน/สาขา </label></div>
                <div class="i-checks"><label> <input type="radio" value="2" name="check_search"> <i></i> ลูกค้า </label></div>
                <div class="i-checks"><label> <input type="radio" value="3" name="check_search"> <i></i> เลขที่งาน </label></div>
            </div>
            <div class="col-4 mb-3" style="display: none;" id="job_no_div">
                <label><b>Job No</b></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="job_no_search" name="job_no_search">
                    <span class="input-group-append"><button type="button" onclick="search_job();" id="btn_ref" name="btn_ref" class="btn btn-success">ค้นหา</button></span>
                </div>


            </div>
            <div class="col-12" id="show_ref_table">

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    </div>
</form>

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green active',
        }).on('ifChanged', function(e) {

            var check = $("input[type='radio'][name='check_search']:checked").val();
            if (check == 1) {
                $("#show_ref_table").html('');
                $('#job_no_div').hide();
                GetTable(check);
            } else if (check == 2) {
                $("#show_ref_table").html('');
                $('#job_no_div').hide();
                GetTable(check);
            } else if (check == 3) {
                $('#job_no_div').show();
                $("#show_ref_table").html('');
            }
        });

    });


    function search_job() {

        var job_no_search = $('#job_no_search').val();
        var check = 3;
        $.ajax({
            type: "POST",
            url: "ajax/job/GetRef_Table.php",
            data: {
                check: check,
                job_no: job_no_search,
            },
            dataType: "html",
            success: function(response) {
                $("#show_ref_table").html(response);
                $('#tbl_ref').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });

    }

    function GetTable(check) {
        var customer_id = $('#customer_id').val();
        var appointment_date = $('#appointment_date').val();
        var customer_branch_id = $('#customer_branch_id').val();


        $.ajax({
            type: "POST",
            url: "ajax/job/GetRef_Table.php",
            data: {
                check: check,
                customer_id: customer_id,
                appointment_date: appointment_date,
                customer_branch_id: customer_branch_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_ref_table").html(response);
                $('#tbl_ref').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }



    function Choose_job_ref(job_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/GetRef_Job.php",
            data: {
                job_id: job_id
            },
            dataType: "json",
            success: function(response) {

                $("#ref_no").val(response.job_no);
                $("#job_ref").val(response.job_id);

                $("#modal").modal('hide');

            }
        });
    }
</script>