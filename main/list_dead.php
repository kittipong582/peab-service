<meta http-equiv="pragma" content="no-cache" />
<?php 
    include('header.php');
    $current_year = date('Y')+5;
    $range = range($current_year, 2021);
    $arr_years = array_combine($range, $range);
    $arr_month = array("00" => "ทั้งปี", "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
 ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>เอกสารการเสียชีวิต</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">หน้าหลัก</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>เอกสารการเสียชีวิต</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label> ปี</label>
                                        <select class="form-control select2-container" id="years" name="years" style="width: 100%;">
                                            <?php foreach ($arr_years as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>" <?php if (date('Y') == $key) {echo "selected";} ?>><?php echo ($value + 543); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label> เดือน</label>
                                        <select class="form-control select2-container" id="month" name="month" style="width: 100%;">
                                            <?php foreach ($arr_month as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="LoadDead();"><i class="fa fa-search"></i> แสดง</button>
                                    <button class="btn btn-primary btn-sm" onclick="AddDead();"><i class="fa fa-plus"></i> เพิ่มเอกสารการเสียชีวิต</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" id="showTable">
                   
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content animated fadeIn">
                    <div id="showModal"></div>
                </div>
            </div>
        </div>
        <div class="modal" id="subModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content animated fadeIn">
                    <div id="showSubModal"></div>
                </div>
            </div>
        </div>
        <?php include('import_script.php'); ?>
        <script>
            $(document).ready(function() {
       
            }); 
            function LoadDead() {
                let years = $("#years").val();
                let month = $("#month").val();
                $.ajax({
                    beforeSend: function(){
                        $("#page-wrapper").LoadingOverlay("show", {
                            zIndex   : 99,
                            imageColor : "#1AB394",
                        }); 
                    },
                    type: 'POST',
                    url: 'ajax/listDead/GetTable.php',
                    data: {
                        years:years,
                        month:month,
                    },
                    dataType: 'html',
                    success: function(data) {
                        $('#showTable').html(data);
                        $('#myTable').DataTable({
                            pageLength: 25,
                            responsive: true,
                            ordering: false
                        });
                        $('#Loading').hide();
                        $('#showTable').show();
                        $("#page-wrapper").LoadingOverlay("hide", true);
                    }
                });
            }
            function AddDead() {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/listDead/FormAdd.php",function(){
                    $("#FormSubmitAdd").click(function() {
                        let document_years = $("#document_years").val();
                        let document_month = $("#document_month").val();
                        if(document_years == "" || document_month == ""){
                            swal({
                                title: "แจ้งเตือน",
                                text: "กรุณากรอกข้อมูลให้ครบถ้วน",
                                type: "warning"
                            });
                            return false;
                        }
                        swal({
                            title: "ยืนยันการเพิ่มเอกสารการเสียชีวิต",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#00CC00",
                            confirmButtonText: "ยืนยัน",
                            cancelButtonText: "ตรวจสอบอีกครั้ง",
                            closeOnConfirm: false
                        },function () {
                            let myForm = document.getElementById('form_add');
                            let formData = new FormData(myForm);
                            $.ajax({
                                url: 'ajax/listDead/Add.php',
                                type: 'POST',
                                dataType: 'json',
                                contentType: false,
                                cache: false,
                                processData:false,
                                data: formData,
                                success : function (data) {
                                    if(data.result == 1){
                                        $('#myModal').modal('hide');
                                        LoadDead();
                                        swal({
                                            title: "แจ้งเตือน",
                                            text: "เพิ่มเอกสารการเสียชีวิตสำเร็จ",
                                            type: "success",
                                            showConfirmButton: true,
                                        });
                                    }else if(data.result == 0){
                                        swal({
                                            title: "แจ้งเตือน",
                                            text: "เพิ่มเอกสารการเสียชีวิตไม่สำเร็จ",
                                            type: "error",
                                            showConfirmButton: true,
                                        });
                                    }else{
                                        swal({
                                            title: "แจ้งเตือน",
                                            text: "ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง",
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
  
            function ImportFamily() {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/listDead/FormImportFamily.php",function(){
                    $("#SubmitImport").click(function() {
                        var file_excel = $('#file_excel').val();
                        if(file_excel == ""){
                            swal({
                                title: "แจ้งเตือน!",
                                text: "กรุณาอัพโหลดไฟล์นำเข้า",
                                type: "warning"
                            });
                            return false;
                        }
                        swal({
                            title: "ยืนยันการนำเข้าข้อมูล ?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#00CC00",
                            confirmButtonText: "ยืนยัน",
                            cancelButtonText: "ตรวจสอบอีกครั้ง",
                            closeOnConfirm: false
                        },function () {
                            let myForm = document.getElementById('form_import');
                            let formData = new FormData(myForm);
                            $.ajax({
                                url: 'ajax/listDead/ImportFamily.php',
                                type: 'POST',
                                dataType: 'json',
                                contentType: false,
                                cache: false,
                                processData:false,
                                data: formData,
                                success : function (data) {
                                    if(data.result == 1){
                                        $('#myModal').modal('hide');
                                        swal({
                                            title: "แจ้งเตือน",
                                            text: "นำเข้าข้อมูลสำเร็จ",
                                            type: "success",
                                            showConfirmButton: true
                                        });
                                    }else if(data.result == 0){
                                        $('#myModal').modal('hide');
                                        swal({
                                            title: "แจ้งเตือน",
                                            text: "ไม่มีข้อมูลถูกนำเข้า",
                                            type: "error",
                                            showConfirmButton: true
                                        });
                                    }else{
                                        swal({
                                            title: "แจ้งเตือน",
                                            text: "ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง",
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
            function readURL(input,value,show_position) {
                var fty = ["xlsx", "xls"];
                var permiss = 0;
                var file_type = value.split('.');
                file_type = file_type[file_type.length-1];
                if (jQuery.inArray( file_type , fty ) !== -1) {
                    $(show_position).html(input.value.replace("C:\\fakepath\\", ''));
                } else if (value == "") {
                    $(show_position).html("เลือกไฟล์...");
                    $(input).val("");
                } else {
                    swal({
                        title: "เกิดข้อผิดพลาด!",
                        text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.xlsx .xls) เท่านั้น!",
                        type: "warning"
                    });
                    $(show_position).html("เลือกไฟล์...");
                    $(input).val("");
                    return false;
                }
            }
        </script>
    </body>

</html>