<?php
include 'header2.php';
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$manual_id = mysqli_real_escape_string($connect_db, $_GET['manual_id']);
$model = mysqli_real_escape_string($connect_db, $_GET['model']);

$sql = "SELECT * FROM tbl_product_brand";
$res = mysqli_query($connect_db, $sql);

$sql_model = "SELECT * FROM tbl_product_model WHERE brand_id='$brand_id' ";
$result = mysqli_query($connect_db, $sql);


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12 ">
        <center>
            <h2>การแก้ไขเบื้องต้น</h2>
        </center>
    </div>
</div>
<div class="row">
    </div>

    <div class="col-6">
        <div id="show_select"></div>
    </div>

</div>

<div id="show_data"></div>

</div>
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function () {
        Get_data();
        $(".select2").select2();
    });

    function Get_data() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const manual_id = urlParams.get('manual_id');
        const model = urlParams.get('model');
    
        $.ajax({
            type: 'POST',
            url: "ajax/manual_basic/Get_data.php",
            data: {
                manual_id: manual_id,
                model: model
            },
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('#Loading').hide();
            }
        });
    }

    // function Search(brand_id) {
    //     var brand_id = $('#brand_id').val();
    //     $.ajax({
    //         type: 'POST',
    //         url: "ajax/manual_basic/select.php",
    //         data: {
    //             brand_id: brand_id
    //         },
    //         dataType: "html",
    //         success: function (response) {
    //             $("#show_select").html(response);
    //             $('#Loading').hide();
    //             Get_data();
    //         }
    //     });
    // }

</script>