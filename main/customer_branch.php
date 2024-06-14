<?php
include('header.php');
include("../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$customer_id = $_GET['id'];
$sql_detail = "SELECT * FROM tbl_customer  WHERE customer_id = '$customer_id'";
$result_detail  = mysqli_query($connection, $sql_detail);
$row_detail = mysqli_fetch_array($result_detail);

?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>
<input type="text" hidden id="customer_id" value="<?php echo $customer_id; ?>">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ข้อมูลสาขา</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_list.php">รายการลูกค้า</a>
            </li>
            <li class="breadcrumb-item ">
                <a href="customer_view_detail.php?id=<?php echo $row_detail['customer_id']; ?>"><?php echo $row_detail['customer_name'] ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ข้อมูลสาขา</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ข้อมูลสาขา</h5>
                </div>
                <div class="ibox-tools" style="padding-right: 5ex;">
                    <a href="customer_form_branch.php?id=<?php echo $customer_id ?>"><button type="button" class="btn btn-xs btn-info"><i class="fa fa-plus"></i> เพิ่มสาขาลูกค้า</button></a>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive" id="showData"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <?php include 'customer_menu.php'; ?>
        </div>
    </div>

</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        getDataBranch();
    });

    function getDataBranch() {
        const customer_id = $("#customer_id").val();
        $.ajax({
            type: "post",
            url: "ajax/customer/getDataBranch.php",
            data: {
                customer_id: customer_id
            },
            dataType: "html",
            success: function(response) {
                $("#showData").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
            }
        });
    }
</script>