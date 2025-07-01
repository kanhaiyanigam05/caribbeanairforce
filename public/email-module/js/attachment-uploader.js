class AttachmentUploader {
    constructor(input, inputLabel, preview) {
        this.input = input;
        this.inputLabel = inputLabel;
        this.preview = preview;
        this.uploadedFiles = new Map(); // Use a Map for better file uniqueness checks
        this.input.addEventListener("change", this.fileChange.bind(this));
        this.inputLabel.addEventListener(
            "click",
            this.updateInputFiles.bind(this)
        );
    }

    fileChange() {
        const files = Array.from(this.input.files);
        files.forEach((file) => {
            if (!this.isFileAlreadyUploaded(file)) {
                this.uploadedFiles.set(file.name, file);
                this.createPreview(file);
            }
        });

        this.updateInputFiles();
    }

    isFileAlreadyUploaded(file) {
        return (
            this.uploadedFiles.has(file.name) &&
            this.uploadedFiles.get(file.name).lastModified === file.lastModified
        );
    }

    createPreview(file) {
        const button = document.createElement("button");
        button.className =
            "text-sm transition-all duration-200 hover:bg-[#a7a7a7] active:scale-95 font-medium flex justify-between items-center py-1 px-[10px] bg-[#dbdbdb] w-full rounded";
        button.setAttribute("type", "button");
        button.setAttribute("title", "Remove?");

        button.innerText = file.name;
        const icon = document.createElement("i");
        icon.className = "fa-solid fa-xmark";
        button.appendChild(icon);

        button.addEventListener("click", () => {
            this.uploadedFiles.delete(file.name);
            button.remove();
            this.updateInputFiles();
        });

        this.preview.appendChild(button);
        console.log(this.preview);
    }

    updateInputFiles() {
        const dataTransfer = new DataTransfer();
        this.uploadedFiles.forEach((file) => dataTransfer.items.add(file));
        this.input.files = dataTransfer.files;

        if (dataTransfer.files.length === 0) {
            this.input.value = "";
        }
    }
}

// Initialize uploader for each wrapper
const uploaderWrappers = document.querySelectorAll(".attachments-wrapper");
uploaderWrappers.forEach((wrapper) => {
    const inputFile = wrapper.querySelector(".input-file");
    const inputLabel = wrapper.querySelector(".input-label");
    const preview = wrapper.querySelector(".attachment-preview");

    if (inputFile && inputLabel && preview) {
        new AttachmentUploader(inputFile, inputLabel, preview);
    } else {
        console.error("Required elements not found in the wrapper");
    }
});
