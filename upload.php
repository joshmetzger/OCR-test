<?php

    if(isset($_FILES['image'])){

        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($file_tmp, 'images/'.$file_name);
        echo "<h3>Image Uploaded Successfully</h3>";
        echo "<img width='800' height='600' src='images/$file_name'>";

        shell_exec('/usr/local/bin/tesseract images/'.$file_name.' output');

        echo "<br><h6>Text from proccessed image: </h6>";

        $my_file = fopen("output.txt", "r") or die("unable to open file");
        echo fread($my_file, filesize("output.txt"));
        fclose($my_file);
    }

?>