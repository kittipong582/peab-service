<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$import_id = getRandomID(10, 'tbl_import_stock', 'import_id');

$sql_team = "SELECT branch_name,team_number,branch_id FROM tbl_branch WHERE active_status = 1";
$result_team  = mysqli_query($connect_db, $sql_team);

?>
<form action="" method="post" id="form-import" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">นำเข้า</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="import_id" name="import_id" value="<?php echo $import_id ?>">
        <div class="row">
            <div class="col-4 mb-2">
                <label>เลือกทีม</label>
                <font color="red">**</font>
                <select class="form-control select2" id="branch_id" name="branch_id" data-width="100%">
                    <option value="">กรุณาเลือกทีม</option>
                    <?php while ($row_team = mysqli_fetch_array($result_team)) { ?>

                        <option value="<?php echo $row_team['branch_id']; ?>"><?php echo $row_team['team_number'] . " - " . $row_team['branch_name'] ?></option>

                    <?php } ?>
                </select>

            </div>

            <div class="col-4 mb-2">
                <div class="form-group">
                    <label>AX_Ref_TRO_no</label>
                    <font color="red">**</font>
                    <input type="text" id="ax_ref_no" name="ax_ref_no" class="form-control" placeholder="" autocomplete="off">
                </div>
            </div>

            <div class="col-4 mb-2">
                <div class="form-group">
                    <label>วันที่เบิกจาก AX</label>
                    <font color="red">**</font>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input class="form-control datepicker" type="text" name="withdraw_date" id="withdraw_date" value="<?php echo date('d/m/Y'); ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="form-group">
                    <label>หมายเหตุ</label>
                    <textarea class="form-control summernote" rows="10" name="remark" id="remark"></textarea>
                </div>
            </div>

            <div class="col-12 mb-3">

                <div class="custom-file" id="upload">
                    <input id="file_main" type="file" class="custom-file-input">
                    <label for="logo" class="custom-file-label">กรุณาเลือกไฟล์...</label>
                </div>
            </div>


        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    </div>
</form>
<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {


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

    });


    var check = 0;
    $('.custom-file-input').on('change', function() {

        var branch_id = $('#branch_id').val();
        var ax_ref_no = $('#ax_ref_no').val();
        var withdraw_date = $('#withdraw_date').val();


        if (branch_id == "" || ax_ref_no == "" || withdraw_date == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
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

        var formData = new FormData($("#form-import")[0]);
        formData.append('uploadfile', $("#file_main")[0].files[0]);

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
            $.ajax({
                type: 'POST',
                url: 'ajax/import_from_ax/import_file_ax.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {

                    if (data.result == 1) {

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
</script>