<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

// if (isset($_POST['customer_group_mol'])) {
//     $customer_group = $_POST['customer_group_mol'];
// }

// $customer_active = "b.active_status = '1'";

// if ($customer_group != "x") {
//     $customer_active != "" ? $con_group = " AND " : "";
//     $condi_group = $con_group . "c.customer_group = '$customer_group'";
// } else {
//     $condi_group = "";
// }


// $sql = "SELECT a.*
// ,b.branch_name
// ,c.customer_name
// FROM tbl_qr_code a
// LEFT JOIN tbl_customer_branch b ON b.customer_branch_id = a.branch_id
// LEFT JOIN tbl_customer c ON c.customer_id = b.customer_id
// WHERE $customer_active $condi_group";
// $res = mysqli_query($connect_db, $sql);
// $total_record = mysqli_num_rows($res);
// $list_size = 600;
// $number = range(0, $total_record, $list_size);

$sql_group = "SELECT * FROM tbl_customer_group WHERE active_status = 1";
$res_group = mysqli_query($connect_db, $sql_group);

?>
<div class="modal-header">
    <h4 class="modal-title">ปริ้น QR Code ทั้งหมด</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label>กลุ่มลูกค้า</label>
                <select class="form-control select2" id="customer_group_mol" name="customer_group_mol" data-width="100%" onchange="GetCustomerGroup()">
                    <option value="x">ทั้งหมด</option>
                    <?php while ($row_group = mysqli_fetch_assoc($res_group)) { ?>
                        <option value="<?php echo $row_group['customer_group_id']; ?>"><?php echo $row_group['customer_group_name']; ?> </option>
                    <?php  } ?>
                </select>
            </div>
            <div id="btn_print"></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>

</div>
<script>
    function GetCustomerGroup() {
        let customer_group_mol = $("#customer_group_mol").val();
        $.ajax({
            type: "POST",
            url: 'ajax/qrcode_generate/button_print.php',
            data: {
                customer_group_mol: customer_group_mol
            },
            dataType: 'html',
            success: function(data) {
                console.log(data);
                $("#btn_print").html(data);
            }
        });
    }
</script>