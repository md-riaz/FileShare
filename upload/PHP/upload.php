<?php

$random_num = rand().'__'; //This line assigns a random number to this variable. 
$uploadOk = 1; //if condition is not fullfilled set this to 0 to stop upload.

if (isset($_FILES)) {

    $files = $_FILES['file_input']; //Get all the files from html input element & store in a variable
    $data = []; //Creating an empty array to store all the files info

    /*
    * Loop through files array with index number & value
    */
    foreach ($files as $index => $file_info) {
        
        foreach ($file_info as $inner_index => $value) {
            $data[$inner_index][$index] = $value;

        }
    }

    foreach ($data as $file) {
        $file_path = '../Uploaded_files/'.$random_num.$file['name'];
        $file_path = str_replace(' ', '_', $file_path);
        $tmp_location = $file['tmp_name'];

        //if no file is selected
        if($tmp_location == "") {
            $uploadOk = 0;
        } else {
                $uploadOk = 1;
        }

        //Check filesize
        if ($files['size'][0] > 20000000) {
            echo 'Sorry, your file is too large <br>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, there was an error uploading your file. <br>";
        }
        // if everything is ok, try to upload file
        else {
            if (move_uploaded_file($tmp_location, $file_path) === true) {
                echo 'The File Successfully Uploaded <br>';
            }
        }
    }
}













?>