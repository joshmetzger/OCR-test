<?php

    if(isset($_FILES['image'])){

        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        // $processed_image = null;

        move_uploaded_file($file_tmp, 'images/'.$file_name);
        echo "<h3>Image Uploaded Successfully</h3>";

        // imagemagick to process image to something easier for tesseract to read...
        // shell_exec('convert images/'.$file_name.' -shade 200x50 output.jpg');
        $img = new Imagick($_SERVER['DOCUMENT_ROOT']."/OCR_test/images/$file_name");
        $img->scaleImage(2000, 2000, true);
        $img->writeImage($_SERVER['DOCUMENT_ROOT']."/OCR_test/processed_images/processed_$file_name");

        echo "<img width='800' height='600' src='processed_images/processed_$file_name'>";
        // echo "<img width='800' height='600' src='images/$file_name'>";

        // try shade, other compression, tiff convert, some other image editing, planing if possible...
        
        shell_exec('/usr/local/bin/tesseract processed_images/processed_'.$file_name.' output');

        echo "<br><h6>Text from proccessed image: </h6>";

        $my_file = fopen("output.txt", "r") or die("unable to open file");
        echo fread($my_file, filesize("output.txt"));
        fclose($my_file);
    }

?>