<?php
include 'header2.php';
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$manual_id = mysqli_escape_string($connect_db, $_GET['manual_id']);

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12 ">
        <center>
            <h2>คู่มือย่อย</h2>
        </center>
    </div>
</div>
<div>
    <label>ค้นหา</label>
    <input type="text" name="search" id="search" class="form-control mb-2" >
    <button type="button" class="btn btn-block btn-success btn-sm" onclick="Get_data();">ค้นหา</button>
</div>

<div id="show_data"></div>


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
        var search = $('#search').val();

        $.ajax({
            type: 'POST',
            url: "ajax/manual_list_sub/Get_data.php",
            data: {
                manual_id: manual_id,
                search: search
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