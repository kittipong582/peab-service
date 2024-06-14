<meta http-equiv="pragma" content="no-cache" />
<?php include('header.php'); ?>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12" style="margin-left: 20px;">
            <h2>ตั้งค่าเขต</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">หน้าหลัก</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="zone_setting.php">เขต</a>
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
                                <label>เขต</label>
                                <div class="ibox-tools">
                                    <button class="btn btn-xs btn-success" onclick="AddExpend();"><i class="fa fa-plus"></i> เพิ่มเขต</button>
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
   
    <?php include('import_script.php'); ?>
    <script>
        $(document).ready(function () {
            LoadExpend();
        });
        function LoadExpend() { 
            $.ajax({
                type: 'POST',
                url: 'ajax/settingzone/GetTable.php',
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
            $('#showModal').load("ajax/settingzone/FormAdd.php",function(){
                $('.select2-container').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $("#myModal"),
                });
                $("#AddFormSubmit").click(function() {
                    let zone_name = $('#zone_name').val();
                    if(zone_name == ""){
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
                            url: 'ajax/settingzone/Add.php',
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

        function modal_add_zone(zone_id) {
            $('#myModal').modal('show');
            $('#showModal').load("ajax/settingzone/FormAdd.php");
        }
        // function ChangeStatus(my_id, keyname, table) {
        //     $.post("ajax/ChangeStatus.php", { table_name: table, key_name: keyname, key_value: my_id }, "json");
        // }
        ///

        function ModalEdit(zone_id) {
    $.ajax({
        type: "post",
        url: "ajax/settingzone/ModalEdit.php",
        data: {zone_id:zone_id},
        dataType: "html",
        success: function (response) {
            $("#showModal").html(response);
            $("#myModal").modal('show');
        }
    });
}

function Update() {

    const zone_name = $("#zone_name").val();

    if (zone_name == "") {
        swal("", "ไม่สามารถทำรายการได้กรุณากรอกชื่อประเภทอะไหล่", "error");
        return false;
    }
    
    swal({
        title: "",
        text: "กรุณายืนยันการทำรายการ",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00FF00",
        confirmButtonText: "ยืนยัน",
        cancelButtonColor: "#DD6B55",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false
    }, function() {

        let myForm = document.getElementById('form-edit');
        let formData = new FormData(myForm);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax/settingzone/Update.php",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {

                console.log(response);

                if (response.result == 1) {
                    swal({
                        title: "",
                        text: "ดำเนินการสำเร็จ",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    }, function() {
                        swal.close();
                        // GetTable();
                        $("#modal").modal('hide');
                    });
                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });

    });
}

function ChangeStatus(button, zone_id) {
    $.ajax({
        type: "post",
        url: "ajax/settingzone/ChangeStatus.php",
        data: {
            zone_id:zone_id
        },
        dataType: "json",
        success: function(response) {

            if (response.result == 1) {

                if (response.status == 1) {
                    $(button).addClass('btn-info').removeClass('btn-danger').html('กำลังใช้งาน');
                } else if (response.status == 0) {
                    $(button).addClass('btn-danger').removeClass('btn-info').html('ยกเลิกใช้งาน');
                }

            } else {
                swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
            }

        }
    });
}
</script>
