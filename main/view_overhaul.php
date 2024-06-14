<?php include('header.php');
session_start();
include("../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$overhaul_id = $_GET['id'];

$sql = "SELECT * FROM tbl_overhaul WHERE overhaul_id = '$overhaul_id'";
$result  = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);

$brand_id = $row['brand_id'];
$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connection, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$model_id = $row['model_id'];
$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connection, $sql_model);
$row_model = mysqli_fetch_array($result_model);


$branch_id = $row['current_branch_id'];
$sql_branch = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
$result_branch   = mysqli_query($connection, $sql_branch);
$row_branch  = mysqli_fetch_array($result_branch);
?>



<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ข้อมูลเครื่อง</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="overhaul_list.php">รายการ overhaul</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ข้อมูลเครื่อง</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>


<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>ข้อมูลเครื่อง</h5>
                </div>
                <div class="ibox-content">
                    <div class="row mb-3">
                        <div class="col-4 mb-3">
                            <label for="serial_no">
                                <b>serial no</b>
                            </label><br>
                            <label><?php echo $row['serial_no'] ?></label>

                        </div>

                        <div class="col-4 mb-3">
                            <label for="serial_no">
                                <b>AX no</b>
                            </label><br>
                            <label><?php echo $row['ax_no'] ?></label>

                        </div>

                        <div class="col-4 mb-3">
                            <label for="serial_no">
                                <b>ทีมดูแล</b>
                            </label><br>
                            <label><?php echo $row_branch['branch_name'] ?></label>

                        </div>


                        <input type="hidden" value="<?php echo $row['overhaul_id'];  ?>" id="overhaul_id" name="overhaul_id">
                        <div class="col-4 mb-3">
                            <label for="brand_id">
                                <b>แบรนด์</b>
                            </label><br>

                            <label><?php echo $row_brand['brand_name'] ?></label>

                        </div>
                        <div class="col-4 mb-3">
                            <label for="model_id">
                                <b>รุ่น</b>
                            </label><br>
                            <label><?php echo $row_model['model_name'] ?></label>
                        </div>

                        <div class="col-4 mb-3">

                            <label for="product_type">
                                <b>เครื่อง</b>
                            </label><br>
                            <label> <?php if ($row['product_type'] == 1) {
                                        echo "เครื่องชง";
                                    } ?>
                                <?php if ($row['product_type'] == 2) {
                                    echo "เครื่องบด";
                                } ?>
                                <?php if ($row['product_type'] == 3) {
                                    echo "เครื่องปั่น";
                                } ?></label>

                        </div>

                        <div class="col-4 mb-3" id="div_buy">

                            <label for="buy_date">
                                <b>วันที่ซื้อ</b>
                            </label><br>
                            <label><?php echo date('d-m-Y', strtotime($row['buy_date'])) ?></label>
                        </div>
                        <div class="col-4 mb-3" id="div_start">
                            <label for="warranty_start_date">
                                <b>วันที่เริ่มประกัน</b>
                            </label>
                            <br>
                            <label><?php echo date('d-m-Y', strtotime($row['warranty_start_date'])) ?></label>
                        </div>

                        <div class="col-4 mb-3" id="div_end">

                            <label for="warranty_end_date">
                                <b>วันที่หมดประกัน</b>
                            </label>
                            <br>
                            <label><?php echo date('d-m-Y', strtotime($row['warranty_end_date'])) ?></label>

                        </div>

                        <div class="col-12 mb-3">

                            <label for="note">
                                <b>หมายเหตุ</b>
                            </label><br>
                            <p><?php echo $row['note'] ?></p>
                        </div>

                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-4 mb-3">
                            <h4>รายการโอนย้าย</h4>
                        </div>
                        <div class="col-8 mb-3">
                            <button class="btn btn-sm btn-info " style="float: right;" onclick="ModalTransfer('<?php echo $overhaul_id ?>');">โอนย้าย</button>
                        </div>
                        <div class="col-12">
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
                            <div id="show_data">

                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row mb-3">
                        <div class="col-4 mb-3">
                            <h4>ประวัติ</h4>
                        </div>
                        <div class="col-12">
                            <div id="Loading_log">
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
                            <div id="show_log_data">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {
        GetTable('<?= $overhaul_id ?>');
        GetTable_log('<?= $overhaul_id ?>');
    });

    function GetTable(overhaul_id) {
        $.ajax({
            type: "post",
            url: "ajax/overhaul_transfer/GetTable.php",
            data: {
                overhaul_id: overhaul_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('#tbl_transfer').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }


    function GetTable_log(overhaul_id) {
        $.ajax({
            type: "post",
            url: "ajax/overhaul_list/GetTable_log.php",
            data: {
                overhaul_id: overhaul_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_log_data").html(response);
                $('#tbl_log').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading_log').hide();
            }
        });
    }



    function ModalTransfer(overhaul_id) {

        $.ajax({
            type: "post",
            url: "ajax/overhaul_transfer/ModalTransfer.php",
            data: {
                overhaul_id: overhaul_id
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




 
</script>