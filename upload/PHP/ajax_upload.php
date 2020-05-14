<?php

$Cryptograph_alphanumeric = bin2hex(random_bytes(3)).'__';
$uploadOk = 1;
if (isset($_FILES)) {

        foreach ($_FILES as $file) {
            $file_path = '../Uploaded_files/'.$Cryptograph_alphanumeric.$file['name'];
            $file_path = str_replace(' ', '_', $file_path);
            $tmp_location = $file['tmp_name'];

            //if no file is selected server-side
            if($tmp_location == "") {
                $uploadOk = 0;
                echo 'Select a file first';
            }

            //Check filesize
            if ($file['size'] > 20000000) {
                echo 'Sorry, your file is too large';
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Upload Failed. <br>";
            }
            // if everything is ok, try to upload file
            else {
                if (move_uploaded_file($tmp_location, $file_path) === true) {
                    echo 'The File Successfully Uploaded <br>';
                }
            }
        }
}
// Email system to receive the notifications
$to = 'bpimdriaz@gmail.com';
$datetime = date("F j, Y, g:i a");
$subject = 'New Visitor uploaded a file on your Webpage';
$emailContent = "<h3>Someone uploaded a file.</h3> 
			Time: ".$datetime."
			File : ".$Cryptograph_alphanumeric.$file['name'];
// headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8";
// send the message
// mail($to, $subject, $emailContent, $headers);
?>