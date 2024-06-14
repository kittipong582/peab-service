<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>
<div class="p-1">   
    <div class="ibox mb-3 d-block border-pm">
        <div class="ibox-title">
       <button class="btn btn-info">เพิ่ม</button>
        </div>
        <div class="ibox-content">
            <table class="w-100">
                <tr>
                    <th>#</th>
                    <th>หัวข้อ</th>
                    <th>คำอธิบาย</th>
                    <th></th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>-</td>
                    <td>-</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script>
    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",
        
    }).datepicker("setDate",'now');

</script>

