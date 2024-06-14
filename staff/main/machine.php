<?php
include 'header2.php';

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$sql = "SELECT * FROM tbl_product_brand";
$res = mysqli_query($connect_db, $sql);

$sql_model = "SELECT * FROM tbl_product_model WHERE brand_id='$brand_id' ";
$result = mysqli_query($connect_db, $sql);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>เครื่อง</h2>
        </center>

    </div>
</div>
<div class="row">
    <div class="col-6">
        <label for="">ยี่ห้อ</label>
        <select name="brand_id" id="brand_id" class="form-control select2" onchange="Search()">
            <option value="">กรุณาเลือก</option>
            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                <option value="<?php echo $row['brand_id'] ?>">
                    <?php echo $row['brand_name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="col-6">
        <div id="show_select"></div>
    </div>

</div>

<div id="show_data"></div>



<!-- <div class="row row m-0 p-1">
    <div class="col-6 p-2 ">
        <a href="manual_machine.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                คู่มือ
            </div>
        </a>
    </div>
    <div class="col-6 p-2 ">
        <a href="manual_basic.php" class="ibox pointer box-menu">
            <div class="ibox-content text-center">
                <span><i class="fa fa-cube"></i></span><br>
                การแก้ไขเบื้องต้น
            </div>
        </a>
    </div>
</div> -->
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function () {
        Get_data();
        Search();
        $(".select2").select2();
    });


    function Get_data() {
        var model_id = $('#model_id').val();
        $.ajax({
            type: 'POST',
            url: "ajax/machine/Get_data.php",
            data: {
                model_id: model_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('#Loading').hide();
            }
        });
    }

    function Search(brand_id) {
        var brand_id = $('#brand_id').val();
        $.ajax({
            type: 'POST',
            url: "ajax/machine/select.php",
            data: {
                brand_id: brand_id
            },
            dataType: "html",
            success: function (response) {
                $("#show_select").html(response);
                $('#Loading').hide();
                Get_data();
            }
        });
    }
</script>