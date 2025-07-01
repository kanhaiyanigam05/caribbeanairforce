document.addEventListener("DOMContentLoaded", function () {
    const dragImageWrapper = document.querySelector(".drag-image-wrapper");
    const imageWrappers = document.querySelectorAll(".display-img-create-order");
    const fileInput = document.querySelector("#event-banner");
    const errorText = document.querySelector("#event-banner-error-text");

    dragImageWrapper.addEventListener("dragover", function (event) {
        event.preventDefault();
        event.stopPropagation();
        dragImageWrapper.classList.add("dragging");
    });

    dragImageWrapper.addEventListener("dragleave", function (event) {
        event.preventDefault();
        event.stopPropagation();
        dragImageWrapper.classList.remove("dragging");
    });

    dragImageWrapper.addEventListener("drop", function (event) {
        event.preventDefault();
        event.stopPropagation();
        dragImageWrapper.classList.remove("dragging");

        const files = event.dataTransfer.files;
        handleFiles(files);

        const dataTransfer = new DataTransfer();

        // Append existing files to the DataTransfer object
        for (let i = 0; i < fileInput.files.length; i++) {
            dataTransfer.items.add(fileInput.files[i]);
        }

        // Append new files to the DataTransfer object
        for (let i = 0; i < files.length; i++) {
            dataTransfer.items.add(files[i]);
        }

        // Update the file input with the new DataTransfer object
        fileInput.files = dataTransfer.files;
    });

    fileInput.addEventListener("change", function (event) {
        console.log(event.target.files);
        const files = event.target.files;
        handleFiles(files);
    });

    dragImageWrapper.addEventListener("click", function (event) {
        fileInput.click();
    });

    function handleFiles(files) {
        errorText.textContent = '';

        if (files.length === 0) {
            return;
        }

        for (const file of files) {
            if (file.type.startsWith("image/") || file.type.startsWith("video/")) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    imageWrappers.forEach(function (wrapper) {
                        displayMedia(event.target.result, wrapper, file.type);
                    });
                };
                reader.readAsDataURL(file);
            } else {
                errorText.textContent = "Please upload valid image or video files.";
            }
        }
    }

    function displayMedia(mediaSrc, wrapper, mediaType) {
        const container = document.createElement("div");
        container.classList.add("media-container");

        let mediaElement;
        if (mediaType.startsWith("image/")) {
            mediaElement = document.createElement("img");
            mediaElement.src = mediaSrc;
        } else if (mediaType.startsWith("video/")) {
            mediaElement = document.createElement("video");
            mediaElement.src = mediaSrc;
            mediaElement.controls = true;
        }

        mediaElement.style.width = "100px";
        mediaElement.style.height = "100px";
        mediaElement.style.objectFit = "cover";
        mediaElement.classList.add("media-item");

        const trashIcon = document.createElement("i");
        trashIcon.classList.add("fa-solid", "fa-trash", "a-icon", "no-bg");
        trashIcon.style.position = "absolute";
        trashIcon.style.top = "10px";
        trashIcon.style.right = "10px";

        trashIcon.addEventListener("click", function () {
            container.remove();
        });

        container.style.position = "relative";
        container.style.display = "inline-block";
        container.style.margin = "5px";

        container.appendChild(mediaElement);
        container.appendChild(trashIcon);

        wrapper.appendChild(container);
    }
});
