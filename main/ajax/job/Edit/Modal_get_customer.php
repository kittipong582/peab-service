<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_text_customer = $_POST['search_text_customer'];
$search_type = $_POST['search_type'];


?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายชื่อลูกค้า</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <input type="hidden" id="search_text_customer" name="search_text_customer" value="<?php echo $search_text_customer ?>">
    <input type="hidden" id="search_type" name="search_type" value="<?php echo $search_type ?>">
    <div class="modal-body" id="show_data">


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

        var search_text_customer = $('#search_text_customer').val();
        var search_type = $('#search_type').val();

        $.ajax({
            type: "POST",
            url: "ajax/job/Edit/Get_table_customer.php",
            data: {
                search_type: search_type,
                search_text_customer: search_text_customer
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('#tbl_get_customer').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });

    }



 
</script>