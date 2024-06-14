<?php
include 'header2.php';
?>
<!-- <style>
    .text_center {
        text-align: center;
    }
</style> -->

<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>งานของฉัน</h2>
        </center>
    </div>
</div>

<div class="p-1">
    <div class="row">
        <!-- <div class="col-12">
            <label> <input type="checkbox" class="i-checks" id="chk" name="chk" value="x" checked onchange="Getdata();">
                แสดงทั้งหมด
            </label>
        </div> -->
        <!-- <div class="col-5 mb-2">

            <input type="text" class="form-control datepicker text-center" name="start_date" id="start_date" value="<?php echo date("d/m/Y", strtotime("now -7 days")); ?>" readonly onchange="Getdata();">

        </div>
        <div class="col-2 mb-2">
            <center><label style="padding-top: 1ex;"><b> ถึง </b></label></center>
        </div>
        <div class="col-5 mb-2">

            <input type="text" class="form-control datepicker text-center" name="end_date" id="end_date" value="<?php echo date("d/m/Y", strtotime("now +7 days")); ?>" readonly onchange="Getdata();">

        </div> -->

        <div class="col-12 mb-2">
            <input type="text" class="form-control mb-2" placeholder="ค้นหาเลขที่ร้าน เช่น (DD0686,CD0112)" id="search" name="search" value="">
            <button type="button" class="btn btn-block btn-success btn-sm" onclick="Getdata();">ค้นหา</button>
        </div>
    </div>
    <div id="show_data"></div>
</div>

<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        Getdata();
        switchSelect1();
    });

    $(".datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        format: 'dd/mm/yyyy',
        thaiyear: false,
        autoclose: true
    });

    function Getdata() {

        // var start_date = $("#start_date").val();
        // var end_date = $("#end_date").val();
        var search = $('#search').val();

        // if (document.getElementById('chk').checked) {
        //     num_chk = 1;
        // } else {
        //     num_chk = 2;
        // }
        // $("#chk").val(num_chk);

        // var chk = $("#chk").val();
        $("#show_data").html('');
        $.ajax({
            type: 'POST',
            url: "ajax/blacklog/get_table.php",
            data: {
                // start_date: start_date,
                // end_date: end_date,
                // chk: chk,
                search: search
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
            }
        });
    }
</script>