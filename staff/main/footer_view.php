 <?php

    $receipt_datetime = "";
    if ($type == 1) {
        $sql_f = "SELECT * FROM tbl_job WHERE job_id = '$job_id' AND start_service_time IS NOT NULL;";
        $result_f  = mysqli_query($connect_db, $sql_f);
        $num_row_f = mysqli_num_rows($result_f);
        $row_f = mysqli_fetch_array($result_f);
        $type = 1;

        $start_service_time = $row_f['start_service_time'];
        $finish_service_time = $row_f['finish_service_time'];
        $receipt_datetime = $row_f['receipt_datetime'];
        $new_id = $job_id;
    } else if ($type == 4) {

        $sql_f = "SELECT * FROM tbl_job a 
        LEFT JOIN tbl_job_oh b ON b.job_id = a.job_id
        WHERE a.job_id = '$job_id' AND user_id = '$user_id' AND check_in_datetime IS NOT NULL;";
        $result_f  = mysqli_query($connect_db, $sql_f);
        $num_row_f = mysqli_num_rows($result_f);
        $row_f = mysqli_fetch_array($result_f);
        $type = 4;

        $start_service_time = $row_f['check_in_datetime'];
        $finish_service_time = $row_f['check_out_datetime'];
        $new_id = $job_id;
    } else {

         $sql_f = "SELECT * FROM tbl_group_pm WHERE group_pm_id = '$job_id' AND start_service_time IS NOT NULL;";
        $result_f  = mysqli_query($connect_db, $sql_f);
        $num_row_f = mysqli_num_rows($result_f);
        $row_f = mysqli_fetch_array($result_f);
        $type = 2;

        $start_service_time = $row_f['start_service_time'];
        $finish_service_time = $row_f['finish_service_time'];


        $sql_job = "SELECT receipt_datetime,a.job_id FROM tbl_job a
        LEFT JOIN tbl_group_pm_detail b ON b.job_id = a.job_id 
        WHERE group_pm_id = '{$row_f['group_pm_id']}'";
        $result_job  = mysqli_query($connect_db, $sql_job);
        $row_job = mysqli_fetch_array($result_job);

        $receipt_datetime = $row_job['receipt_datetime'];
        $new_id = $row_job['job_id'];
    }
    // echo $sql_f;
    // echo "Test";

    $nowdate = date("Y-m-d H:i:s");

    // $start_service_time = new DateTime($row['start_service_time']);
    // $today = new DateTime($nowdate);

    // $second = $start_service_time->diff($today)->s;

    $start = new DateTime($start_service_time);
    $end = new DateTime($nowdate);
    $diff = $start->diff($end);

    $daysInSecs = $diff->format('%r%a') * 24 * 60 * 60;
    $hoursInSecs = $diff->h * 60 * 60;
    $minsInSecs = $diff->i * 60;

    $seconds = $daysInSecs + $hoursInSecs + $minsInSecs + $diff->s;

    // echo $seconds; // output: 284169600


    // $result_start = new DateTime($row['start_service_time']);
    // $result_finish = new DateTime($row['finish_service_time']);
    // $calculate_result = $result_start->diff($result_finish);



    //Create a date object out of a string (e.g. from a database):
    $result_start = new DateTime($start_service_time);
    //Create a date object out of today's date:
    $result_finish = new DateTime($finish_service_time);
    //Create a comparison of the two dates and store it in an array:
    $diff = (array) date_diff($result_start, $result_finish);



    ?>

 <?php
    if ($row_f['hold_status'] == 0 && $num_row_f != 0 && $finish_service_time == "") {
    ?>

     <input type="hidden" id="type" name="type" value="<?php echo $type ?>">
     <div class="ibox box-header set-footer">
         <div class="ibox-title text-center">

             <input type="hidden" id="seconds" name="seconds" value="<?php echo $seconds ?>">
             วันที่ <?php echo date('d/m/Y', strtotime($start_service_time)) ?>
             เวลา <?php echo date('H:i', strtotime($start_service_time)) ?> <br>
             ( <label id="day">xx </label> <label id="check_day">วัน</label>
             <label id="hour">xx</label> ชั่วโมง
             <label id="minute">xx</label> นาที
             <label id="second">xx</label> วินาที )<br>
             <button class="btn btn-success btn-md btn-block" type="button" id="check" onclick="modal_checkout('<?php echo $job_id ?>')">
                 บันทึกออกงาน </button>
             <?php if ($type != 4) { ?>
                 <button class="btn btn-warning btn-md btn-block" type="button" id="check" onclick="modal_hold('<?php echo $job_id ?>','1')">
                     หยุดงานชั่วคราว </button>
             <?php } ?>
         </div>
     </div>

 <?php
    } else if ($row_f['hold_status'] == 0 && $finish_service_time != "") {
    ?>

     <div class="ibox box-header set-footer">
         <div class="ibox-title text-center">
             <b>เวลาการทำงาน</b>
             <br class="hide-md">
             เข้างาน วันที่ <?php echo date('d/m/Y', strtotime($start_service_time)) ?>
             เวลา <?php echo date('H:i', strtotime($start_service_time)) ?>
             <br>

             ออกงาน วันที่ <?php echo date('d/m/Y', strtotime($finish_service_time)) ?>
             เวลา <?php echo date('H:i', strtotime($finish_service_time)) ?>
             <br>

             ( <label id="end_day"><?php echo $diff['d']; ?></label> <label id="check_end_day">วัน</label>
             <label id="end_hour"><?php echo $diff['h']; ?></label> ชั่วโมง
             <label id="end_minute"><?php echo $diff['i']; ?></label> นาที )
             <?php if ($receipt_datetime != "") { ?>
                 <a href="../../../print/Receipt _CRM.php?job_id=<?php echo $new_id ?>" target="_blank"><button type="button" class="btn btn-secondary btn-lg btn-block">
                         ใบเสร็จชั่วคราว</button></a>
             <?php } ?>



             <label id="day" hidden>xx </label>
             <label id="hour" hidden>xx</label>
             <label id="minute" hidden>xx</label>
             <label id="second" hidden>xx</label>
             <!-- <label id="end_second">xx</label> วินาที )<br> -->
         </div>
     </div>


 <?php
    } else if ($row_f['hold_status'] == 1) { ;?>


     <div class="ibox box-header set-footer">
         <div class="ibox-title text-center">
             <b>เวลาการทำงาน</b>
             <br class="hide-md">
             เข้างาน วันที่ <?php echo date('d/m/Y', strtotime($start_service_time)) ?>
             เวลา <?php echo date('H:i', strtotime($start_service_time)) ?>
             <br>

             หยุดงานชั่วคราว
             <br>

             ( <label id="end_day"><?php echo $diff['d']; ?></label> <label id="check_end_day">วัน</label>
             <label id="end_hour"><?php echo $diff['h']; ?></label> ชั่วโมง
             <label id="end_minute"><?php echo $diff['i']; ?></label> นาที )

             <label id="day" hidden>xx </label>
             <label id="hour" hidden>xx</label>
             <label id="minute" hidden>xx</label>
             <label id="second" hidden>xx</label>
             <button class="btn btn-warning btn-md btn-block" type="button" id="check" onclick="modal_hold('<?php echo $job_id ?>','2')">
                 ทำงานต่อ </button>
         </div>
     </div>



 <?php  }
    ?>


 <script>
     function modal_checkout(job_id) {

         var type = $('#type').val();
         $.ajax({
             type: "post",
             url: "ajax/mywork/modal_checkout.php",
             data: {
                 job_id: job_id,
                 type: type
             },
             dataType: "html",
             success: function(response) {
                 $("#modal .modal-content").html(response);
                 $("#modal").modal('show');
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
             }
         });
     }


     function modal_hold(job_id, type) {

         if (type == 1) {
             $.ajax({
                 type: "post",
                 url: "ajax/mywork/modal_hold.php",
                 data: {
                     job_id: job_id,
                     type: type
                 },
                 dataType: "html",
                 success: function(response) {
                     $("#modal .modal-content").html(response);
                     $("#modal").modal('show');
                     $('.summernote').summernote({
                         toolbar: false,
                         height: 100,
                     });

                 }
             });
         } else if (type == 2) {

             hold_status(job_id, "job");

         }



     }

     function hold_status(job_id, hold_job) {

         var type = $('#type').val();

         if (hold_job == 'on') {
             var remark = $('#remark').val();
         }

         // alert(job_id);
         $.ajax({
             type: 'POST',
             url: 'ajax/mywork/hold_job.php',
             data: {
                 job_id: job_id,
                 type: type,
                 remark: remark
             },
             dataType: 'json',
             success: function(data) {
                 if (data.result == 1) {
                     window.location.reload();
                 } else if (data.result == 2) {
                     swal({
                         title: 'ผิดพลาด!',
                         text: 'มีบางอย่างผิดพลาด กรุณาลองใหม่ !!',
                         type: 'warning'
                     });
                     return false;
                     window.location.reload();
                 }
             }
         })
     }
 </script>