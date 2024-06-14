<?php include 'header3.php';

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$url = '../asset/peaberry.jpg';

$user_id;


?>

<body>
    <input type="" name="sig_validate" id="sig_validate" value="0">

    <div class="">
        <div class="" id="signature_box"></div>
    </div>


</body>

<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {

        $("#signature_box").load("signature.php");

    });


    var sig_validate = $("#sig_validate").val()
    if (sig_validate == 1) {
        var canvas = document.getElementById('sign-pad');
        var img_data = canvas.toDataURL(); // Convert canvas content to base64 image data
        formData.append('signature', img_data);

        // html2canvas([document.getElementById('sign-pad')], {
        //     onrendered: function(canvas) {
        //         var canvas_img_data = canvas.toDataURL('image/png');
        //         var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
        //         formData.append('signature', img_data);
        //     }
        // });
    }
</script>