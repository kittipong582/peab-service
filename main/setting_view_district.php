<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$amphoe_id = $_GET['id'];

$sql_header = "SELECT a.amphoe_name_th,b.province_name_th,b.province_id FROM tbl_amphoe a 
LEFT JOIN tbl_province b ON b.province_id = a.ref_province 
WHERE a.amphoe_id = '$amphoe_id'";
$result_header  = mysqli_query($connect_db, $sql_header);
$row_header = mysqli_fetch_array($result_header);


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
        <h2><?php echo $row_header['amphoe_name_th'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="setting_amphoe.php">ตั้งค่าที่อยู่</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="setting_view_amphoe.php?id=<?php echo $row_header['province_id']; ?>"><?php echo $row_header['province_name_th'] ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo $row_header['amphoe_name_th'] ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <input type="hidden" value="<?php echo $amphoe_id; ?>" id="amphoe_id" name="amphoe_id">
    <div class="row">
    </div>
    <div class="ibox">
        <div class="ibox-title">

            <div class="ibox-tools">
                <button type="button" class="btn btn-primary btn-xs" onclick="ModalAdd('<?php echo $amphoe_id; ?>')"><i class="fa fa-plus"> เพิ่มอำเภอ</i></button>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
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
        var amphoe_id = $('#amphoe_id').val();
        $.ajax({
            type: "post",
            url: "ajax/setting_amphoe/GetTable_district.php",
            data: {
                amphoe_id: amphoe_id
            },
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

    function ModalAdd(amphoe_id) {
        $.ajax({
            type: "post",
            url: "ajax/setting_amphoe/ModalAdd_District.php",
            data: {
                amphoe_id: amphoe_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }


    function ModalEdit_District(district_id) {
        $.ajax({
            type: "post",
            url: "ajax/setting_amphoe/ModalEdit_District.php",
            data: {
                district_id: district_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
            }
        });
    }
</script>