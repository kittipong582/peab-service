<meta http-equiv="pragma" content="no-cache" />
<?php include('header.php'); ?>
<style>
    .classmodal1 {
        max-width: 800px;
        margin: auto;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12" style="margin-left: 20px;">
        <h2>ตั้งค่าสาขา</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าหลัก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="branch_setting.php">ตั้งค่าสาขา</a>
            </li>

        </ol>
    </div>
</div>


<div id="wrapper">
    <!-- <div id="page-wrapper" class="gray-bg"> -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <label>รายการสาขา</label>
                        <div class="ibox-tools">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal" onclick="modalinsert();"><i class="fa fa-plus"></i> เพิ่มสาขา </button>
                        </div>
                    </div>
                    <div class="ibox-content">
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
                        <div id="show_table"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<div class="modal" id="modal">
    <div class="modal-dialog modal-dialog-centered classmodal1" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>




<?php include('import_script.php'); ?>

<script>
    function modalinsert() {

        $.ajax({
            type: 'POST',
            url: "ajax/branch/modal_insert.php",
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });

    }


    $(document).ready(function() {
        load_table();
    });

    function load_table() {
        $.ajax({
            type: 'POST',
            url: 'ajax/branch/getTable.php',
            data: {},
            dataType: 'html',
            success: function(response) {
                $('#show_table').html(response);
                $('.dataTables-example').DataTable({
                    pageLength: 25,
                    responsive: true,
                });
                $('#Loading').hide();
            }
        });
    }

    function Changestatus(branch_id)

    {

        $.ajax({

            type: 'POST',

            url: 'ajax/branch/ChangeStatus.php',

            data: {

                branch_id: branch_id

            },

            dataType: 'json',

            success: function(data) {
                if (data.result == 1) {
                    load_table();
                }
            }

        });

    }

    function submit() {

        var branch_name = $('#branch_name').val();
        var district = $('#district').val();
        var zone = $('#zone').val();



        var formData = new FormData($("#frm_color")[0]);

        if (branch_name == "" || district == "all" || zone == '') {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function() {

            $.ajax({
                type: 'POST',
                url: 'ajax/branch/insert.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        $('.modal-backdrop').remove();
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });

                        load_table();
                    }
                }
            })
        });
    }
</script>
</body>

</html>