<meta http-equiv="pragma" content="no-cache" />
<?php include('header.php'); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12" style="margin-left: 20px;">
            <h2>รุ่นและยี่ห้อ</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">หน้าหลัก</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="ิbrand&model_setting.php">รุ่นและยี่ห้อ</a>
                </li>

            </ol>
        </div>
    </div>


    <div id="wrapper">
        <!-- <div id="page-wrapper" class="gray-bg"> -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="mr-2">ข้อมูลรุ่นและยี่ห้อ</h5>
                                <div class="ibox-tools">
                                    <button class="btn btn-xs btn-success" onclick="AddExpend();"><i class="fa fa-plus"></i> เพิ่มประเภทรุ่นและยี่ห้อ</button>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm-12 m-b-xs">
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
                                        <div id="showTable" style="display:none" class="row">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
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
        $(document).ready(function () {
            LoadExpend();
        });
        function LoadExpend() { 
            $.ajax({
                type: 'POST',
                url: 'ajax/settingExpend/GetTable.php',
                dataType: 'html',
                success: function (data) {
                    $('#showTable').html(data);
                    $('#myTable').DataTable({
                        pageLength: 25,
                        responsive: true,
                        ordering: false,
                        autoWidth: false,
                    });
                    $('#Loading').hide();
                    $('#showTable').show();
                }
            });
        }
        function AddExpend() {
            $('#myModal').modal('show');
            $('#showModal').load("ajax/settingExpend/FormAdd.php",function(){
                $('.select2-container').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $("#myModal"),
                });
                $("#AddFormSubmit").click(function() {
                    let expend_type_name = $('#expend_type_name').val();
                    if(expend_type_name == ""){
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'กรุณากรอกข้อมูลให้ครบ',
                            type: "warning",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        },1500);
                        return false;
                    }
                    swal({
                        title: "ยืนยัน การเพิ่มข้อมูล ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#00CC00",
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ตรวจสอบอีกครั้ง",
                        closeOnConfirm: false
                    },function () {
                        $(".confirm").prop('disabled', true);
                        let myForm = document.getElementById('form_add');
                        let formData = new FormData(myForm);
                        $.ajax({
                            url: 'ajax/settingExpend/Add.php',
                            type: 'POST',
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            processData:false,
                            data: formData,
                            success : function (data) {
                                $(".confirm").prop('disabled', false);
                                if(data.result == 1){
                                    LoadExpend();
                                    swal({
                                        title: "แจ้งเตือน",
                                        text: "เพิ่มข้อมูลสำเร็จ",
                                        type: "success",
                                        showConfirmButton: false
                                    });
                                    setTimeout(function () {
                                        $('#myModal').modal('hide');
                                        swal.close();
                                    },2000);
                                }else if(data.result == 0){
                                    swal({
                                        title: "แจ้งเตือน",
                                        text: "เพิ่มข้อมูลไม่สำเร็จ",
                                        type: "error",
                                        showConfirmButton: true
                                    });
                                }else{
                                    swal({
                                        title: "แจ้งเตือน!",
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
        function EditExpend(expend_type_id) {
            $('#myModal').modal('show');
            $('#showModal').load("ajax/settingExpend/FormEdit.php",{ "expend_type_id":expend_type_id },function(){
                $('.select2-container').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $("#myModal"),
                });
                $("#EditFormSubmit").click(function() {
                    let expend_type_name = $('#expend_type_name').val();
                    if(expend_type_name == ""){
                        swal({
                            title: 'แจ้งเตือน',
                            text: 'กรุณากรอกข้อมูลให้ครบ',
                            type: "warning",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        },1500);
                        return false;
                    }
                    swal({
                        title: "ยืนยัน การแก้ไขข้อมูล ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#00CC00",
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ตรวจสอบอีกครั้ง",
                        closeOnConfirm: false
                    },function () {
                        let myForm = document.getElementById('form_edit');
                        let formData = new FormData(myForm);
                        $.ajax({
                            url: 'ajax/settingExpend/Edit.php',
                            type: 'POST',
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            processData:false,
                            data: formData,
                            success : function (data) {
                                if(data.result == 1){
                                    LoadExpend();
                                    swal({
                                        title: "แจ้งเตือน",
                                        text: "แก้ไขข้อมูลสำเร็จ",
                                        type: "success",
                                        showConfirmButton: false
                                    });
                                    setTimeout(function () {
                                        $('#myModal').modal('hide');
                                        swal.close();
                                    },2000);
                                }else if(data.result == 0){
                                    swal({
                                        title: "แจ้งเตือน",
                                        text: "แก้ไขข้อมูลไม่สำเร็จ",
                                        type: "error",
                                        showConfirmButton: true
                                    });
                                }else{
                                    swal({
                                        title: "แจ้งเตือน!",
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
        function ChangeStatus(my_id, keyname, table) {
            $.post("ajax/ChangeStatus.php", { table_name: table, key_name: keyname, key_value: my_id }, "json");
        }
    </script>
    </body>
</html>