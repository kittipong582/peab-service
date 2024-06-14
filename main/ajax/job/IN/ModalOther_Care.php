<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$row = $_POST['row'];
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการทีม</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <input type="hidden" id="row" name="row" value="<?php echo $row ?>">
    <div class="modal-body" id="show_data_care">



    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    </div>
</form>

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {
        GetTable();
    });

    function GetTable() {
        $.ajax({
            url: "ajax/job/IN/GetCare_Table.php",
            dataType: "html",
            success: function(response) {
                $("#show_data_care").html(response);
                $('#tbl_care').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }



    function Choose_Care(branch_id) {

        var row = $('#row').val();
        $.ajax({
            type: "POST",
            url: "ajax/job/IN/GetCare_IN.php",
            data: {
                branch_id: branch_id,
            },
            dataType: "json",
            success: function(response) {
                $("#branch_care_id").val(response.branch_id);
                $("#branch_care").val(response.branch_name);
               
                
                var branch_id = response.branch_id;

                $.ajax({
                    type: "POST",
                    url: "ajax/job/IN/GetSelectIN_User.php",
                    data: {
                        branch_id: branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#user_list").html(response);
                        $(".select2").select2({});
                    }
                });

                $("#modal").modal('hide');
            }
        });
    }
</script>