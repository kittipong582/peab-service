<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = mysqli_real_escape_string($connect_db, $_POST['customer_branch_id']);

$sql = "SELECT 
cb.customer_branch_id 
,cb.branch_name
,pd.product_id
,pt.type_code
,pt.type_name
,pd.serial_no 
,pb.brand_name
,pdm.model_name
,pd.warranty_type
,pd.install_date
,pd.warranty_start_date
,pd.warranty_expire_date
FROM tbl_customer_branch cb
JOIN tbl_product pd ON pd.current_branch_id = cb.customer_branch_id  
JOIN tbl_product_brand pb ON pb.brand_id = pd.brand_id
JOIN tbl_product_model pdm ON pdm.model_id = pd.model_id 
JOIN tbl_product_type pt ON pt.type_id = pd.product_type
WHERE cb.customer_branch_id  = '$customer_branch_id' AND pd.active_status = '1'";
$res = mysqli_query($connect_db, $sql) or die($connect_db->error);
$num_row = mysqli_num_rows($res);

$list = array();
while ($row = mysqli_fetch_assoc($res)) {
    if ($row['warranty_type'] == 1) {
        $warranty_text = 'ซื้อจากบริษัท';
    } else  if ($row['warranty_type'] == 2) {
        $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
    } else if ($row['warranty_type'] == 3) {
        $warranty_text = 'สัญญาบริการ';
    }

    $temp_list = [
        "product_id" => $row['product_id'],
        "serial_no" => $row['serial_no'],
        "prduct_type" => $row['type_code'] . ' - ' . $row['type_name'],
        "brand_name" => $row['brand_name'],
        "model_name" => $row['model_name'],
        "warranty_text" => $warranty_text,
        "install_date" => date("d/m/Y", strtotime($row['install_date'])),
        "warranty_start_date" => date("d/m/Y", strtotime($row['warranty_start_date'])),
        "warranty_expire_date" => date("d/m/Y", strtotime($row['warranty_expire_date'])),
    ];

    array_push($list, $temp_list);
}

$group_pm_id = getRandomID(10, 'tbl_group_pm', 'group_pm_id');
?>

<a class="nav-link tab_head_add" href="" data-toggle="tab">
    <button type="button" class="btn btn-primary btn-xs" onclick="GetModalAddMC()">เพิ่มเครื่อง</button>
</a>

<ul class="nav nav-tabs" id="mc_nav">
    <input type="hidden" id="group_pm_id" name="group_pm_id" value="<?php echo $group_pm_id ?>">
    <input type="hidden" id="num_tab" name="num_tab" value="<?php echo $num_row; ?>">
    <?php
    $no = 0;
    for ($i = 1; $i <= $num_row; $i++) { ?>
        <li id="li_<?php echo $i ?>">
            <a class="nav-link tab_head_<?php echo $i ?> <?php echo ($i == 1) ?  "active" : "" ?>" id="tab_head_<?php echo $i ?>" href="#tab-<?php echo $i ?>" data-toggle="tab">
                <?php echo $list[$no]['model_name']; ?>
                <button type="button" class="btn btn-danger btn-xs" onclick="RemoveMCTab('<?php echo $i ?>')">X</button>
            </a>
        </li>
    <?php
        if ($i > 100) {
            exit;
        }
        $no++;
    } ?>

</ul>

<div class="tab-content" id="tab_content">
    <?php
    $no = 1;
    foreach ($list as $row) {
    ?>
        <div role="tabpanel" id="tab-<?php echo $no ?>" class="tab-pane <?php echo ($no == 1) ?  "active" : "" ?>">
            <div class="row mt-3 mb-3">
                <input type="hidden" id="choose_product_id" name="choose_product_id[]" value="<?php echo $row['product_id']; ?>">

                <div class="mb-3 col-3">
                    <label>Serial No</label>
                    <input type="text" readonly id="serial_no" value="<?php echo $row['serial_no']; ?>" name="serial_no[]" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label>ประเภทเครื่อง</label>
                    <input type="text" readonly id="product_type" value="<?php echo $row['prduct_type']; ?>" name="product_type[]" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label>ยี่ห้อ</label>
                    <input type="text" readonly id="brand" value="<?php echo $row['brand_name']; ?>" name="brand[]" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label>รุ่น</label>
                    <input type="text" readonly id="model" value="<?php echo $row['model_name']; ?>" name="model[]" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label>ประเภทการรับประกัน</label>
                    <input type="text" readonly id="warranty_type" value="<?php echo $row['warranty_text']; ?>" name="warranty_type[]" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label>วันที่ติดตั้ง</label>
                    <input type="text" readonly id="install_date" value="<?php echo $row['install_date']; ?>" name="install_date[]" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label>วันที่เริ่มประกัน</label>
                    <input type="text" readonly id="warranty_start_date" value="<?php echo $row['warranty_start_date']; ?>" name="warranty_start_date[]" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label>วันที่หมดประกัน</label>
                    <input type="text" readonly id="warranty_expire_date" value="<?php echo $row['warranty_expire_date']; ?>" name="warranty_expire_date[]" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="mb-3 col-12">
                    <strong>
                        <h4>4.ค่าบริการ</h4>
                    </strong>
                </div>

                <div class="mb-3 col-12">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:5%;"></th>
                                <th style="width:20%;">รายการ</th>
                                <th style="width:10%;">จำนวน</th>
                                <th style="width:10%;">หน่วย</th>
                                <th style="width:10%;">ราคาต่อหน่วย</th>
                                <th style="width:10%;">ราคารวม (โดยประมาณ)</th>
                            </tr>
                        </thead>
                        <tbody id="Addform_<?php echo $no ?>" name="Addform">
                            <div id="counter_<?php echo $no ?>" hidden>0</div>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row_tab('<?php echo $no ?>');"><i class="fa fa-plus"></i>
                        เพิ่มรายการ
                    </button>
                </div>
            </div>
        </div>
    <?php
        $no += 1;
    } ?>

</div>