<?php

    if(isset($_FILES['image'])){

        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($file_tmp, 'images/'.$file_name);
        echo "<h3>Image Uploaded Successfully</h3>";

        // imagemagick to process image to something easier for tesseract to read...
        $img = new Imagick($_SERVER['DOCUMENT_ROOT']."/OCR_test/images/$file_name");
        // $img->scaleImage(3000, 3000, true);
        $img->adaptiveSharpenImage(0, 8);
        $img->contrastImage(5);
        $img->writeImage($_SERVER['DOCUMENT_ROOT']."/OCR_test/processed_images/processed_$file_name");

        echo "<img width='800' height='600' src='processed_images/processed_$file_name'>";
        // echo "<img width='800' height='600' src='images/$file_name'>";
        
        shell_exec('/usr/local/bin/tesseract processed_images/processed_'.$file_name.' text_files/text_'.$file_name.'');

        echo "<br><h6>Text from proccessed image: </h6>";

        $my_file = fopen("text_files/text_$file_name.txt", "r") or die("unable to open file");
        echo fread($my_file, filesize("text_files/text_$file_name.txt"));
        fclose($my_file);
    }

?>