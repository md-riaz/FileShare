const query = document.querySelector.bind(document); //Shortcut code for querySelector

const form = query(".form"); //select input element
const inputFile = query("#file_input"); //select input element
const submit_btn = query("#uploadSubmit"); //select submit button
var UploadOk = true;
(() => submit_btn.disabled = true)(); //Set submit button disabled by self executing arrow function
/*
 * Function for displaying selected file names
 */
inputFile.addEventListener("change", () => {
    var file_size = 0;
    var name_list = "";
    if ('files' in inputFile) {
        if (inputFile.files.length == 0) {
            name_list = "No file selected";
        } else {
            for (let i = 0; i < inputFile.files.length; i++) {


                file_size += inputFile.files[i]
                    .size; //Get the file size of selected item and addition the file size


                console.log("File size is: " + file_size + " byte");

                //Check file size & limit
                if (file_size > 20000000) {
                    console.log("File too big");
                    query('.note').style.color = 'red';
                    UploadOk = false;
                } else {
                    console.log("File is ok");
                    query('.note').style.color = '#8a8989';
                    UploadOk = true;
                }


                name_list += "<br><strong>" + (i + 1) + ". file:</strong> ";
                var file = inputFile.files[i];
                if ('name' in file) {
                    name_list += file.name + "<br>";
                }
            }
        }
    }
    query(".file_names").innerHTML = name_list;
    query(".total_size").innerHTML = "Total size: " + (file_size / 1048576).toFixed(2) +
        " MB"; //byte to mb convert & display
});
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
/*
 * Function for setting strokeDashoffset value
 */
function setProgress(percent) {
    console.log("setProgress percent: " + percent);
    const offset = poridhi - percent / 105 * poridhi;
    circle.style.strokeDashoffset = offset;
    console.log("Current strokeDashoffset is : " + offset);
}
setProgress(0);

inputFile.addEventListener("change", () => submit_btn.disabled =
    false) //remove disabled attribute from submit button

/*
 * Function for ajax file upload
 */
function ajax_send() {
    if (UploadOk == true) {
        query(".success").classList.remove("show");
        form.onsubmit = () => false //Prevent page from refreshing on submit
        //if file selected or not client-side
        if (inputFile.value != "") {
            //Javascript for renaming submit button on click
            submit_btn.value = "Uploading...";
            /*
             * AJAX Codes
             */
            var formdata = new FormData(); //Creating instance of formdata object

            //loop all files one by on
            for (let i = 0; i < inputFile.files.length; i++) {
                var files = inputFile.files[i];
                formdata.append(i, files);
            }
            const ajax = new XMLHttpRequest(); //AJAX object for exchange data with a server behind the scenes.
            ajax.upload.addEventListener("progress", progressHandler,
                false); //When uploading file,run progressHandler function.
            ajax.addEventListener("load", completeHandler, false); //Show a messege when upload is completed
            ajax.addEventListener("error", errorHandler, false); //Show a messege when error happen
            ajax.addEventListener("abort", abortHandler, false); //Show a messege when upload is interrupted
            ajax.open("POST", "PHP/ajax_upload.php"); //Specifies the type of request & request method
            ajax.send(formdata); //Sends the request to the server

            //function for Progressbar & file size displaying
            function progressHandler(event) {
                query(".upload_icon").classList.add("play"); //start upload icon animation
                var percent = (event.loaded / event.total) * 100;
                setProgress(percent); //Asign value to Circle progressbar
                console.log("Completed upload: " + percent + "%");
            }
            /*
             * Function on file upload completed
             */
            function completeHandler(event) {
                query(".total_size").innerHTML = event.target.responseText;
                query(".success").classList.add("show");
                submit_btn.value = "Upload";
                form.reset();
                query(".file_names").innerHTML = "";
                setTimeout(() => setProgress(0), 1000); //Resetting Circle progressbar
                query(".upload_icon").classList.remove("play"); //stop upload icon animation
            }
            function errorHandler(event) {
                query("status").innerHTML = "Upload Failed: refresh the page";
            }

            function abortHandler(event) {
                query("status").innerHTML = "Upload Aborted: refresh the page";
            }
                    } else {
            query(".total_size").innerHTML = "*Select a file first";
        }
    } else {
        query(".total_size").innerHTML = "*File size limit crossed !";
    }

}