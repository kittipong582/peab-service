
<head>
    <title>Peaberry</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../template/css/plugins/sweetalert/sweetalert.css">

    <link rel="stylesheet" href="logintemplate/fonts/icomoon/style.css">

    <link rel="stylesheet" href="logintemplate/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="logintemplate/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="logintemplate/css/style.css">

</head>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    background: #051563;
    /* background: linear-gradient(to right, #b92b27, #1565c0) */
}

.card {
    margin-bottom: 20px;
    border: none
}

.box {
    width: 500px;
    padding: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    background: #191919;
    ;
    text-align: center;
    transition: 0.25s;
    margin-top: 150px;
    margin-left: 19px
}

.box input[type="text"],
.box input[type="password"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #3498db;
    padding: 10px 10px;
    width: 250px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s
}

.box h1 {
    color: white;
    text-transform: uppercase;
    font-weight: 500
}

.box input[type="text"]:focus,
.box input[type="password"]:focus {
    width: 300px;
    border-color: #2ecc71
}

.box input[type="button"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #2ecc71;
    padding: 14px 40px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer
}

.box input[type="button"]:hover {
    background: #2ecc71
}

.forgot {
    text-decoration: underline
}

ul.social-network {
    list-style: none;
    display: inline;
    margin-left: 0 !important;
    padding: 0
}

ul.social-network li {
    display: inline;
    margin: 0 5px
}

.social-network a.icoFacebook:hover {
    background-color: #3B5998
}

.social-network a.icoTwitter:hover {
    background-color: #33ccff
}

.social-network a.icoGoogle:hover {
    background-color: #BD3518
}

.social-network a.icoFacebook:hover i,
.social-network a.icoTwitter:hover i,
.social-network a.icoGoogle:hover i {
    color: #fff
}

a.socialIcon:hover,
.socialHoverClass {
    color: #44BCDD
}

.social-circle li a {
    display: inline-block;
    position: relative;
    margin: 0 auto 0 auto;
    border-radius: 50%;
    text-align: center;
    width: 50px;
    height: 50px;
    font-size: 20px
}

.social-circle li i {
    margin: 0;
    line-height: 50px;
    text-align: center
}

.social-circle li a:hover i,
.triggeredHover {
    transform: rotate(360deg);
    transition: all 0.2s
}

.social-circle i {
    color: #fff;
    transition: all 0.8s;
    transition: all 0.8s
}
</style>

<?php 

$url = 'asset/peaberry.jpg';

?>



<br><br><br><br><br><br><br><br><br><br><br><br>

<div class="container">
    <div class="row ">
        <div class="col-md-6 offset-md-3 col-12 text-center p-3 mt-5">
            <div class="form-block">

                <div class="form-group ">

                    <img src="<?php echo $url;?>" alt="" class="w-75"><br><br>
                </div>
                  

<center><small>Server Bigsara</small></center>
              
                <div class="form-group first">
                    <label for="username">รหัสพนักงาน</label>
                    <input type="text" class="form-control" placeholder="" id="username">
                </div>
                <div class="form-group last mb-3">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" class="form-control" placeholder="" id="password">
                </div>

                <div class="d-sm-flex mb-5 align-items-center">
                </div>
                <button class="btn btn-block btn-info" id="login"> เข้าสู่ระบบ</button>
                <button class="btn btn-block btn-sm btn-warning"> ลืมรหัสผ่าน ?</button>

            </div>
        </div>
    </div>
</div>




<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../../template/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="logintemplate/js/jquery-3.3.1.min.js"></script>

<script src="logintemplate/js/popper.min.js"></script>
<script src="logintemplate/js/bootstrap.min.js"></script>
<script src="logintemplate/js/main.js"></script>

<script>
$(document).ready(function() {

});




$('#password').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        CheckLogin();
    }
});

$('#username').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        CheckLogin();
    }
});

$('#login').on('click', function() {
    CheckLogin();

});

function CheckLogin() {
    var username = $('#username').val();
    var password = $('#password').val();
    if (username == "" || password == "") {

        swal({
            title: 'เกิดข้อผิดพลาด',
            text: 'กรุณากรอกชื่อและรหัสผ่าน',
            type: 'error'

        });
        return false;
    }
    $.ajax({
        type: 'POST',
        url: 'auth.php',
        data: {
            username: username,
            password: password,
        },
        dataType: 'json',
        success: function(data) {
            if (data.result == 1) {
                location.href = "main/index2.php";
            } else {
                swal({
                    title: "เกิดข้อผิดพลาด",
                    text: "กรุณาตรวจสอบข้อมูล",
                    type: "error"
                }, function() {
                    
                });
            }
        }
    })
}
</script>