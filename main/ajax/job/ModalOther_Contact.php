<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการผู้ติดต่อ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <input type="hidden" id="customer_branch_id" value="<?php echo $customer_branch_id ?>" name="customer_branch_id">
    <div class="modal-body" id="show_data_contact">



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
        var customer_branch_id = $('#customer_branch_id').val();
        $.ajax({
            type: "POST",
            url: "ajax/job/GetContact_Table.php",
            data: {
                customer_branch_id: customer_branch_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data_contact").html(response);
                $('#tbl_contact').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }



    function Choose_Contact(contact_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/GetContact.php",
            data: {
                contact_id: contact_id,
            },
            dataType: "json",
            success: function(response) {
                $("#contact_name").val(response.contact_name);
                $("#contact_phone").val(response.contact_phone);
                $("#contact_position").val(response.contact_position);
                $("#modal").modal('hide');
            }
        });
    }
</script>