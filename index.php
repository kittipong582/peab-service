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
    <link rel="stylesheet" type="text/css" href="../template/css/plugins/sweetalert/sweetalert.css">

</head>



<style>
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background: linear-gradient(to right, #b92b27, #1565c0)
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

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <form onsubmit="event.preventDefault()" class="box">
                    <h1>Login (V3)</h1>
                    <p class="text-muted"> Please enter your login and password!</p>
                    <input type="text" name="username" id="username" placeholder="Username">
                    <input type="password" name="password" id="password" placeholder="Password">
                    <input type="button" id="login" value="Login" href="#">
                    <div class="col-md-12">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../template/js/plugins/sweetalert/sweetalert.min.js"></script>

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
                // alert("asgsd");
                if (data.result == 1) {
                    location.href = "main/index.php";
                } else if (data.result == 2) {
                    location.href = "admin/index.php";
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