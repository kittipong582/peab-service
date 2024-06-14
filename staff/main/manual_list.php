<?php
include 'header2.php';


?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12 ">
        <center>
            <h2>Manual</h2>
        </center>

    </div>
</div>
<div>
    <label>ค้นหา</label>
    <input type="text" name="search" id="search" class="form-control mb-2">
    <button type="button" class="btn btn-block btn-success btn-sm" onclick="GetTable();">ค้นหา</button>
</div>
<div id="show_data"></div>

</div>
<?php include 'footer.php'; ?>
<script>
    $(document).ready(function () {
        GetTable();
    });
    function GetTable() {
        var search = $('#search').val();
        $.ajax({
            type: 'POST',
            url: "ajax/manual_list/GetTable.php",
            data: {
                search: search
            },
            dataType: "html",
            success: function (response) {
                $("#show_data").html(response);
                $('#Loading').hide();
            }
        });
    }
</script>