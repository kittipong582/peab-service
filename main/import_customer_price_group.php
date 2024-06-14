<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$customer_group_id = $_GET['id'];

$sql_group = "SELECT * FROM tbl_customer_group WHERE customer_group_id = '$customer_group_id'";
$result_group  = mysqli_query($connect_db, $sql_group);
$row_group = mysqli_fetch_array($result_group);


$sql_spare = "SELECT * FROM tbl_spare_part a 
LEFT JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id 
 ORDER BY spare_part_code";
$result_spare  = mysqli_query($connect_db, $sql_spare);

?>
<style>
    .classmodal1 {
        max-width: 1000px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>นำเข้าลูกค้าของกลุ่ม<?php echo $row_group['customer_group_name'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>

            <li class="breadcrumb-item ">
                <a href="price_group_setting.php">กลุ่มราคา</a>
            </li>
            <li class="breadcrumb-item ">
                <a href="customer_spare_price.php?id=<?php echo $customer_group_id ?>">กลุ่ม<?php echo $row_group['customer_group_name'] ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong>นำเข้าลูกค้าของกลุ่ม<?php echo $row_group['customer_group_name'] ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-tools">
            </div>
        </div>


        <div class="ibox-content">

            <div class="row mb-3" id="">
                <div class="col-4"></div>
                <div class="col-2">
                    <button type="button" onclick="export_customer_price_group('<?php echo $customer_group_id ?>');" class="btn btn-primary btn-sm"> โหลดแบบฟอร์ม </button>
                </div>
                <div class="col-4"></div>
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
            <form id="frm_spare_price_group" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="customer_group_id" name="customer_group_id" value="<?php echo $customer_group_id ?>">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <div class="custom-file" id="upload">
                            <input id="logo" type="file" class="custom-file-input">
                            <label for="logo" class="custom-file-label">กรุณาเลือกไฟล์...</label>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>




<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        $('#Loading').hide();
    });

    var check = 0;
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        let type = fileName.split('.')[1].trim();
        if (type == 'xlsx' || type == 'xls') {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            upload_file();
            check = 1;
        } else {
            swal({
                title: 'ไฟล์ไม่ถูกต้อง',
                // title: 'Invalid file',
                // text: 'Only xlsx files can be uploaded',
                text: 'Upload ใช้เฉพาะไฟล์นามสกุล .xlsx(ไฟล์ Excel) เท่านั้น ',
                type: 'error'
            });
            check = 0;
        }
    });


    function upload_file() {

        var formData = new FormData($("#frm_spare_price_group")[0]);
        formData.append('uploadfile', $('input[type=file]')[0].files[0]);

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            buttonsStyling: false
        }, function() {
            $('#frm_spare_price_group').hide();
            $('#Loading').show();
            $.ajax({
                type: 'POST',
                url: 'ajax/import/customer_price_group/import_customer_price.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    $('#Loading').hide();
                    $('#frm_spare_price_group').show();
                    if (data.result == 1) {

                        swal.close();
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 2000,
                            onHidden: function() {
                                var customer_group_id = $('#customer_group_id').val();
                                window.location.href = 'customer_group_add.php?id=' + customer_group_id;
                            }
                        };
                        toastr.success('ข้อมูลถูกบันทึก', 'ดำเนินสำเร็จ')

                    } else if (data.result == 0) {
                        swal.close();
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 2000,
                            onHidden: function() {
                                window.location.reload();
                            }
                        };
                        toastr.warning('กรุณาตรวจสอบข้อมูล', 'ไม่สามารถดำเนินการได้')
                    }
                }
            })
        })
    }

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

    function export_customer_price_group(customer_group_id) {


        var redirect = 'ajax/report/customer_price_group/export_customer_price_group.php';

        $.redirectPost(redirect, {

            customer_group_id: customer_group_id,

        });
    }
</script>