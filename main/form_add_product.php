<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_GET['id'];

/////////////////////////นับเครื่องชง///////////////////////////////////////
$sql_product1 = "SELECT COUNT(product_id) AS num_1 FROM tbl_product WHERE branch_id = '$branch_id' and product_type = 1";
$result_product1  = mysqli_query($connect_db, $sql_product1);
$row_product1 = mysqli_fetch_array($result_product1);

/////////////////////////นับเครื่องบด///////////////////////////////////////
$sql_product2 = "SELECT COUNT(product_id) AS num_2 FROM tbl_product WHERE branch_id = '$branch_id' and product_type = 2";
$result_product2  = mysqli_query($connect_db, $sql_product2);
$row_product2 = mysqli_fetch_array($result_product2);

/////////////////////////นับเครื่องปั่น///////////////////////////////////////
$sql_product3 = "SELECT COUNT(product_id) AS num_3 FROM tbl_product WHERE branch_id = '$branch_id' and product_type = 3";
$result_product3 = mysqli_query($connect_db, $sql_product3);
$row_product3 = mysqli_fetch_array($result_product3);
?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>

<style>
    .line-vertical {
        border-left: 1px solid rgba(0, 0, 0, .1);
        ;
        height: 90%;
        position: absolute;
        left: 50%;

    }

    .hidden-color {
        display: none;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ข้อมูลลูกค้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>ข้อมูลลูกค้า</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox-content">
        <div class="row">
            <div class="col-3">
                <a href="index.php"><button type="button" class="btn btn-w-m btn-success"><i class="fa fa-home"></i> <span class="nav-label">หน้าหลัก</span></button></a>
            </div>
            <div class="col-3">
                <a href="form_add_product.php?id=<?php echo $branch_id ?>"><button type="button" class="btn btn-outline btn-primary"><i class="fa fa-home"></i> <span class="nav-label">หน้าหลัก</span></button></a>

            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="widget style1 navy-bg">

                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-8">
                            <span>เครื่อชง</span>
                            <h2 class="font-bold"><?php echo $row_product1['num_1'] ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-8">
                            <span>เครื่อชง</span>
                            <h2 class="font-bold"><?php echo $row_product1['num_1'] ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-8">
                            <span>เครื่อชง</span>
                            <h2 class="font-bold"><?php echo $row_product1['num_1'] ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>