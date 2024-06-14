<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];

$sql = "SELECT a.*,b.product_type FROM tbl_job a
LEFT JOIN tbl_product b ON a.product_id = b.product_id
WHERE a.job_id = '$job_id'";
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);


?>
<style>
.select2-dropdown {
    z-index: 9999999;
}
</style>
<form action="" method="post" id="form_qc" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>ตรวจสอบเครื่องทดแทน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body" style="padding-bottom: 0;">

        <input type="hidden" id="product_type" name="product_type" value="<?php echo $row['product_type'] ?>"></input>
        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>"></input>

        <div class="row">

            <div class="col-12">
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="oh_type" name="oh_type" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;เครื่องสำรอง </label>
                      <input type="radio" class="iradio_square-green" id="oh_type" name="oh_type" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;QC เครื่องสำรอง </label>
                </div>
            </div>


        </div>

        <hr>

        <div class="row">

            <!-- 1. -->
            <div class="col-12">
                <h4><b>1.ตรวจเช็คสายไฟ สายแพร์</b></h4>
            </div>
            <div class="col-12">สายไฟไม่มีรอยหนูกัด , ฉีกขาด , ไหม้</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no1" name="choice_no1" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no1" name="choice_no1" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <!-- <div class="col-12">
                <input type="text" class="boxline" style="padding-right: 8px;" id="no1_detail" name="no1_detail"
                    placeholder="หมายเหตุ">
            </div> -->

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no1_detail" name="no1_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 2. -->
            <div class="col-12"><br>
                <h4><b>2.ตรวจเช็คการทำงานของสวิตซ์ (Selector Switch)</b></h4>
            </div>
            <div class="col-12">ทำความสะอาด , ไม่มีรอยช๊อทไหม้ , สั่งงานได้ปกติ </div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no2" name="choice_no2" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no2" name="choice_no2" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no2_detail" name="no2_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 3. -->
            <div class="col-12"><br>
                <h4><b>3.ตรวจเช็ค Function ของปุ่มกด</b></h4>
            </div>
            <div class="col-12">กดคำสั่งได้ทุกปุ่มและเข้าโปรแกรมตั้งค่าน้ำได้ปกติ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no3" name="choice_no3" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no3" name="choice_no3" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no3_detail" name="no3_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 4. -->
            <div class="col-12"><br>
                <h4><b>4.ตรวจเช็คความต้านทาน Heater ทุกขดลวด (หน่วยวัดเป็น Ω)</b></h4>
            </div>
            <div class="col-12">ความต้านทาน 3 หัวชง ไม่เกิน 33 Ω , 2 หัวชง ไม่เกิน 46 Ω ,ไม่ลงกราวด์</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no4" name="choice_no4" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no4" name="choice_no4" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no4_detail" name="no4_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 5. -->
            <div class="col-12"><br>
                <h4><b>5.ตรวจเช็คกระแสไฟ Heater ทุกขดลวด (หน่วยวัดเป็น A)</b></h4>
            </div>
            <div class="col-12">ความต้านทาน 3 หัวชง ไม่เกิน 33 Ω , 2 หัวชง ไม่เกิน 46 Ω ,ไม่ลงกราวด์</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no5" name="choice_no5" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no5" name="choice_no5" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no5_detail" name="no5_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 6. -->
            <div class="col-12"><br>
                <h4><b>6.ตรวจเช็คบอร์ดคอนโทรล</b></h4>
            </div>
            <div class="col-12">ทำความสะอาด , ไม่ชื้น , ไม่มีรอยช๊อทไหม้ , สั่งงานได้ปกติ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no6" name="choice_no6" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no6" name="choice_no6" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no6_detail" name="no6_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 7. -->
            <div class="col-12"><br>
                <h4><b>7.ตรวจเช็คการรั่วซึมตามข้อต่อต่างๆ</b></h4>
            </div>
            <div class="col-12">ไม่มีรั่วซึมตามข้อต่อและมาร์คทุกรอยต่อ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no7" name="choice_no7" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no7" name="choice_no7" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no7_detail" name="no7_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 8. -->
            <div class="col-12"><br>
                <h4><b>8.ตรวจเช็คอุณหภูมิน้ำหัวชง</b></h4>
            </div>
            <div class="col-12">อุณหภูมิน้ำหัวชง 90-95 C</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no8" name="choice_no8" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no8" name="choice_no8" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no8_detail" name="no8_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 9. -->
            <div class="col-12"><br>
                <h4><b>9.ตรวจเช็คแรงดัน Steam Boiler</b></h4>
            </div>
            <div class="col-12">แรงดันหัวชง 1.0-1.2 bar</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no9" name="choice_no9" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no9" name="choice_no9" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no9_detail" name="no9_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 10. -->
            <div class="col-12"><br>
                <h4><b>10.ตรวจเช็คการทำงานของ Anti-Vacuum Valve</b></h4>
            </div>
            <div class="col-12">ระบายอากาศออกขณะเติมน้ำเข้า boiler ได้และปิดสนิท</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no10" name="choice_no10" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no10" name="choice_no10" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no10_detail" name="no10_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 11. -->
            <div class="col-12"><br>
                <h4><b>11.ตรวจเช็คการทำงานของ One-way Valve / S.C.N.R. Valve</b></h4>
            </div>
            <div class="col-12">ท่อน้ำหลังออกจากปั้มภายในเครื่องต้องไม่ร้อน</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no11" name="choice_no11" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no11" name="choice_no11" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no11_detail" name="no11_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 12. -->
            <div class="col-12"><br>
                <h4><b>12.ตรวจเช็คสภาพและการทำงานของปั๊ม</b></h4>
            </div>
            <div class="col-12">สภาพขายางยึดและปั้มสมบูรณ์ ไม่สั่นหรือมีเสียงดัง </div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no12" name="choice_no12" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no12" name="choice_no12" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no12_detail" name="no12_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 13. -->
            <div class="col-12"><br>
                <h4><b>13.ตรวจเช็คแรงดันน้ำขาเข้า และขณะปั๊มภายในทำงาน (หน่วยวัดเป็น Bar) </b></h4>
            </div>
            <div class="col-12">แรงดันน้ำออกจากปั้ม 8-10 bar</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no13" name="choice_no13" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no13" name="choice_no13" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no13_detail" name="no13_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 14. -->
            <div class="col-12"><br>
                <h4><b>14.ตรวจเช็คการทำงานของ Level probe</b></h4>
            </div>
            <div class="col-12">สั่งตัดและต่อการเติมน้ำเข้า Boiler ได้ปกติ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no14" name="choice_no14" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no14" name="choice_no14" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no14_detail" name="no14_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 15. -->
            <div class="col-12"><br>
                <h4><b>15.ตรวจเช็คความสะอาดภายในเครื่อง </b></h4>
            </div>
            <div class="col-12">ไม่มีคราบกาแฟ คราบน้ำ ขี้หนู ขี้แมลงสาบหรือเศษขยะต่าง ๆ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no15" name="choice_no15" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no15" name="choice_no15" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no15_detail" name="no15_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 16. -->
            <div class="col-12"><br>
                <h4><b>16.ตรวจเช็ควาล์วสตีมนม </b></h4>
            </div>
            <div class="col-12">สตรีมนมได้ดีไม่เบาและไม่ฝืด</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no16" name="choice_no16" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no16" name="choice_no16" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no16_detail" name="no16_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 17. -->
            <div class="col-12"><br>
                <h4><b>17.ตรวจเช็คท่อ Steam milk </b></h4>
            </div>
            <div class="col-12">ไม่มีคราบนมติดที่ก้านหรือปลายท่อสตรีม,ไม่มีรั่วซึมบริเวณซีลจุดต่าง ๆ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no17" name="choice_no17" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no17" name="choice_no17" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no17_detail" name="no17_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 18. -->
            <div class="col-12"><br>
                <h4><b>18.ตรวจเช็คหล่อลื่นและขันแน่นจุดต่อต่างๆ </b></h4>
            </div>
            <div class="col-12">ใช้ปากกามาร์คเกอร์ขีดที่หัวน็อตและข้อต่อเกลียวต่างๆ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no18" name="choice_no18" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no18" name="choice_no18" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no18_detail" name="no18_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 19. -->
            <div class="col-12"><br>
                <h4><b>19.ตรวจเช็คความสะอาดหัวกรุ๊ปภายนอก </b></h4>
            </div>
            <div class="col-12">ไม่มีคราบกาแฟเกาะตกค้าง</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no19" name="choice_no19" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no19" name="choice_no19" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no19_detail" name="no19_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 20. -->
            <div class="col-12"><br>
                <h4><b>20.ตรวจเช็คความสะอาดภายในเครื่องและท่อน้ำทิ้ง </b></h4>
            </div>
            <div class="col-12">ไม่มีคราบกาแฟ , คราบน้ำและน้ำทิ้งไหลได้สะดวก</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no20" name="choice_no20" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no20" name="choice_no20" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no20_detail" name="no20_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 21. -->
            <div class="col-12"><br>
                <h4><b>21.ตั้งค่าปริมาณน้ำ และ Function การทำงานแต่ละปุ่ม </b></h4>
            </div>
            <div class="col-12">ระบบจำค่าการไหลของน้ำที่ตั้งไว้แต่ละหัวกรุ๊ปใกล้เคียงกัน/เท่ากัน</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no21" name="choice_no21" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no21" name="choice_no21" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no21_detail" name="no21_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 22. -->
            <div class="col-12"><br>
                <h4><b>22.ตรวจเช็คตะกรันในระบบหลังจากล้างเครื่องเสร็จ/ก่อนล้าง </b></h4>
            </div>
            <div class="col-12">ไม่มีเศษตะกรันปะปนออกมาจากน้ำหัวกรุ๊ป /หัวน้ำร้อน </div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no22" name="choice_no22" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no22" name="choice_no22" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no22_detail" name="no22_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 23. -->
            <div class="col-12"><br>
                <h4><b>23.ตรวจเช็คและทำความสะอาด Solenoid valve 3 way หัวชง </b></h4>
            </div>
            <div class="col-12">เปิด-ปิดสนิท ไม่มีเสียงดังและทำความสะอาดหลังจากเทสชงกาแฟ </div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no23" name="choice_no23" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no23" name="choice_no23" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no23_detail" name="no23_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 24. -->
            <div class="col-12"><br>
                <h4><b>24.ตรวจเช็คและทำความสะอาด Solenoid valve 2 way Water Inlet, Hot water </b></h4>
            </div>
            <div class="col-12">เปิด-ปิดสนิท ไม่มีน้ำรั่วซึมเข้าระบบ , น้ำร้อนออกปกติ </div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no24" name="choice_no24" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no24" name="choice_no24" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no24_detail" name="no24_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 25. -->
            <div class="col-12"><br>
                <h4><b>25.ตรวจเช็ค Safety valve ฐานและฝาปิด </b></h4>
            </div>
            <div class="col-12">ไม่ระบายแรงดันออก , มีฐาน , ฝาครอบ, ท่อซิลิโคนและปิดสนิท </div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no25" name="choice_no25" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no25" name="choice_no25" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no25_detail" name="no25_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 26. -->
            <div class="col-12"><br>
                <h4><b>26.ทำความสะอาด Pump filter </b></h4>
            </div>
            <div class="col-12">ปรับแรงดันได้และ Filterไม่อุดตัน ล้างทำความสะอาด</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no26" name="choice_no26" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no26" name="choice_no26" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no26_detail" name="no26_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 27. -->
            <div class="col-12"><br>
                <h4><b>27.ตรวจเช็คจุดเชื่อมต่าง ๆ </b></h4>
            </div>
            <div class="col-12">ไม่แตกร้าวหรือรั่วซึม , ทำความสะอาดรอยเชื่อม</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no27" name="choice_no27" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no27" name="choice_no27" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no27_detail" name="no27_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 28. -->
            <div class="col-12"><br>
                <h4><b>28.ตรวจเช็คการทำช๊อทกาแฟ </b></h4>
            </div>
            <div class="col-12">เทสกาแฟ 10 ครั้ง/ 1 หัวกรุ๊ป</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no28" name="choice_no28" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no28" name="choice_no28" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no28_detail" name="no28_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 29. -->
            <div class="col-12"><br>
                <h4><b>29.ตรวจเช็คเวลาเปิดเครื่องและพร้อมใช้งาน </b></h4>
            </div>
            <div class="col-12">ระบบตัด-ต้มทำงานปกติเครื่องพร้อมใช้งานไม่เกิน 30 นาที</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no29" name="choice_no29" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no29" name="choice_no29" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no29_detail" name="no29_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 30. -->
            <div class="col-12"><br>
                <h4><b>30.ตรวจเช็คสภาพโครงเครื่องและรอยสนิม </b></h4>
            </div>
            <div class="col-12">ทำสี , ปะผุหรือเปลี่ยนโครงใหม่</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no30" name="choice_no30" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no30" name="choice_no30" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no30_detail" name="no30_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 31. -->
            <div class="col-12"><br>
                <h4><b>31.ตรวจเช็คสภาพท่อน้ำดีจุดต่าง ๆ </b></h4>
            </div>
            <div class="col-12">ไม่บวม,บี้,แบน,รั่วซึม,อุดตัน</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no31" name="choice_no31" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no31" name="choice_no31" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no31_detail" name="no31_detail" placeholder="หมายเหตุ">
            </div>

            <!-- 32. -->
            <div class="col-12"><br>
                <h4><b>32.ตรวจเช็คสภาพท่อน้ำทิ้ง </b></h4>
            </div>
            <div class="col-12">ไม่บี้ , แบน , ขาด , อุดตัน</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no32" name="choice_no32" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no32" name="choice_no32" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no32_detail" name="no32_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 33. -->
            <div class="col-12"><br>
                <h4><b>33.ตรวจเช็คสภาพบอดี้จุดต่าง ๆ </b></h4>
            </div>
            <div class="col-12">ไม่แตกร้าว , ถลอก , ผุ</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no33" name="choice_no33" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no33" name="choice_no33" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no33_detail" name="no33_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 34. -->
            <div class="col-12"><br>
                <h4><b>34.ตรวจเช็คสภาพด้ามชง ๆ </b></h4>
            </div>
            <div class="col-12">ไม่สึกหรอ , นำออกจากหัวกรุ๊ปพร้อมกันได้ไม่ชนกัน</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no34" name="choice_no34" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no34" name="choice_no34" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no34_detail" name="no34_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 35. -->
            <div class="col-12"><br>
                <h4><b>35.ตรวจเช็คสภาพสายไฟ Main Power </b></h4>
            </div>
            <div class="col-12">ไม่ถลอก , ไม่มีรอยหนูกัดทองแดงโผล่</div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no35" name="choice_no35" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no35" name="choice_no35" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no35_detail" name="no35_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 36. -->
            <div class="col-12"><br>
                <h4><b>36.ตรวจเช็คสภาพไส้กรองน้ำ 3 M </b></h4>
            </div>
            <div class="col-12">ไม่ตัน ,ไม่หมดอายุ </div>
            <div class="col-12"><br>
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no36" name="choice_no36" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no36" name="choice_no36" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no36_detail" name="no36_detail" placeholder="หมายเหตุ">
            </div>


            <!-- 37. -->
            <div class="col-12"><br>
                <h4><b>37.รายการอื่นๆ</b></h4>
            </div>
            <div class="col-12">
                <div class="input-group">
                    <input type="radio" class="iradio_square-green" id="choice_no37" name="choice_no37" value="1"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ผ่าน </label>
                    <input type="radio" class="iradio_square-green" id="choice_no37" name="choice_no37" value="2"><label
                        style="font-size: 13px; padding-right: 8px;">&nbsp;ไม่ผ่าน </label>
                </div>
            </div>

            <div class="col-12 form-group">
                <input type="text" class="form-control" id="no37_detail" name="no37_detail" placeholder="หมายเหตุ">
            </div>

            <div class="col-12"><br>
                <h4><b>ข้อเสนอแนะ</b></h4>
                <textarea class="form-control summernote" rows="5" name="remark" id="remark"></textarea>
            </div>


        </div>
        <br>
    </div>


</form>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
    <button class="btn btn-success btn-sm" type="button" id="submit" onclick="Submit_qc_overhaul()">บันทึก</button>
</div>


<?php include('import_script.php'); ?>
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


function Submit_qc_overhaul() {

    var job_id = $('#job_id').val();
    var formData = new FormData($("#form_qc")[0]);

    if (overhaul == "x") {
        swal({
            title: 'เกิดข้อผิดพลาด',
            text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
            type: 'error'
        });
        return false;
    }

    swal({
        title: 'กรุณายืนยันเพื่อทำรายการ',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ยืนยัน',
        closeOnConfirm: false
    }, function() {

        $.ajax({
            type: 'POST',
            url: 'ajax/mywork/overhaul/add_qc_overhaul.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.result == 1) {
                    $('#modal').modal('hide');
                    swal({
                        title: "ดำเนินการสำเร็จ!",
                        text: "ทำการบันทึกรายการ เรียบร้อย",
                        type: "success",
                    }, function() {
                        Getdata();
                    });
                }
                if (data.result == 0) {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        text: "บันทึกผิดพลาด",
                        type: "error",
                    });
                }
            }

        })
    });
}
</script>