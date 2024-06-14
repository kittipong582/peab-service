<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_box'];
$search_type = $_POST['search_type'];
$job_type = $_POST['job_type'];
$chk_job = $_POST['chk_job'];

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
    <input type="hidden" id="job_type" name="job_type" value="<?php echo $job_type ?>">

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
        var search_value = $('#search_value').val();
        var job_type = $('#job_type').val();
        if (job_type == 1) {
            $.ajax({
                type: "POST",
                url: "ajax/job/CM/GetCM_Table.php",
                data: {
                    search_type: search_type,
                    search_value: search_value,
                    job_type: job_type
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('#tbl_CM').DataTable({
                        pageLength: 25,
                        responsive: true
                    });
                }
            });
        } else if (job_type == 2) {
            $.ajax({
                type: "POST",
                url: "ajax/job/PM/GetPM_Table.php",
                data: {
                    search_type: search_type,
                    search_value: search_value,
                    job_type: job_type
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('#tbl_PM').DataTable({
                        pageLength: 25,
                        responsive: true
                    });
                }
            });
        } else if (job_type == 7) {
            $.ajax({
                type: "POST",
                url: "ajax/job/Audit/GetAudit_Table.php",
                data: {
                    search_type: search_type,
                    search_value: search_value,
                    job_type: job_type
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('#tbl_PM').DataTable({
                        pageLength: 25,
                        responsive: true
                    });
                }
            });


        } else {

            $.ajax({
                type: "POST",
                url: "ajax/job/IN/GetIN_Table.php",
                data: {
                    search_type: search_type,
                    search_value: search_value,
                    job_type: job_type
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('#tbl_IN').DataTable({
                        pageLength: 25,
                        responsive: true
                    });
                }
            });

        }
    }



    function Choose_CM_Product(product_id) {

        let chk_job = '<?php echo $chk_job ?>';
        console.log(chk_job);
        $.ajax({
            type: "POST",
            url: "ajax/job/CM/GetProduct_CM.php",
            data: {
                product_id: product_id
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

                /////////////////2.///////////////////
                $("#choose_product_id").val(response.product_id);
                $("#product_type").val(response.product_type);
                $("#serial_no").val(response.serial_no);
                $("#model").val(response.model_name);
                $("#brand").val(response.brand_name);
                $("#warranty_type").val(response.warranty_type);
                $("#warranty_start_date").val(response.warranty_start_date);
                $("#install_date").val(response.install_date);
                $("#warranty_expire_date").val(response.warranty_expire_date);

                ///////////////4.////////////
                if (chk_job == 'qc') {
                    $("#branch_care_id").val('uUzvlhGBg1');
                    $("#branch_care").val('กรุงเทพ ทีม QC TE039');
                } else {
                    $("#branch_care_id").val(response.branch_care_id);
                    $("#branch_care").val(response.branch_care);
                }
                var branch_id = response.branch_care_id;
                $.ajax({
                    type: "POST",
                    url: "ajax/job/GetSelect_User.php",
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





    function Choose_PM_Product(product_id, customer_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/PM/GetProduct_PM.php",
            data: {
                product_id: product_id,
                customer_id: customer_id
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

                /////////////////2.///////////////////
                $("#choose_product_id").val(response.product_id);
                $("#product_type").val(response.product_type);
                $("#serial_no").val(response.serial_no);
                $("#model").val(response.model_name);
                $("#brand").val(response.brand_name);
                $("#warranty_type").val(response.warranty_type);
                $("#warranty_start_date").val(response.warranty_start_date);
                $("#install_date").val(response.install_date);
                $("#warranty_expire_date").val(response.warranty_expire_date);

                ///////////////4.////////////
                $(".branch_care_id").val(response.branch_care_id);
                $(".branch_care").val(response.branch_care);
                $("#check_plan").val(response.branch_care_id);

                var branch_id = response.branch_care_id;
                $.ajax({
                    type: "POST",
                    url: "ajax/job/GetSelect_User.php",
                    data: {
                        branch_id: branch_id,
                    },
                    dataType: "html",
                    success: function(response) {
                        $(".user_list").html(response);
                        $(".select2").select2({});
                    }
                });
                $("#modal").modal('hide');
            }
        });
    }



    function Choose_IN(customer_id) {

        $.ajax({
            type: "POST",
            url: "ajax/job/IN/GetProduct_IN.php",
            data: {
                customer_id: customer_id
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
                $("#customer_branch_id").val(response.customer_branch_id);
                var branch_id = response.branch_care_id;
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