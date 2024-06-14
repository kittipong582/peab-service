<?php include 'header2.php'; ?>

<?php
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql_team = "SELECT * FROM tbl_branch WHERE active_status = 1";
$result_team  = mysqli_query($connect_db, $sql_team);

$sql_create = "SELECT * FROM tbl_user WHERE admin_status = 9";
$result_create  = mysqli_query($connect_db, $sql_create);

?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <center>
            <h2>ปฏิทินงาน</h2>
        </center>
    </div>
</div>

<div class="p-1">
    <div class="row">


        <div class="col-md-12 mt-2">
            <label>ชนิดงาน</label>
            <select class="form-control select2" id="job_type" name="job_type" data-width="100%" onchange="renderCalendar();">
                <option value="x">ทั้งหมด </option>
                <option value="1">CM </option>
                <option value="2">PM </option>
                <option value="3">Installation </option>
                <option value="4">Overhaul </option>
                <option value="5">งานอื่นๆ </option>
                <option value="6">งานเสนอราคา </option>
            </select>
        </div>

        <div class="col-md-2 col-sm-12">
            <label> &nbsp;&nbsp;&nbsp;</label><br>
            <input class="btn btn-sm btn-info btn-block" id="rerender" type="button" onclick="renderCalendar();" value="แสดงข้อมูล">
        </div>
    </div>
    <!-- <div id="Loading">
        <div class="spiner-example">
            <div class="sk-spinner sk-spinner-wave">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
        </div>
    </div> -->
    <br>
    <div id="calendar_mou"></div>

</div>


<?php include 'footer.php'; ?>

<script>
    $(".select2").select2({
        width: "75%"
    });

    $(document).ready(function() {

        // $('#Loading').hide();

        renderCalendar();
    });

    document.querySelector("#rerender").addEventListener("click", function() {

    });

    function renderCalendar() {

        // $('#calendar_mou').fullCalendar('removeEvents');

        var job_type = $('#job_type').val();


        var data_event = {
            url: "ajax/mywork/plan_calendar/event.php",
            method: 'POST',
            data: {
                job_type: job_type
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
</script>