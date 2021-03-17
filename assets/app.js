window.onload = function () {
    let file_list = document.querySelector('.file_list');

    if (file_list) {
        // fetching json data from server
        fetch('https://riaz.dev.alpha.net.bd/FileShare/upload/filelist.php').then(function (response) {
            // The API call was successful!
            if (response.ok) {
                return response.json();
            } else {
                return Promise.reject(response);
            }
        }).then(function (data) {
            // This is the JSON from our response
            data.forEach(function (file) {
                let downloadUrl = window.btoa(file['downloadUrl']);
                let hrefUrl = window.btoa(file['hrefUrl']);
                let item =
                    `
                    < a class = 'content_file'
                    href = "${window.location.href}view/?f=${hrefUrl}"
                    data-href = "${window.location.href}download/?d=${downloadUrl}"
                    title = "${file['filename']}" >
                        <img src="${file['previewUrl']}" alt="${file['filename']}">
                        <span class='file_name'>${file['filename']}</span>
                        <span class='file_size'>${file['size']}</span>
                    </a> 
                `;
                file_list.insertAdjacentHTML('beforeend', item);
            });
            fileLinksListener();
        }).catch(function (err) {
            // There was an error
            console.warn('Something went wrong.', err);
        });
    }

    function fileLinksListener() {
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
    }


    let copyToClipboard = function (copyText) {
        var dummy = document.createElement("input"); // Create a dummy input to copy the string array inside it
        document.body.appendChild(dummy); // Add it to the document
        dummy.value = copyText;
        dummy.select(); // Select it
        document.execCommand("copy"); // Copy its contents
        document.body.removeChild(dummy); // Remove it as its not needed anymore
    }

    const formatBytes = function (bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    };

    var RandomID = function () {
        // Math.random should be unique because of its seeding algorithm.
        // Convert it to base 36 (numbers + letters), and grab the first 9 characters
        // after the decimal.
        return '_' + Math.random().toString(36).substr(2, 9);
    };

    /* ajax file upload section */
    let fileCatcher = document.getElementById('file_catcher');
    let dropZoneElement = document.querySelector(".drop_area_container");
    let fileInput = document.getElementById('file_input');
    let fileListDisplay = document.getElementById('file_list_display');
    let fileList = [];
    let renderFileList, sendFile;
    let postUrl = 'uploadHandler.php';
    let maxSize = 20000000; //in byte
    let xhrMessage = [];

    if (dropZoneElement) {
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
                fileInput.files = e.dataTransfer.files;
                fileInput.dispatchEvent(new Event('change'));
            }
            dropZoneElement.classList.remove("drop-zone--over");
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function (event) {
            fileList = [];
            for (let i = 0; i < fileInput.files.length; i++) {
                fileInput.files[i].id = RandomID();
                fileInput.files[i].prevUpload = 0;
                fileList.push(fileInput.files[i]);
            }
            renderFileList();
            // send file after getting all files
            fileList.forEach(function (file) {
                if (file.size > maxSize) {
                    document.getElementById(file.id).classList.add('sizeExceeded');
                    document.getElementById(file.id).querySelector('.item_remove').addEventListener('click', function (e) {
                        elm.remove();
                    })
                } else {
                    sendFile(file);
                }

            });


        });
    }


    renderFileList = function () {
        fileList.forEach(function (file, index) {
            let size = formatBytes(file.size);
            let imgExt = ['jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'png', 'gif', 'bmp', 'svg', 'webp'];
            let fileExt = file.name.substring(file.name.lastIndexOf('.') + 1).toLowerCase();
            let preview;
            if (!imgExt.includes(fileExt)) {
                preview = `../assets/file_icons/${fileExt}.png`
            } else {
                preview = URL.createObjectURL(file);
            }
            let item =
                `<div class="list_item" id="${file.id}">
                        <div class="img">
                            <img src="${preview}" alt="${file.name}">
                        </div>
                        <div class="contents">
                            <div class="top">
                                <div class="item_title">${file.name}</div>
                                <div class="item_size">${size}</div>
                                <div class="item_close">
                                    <svg viewBox="0 0 492 492"><defs/><path d="M300 246L484 62a27 27 0 000-38L468 8a27 27 0 00-38 0L246 192 62 8a27 27 0 00-38 0L8 24a27 27 0 000 38l184 184L8 430a27 27 0 000 38l16 16a27 27 0 0038 0l184-184 184 184a27 27 0 0038 0l16-16a27 27 0 000-38L300 246z"/></svg>
                                </div>
                            </div>
                            <div class="progress_bar">
                                <div class="progress" style="width: 0;"></div>
                            </div>
                            <div class="bottom">
                                <div class="percent">0% done</div>
                                <div class="speed_status">${file.prevUpload}/sec</div>
                            </div>
                        </div>
                    </div>`;

            fileListDisplay.insertAdjacentHTML('afterbegin', item);

        });
        listItem = fileListDisplay.querySelectorAll('.list_item');
        if (listItem) {
            listItem.forEach(function (item) {
                let fileId = item.id;
                let closeBtn = item.querySelector('.item_close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function (e) {
                        abortRequest(fileId);
                    });
                }
            });
        }
    }

    let requests = [];
    sendFile = function (file) {
        let formData = new FormData();
        requests[file.id] = new XMLHttpRequest();
        formData.set('file_input', file);
        formData.set('id', file.id);

        requests[file.id].upload.addEventListener("progress", function (event) {
            progressHandler(event, file) // When uploading file,execute progressHandler function.

        });
        requests[file.id].addEventListener("load", function (event) {
            completeHandler(event, file) // execute function when upload is completed
        });
        requests[file.id].addEventListener("error", function (event) {
            errorHandler(event, file) // execute function when error happen
        });
        requests[file.id].addEventListener("abort", function (event) {
            abortHandler(event, file) // execute function when upload is interrupted
        });
        requests[file.id].open('POST', postUrl); //Specifies the type of request & request method
        requests[file.id].send(formData); //Sends the request to the server
        requests[file.id].onreadystatechange = function () {
            if (requests[file.id].readyState === XMLHttpRequest.DONE) {
                let response = JSON.parse(requests[file.id].responseText);
                if (response.status !== 200) {
                    let elm = document.getElementById(file.id);
                    if (elm) {
                        elm.classList.add('error');
                        elm.querySelector('.percent').innerHTML = response.message;
                        elm.querySelector('.speed_status').remove();
                        elm.querySelector('.progress_bar .progress').style.width = '0%';
                    }
                }
            }
        }
    }

    let progressHandler = function (event, file) {
        let percent = Math.round((event.loaded / event.total) * 100);
        let elm = document.getElementById(file.id);
        if (elm) {
            elm.querySelector('.progress_bar .progress').style.width = percent + '%';
            elm.querySelector('.percent').innerHTML = percent + '% done';
        }

        // get upload speed in every 1 sec
        setTimeout(uploadSpeed(file, event.loaded), 1000);
    }

    let completeHandler = function (event, file) {
        let elm = document.getElementById(file.id);
        elm.querySelector('.item_close').className = 'item_remove';
        if (elm.querySelector('.speed_status')) elm.querySelector('.speed_status').innerHTML = "<span>&#10003;</span>";
        elm.querySelector('.item_remove').addEventListener('click', function (e) {
            elm.remove();
        })
    }

    let errorHandler = function (event, file) {
        xhrMessage.push('Upload failed of #' + file.id + '. Refresh the page.');
        console.log(xhrMessage)
    }

    let abortHandler = function (event, file) {
        xhrMessage.push('Aborted Upload of #' + file.id + '. Refresh the page.');
        console.log(xhrMessage)
    }

    let uploadSpeed = function (file, uploaded) {
        //speed
        let up_speed = Math.abs(uploaded);
        speed = Math.abs(up_speed - file.prevUpload);
        file.prevUpload = up_speed;
        let elm = document.getElementById(file.id).querySelector('.speed_status');
        if (elm) {
            elm.innerHTML = formatBytes(speed) + '/sec';
        }


    }
    // abort specific file id xhr
    let abortRequest = function (fileId) {
        if (requests[fileId]) {
            requests[fileId].abort();
        }
        let parent = document.getElementById(fileId);
        let elm = parent.querySelector('.item_close')
        if (elm) {
            elm.className = 'item_remove';
            elm.addEventListener('click', function (e) {
                parent.remove();
            })
        }
    }


}