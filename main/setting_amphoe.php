<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_GET['id'];

$sql = "SELECT a.*, (a.branch_id) AS id,b.*,(b.branch_name) AS b_name  FROM tbl_branch a 
LEFT JOIN tbl_customer_branch b ON a.branch_id = b.branch_care_id WHERE b.customer_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>

<style>
    .line-vertical {
        border-left: 1px solid rgba(0, 0, 0, .1);
        ;
        height: 90%;
        position: absolute;
        left: 50%;

    }

    .hidden-color {
        display: none;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ตั้งค่าที่อยู่</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ตั้งค่าที่อยู่</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
    </div>
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
            <div class="row">
                <div class="col-6">
                   
                </div>

            </div>
        </div>
        <div id="Loading">
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
        <div class="ibox-content" id="show_data">

        </div>
    </div>
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        GetTable();
    });

    function GetTable() {
        $.ajax({
            type: "post",
            url: "ajax/setting_amphoe/GetTable_province.php",
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }

</script>