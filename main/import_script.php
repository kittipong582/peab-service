<div class="modal fade" id="myModalTemp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animated fadeIn">
            <div id="showModalTemp"></div>
        </div>
    </div>
</div>
<!-- Mainly scripts -->
<script src="../template/js/jquery-3.1.1.min.js"></script>

<!-- jQuery UI -->
<script src="../template/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="../template/js/popper.min.js"></script>
<script src="../template/js/bootstrap.js"></script>
<script src="../template/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../template/js/plugins/slimscroll/jquery.slimscroll.js"></script>

<!-- Data TAble -->
<script src="../template/js/plugins/dataTables/datatables.min.js"></script>
<script src="../template/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<!-- Flot -->
<script src="../template/js/plugins/flot/jquery.flot.js"></script>
<script src="../template/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="../template/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="../template/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="../template/js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="../template/js/plugins/peity/jquery.peity.min.js"></script>
<script src="../template/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="../template/js/inspinia.js"></script>
<script src="../template/js/plugins/pace/pace.min.js"></script>


<!-- GITTER -->
<script src="../template/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="../template/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="../template/js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="../template/js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<script src="../template/js/plugins/toastr/toastr.min.js"></script>


<!-- Sweet alert -->
<script src="../template/js/plugins/sweetalert/sweetalert.min.js"></script>

<!-- Thailand -->
<!-- <script type="text/javascript" src="../vendor/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
	<script type="text/javascript" src="../vendor/jquery.Thailand.js/dependencies/JQL.min.js"></script>
	<script type="text/javascript" src="../vendor/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script> -->
<!-- Data picker -->
<script src="../template/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="../template/js/plugins/select2/select2.full.min.js"></script>

<!-- SUMMERNOTE -->
<script src="../template/js/plugins/summernote/summernote-bs4.js"></script>

<!-- Switchery -->
<script src="../template/js/plugins/switchery/switchery.js"></script>
<!-- iCheck -->
<script src="../template/js/plugins/iCheck/icheck.min.js"></script>
<!-- Chart c3-->
<script src="../template/js/plugins/d3/d3.min.js"></script>
<script src="../template/js/plugins/c3/c3.min.js"></script>

<!-- Clock picker -->
<script src="../template/js/plugins/clockpicker/clockpicker.js"></script>

<script src="../template/js/plugins/chosen/chosen.jquery.js"></script>

<script src="../template/js/plugins/jasny/jasny-bootstrap.min.js"></script>

<script src="../template/js/plugins/dropzone/dropzone.js"></script>


<!-- <script src="../template/js/jquery-3.1.1.min.js"></script>
    <script src="../template/js/popper.min.js"></script>
    <script src="../template/js/bootstrap.js"></script>
    <script src="../template/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../template/js/plugins/slimscroll/jquery.slimscroll.min.js"></script> -->

<!-- Custom and plugin javascript -->
<!-- <script src="../template/js/inspinia.js"></script>
    <script src="../template/js/plugins/pace/pace.min.js"></script> -->

<!-- ChartJS-->
<!-- <script src="../template/js/plugins/chartJs/Chart.min.js"></script>
    <script src="../template/js/demo/chartjs-demo.js"></script>  -->


<!-- Signature -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/numeric/1.2.6/numeric.min.js"></script>
<script src="../template/js/bezier.js"></script>
<script src="../template/js/jquery.signaturepad.js"></script> 
<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script> -->

<script src="../template/js/plugins/fullcalendar/moment.min.js"></script>

<script src="../template/js/plugins/fullcalendar/fullcalendar.min.js"></script>

<link href="../template/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">

<link href="../template/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>

<script>
    function SetLine() {
        $('#myModalTemp').modal('show');
        $('#showModalTemp').load("ajax/indexLine/FormLine.php", function() {
            $("#FormSubmitEdit").click(function() {
                swal({
                    title: "ยืนยันการปรับปรุง Line แจ้งเตือน",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#00CC00",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ตรวจสอบอีกครั้ง",
                    closeOnConfirm: false
                }, function() {
                    let myForm = document.getElementById('form_edit');
                    let formData = new FormData(myForm);
                    $.ajax({
                        url: 'ajax/indexLine/Edit.php',
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
                                    text: "ปรับปรุง Line แจ้งเตือนสำเร็จ",
                                    type: "success",
                                    showConfirmButton: true,
                                });
                            } else if (data.result == 0) {
                                swal({
                                    title: "แจ้งเตือน",
                                    text: "ปรับปรุง Line แจ้งเตือนไม่สำเร็จ",
                                    type: "error",
                                    showConfirmButton: true,
                                });
                            } else {
                                swal({
                                    title: "แจ้งเตือน",
                                    text: "ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง!!",
                                    type: "error",
                                    showConfirmButton: true,
                                });
                            }
                        }
                    });
                });
            });
        });
    }

    function SetVisibleLine() {
        if ($('#line_active').is(':checked')) {
            $('#line_show').removeClass("invisible").addClass("visible");
        } else {
            $('#line_show').removeClass("visible").addClass("invisible");
        }
    }
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
