<?php

echo $files_name  = $_FILES['image']['name'];
echo "</br>";
echo $files_tmp = $_FILES['image']['tmp_name'];
echo "</br>";
if (move_uploaded_file($files_tmp, $files_name)) {
    echo "successfuly";
} else {
    echo "Error";
}
