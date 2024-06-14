<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_box'];
$search_type = $_POST['search_type'];
$search_value2 = $_POST['search_box2'];
    

?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการเครื่อง</strong></h5>
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
    $(document).ready(function() {
        GetTable();
    });

    function GetTable() {
        var search_type = $('#search_type').val();
        var search_value = $('#search_box').val();
        var search_value2 = $('#search_box2').val();

        $.ajax({
            type: "POST",
            url: "ajax/job/job_overhaul/Get_Table_branch.php",
            data: {
                search_type: search_type,
                search_value: search_value,
                search_value2:search_value2
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('#tbl_OH').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }



    function Choose_customer(customer_id, customer_branch_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job_overhaul/GetCustomer.php",
            data: {
                customer_id: customer_id,
                customer_branch_id: customer_branch_id
            },
            dataType: "json",
            success: function(response) {

                ////////////////1./////////////////
                $("#customer_name").val(response.customer_name);
                $("#branch_name").val(response.branch_name);
                $("#contact_name").val(response.contact_name);
                $("#contact_phone").val(response.contact_phone);
                $("#customer_branch_id").val(response.customer_branch_id);
                $("#contact_position").val(response.contact_position);

                ///////////////4.////////////
                $("#branch_care_id").val(response.branch_care_id);
                $("#branch_care").val(response.branch_care);

                var branch_id = response.branch_care_id;
                $.ajax({
                    type: "POST",
                    url: "ajax/job_overhaul/GetSelect_User.php",
                    data: {
                        branch_id: branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#user_list").html(response);
                        $("#get_user_list").html(response);
                        $("#send_user_list").html(response);
                        $("#qc_user_list").html(response);
                        $(".select2").select2({});
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "ajax/job/job_overhaul/work4.php",
                    data: {
                        branch_id: branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#work4").html(response);
                        $(".datepicker").datepicker({
                            todayBtn: "linked",
                            keyboardNavigation: false,
                            format: 'dd-mm-yyyy',
                            autoclose: true,
                        });
                        $(".select2").select2({});
                    }
                });


                $.ajax({
                    type: "POST",
                    url: "ajax/job/job_overhaul/GetProduct.php",
                    data: {
                        customer_branch_id: response.customer_branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#productpoint").html(response);
                        $(".select2").select2({});
                    }
                });
                $("#modal").modal('hide');
            }
        });
    }



    function Choose_OH_Product(product_id,customer_branch_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/job_overhaul/chooseProduct.php",
            data: {
                product_id: product_id,
                customer_branch_id:customer_branch_id
            },
            dataType: "json",
            success: function(response) {

                $("#productpoint").html();
                ////////////////1./////////////////
                $("#customer_name").val(response.customer_name);
                $("#branch_name").val(response.branch_name);
                $("#contact_name").val(response.contact_name);
                $("#contact_phone").val(response.contact_phone);
                $("#customer_branch_id").val(response.customer_branch_id);
                $("#contact_position").val(response.contact_position);

                /////////////////2.///////////////////
                $("#product_id").val(response.product_id);
                $("#product_type").val(response.product_type);
                $("#serial_no").val(response.serial_no);
                $("#model").val(response.model_name);
                $("#brand").val(response.brand_name);
                $("#warranty_type").val(response.warranty_type);
                $("#warranty_start_date").val(response.warranty_start_date);
                $("#install_date").val(response.install_date);
                $("#warranty_expire_date").val(response.warranty_expire_date);

                ///////////////4.////////////
                $("#branch_care_id").val(response.branch_care_id);
                $("#branch_care").val(response.branch_care);

                var branch_id = response.branch_care_id;
                $.ajax({
                    type: "POST",
                    url: "ajax/job_overhaul/GetSelect_User.php",
                    data: {
                        branch_id: branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#user_list").html(response);
                        $("#get_user_list").html(response);
                        $("#send_user_list").html(response);
                        $("#qc_user_list").html(response);
                        $(".select2").select2({});
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "ajax/job/job_overhaul/work4.php",
                    data: {
                        branch_id: branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $("#work4").html(response);
                        $(".datepicker").datepicker({
                            todayBtn: "linked",
                            keyboardNavigation: false,
                            format: 'dd-mm-yyyy',
                            autoclose: true,
                        });
                        $(".select2").select2({});
                    }
                });
                $("#modal").modal('hide');
            }
        });
    }
</script>