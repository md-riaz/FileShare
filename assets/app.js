window.onload = function () {
    // Get all the elements that match the selector
    let fileLinks = document.querySelectorAll('.content_file');

    if (fileLinks.length > 0) {
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


























const query = document.querySelector.bind(document); //Shortcut code for querySelector
const dropZoneElement = query(".drop-zone"); // drop zone
const form = query(".form"); //select input element
const inputFile = query("#file_input"); //select input element
const submit_btn = query("#uploadSubmit"); //select submit button
let noteText = query('.note');
let file_names = query(".file_names");
let total_size = query(".total_size");
let success_msg = query(".success");
var UploadOk = true;


/* Byte to megabyte conversion */
var byteToMB = (size) => (size / 1048576).toFixed(2);


/*
 * CODE for animating svg stroke to see upload progress
 */
let circle = query('.progress-ring__circle');
let radius = circle.r.baseVal.value;
console.log("Radius of this circle: " + radius);

let poridhi = radius * 2 * Math.PI;
console.log("Circumference of this circle: " + poridhi);

circle.style.strokeDasharray = `${poridhi} ${poridhi}`;
console.log("strokeDasharray of this circle: " + circle.style.strokeDasharray);

circle.style.strokeDashoffset = `${poridhi}`;
console.log("strokeDashoffset of this circle: " + circle.style.strokeDashoffset);

/*  Function for setting strokeDashoffset value */
function setProgress(percent) {
    console.log("setProgress percent: " + percent);
    const offset = poridhi - percent / 105 * poridhi;
    circle.style.strokeDashoffset = offset;
    console.log("Current strokeDashoffset is : " + offset);
}

setProgress(0);

/* Check if file is selected or not */
inputFile.addEventListener("change",
    () => 'files' in inputFile ?
        inputFile.files.length === 0 ? name_list = "No file selected" : showFileList()
        : ""
);

/********* Drag and drop *********/

// on file drag, prevent browser to load file & add a class to drop zone
dropZoneElement.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneElement.classList.add("drop-zone--over");
});

// on dragleave & dragend, remove class
["dragleave", "dragend"].forEach((type) =>
    dropZoneElement.addEventListener(type, (e) => dropZoneElement.classList.remove("drop-zone--over"))
);

// if file dropped in drop zone then insert files in input element and show list of file names
dropZoneElement.addEventListener("drop", (e) => {
    e.preventDefault();
    if (e.dataTransfer.files.length) {
        inputFile.files = e.dataTransfer.files;
        showFileList();
    }
    dropZoneElement.classList.remove("drop-zone--over");
});

/*  Display selected file names */
function showFileList() {
    let file_size = 0, name_list = ""; // empty list default

    for (let i = 0; i < inputFile.files.length; i++) {
        file_size += inputFile.files[i].size; //Get the file size of selected item and addition the file size
        console.log(`File size is: ${byteToMB(file_size)} byte`);

        //Check file size & limit
        if (file_size > 20000000) {
            console.log("File too big");
            noteText.style.color = 'red';
            UploadOk = false;
        } else {
            console.log("File is ok");
            noteText.style.color = '#8a8989';
            UploadOk = true;
        }

        // get list of selected file names
        name_list += "<br><strong>" + (i + 1) + ". file:</strong> ";

        let file = inputFile.files[i];
        if ('name' in file) {
            name_list += file.name + "<br>";
        }
    }
    file_names.innerHTML = name_list;
    total_size.innerHTML = `Total size: ${byteToMB(file_size)} MB`;
}

/*
 * Function for ajax file upload
 */
function ajax_send() {
    if (UploadOk === true) {
        success_msg.classList.remove("show");
        form.onsubmit = () => false //Prevent page from refreshing on submit

        //if file selected or not client-side
        if (inputFile.value !== "") {
            // Rename submit btn
            submit_btn.value = "Uploading...";

            /************* AJAX Codes *************/
            var formData = new FormData(); //Creating instance of form data object

            //loop all files one by one and append in FormData
            for (let i = 0; i < inputFile.files.length; i++) {
                var files = inputFile.files[i];
                formData.append(i, files);
            }
            const ajax = new XMLHttpRequest(); //AJAX object for exchange data with a server behind the scenes.
            ajax.upload.addEventListener("progress", progressHandler,
                false); //When uploading file,run progressHandler function.
            ajax.addEventListener("load", completeHandler, false); //Show a messege when upload is completed
            ajax.addEventListener("error", errorHandler, false); //Show a messege when error happen
            ajax.addEventListener("abort", abortHandler, false); //Show a messege when upload is interrupted
            ajax.open("POST", "PHP/ajax_upload.php"); //Specifies the type of request & request method
            ajax.send(formData); //Sends the request to the server

          /* Function for Progressbar & file size displaying */
            function progressHandler(event) {
                query(".upload_icon").classList.add("play"); //start upload icon animation
                var percent = (event.loaded / event.total) * 100;
                setProgress(percent); //Asign value to Circle progressbar
                console.log("Completed upload: " + percent + "%");
            }

            /*  Function on file upload completed */
            function completeHandler(event) {
                total_size.innerHTML = event.target.responseText;
                setTimeout(() => total_size.innerHTML = "", 5000); // Reset response after 5sec
                success_msg.classList.add("show");
                submit_btn.value = "Upload";
                form.reset();
                file_names.innerHTML = "";
                setTimeout(() => setProgress(0), 1000); // Resetting Circle progressbar
                query(".upload_icon").classList.remove("play"); // stop upload icon animation
            }

            function errorHandler(event) {
                total_size.innerHTML = "Upload Failed: refresh the page";
            }

            function abortHandler(event) {
                total_size.innerHTML = "Upload Aborted: refresh the page";
            }
        } else {
            total_size.innerHTML = "*Select a file first";
        }
    } else {
        total_size.innerHTML = "*File size limit crossed !";
    }

}
