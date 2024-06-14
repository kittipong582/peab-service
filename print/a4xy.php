<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    /* div {
        border: 1px solid black;
    } */

    div:hover {
        cursor: crosshair;
    }

    #coordinates {
        position: absolute;
        display: none;
    }
</style>

<body>

    <!-- <img id="hover-div" src="" width="297" height="210" /> -->
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div id="hover-div" src="" style="width: 420px; height: 594px; border : 1px solid #000;"></div>
                <div id="coordinates"></div>
            </div>
            <div class="col">
                <div id="obj_list"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(function() {

            $('#hover-div')
                .bind('mouseenter', function() {
                    $('#coordinates').show();
                })
                .bind('mouseleave', function() {
                    $('#coordinates').hide();
                })
                .bind('mousemove', function(evt) {
                    $('#coordinates').html(
                        'X' + ((evt.pageX - this.offsetLeft) / 2) + '/' + 'Y' + ((evt.pageY - this.offsetTop) / 2)
                    ).css({
                        left: evt.pageX + 20,
                        top: evt.pageY + 20
                    })
                })

            $('#hover-div').click(function(evt) {

                let obj_data = 'X' + ((evt.pageX - this.offsetLeft) / 2) + '/' + 'Y' + ((evt.pageY - this.offsetTop) / 2)
                var newtext = $('<span />').css({
                    position: 'absolute',
                    left: evt.pageX,
                    top: evt.pageY
                });
                newtext.html(obj_data)
                $('#hover-div').append(newtext)

                var textArea = $('<textarea />').addClass('form-control mb-2')
                textArea.id = "idTextarea";
                textArea.cols = "50";
                textArea.rows = "50";
                textArea.class = "form-control";

                let textBox = $('<input />')

                $("#obj_list").append(textArea + textBox);

            });
        });
    </script>
</body>

</html>