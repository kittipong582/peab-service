<style type="text/css">
    /* small { font-family: Arial, Helvetica, sans-serif; font-size: 9pt; } 
            input, textarea,select { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; } 
            b { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; } 
            big { font-family: Arial, Helvetica, sans-serif; font-size: 14pt; } 
            strong { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight : extra-bold; } 
            font, td { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; } 
            BODY { font-size: 11pt; font-family: Arial, Helvetica, sans-serif; }  */
</style>

<link href="signature/css/jquery.signaturepad.css" rel="stylesheet">
<!-- <script src="signature/js/jquery_1_10_2.min.js"></script> -->
<script src="signature/js/numeric-1.2.6.min.js"></script>
<script src="signature/js/bezier.js"></script>
<script src="signature/js/jquery.signaturepad.js"></script>
<script type='text/javascript' src="signature/js/html2canvas.js"></script>
<script src="signature/js/json2.min.js"></script>


<div align="center">
    <small>กรุณาเซ็นชื่อในช่องด้านล่าง | <a id="btnClearSign" style="color: red;">ลบลายเซ็น</a></small>
    <div id="signArea" class="border">
        <div class="typed"></div>
        <canvas class="sign-pad" id="sign-pad" ontouchmove="Bruh()" ></canvas>
    </div>
    <!-- <button class="submit_bt" id="submit_bt">บันทึก</button> -->
</div>
<script>
    $(document).ready(function() {
        $('#signArea').signaturePad({
            drawOnly: true,
            drawBezierCurves: true,
            lineTop: 200
        });
    });

    $("#btnClearSign").click(function(e) {
        $('#signArea').signaturePad().clearCanvas();
        $('#sig_validate').val(0);
    });

    function Bruh() {
        $('#sig_validate').val(1);
    }

    function isCanvasBlank(canvas) {

        txt_tmp = canvas.toDataURL();

        //console.log(canvas.toDataURL());

        if ((txt_tmp.length == 1162) | (txt_tmp.length == 1178) | (txt_tmp.length == 586) | (txt_tmp.length == 594) | (txt_tmp.length == 642) | (txt_tmp.length == 654))
            return true;
        else
            return false;

    }

    // $("#submit_bt").click(function(e) {
    //     let sss = document.getElementById('sign-pad')

    //     // บันทึกลงฐานข้อมูล
    //     html2canvas([document.getElementById('sign-pad')], {
    //         onrendered: function(canvas) {
    //             var canvas_img_data = canvas.toDataURL('image/png');
    //             var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
    //             console.log(img_data);
    //             //ajax call to save image inside folder
    //             $.ajax({
    //                 url: 'ajax/signature/save_sign.php',
    //                 data: {
    //                     img_data: img_data,

    //                 },
    //                 type: 'post',
    //                 dataType: 'json',
    //                 success: function(response) {

    //                     //alert(response.id); // ใช้ response.ชื่อ Key ในการดึงข้อมูลที่ส่งกลับมา
    //                     //window.location.href = response.file_name;

    //                     alert("บันทึกข้อมูลเรียบร้อยแล้ว !!\n\nข้อความส่งกลับ : " + response.id);

    //                     window.location.reload();

    //                 }
    //             });
    //         }
    //     });
    // });
</script>