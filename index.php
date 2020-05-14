<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="https://img.icons8.com/cute-clipart/64/000000/external-link.png" type="image/x-icon">
  <title>Link Copier</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      min-width: 100vw;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      overflow-x: hidden;
      box-sizing: border-box;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 1.5em;
      color: #fff;
    }

    .wrapper {
      width: 90vw;
      height: 100vh;
    }

    .wrapper h1 {
      width: 100vw;
      color: #ccc;
      background-color: #222;
      padding: 10px 20px;
      font-size: 1.2em;
      margin-left: -5vw;
    }

    button.content {
      display: block;
      min-height: 30px;
      min-width: 50px;
      margin: 10px;
      padding: 5px;
      cursor: pointer;
      letter-spacing: 1px;
      color: #428bca;
      text-decoration: none;
      position: relative;
      border: none;
      counter-increment: num;
      margin-left: 45px;
    }


    button.content:hover {
      text-decoration: underline;
    }

    button.content::before {
      position: absolute;
      content: '';
      height: 50px;
      width: 50px;
      left: -25px;
      top: 5px;
      background: url(https://img.icons8.com/ios/50/000000/link.png) no-repeat;
      background-size: 20px;
    }

    button.content::after {
      position: absolute;
      height: 30px;
      width: 30px;
      left: -60px;
      top: 0;
      background: #009688;
      color: white;
      content: counter(num);
      line-height: 2.5;
      border-radius: 50%;
    }

    .plus-icon {
      position: fixed;
      height: 100px;
      width: 100px;
      background: url(https://img.icons8.com/cotton/64/000000/plus--v2.png);
      background-repeat: no-repeat;
      cursor: pointer;
      text-decoration: none;
      right: 0;
      bottom: 0;
    }

    div a img {
      visibility: hidden; /*remove branding of 000webhost*/
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <h1>Direct File Links</h1>
     <!--  Check folder and read content -->
    <?php 
        $resource = opendir("upload/Uploaded_files");
        while (($entry = readdir($resource)) !== FALSE) {
          if ($entry != '.' && $entry != '..') {
              echo '<button class="content">'.$entry.'</button>';
          }
        }
      ?>
  </div>
  <a class="plus-icon" href="upload/"></a>

  <script>
    window.onload = function () {
      var queryAll = document.querySelectorAll.bind(document);
      // Get all the elements that match the selector
      var Btns = queryAll(".content");

      [].forEach.call(Btns, (btn) => {
        btn.addEventListener("click", () => {
          let value = btn.innerHTML;
          let Final_value = window.location.href + "upload/Uploaded_files/" + value;
          console.log(Final_value);

          // Create a dummy input to copy the string array inside it
          var dummy = document.createElement("input");
          // Add it to the document
          document.body.appendChild(dummy);
          dummy.value = Final_value;
          // Select it
          dummy.select();

          // Copy its contents
          document.execCommand("copy");

          // Remove it as its not needed anymore
          document.body.removeChild(dummy);

          /* Alert the copied text */
          alert("Copied the text: \n" + Final_value);
        });
      });
    }
  </script>
</body>

</html>