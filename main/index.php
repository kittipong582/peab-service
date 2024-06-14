<?php
session_start();
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">
        <h2>Dashboard</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>

            <li class="breadcrumb-item active">
                <strong>Dashboard</strong>
            </li>
        </ol>
    </div>
    <!-- <div class="col-lg-2"></div> -->
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-3 ">
                            <div class="form-group">
                                <label>ปี</label>
                                <select class="form-control select2" name="select_year" id="select_year" onchange="load_graph()">
                                    <?php
                                    for ($y = date("Y") - 3; $y <= date("Y"); $y++) { ?>
                                        <option value="<?php echo $y ?>" <?php if ($y == date("Y")) {
                                                                                echo "SELECTED";
                                                                            } ?>><?php echo  $y; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="ibox-tools">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <div class="ibox-content">

                            <div id="chart-container">
                                <canvas id="barChart"></canvas>
                            </div>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="ibox-content">
                            <div id="chart-container2">
                                <canvas id="barChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-3">
                        <div class="ibox-content">
                            <div id="container-chart_cm">
                                <label for="">CM</label>
                                <canvas id="chart_cm"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="ibox-content">
                            <div id="container-chart_pm">
                                <label for="">PM</label>
                                <canvas id="chart_pm"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="ibox-content">
                            <div id="container-chart_oh">
                                <label for="">OH</label>
                                <canvas id="chart_oh"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="ibox-content">
                            <div id="container-chart_in">
                                <label for="">IN</label>
                                <canvas id="chart_in"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row" id="dashbord_month">

    </div>
    <div class="row">

        <div class="col-6">
            <div class="ibox-content">
                <div id="container-chart_in2">
                    <label for="">IN</label>
                    <canvas id="chart_in2"></canvas>
                </div>
            </div>
            <div class="ibox-content mt-3">
                <div id="chart-container_month">
                    <canvas id="barChart_month"></canvas>
                </div>
            </div>
            <div class="ibox-content mt-3">
                <div id="chart-container_mttr">
                    <canvas id="barChart_mttr"></canvas>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="ibox-content">
                <div id="container_table_work">

                </div>
            </div>
        </div>

    </div>
</div>

<!-- <script src="../template/js/plugins/chartJs/Chart.min.js"></script> -->


<script>
    $(document).ready(function() {
        $(".select2").select2({
            width: "100%"
        })
        load_graph();
    });


    function load_graph() {

        var year = $('#select_year').val(); ///////////////ดึงปี//////////


        $.post('ajax/dashboard/get_Graph1.php', {
                year: year,

            },
            function(array_data) {
                var data_result = JSON.parse(array_data);
                // console.log(data_result);
                var daily_label = [];
                for (var i = 0; i < data_result[0].length; i++) {
                    var data = data_result[0][i]['month'];
                    daily_label.push(data);
                }
                var top_job = [];
                for (var i = 0; i < data_result[0].length; i++) {
                    var data = data_result[0][i]['total_job'];
                    top_job.push(data);
                }
                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "งานทั้งหมดในปี " + year,
                        backgroundColor: 'rgba(26,179,148,0.5)',
                        borderColor: "rgba(26,179,148,0.5)",
                        pointBackgroundColor: "rgba(26,179,148,0.5)",
                        pointBorderColor: "#fff",
                        data: top_job
                    }],
                };
                var barOptions = {
                    responsive: true,
                };
                $('#barChart').remove();
                $('#chart-container').append('<canvas id="barChart"><canvas>');
                var ctx2 = document.getElementById("barChart").getContext("2d");
                new Chart(ctx2, {
                    type: 'bar',
                    data: barData,
                    options: barOptions,
                });
            });



        $.post('ajax/dashboard/get_Graph2.php', {
                year: year,

            },
            function(array_data1) {
                var data_result = JSON.parse(array_data1);


                var daily_label = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['job_type'];
                    daily_label.push(data);
                }

                var top_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    top_job.push(data);
                }

                var color = ["rgba(255, 99, 71, 1)", "rgba(135, 209, 71, 1)", "rgba(135, 209, 198, 1)", "rgba(135, 109, 198, 1)", "rgba(255, 239, 50, 1)"];


                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "ประเภทงานทั้งหมดในปี " + year,
                        backgroundColor: color,
                        borderColor: color,
                        pointBackgroundColor: color,
                        pointBorderColor: "#fff",
                        data: top_job,

                    }],
                };
                var barOptions = {
                    responsive: true,

                };
                $('#barChart2').remove();
                $('#chart-container2').append('<canvas id="barChart2"><canvas>');
                var ctx2 = document.getElementById("barChart2").getContext("2d");
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: barData,
                    options: barOptions

                });
            });


        $.post('ajax/dashboard/get_GraphCM.php', {
                year: year,

            },
            function(array_data1) {
                var data_result = JSON.parse(array_data1);


                var daily_label = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['job_type'];
                    daily_label.push(data);
                }

                var top_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    top_job.push(data);
                }

                var color = ["rgba(255, 99, 71, 1)", "rgba(135, 209, 71, 1)", "rgba(135, 209, 198, 1)", "rgba(135, 109, 198, 1)", "rgba(255, 239, 50, 1)"];


                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "ประเภทงานทั้งหมดในปี " + year,
                        backgroundColor: color,
                        borderColor: color,
                        pointBackgroundColor: color,
                        pointBorderColor: "#fff",
                        data: top_job,

                    }],
                };
                var barOptions = {
                    responsive: true,

                };
                $('#chart_cm').remove();
                $('#container-chart_cm').append('<canvas id="chart_cm"><canvas>');
                var ctx2 = document.getElementById("chart_cm").getContext("2d");
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: barData,
                    options: barOptions

                });
            });

        $.post('ajax/dashboard/get_GraphPM.php', {
                year: year,

            },
            function(array_data1) {
                var data_result = JSON.parse(array_data1);


                var daily_label = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['job_type'];
                    daily_label.push(data);
                }

                var top_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    top_job.push(data);
                }

                var color = ["rgba(255, 99, 71, 1)", "rgba(135, 209, 71, 1)", "rgba(135, 209, 198, 1)", "rgba(135, 109, 198, 1)", "rgba(255, 239, 50, 1)"];


                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "ประเภทงานทั้งหมดในปี " + year,
                        backgroundColor: color,
                        borderColor: color,
                        pointBackgroundColor: color,
                        pointBorderColor: "#fff",
                        data: top_job,

                    }],
                };
                var barOptions = {
                    responsive: true,

                };
                $('#chart_pm').remove();
                $('#container-chart_pm').append('<canvas id="chart_pm"><canvas>');
                var ctx2 = document.getElementById("chart_pm").getContext("2d");
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: barData,
                    options: barOptions

                });
            });

        $.post('ajax/dashboard/get_GraphOH.php', {
                year: year,

            },
            function(array_data1) {
                var data_result = JSON.parse(array_data1);


                var daily_label = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['job_type'];
                    daily_label.push(data);
                }

                var top_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    top_job.push(data);
                }

                var color = ["rgba(255, 99, 71, 1)", "rgba(135, 209, 71, 1)", "rgba(135, 209, 198, 1)", "rgba(135, 109, 198, 1)", "rgba(255, 239, 50, 1)"];


                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "ประเภทงานทั้งหมดในปี " + year,
                        backgroundColor: color,
                        borderColor: color,
                        pointBackgroundColor: color,
                        pointBorderColor: "#fff",
                        data: top_job,

                    }],
                };
                var barOptions = {
                    responsive: true,

                };
                $('#chart_oh').remove();
                $('#container-chart_oh').append('<canvas id="chart_oh"><canvas>');
                var ctx2 = document.getElementById("chart_oh").getContext("2d");
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: barData,
                    options: barOptions

                });
            });

        $.post('ajax/dashboard/get_GraphIN.php', {
                year: year,

            },
            function(array_data1) {
                var data_result = JSON.parse(array_data1);


                var daily_label = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['job_type'];
                    daily_label.push(data);
                }

                var top_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    top_job.push(data);
                }

                var color = ["rgba(255, 99, 71, 1)", "rgba(135, 209, 71, 1)", "rgba(135, 209, 198, 1)", "rgba(135, 109, 198, 1)", "rgba(255, 239, 50, 1)"];


                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "ประเภทงานทั้งหมดในปี " + year,
                        backgroundColor: color,
                        borderColor: color,
                        pointBackgroundColor: color,
                        pointBorderColor: "#fff",
                        data: top_job,

                    }],
                };
                var barOptions = {
                    responsive: true,

                };
                $('#chart_in').remove();
                $('#container-chart_in').append('<canvas id="chart_in"><canvas>');
                var ctx2 = document.getElementById("chart_in").getContext("2d");
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: barData,
                    options: barOptions

                });
            });

        $.ajax({
            type: "POST",
            url: "ajax/dashboard/dash_month/get_dashbord_month.php",
            data: {
                year: year
            },
            dataType: "html",
            success: function(response) {
                $("#dashbord_month").html(response);
                $(".select2").select2({
                    width: "100%"
                })
                load_graph_month()
            }
        });
    }

    function load_graph_month() {
        var year = $('#select_year').val();
        let month = $('#select_month').val();
        var type = $('#job_type').val();
        GetBacklogTable()

        $.post('ajax/dashboard/dash_month/get_donutchart_month.php', {
                year: year,
                month: month,
                type: type

            },
            function(array_data1) {
                var data_result = JSON.parse(array_data1);


                var daily_label = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['job_type'];
                    daily_label.push(data);
                }

                var top_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    top_job.push(data);
                }

                var color = ["rgba(255, 99, 71, 1)", "rgba(135, 209, 71, 1)", "rgba(135, 209, 198, 1)", "rgba(135, 109, 198, 1)", "rgba(255, 239, 50, 1)"];


                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "ประเภทงานทั้งหมดในปี " + year,
                        backgroundColor: color,
                        borderColor: color,
                        pointBackgroundColor: color,
                        pointBorderColor: "#fff",
                        data: top_job,

                    }],
                };
                var barOptions = {
                    responsive: true,

                };
                $('#chart_in2').remove();
                $('#container-chart_in2').append('<canvas id="chart_in2"><canvas>');
                var ctx2 = document.getElementById("chart_in2").getContext("2d");
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: barData,
                    options: barOptions

                });
            });

        $.post('ajax/dashboard/dash_month/get_barchart_month.php', {
                year: year,
                month: month,
                type: type
            },
            function(array_data) {
                var data_result = JSON.parse(array_data);
                var daily_label = [];
                for (var i = 0; i < data_result[0].length; i++) {
                    var data = data_result[0][i]['month'];
                    daily_label.push(data);
                }
                var top_job = [];
                for (var i = 0; i < data_result[0].length; i++) {
                    var data = data_result[0][i]['total_job'];
                    top_job.push(data);
                }

                var top_job2 = [];
                for (var i = 0; i < data_result[1].length; i++) {
                    var data = data_result[1][i]['total_job'];
                    top_job2.push(data);
                }

                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "งานทั้งหมดในปี " + year,
                        backgroundColor: 'rgba(26,179,148,0.5)',
                        borderColor: "rgba(26,179,148,0.5)",
                        pointBackgroundColor: "rgba(26,179,148,0.5)",
                        pointBorderColor: "#fff",
                        data: top_job
                    }, {
                        label: "งานทั้งหมดในปี " + (year - 1),
                        backgroundColor: 'rgba(220, 220, 220, 0.5)',
                        pointBorderColor: "#fff",
                        data: top_job2
                    }]

                };
                var barOptions = {
                    responsive: true,
                };
                $('#barChart_month').remove();
                $('#chart-container_month').append('<canvas id="barChart_month"><canvas>');
                var ctx2 = document.getElementById("barChart_month").getContext("2d");
                new Chart(ctx2, {
                    type: 'bar',
                    data: barData,
                    options: barOptions,
                });
            });

        $.post('ajax/dashboard/dash_month/get_barchart_mttr.php', {
                year: year,
                month: month,
                type: type

            },
            function(array_data) {
                var data_result = JSON.parse(array_data);
                var daily_label = [];
                for (var i = 0; i < data_result[0].length; i++) {
                    var data = data_result[0][i]['month'];
                    daily_label.push(data);
                }
                var top_job = [];
                for (var i = 0; i < data_result[0].length; i++) {
                    var data = data_result[0][i]['total_job'];
                    top_job.push(data);
                }

                var barData = {
                    labels: daily_label,
                    datasets: [{
                        label: "MTTR ในปี " + year,
                        backgroundColor: 'rgba(26,179,148,0.5)',
                        borderColor: "rgba(26,179,148,0.5)",
                        pointBackgroundColor: "rgba(26,179,148,0.5)",
                        pointBorderColor: "#fff",
                        data: top_job
                    }]

                };
                var barOptions = {
                    responsive: true,
                };
                $('#barChart_mttr').remove();
                $('#chart-container_mttr').append('<canvas id="barChart_mttr"><canvas>');
                var ctx2 = document.getElementById("barChart_mttr").getContext("2d");
                new Chart(ctx2, {
                    type: 'bar',
                    data: barData,
                    options: barOptions,
                });
            });

    }

    function GetBacklogTable() {
        var year = $('#select_year').val();
        let month = $('#select_month').val();
        let type = $("#job_type").val();
        $.ajax({
            type: "POST",
            url: "ajax/dashboard/dash_month/get_table.php",
            data: {
                year: year,
                month: month,
                type: type
            },
            dataType: "html",
            success: function(response) {
                $("#container_table_work").html(response);
            }
        });

    }
</script>

</body>

</html>