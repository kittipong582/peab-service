<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$job_id = $_POST['job_id'];


?>
<style>
    .border-black {
        border: 1px solid black;
    }
</style>

<div class="wrapper wrapper-content" style="padding: 15px 0px 0px 0px;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="from-control mb-3">
                            <button type="button" onclick="Modal_Signature('<?php echo $job_id ?>');" class="btn btn-info btn-lg btn-block">
                                ลายเซ็น</button>
                        </div>

                        <!-- <div class="from-control mb-3">
                            <a href="../../../../print/Receipt _CRM.php?job_id=<?php echo $job_id ?>" target="_blank"><button type="button" class="btn btn-secondary btn-lg btn-block">
                                    ใบเสร็จชั่วคราว</button></a>
                        </div>

                        <div class="from-control mb-3">
                            <button type="button" onclick="Check_datetime('<?php echo $job_id ?>')" class="btn btn-secondary btn-lg btn-block">
                                ใบเสร็จชั่วคราว(ใหม่)</button>
                        </div> -->


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })

    $('table').DataTable({
        pageLength: 10,
        responsive: true,
        // sorting: disable
    });

    function Modal_Signature(job_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/Modal_Signature.php",
            data: {
                job_id: job_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('#signatureArea').signaturePad({
                    drawOnly: true,
                    drawBezierCurves: true,
                    lineTop: 10
                });
            }
        });
    }

    function Check_datetime(job_id) {
        swal({
            title: "Loading",
            text: "Loading...",
            showCancelButton: false,
            showConfirmButton: false
            //icon: "success"
        });
        $.ajax({
            type: 'POST',
            url: '../../../../print/save_datetime.php',
            data: {

                job_id: job_id
            },
            dataType: 'json',
            success: function(data) {

                window.open(
                    "../../print/Receipt _CRM_new.php?job_id=" + job_id,
                    '_blank' // <- This is what makes it open in a new window.
                );
                // window.location.href = "../../print/Receipt _CRM_new.php?job_id=" + job_id;
                swal.close();
            }
        })
    }
</script>