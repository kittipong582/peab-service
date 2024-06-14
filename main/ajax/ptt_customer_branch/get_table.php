<?php 
     include("../../../config/main_function.php");
     $connect_db = connectDB("LM=VjfQ{6rsm&/h`");
     if ($connect_db) { 
          $search = mysqli_real_escape_string($connect_db,$_POST["search"]);
          $search_opt = mysqli_real_escape_string($connect_db,$_POST["search_opt"]);

          switch ($search_opt) {
               case '1':
                    $con_opt = " AND qc.qr_no LIKE '%$search%' ";
                    break;
               case '2':
                    $con_opt = " AND cb.branch_code LIKE '%$search%' ";
                    break;
               case '3': 
                    $con_opt = " AND (cb.branch_name LIKE '%$search%' OR cc.contact_name LIKE '%$search%') ";
                    break;
               default:
                    break;
          }

          $sql = "SELECT * FROM `tbl_customer_branch` AS cb
          LEFT JOIN `tbl_ptt_customer_branch` AS p ON cb.customer_branch_id = p.customer_branch_id
          LEFT JOIN `tbl_customer_contact` AS cc ON cb.customer_branch_id = cc.customer_branch_id
          LEFT JOIN `tbl_qr_code` AS qc ON cb.customer_branch_id = qc.branch_id
          WHERE cb.active_status = 1 $con_opt";
          $res = mysqli_query($connect_db,$sql);
          ?>
     <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
               <thead>
                    <tr>
                         <th style="width:10%;" class="text-center">สาขา</th>
                         <th style="width:10%;" class="text-center">สถานะ</th>
                         <th style="width:10%;"></th>
                    </tr>
               </thead>
               <tbody>
                    <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                         <tr>
                              <td style="width:10%;" class="text-left">
                                   <b>ชื่อลูกค้า : </b><?php echo $row["contact_name"]; ?><br>
                                   <b>เบอร์ : </b><?php echo $row["contact_phone"]; ?><br>
                                   <b>สาขา : </b><?php echo $row["branch_name"] ?>
                              </td>
                              <td style="width:10%;" class="text-center"></td>
                              <td style="width:10%;"><button class="btn btn-info btn-sm mb-2 w-100">รายละเอียด</button></td>
                         </tr>
                    <?php } ?>
               </tbody>
          </table>
     </div>
     <?php } ?>