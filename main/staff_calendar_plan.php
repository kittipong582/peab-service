<?php

include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$sql_team = "SELECT * FROM tbl_branch WHERE active_status = 1";
$result_team  = mysqli_query($connect_db, $sql_team);

$sql_create = "SELECT * FROM tbl_user WHERE admin_status = 9";
$result_create  = mysqli_query($connect_db, $sql_create);

?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายการงาน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="job_list.php">รายการงาน</a>
            </li>

        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">

                        <div class="col-lg-12">
                            <div class="row">


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ชนิดงาน</label>
                                        <select class="form-control select2" id="job_type" name="job_type" data-width="100%">
                                            <option value="x">ทั้งหมด </option>
                                            <option value="1">CM </option>
                                            <option value="2">PM </option>
                                            <option value="3">Installation </option>
                                            <option value="4">Overhaul </option>
                                            <option value="5">งานอื่นๆ </option>
                                            <option value="6">งานเสนอราคา </option>

                                        </select>
                                    </div>
                                </div>


                                <!-- <div class="col-md-2 col-sm-12">
                                    <label>สถานะ</label><br>
                                    <select class="form-control select2" id="job_status" name="job_status" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                        <option value="1">เปิดงาน </option>
                                        <option value="2">กำลังดำเนินการ </option>
                                        <option value="3">รอปิดงาน </option>
                                        <option value="4">ปิดงาน </option>
                                        <option value="5">งานยกเลิก </option>
                                    </select>

                                </div> -->


                                <div class="col-md-2 col-sm-12">
                                    <label>ทีม</label><br>
                                    <select class="form-control select2" id="team_id" name="team_id" onchange="get_user(this.value)" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                        <?php while ($row_team = mysqli_fetch_array($result_team)) { ?>
                                            <option value="<?php echo $row_team['branch_id'] ?>"><?php echo $row_team['team_number'] . " - " . $row_team['branch_name'] ?></option>
                                        <?php } ?>

                                    </select>

                                </div>


                                <div class="col-md-2 col-sm-12" id="point_user">
                                    <label>ช่าง</label><br>
                                    <select class="form-control select2" id="user_point" name="user_point" data-width="100%">
                                        <option value="x">ทั้งหมด </option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12" id="getcusbranch">
                                <div class="form-group">
                                    <label>สถานะ</label>
                                    <select class="form-control select2" id="status" name="status" data-width="100%">
                                        <option value="x" selected>ทั้งหมด </option>
                                        <option value="1">เปิดงาน</option>
                                        <option value="2">อยู่ระหว่างดำเนินการ</option>
                                        <option value="3">หยุดงานชั่วคราว</option>
                                        <option value="4">รอปิดงาน</option>
                                        <option value="5">ปิดงานแล้ว</option>
                                        <option value="6">งานค้าง</option>
                                    </select>
                                </div>
                            </div>

                                <div class="col-md-2 col-sm-12">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <input class="btn btn-sm btn-info btn-block" id="rerender" type="button" onclick="renderCalendar();" value="แสดงข้อมูล">
                                </div>
                            </div>
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
                        <br>
                        <div id="calendar_mou"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="show_modal"></div>
            </div>
        </div>
    </div>

    <?php include('import_script.php'); ?>

    <script>
        $(".select2").select2({
            width: "75%"
        });

        $(document).ready(function() {

            // $('#Loading').hide();


            renderCalendar();
        });

        document.querySelector("#rerender").addEventListener("click", function() {

            // var job_type = $('#job_type').val();
            // var user_point = $('#user_point').val();
            // var team_id = $('#team_id').val();
            // var ev2 = {
            //     "events": [{
            //         "url": "ajax/plan_calendar/event.php",
            //         "method": "POST",
            //         "data": {
            //             'job_type': job_type,
            //             'user_id': user_point,
            //             'team_id': team_id
            //         },
            //     }]
            // };

            // $('#calendar_mou').fullCalendar('removeEvents');
            // $('#calendar_mou').fullCalendar('addEventSource', ev2);
            // renderCalendar();

            // $('#calendar_mou').fullCalendar('refetchEvents');

        });

        function renderCalendar() {

            // $('#calendar_mou').fullCalendar('removeEvents');



            var job_type = $('#job_type').val();
            var user_point = $('#user_point').val();
            var team_id = $('#team_id').val();
            var status = $('#status').val();

            var data_event = {
                url: "ajax/plan_calendar/event.php",
                method: 'POST',
                data: {
                    job_type: job_type,
                    user_id: user_point,
                    team_id: team_id,
                    status: status
                }
            };

            $('#calendar_mou').fullCalendar('removeEvents');
            $('#calendar_mou').fullCalendar('addEventSource', data_event);

            $('#calendar_mou').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },

                eventColor: 'green',

                eventClick: function(event, jsEvent, view) {

                    console.log(event);
                    // $('#modalTitle').html(event.title);
                    $('#plan_name').html(event.title);
                    // $('#dStart').html(event.description);
                    // $('#people').html(event.people);
                    // $('#product_name').html(event.product_name);
                    $('#plan_no').html(event.plan_no);
                    // $('#plan_delivery_date').val(event.plan_delivery_date);
                    // $('#FullName').html(event.name);
                    // $('#DtInsert').html(event.dtinsert);
                    // $('#fullCalModal').modal();
                    window.location(event.url);
                    // swal({title:'sdfasd',text:'calendar/table_customer_booking.php?booking_date="'+event.start+'" '});
                    // location.href("view_plan.php?id=" + event.plan_id);
                },

                defaultDate: '<?php echo date("Y-m-d"); ?>',
                lang: 'th',
                buttonIcons: false, // show the prev/next text
                weekNumbers: false,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: data_event,
                // events:"Calendar/getCalendar1.json",
                loading: function(bool) {
                    if (bool) $('#Loading').show();
                    else $('#Loading').hide();

                }

            });
        }


        function get_user(team_id) {
            $.ajax({
                type: 'POST',
                url: "ajax/job_list/Get_user.php",
                data: {
                    team_id: team_id,
                },
                dataType: "html",
                success: function(response) {
                    $("#point_user").html(response);
                    $(".select2").select2({});
                }
            });

        }
    </script>