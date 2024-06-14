<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_POST['product_id'];
$job_id = $_POST['job_id'];

?>



<form action="" method="post" id="form-add_fiexd" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>ประวัติการซ่อม</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>">
        <input type="hidden" id="job_id" name="product_id" value="<?php echo $job_id ?>">
        <div class="row">
            <div class="col-12 text-center">
                <div id="Loading_history">
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

                <div id="show_data">

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
    </div>

</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});
        load_table_history();
    });

    function load_table_history() {

        var product_id = $('#product_id').val();
        var job_id = $('#job_id').val();

        $.ajax({
            type: 'POST',
            url: 'ajax/CM_view/history/getTable_history.php',
            data: {
                product_id: product_id,
                job_id:job_id
            },
            dataType: 'html',
            success: function(response) {
                $('#show_data').html(response);
                $('.history_tbl').DataTable({
                    pageLength: 25,
                    responsive: true,
                });
                $('#Loading_history').hide();
            }
        });
    }
</script>