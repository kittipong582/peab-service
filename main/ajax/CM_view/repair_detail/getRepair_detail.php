<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

$sql_img = "SELECT * FROM tbl_job_process_image WHERE job_id = '$job_id'";
$rs_img = mysqli_query($connect_db, $sql_img) or die($connect_db->error);


?>
<form action="" method="post" id="form-add_repair_detail" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label><strong>รายละเอียดการซ่อม</strong></label>
        </div>
        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
        <div class="col-md-4 mb-3">
        </div>
        <div class="col-md-4 mb-3 text-right">
            <div class="form-group" id="btn_edit">
                <button type="button" class="btn btn-warning btn-sm" onclick="change_detail()">แก้ไขรายระเอียด</button>
                <input type="hidden" id="btn_val" name="btn_val" value="0">
            </div>

            <div class="form-group" id="form_btn" style="display: none;">
                <button type="button" class="btn btn-primary btn-sm" onclick="save_detail('<?php echo $job_id ?>')">บันทึกแก้ไข</button>

                <button type="button" class="btn btn-danger btn-sm" onclick="change_detail()">ยกเลิกแก้ไข</button>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">

            <div class="form-group" id="form_detail">
                <p><?php echo $row['repair_detail']; ?></p>
            </div>


            <div class="form-group" id="form_summernote" style="display: none;">
                <textarea class="summernote" id="repair_detail" name="repair_detail"><?php echo $row['repair_detail']; ?></textarea>
            </div>



        </div>

        <div class="col-md-12 mb-3">

            <label><strong>ภาพการซ่อม</strong></label>
        </div>

        <div class="col-md-12 mb-3">

            <button type="button" class="btn btn-success btn-sm" onclick="form_upload('<?php echo $job_id ?>')">อัพโหลด</button>
            <input type="hidden" id="btn_up" name="btn_up" value="0">
        </div>

        <div class="col-md-12 mb-3" id="form_upload" style="display: none;">

            <!-- <form id='dropzoneForm' name='file' action='UploadImage.php' class='dropzone'>
                <input type="hidden" name="job_id" id="job_id" value="<?php echo $job_id; ?>">
                <div class='fallback'>
                    <input name='file_image' type='file' multiple accept="image/*" />
                </div>
            </form> -->
            <div class="BroweForFile">
                <input type="file" id="upload" name="image[]" multiple onchange="Upload(this,value);">
            </div>

        </div>

        <?php $i = 0;
        while ($row_img = mysqli_fetch_assoc($rs_img)) {

            $i++;

            if ($row_img['description'] == null || "") {
                $des = "";
            } else {
                $des = $row_img['description'];
            }
        ?>


            <div class="col-md-3 mb-3">

                <div class="spiner-example spinning" id="loading_spinner">
                    <div class="sk-spinner sk-spinner-fading-circle">
                        <div class="sk-circle1 sk-circle"></div>
                        <div class="sk-circle2 sk-circle"></div>
                        <div class="sk-circle3 sk-circle"></div>
                        <div class="sk-circle4 sk-circle"></div>
                        <div class="sk-circle5 sk-circle"></div>
                        <div class="sk-circle6 sk-circle"></div>
                        <div class="sk-circle7 sk-circle"></div>
                        <div class="sk-circle8 sk-circle"></div>
                        <div class="sk-circle9 sk-circle"></div>
                        <div class="sk-circle10 sk-circle"></div>
                        <div class="sk-circle11 sk-circle"></div>
                        <div class="sk-circle12 sk-circle"></div>
                    </div>
                </div>

                <div class="form-group text-center img_show" id="img_show">
                    <a target="_blank" href="upload/repair_image/<?php echo $row_img['image_path']; ?>" data-lity>
                        <img class="mb-3" loading="lazy" src="upload/<?php echo ($row_img['image_path'] == "") ? "No-Image.png" : "repair_image/" . $row_img['image_path']; ?>" width="150px" height="150px" />
                    </a><br>

                    <label class=""><?php echo $des ?></label>

                    <div class="form-group ">
                        <button type="button" class="btn btn-warning btn-sm" onclick="Modal_des('<?php echo $row_img['image_id'] ?>')">แก้ไข</button>

                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_img('<?php echo $row_img['image_id'] ?>')">ลบ</button>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
</form>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {

        $(".select2").select2({});

        $('.summernote').summernote({
            toolbar: false,
            height: 250,
        });



    });

    function form_upload() {

        var btn_up = $('#btn_up').val();

        if (btn_up == 0) {

            $('#form_upload').show();

            $('#btn_up').val('1');
        } else {


            $('#form_upload').hide();

            $('#btn_up').val('0');
        }

    }

    function Upload() {
        var formData = new FormData($("#form-add_repair_detail")[0]);

        $('.img_show').hide();
        $('.spinning').show();
        $.ajax({
            type: 'POST',
            url: 'ajax/CM_view/repair_detail/UploadImage.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.result == 1) {
                    // swal({
                    //     title: "ดำเนินการสำเร็จ!",
                    //     text: "ทำการบันทึกรายการ เรียบร้อย",
                    //     type: "success",
                    //     showConfirmButton: true
                    // });

                    $(".tab_head").removeClass("active");
                    $(".tab_head h4").removeClass("font-weight-bold");
                    $(".tab_head h4").addClass("text-muted");
                    $(".tab-pane").removeClass("show");
                    $(".tab-pane").removeClass("active");
                    $("#tab_head_3").children("h4").removeClass("text-muted");
                    $("#tab_head_3").children("h4").addClass("font-weight-bold");
                    $("#tab_head_3").addClass("active");
                    current_fs = $(".active");
                    // next_fs = $(this).attr('id');
                    // next_fs = "#" + next_fs + "1";
                    $('#tab-3').addClass("active");
                    current_fs.animate({}, {
                        step: function() {
                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({
                                'display': 'block'
                            });
                        }
                    });
                    load_repair_detail();
                    $('.img_show').show();
                    $('.spinning').hide();

                } else {
                    swal({
                        title: 'ผิดพลาด!',
                        text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                        type: 'warning'
                    });
                    return false;
                }

            }
        })
    }



    function change_detail() {

        var btn_val = $('#btn_val').val();

        if (btn_val == 0) {
            $('#form_btn').show();
            $('#form_summernote').show();

            $('#btn_edit').hide();
            $('#form_detail').hide();

            $('#btn_val').val('1');
        } else {
            $('#form_btn').hide();
            $('#form_summernote').hide();

            $('#btn_edit').show();
            $('#form_detail').show();

            $('#btn_val').val('0');

        }

    }

    function save_detail() {

        var formData = new FormData($("#form-add_repair_detail")[0]);


        $.ajax({
            type: 'POST',
            url: 'ajax/CM_view/repair_detail/Add_repair_detail.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.result == 1) {
                    swal({
                        title: "ดำเนินการสำเร็จ!",
                        text: "ทำการบันทึกรายการ เรียบร้อย",
                        type: "success",
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        swal.close();
                    }, 500);
                    $("#modal").modal('hide');
                    $(".tab_head").removeClass("active");
                    $(".tab_head h4").removeClass("font-weight-bold");
                    $(".tab_head h4").addClass("text-muted");
                    $(".tab-pane").removeClass("show");
                    $(".tab-pane").removeClass("active");
                    $("#tab_head_3").children("h4").removeClass("text-muted");
                    $("#tab_head_3").children("h4").addClass("font-weight-bold");
                    $("#tab_head_3").addClass("active");

                    current_fs = $(".active");

                    // next_fs = $(this).attr('id');
                    // next_fs = "#" + next_fs + "1";
                    $('#tab-3').addClass("active");

                    current_fs.animate({}, {
                        step: function() {
                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({
                                'display': 'block'
                            });
                        }
                    });
                    load_repair_detail();


                } else {
                    swal({
                        title: 'ผิดพลาด!',
                        text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                        type: 'warning'
                    });
                    return false;
                }

            }
        })
    }



    function Modal_des(image_id) {
        $.ajax({
            type: "post",
            url: "ajax/CM_view/repair_detail/Modal_des.php",
            data: {
                image_id: image_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
            }
        });
    }



    function Submit_des() {

        var formData = new FormData($("#form-des_img")[0]);


        $.ajax({
            type: 'POST',
            url: 'ajax/CM_view/repair_detail/Add_des.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.result == 1) {
                    swal({
                        title: "ดำเนินการสำเร็จ!",
                        text: "ทำการบันทึกรายการ เรียบร้อย",
                        type: "success",
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        swal.close();
                    }, 500);
                    $("#modal").modal('hide');
                    $(".tab_head").removeClass("active");
                    $(".tab_head h4").removeClass("font-weight-bold");
                    $(".tab_head h4").addClass("text-muted");
                    $(".tab-pane").removeClass("show");
                    $(".tab-pane").removeClass("active");
                    $("#tab_head_3").children("h4").removeClass("text-muted");
                    $("#tab_head_3").children("h4").addClass("font-weight-bold");
                    $("#tab_head_3").addClass("active");

                    current_fs = $(".active");

                    // next_fs = $(this).attr('id');
                    // next_fs = "#" + next_fs + "1";
                    $('#tab-3').addClass("active");

                    current_fs.animate({}, {
                        step: function() {
                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            next_fs.css({
                                'display': 'block'
                            });
                        }
                    });
                    load_repair_detail();


                } else {
                    swal({
                        title: 'ผิดพลาด!',
                        text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                        type: 'warning'
                    });
                    return false;
                }

            }
        })

    }




    function delete_img(image_id)

    {

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

                url: 'ajax/CM_view/repair_detail/delete_image.php',

                data: {

                    image_id: image_id

                },

                dataType: 'json',

                success: function(data) {


                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                        }, 500);
                        load_repair_detail();

                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: '',
                            type: 'warning'
                        });
                        return false;
                    }
                }

            });
        });

    }
</script>