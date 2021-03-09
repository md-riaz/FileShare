<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <title>FileShare</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Katibeh&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<div class="page_wrapper">
    <h1>Direct File Links</h1>
    <!--  Check folder and read content -->
    <div class="file_list">
		<?php
		$url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$resource = getcwd() . '/upload/shared_files';
		$files = glob($resource . '/*.*');
		// sorting files with modified date
		usort($files, function ($file1, $file2) {
			return filemtime($file1) < filemtime($file2);
		});

		foreach ($files as $file) {
			$filename = pathinfo($file, PATHINFO_BASENAME);
			$filenameEncoded = str_rot13($filename);
			$ext = pathinfo($file, PATHINFO_EXTENSION);

			echo "
                    <a class='content_file' href='{$url}upload/shared_files/{$filename}' data-href='{$url}download.php?file={$filenameEncoded}'>
                      <img src='file_icons/{$ext}.png' alt='{$filename}'>
                      <span class='file_name'>{$filename}</span>
                    </a>
                  ";
		}
		?>
    </div>
</div>
<a class="upload_btn" href="upload/">Upload Now</a>
<script>
    window.onload = function () {
        // Get all the elements that match the selector
        let fileLinks = document.querySelectorAll('.content_file');

        for (let link of fileLinks) {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                copyToClipboard(this.dataset.href);
                this.classList.toggle('copied');
                setTimeout(() => {
                    // toggle back after 1 second
                    this.classList.toggle('copied');
                }, 2000)
            })

        }

        function copyToClipboard(copyText) {
            var dummy = document.createElement("input"); // Create a dummy input to copy the string array inside it
            document.body.appendChild(dummy); // Add it to the document
            dummy.value = copyText;
            dummy.select(); // Select it
            document.execCommand("copy"); // Copy its contents
            document.body.removeChild(dummy); // Remove it as its not needed anymore
        }

    }
</script>
</body>

</html>