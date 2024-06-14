<!-- <div class="ibox box-header set-footer">
                        <div class="ibox-title text-center">
                            ขณะนี้คุณทำงานอยู่ที่ .... <br class="hide-md"> ตั้งแต่เวลา 00:05 ( 10 ชั่วโมง 8 นาที )
                        </div>
                    </div> -->

</div>
</div>
</div>
</div>

<div class="modal fade" id="myModalTemp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModalTemp"></div>
        </div>
    </div>
</div>



<!-- Mainly scripts -->
<script src="../../../template/js/jquery-3.1.1.min.js"></script>
<script src="../../../template/js/popper.min.js"></script>
<script src="../../../template/js/bootstrap.js"></script>
<script src="../../../template/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../../../template/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Data TAble -->
<script src="../../../template/js/plugins/dataTables/datatables.min.js"></script>
<script src="../../../template/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="../../../template/js/inspinia.js"></script>
<script src="../../../template/js/plugins/pace/pace.min.js"></script>

<!-- Flot -->
<script src="../../../template/js/plugins/flot/jquery.flot.js"></script>
<script src="../../../template/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="../../../template/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="../../../template/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="../../../template/js/plugins/iCheck/icheck.min.js"></script>
<!-- Sweetalert -->
<script src="../../../template/js/plugins/sweetalert/sweetalert.min.js"></script>

<!-- Summernote -->
<script src="../../../template/js/plugins/summernote/summernote-bs4.js"></script>

<!-- Select2 -->
<script src="../../../template/js/plugins/select2/select2.full.min.js"></script>

<!-- clipboard -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

<!-- Signature -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/numeric/1.2.6/numeric.min.js"></script>
<script src="../../../template/js/bezier.js"></script>
<script src="../../../template/js/jquery.signaturepad.js"></script>
<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js">
</script>

<!-- calender -->
<script src="../../template/js/plugins/fullcalendar/moment.min.js"></script>

<script src="../../template/js/plugins/fullcalendar/fullcalendar.min.js"></script>

<link href="../../template/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">

<link href="../../template/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>


<script>
    //---------------------------------------------
    function SetNewPass() {
        $('#myModalTemp').modal('show');
        $('#showModalTemp').load("ajax/indexPassword/FormPass.php", function() {
            $("#FormSubmitEdit").click(function() {
                let old_pass = $('#old_pass').val();
                let new_pass = $('#new_pass').val();
                let confirm_pass = $('#confirm_pass').val();
                if (old_pass == "" || new_pass == "" || confirm_pass == "") {
                    swal({
                        title: "แจ้งเตือน",
                        text: "กรุณากรอกข้อมูลให้ครบถ้วน",
                        type: "warning"
                    });
                    return false;
                }
                if (new_pass != confirm_pass) {
                    swal({
                        title: "แจ้งเตือน",
                        text: "ยืนยันรหัสผ่านใหม่อีกครั้ง ไม่ถูกต้อง",
                        type: "warning"
                    });
                    return false;
                }
                swal({
                    title: "แจ้งเตือน",
                    text: "ยืนยันการแก้ไขรหัสผ่าน ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#00CC00",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ตรวจสอบอีกครั้ง",
                    closeOnConfirm: false
                }, function() {
                    let myForm = document.getElementById('form_pass');
                    let formData = new FormData(myForm);
                    $.ajax({
                        url: 'ajax/indexPassword/Pass.php',
                        type: 'POST',
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function(data) {
                            if (data.result == 1) {
                                $('#myModalTemp').modal('hide');
                                swal({
                                    title: "แจ้งเตือน",
                                    text: "แก้ไขรหัสผ่านสำเร็จ",
                                    type: "success",
                                    showConfirmButton: true
                                });
                            } else if (data.result == 0) {
                                swal({
                                    title: "แจ้งเตือน",
                                    text: "แก้ไขรหัสผ่านไม่สำเร็จ",
                                    type: "error",
                                    showConfirmButton: true
                                });
                            } else {
                                swal({
                                    title: "แจ้งเตือน",
                                    text: "ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง!!",
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                });
            });
        });
    }
</script>


</body>

</html>