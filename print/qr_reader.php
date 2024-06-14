<?php
include("../config/main_function.php");
include("header2.php");

$connection = connectDB("LM=VjfQ{6rsm&/h`");

$qr_no = mysqli_real_escape_string($connection, $_GET['id']);

$sql = "SELECT
a.branch_id
,b.branch_name
,c.customer_name
FROM tbl_qr_code a
LEFT JOIN tbl_customer_branch b ON b.customer_branch_id = a.branch_id
LEFT JOIN tbl_customer c ON c.customer_id = b.customer_id
WHERE a.qr_no = '$qr_no'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);
?>

<div class="p-3">
    <div class="row wrapper border-bottom white-bg page-heading mb-3">
        <div class="col-lg-12 mt-4">
            <center>
                <h3>ลูกค้า : <?php echo $row['customer_name']; ?></h3>
                <h4>สาขา : <?php echo $row['branch_name']; ?></h4>
            </center>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <a class="ibox pointer box-menu" onclick="Product_list()">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-cubes"></i></span><br>
                    รายการสินค้า
                </div>
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <a class="ibox pointer box-menu" onclick="ReportRepair()">
                <div class="ibox-content text-center">
                    <span><i class="fa fa-file-text-o"></i></span><br>
                    แจ้งซ่อม
                </div>
            </a>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
<script>
    $(document).ready(function() {
        $(".select2").select2({
            width: "75%"
        });
    });

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    }).datepicker("setDate", 'now');

    $.extend({
        redirectPost: function(location, args) {
            var form = '';
            $.each(args, function(key, value) {
                form += '<input type="hidden" name="' + key + '" value="' + value + '">';
            });
            $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body')
                .submit();
        }
    });

    function Product_list() {
        let branch_id = '<?php echo $row['branch_id']; ?>';
        let redirect = 'product_list.php';
        $.redirectPost(redirect, {
            branch_id : branch_id,
        });
    }

    function ReportRepair() {
        let branch_id = '<?php echo $row['branch_id']; ?>';
        let redirect = 'report_repair.php';
        $.redirectPost(redirect, {
            branch_id : branch_id,
        });
    }
</script>