<?php
include('header.php');
?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>รายงานแจ้งซ่อม</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="report_repeat_repair.php">รายงานแจ้งซ่อม</a>
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
                                    <label>ตั้งแต่</label>
                                    <div class="input-group date">

                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label> ถึงวันที่</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label> &nbsp;&nbsp;&nbsp;</label><br>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" onclick="GetTable()">ค้นหา</button>
                                    </div>
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
                        <div id="showTable"></div>
                    </div>
                </div>
            </div>
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

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {
        GetTable()
    });

    $(".datepicker").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        format: 'dd/mm/yyyy',
        thaiyear: false,
        language: 'th', //Set เป็นปี พ.ศ.
        autoclose: true
    });

    $(".select2").select2({
        width: "75%"
    });

    function GetTable() {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            type: "POST",
            url: "ajax/report_repair_list/GetTable.php",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            datatype: "html",
            success: function(response) {
                $("#showTable").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true,
                    ordering: false
                });
                $('#Loading').hide();
            }
        });
    }

    function GetModalDetail(report_id) {
        $("#myModal").modal("show");
        $("#showModal").load("ajax/report_repair_list/modal_report_deatil.php", {
            report_id: report_id
        }, );
    }
</script>