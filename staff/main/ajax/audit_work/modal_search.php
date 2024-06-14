<?php
@include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];

?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>ลูกค้า / สาขา</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <input type="hidden" id="search_value" name="search_value" value="<?php echo $search_value ?>">
    <input type="hidden" id="search_type" name="search_type" value="<?php echo $search_type ?>">
    <div class="modal-body" id="show_data">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    </div>
</form>

<?php include('footer.php'); ?>

<script>
    $(document).ready(function () {
        GetTable();
    });

    function GetTable() {
        var search_type = $('#search_type').val();
        var search_value = $('#search_value').val();
        console.log(search_value);
        $.ajax({
            type: "POST",
            url: "ajax/audit_work/get_search_table.php",
            data: {
                search_type: search_type,
                search_value: search_value,
            },
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('#tbl_PM').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }

    function ChooseCustomer(customer_branch_id,customer_id) {
        console.log(customer_branch_id);
        console.log(customer_id);
        $.ajax({
            type: "POST",
            url: "ajax/audit_work/get_customer.php",
            data: {
                customer_branch_id: customer_branch_id
            },
            dataType: "json",
            success: function (response) {
                $("#branch_name").val(response.branch_name);
                $("#customer_branch_id").val(customer_branch_id);
                $("#customer_name").val(response.customer_name);
                $("#branch_code").val(response.branch_code);
                $("#customer_id").val(response.customer_id);
    
                $("#myModal").modal('hide');
            }
        });
    }
</script>