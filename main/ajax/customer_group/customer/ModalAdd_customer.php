<?php

include("../../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_group_id = $_POST['customer_group_id'];


?>

<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="customer_group_id" name="customer_group_id" value="<?php echo $customer_group_id ?>">
        <div class="row">
            <div class="col-5 mb-3">
                <label for="">
                    ตัวเลือกค้นหา
                </label>
                <select class="form-control select2" id="search_type" name="search_type" style="width: 100%;">
                    <option value="">กรุณาเลือกตัวเลือก</option>
                    <option value="1">รหัสลูกค้า</option>
                    <option value="2">ชื่อลูกค้า</option>

                </select>
            </div>

            <div class="col-5 mb-3">
                <label for="">
                    คำค้นหา
                </label>
                <input type="text" class="form-control mb-3" id="search_text" name="search_text">
            </div>
            <div class="col-2 mb-3">
                <label for="">
                    <br>
                </label>
                <input class="btn btn-sm btn-info btn-block" type="button" onclick="GetTable_customer();" value="ค้นหา">
            </div>


        </div>
        <div class="row" id="tbl_point">



        </div>


    </div>
    <div class="modal-footer">

    </div>
</form>
<?php include('import_script.php'); ?>

<script>
    function GetTable_customer() {

        var customer_group_id = $('#customer_group_id').val();
        var search_type = $('#search_type').val();
        var search_text = $('#search_text').val();
        $.ajax({
            type: "POST",
            url: "ajax/customer_group/customer/GetTable_add.php",
            data: {
                customer_group_id: customer_group_id,
                search_type: search_type,
                search_text: search_text
            },
            dataType: "html",
            success: function(response) {
                $("#tbl_point").html(response);
                $('#table_add').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }



    function Add_customer(customer_id) {

        var customer_group_id = $('#customer_group_id').val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/customer_group/customer/add.php",
            data: {
                customer_id: customer_id,
                customer_group_id: customer_group_id
            },
            success: function(response) {

                if (response.result == 1) {
                    swal({
                        title: "",
                        text: "ดำเนินการสำเร็จ",
                        type: "success",
                        showConfirmButton: false,
                        timer: 700
                    }, function() {
                        swal.close();
                        GetTable_customer();
                        GetTable_list();
                    });
                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });

    }
</script>