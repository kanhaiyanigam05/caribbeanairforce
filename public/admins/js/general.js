function handleAlert(wrapper) {
    const mainWrapper = wrapper.parentElement.parentElement;
    const itemBox = mainWrapper.querySelector(".item-box");
    const alertBoxWrapper = mainWrapper.querySelector(".alert-box-wrapper");

    if (wrapper.checked) {
        alertBoxWrapper.classList.remove("hidden");
        itemBox.classList.add("hidden");
    } else {
        itemBox.classList.remove("hidden");
        alertBoxWrapper.classList.add("hidden");
    }
}

function handleOnlineEvent(wrapper) {
    const mainWrapper = document.querySelector(".online-event-wrapper");
    const itemBox = mainWrapper.querySelector(".item-box");
    const onlineEventDropdown = mainWrapper.querySelector(
        ".online-event-dropdown"
    );

    if (wrapper.checked) {
        onlineEventDropdown.classList.remove("hidden");
        itemBox.classList.add("hidden");
    } else {
        itemBox.classList.remove("hidden");
        onlineEventDropdown.classList.add("hidden");
    }
}

function handleHamburgerClick(button) {
    const mobileNavbar = document.querySelector(".mobile-navbar");

    if (button.classList.contains("is-active")) {
        button.classList.remove("is-active");
        mobileNavbar.classList.remove("show");
    } else {
        button.classList.add("is-active");
        mobileNavbar.classList.add("show");
    }
}

function handleDropdown(wrapper) {
    const dropdown = wrapper.querySelector(".dropdown-wrapper");
    dropdown.classList.toggle("dropdown-show");

    document.addEventListener("click", (event) => {
        if (
            !dropdown.contains(event.target) &&
            !wrapper.contains(event.target)
        ) {
            dropdown.classList.remove("dropdown-show");
        }
    });
}

function handleNotification(wrapper) {
    const dropdown = wrapper.querySelector(
        ".notification-dropdown-main-wrapper"
    );
    dropdown.classList.toggle("dropdown-show");

    try {
        const main = document.querySelector("main");
        main.classList.add("relative", "z-index-minus-1");
    } catch (error) {
        console.log(error);
    }

    document.addEventListener("click", (event) => {
        if (
            !dropdown.contains(event.target) &&
            !wrapper.contains(event.target)
        ) {
            dropdown.classList.remove("dropdown-show");

            try {
                const main = document.querySelector("main");
                main.classList.remove("relative", "z-index-minus-1");
            } catch (error) { }
        }
    });
}

function handleCardsDropdown(wrapper) {
    const dropdown = wrapper.querySelector(".card-dropdown-wrapper");
    dropdown.classList.add("dropdown-show");

    document.addEventListener("click", (event) => {
        if (
            !dropdown.contains(event.target) &&
            !wrapper.contains(event.target)
        ) {
            dropdown.classList.remove("dropdown-show");
        }
    });
}

function handleUpdateEventEditAction(wrapper) {
    const baseDrppdown = wrapper.parentElement.parentElement;
    const detailedDrppdown = baseDrppdown.parentElement.querySelector(
        ".card-dropdown-wrapper-2"
    );

    baseDrppdown.classList.remove("dropdown-show");
    detailedDrppdown.classList.add("dropdown-show");

    document.addEventListener("click", (event) => {
        if (
            !detailedDrppdown.contains(event.target) &&
            !wrapper.contains(event.target)
        ) {
            detailedDrppdown.classList.remove("dropdown-show");
        }
    });
}

function handleBackUpdateEventEditAction(wrapper) {
    const topWrapper =
        wrapper.parentElement.parentElement.parentElement.parentElement;
    const baseDropdown = topWrapper.querySelector(".card-dropdown-wrapper");
    const detailedDropdown = wrapper.parentElement.parentElement.parentElement;

    detailedDropdown.classList.remove("dropdown-show");
    baseDropdown.classList.add("dropdown-show");
}

function handleShowHideDetailedViewOfEvent(button) {
    const itemWrapper = button.parentElement.parentElement;
    const content = itemWrapper.querySelector(".feed-text-wrapper");

    content.classList.toggle("feed-text-wrapper-hidden");
}

function handleEventJoin(button) {
    const icon = button.querySelector("i");

    if (icon.classList.contains("fa-regular")) {
        icon.classList.remove("fa-regular");
        icon.classList.add("fa-solid");
    } else {
        icon.classList.remove("fa-solid");
        icon.classList.add("fa-regular");
    }
}

// show-modal

function handleCreateEventModalShow() {
    const modal = document.querySelector("#create-event-modal");
    const body = document.querySelector("body");

    body.style.overflow = "hidden";
    modal.classList.add("show-modal");

    // document.addEventListener("click", (event) => {
    //   if (event.target === modal) {
    //     body.style.overflow = "";
    //     modal.classList.remove("show-modal");
    //   }
    // });
}

function handleProfilePageDPChange() {
    const modal = document.querySelector("#display-picture-modal");
    const body = document.querySelector("body");

    body.style.overflow = "hidden";
    modal.classList.add("show-modal");

    document.addEventListener("click", (event) => {
        if (event.target === modal) {
            body.style.overflow = "";
            modal.classList.remove("show-modal");
        }
    });
}

function handleProfilePageCoverPhotoChange() {
    const modal = document.querySelector("#display-cover-modal");
    const body = document.querySelector("body");

    body.style.overflow = "hidden";
    modal.classList.add("show-modal");

    document.addEventListener("click", (event) => {
        if (event.target === modal) {
            body.style.overflow = "";
            modal.classList.remove("show-modal");
        }
    });
}

function handleProfileUpdate() {
    const modal = document.querySelector("#profile-modal");
    const body = document.querySelector("body");

    setTimeout(() => {
        body.style.overflow = "hidden";
        modal.classList.add("show-modal");
    }, 500);

    document.addEventListener("click", (event) => {
        if (event.target === modal) {
            body.style.overflow = "";
            modal.classList.remove("show-modal");
            button.classList.remove("rotate-100");
        }
    });
}

function handleHideProfileCoverPhotoChangeModal() {
    const modal = document.querySelector("#display-cover-modal");
    const body = document.querySelector("body");

    body.style.overflow = "";
    modal.classList.remove("show-modal");
}

function handleHideProfileModal() {
    const modal = document.querySelector("#profile-modal");
    const body = document.querySelector("body");

    body.style.overflow = "";
    modal.classList.remove("show-modal");
}

function handleHideProfileDpChangeModal() {
    const modal = document.querySelector("#display-picture-modal");
    const body = document.querySelector("body");

    body.style.overflow = "";
    modal.classList.remove("show-modal");
}

function handleHideEventCreateModal() {
    const modal = document.querySelector("#create-event-modal");
    const body = document.querySelector("body");
    allHiddenElements = modal.querySelectorAll(".create-event-item");

    allHiddenElements.forEach((element) => {
        element.classList.add("hidden");
    });

    body.style.overflow = "";
    modal.classList.remove("show-modal");
}

function handleRemoveCreateEventModal() {
    const modal = document.querySelector("#create-event-modal");
    const body = document.querySelector("body");

    body.style.overflow = "";
    modal.classList.remove("show-modal");
}

function handleEventEditAction() {
    const wrapper = document.querySelector(".details-edit-event-wrapper");
    const editBtn = document.querySelector(".base-prev-event-wrapper-btn i");

    if (editBtn.classList.contains("fa-pen")) {
        editBtn.classList.remove("skewY-minus-20");
        editBtn.classList.add("skewY-plus-20");

        setTimeout(() => {
            wrapper.classList.remove("hidden");
            wrapper.classList.add("bottom-111");
            editBtn.classList.remove("skewY-minus-20");
            editBtn.classList.remove("skewY-plus-20");
            editBtn.classList.replace("fa-pen", "fa-x");
        }, 200);
    } else {
        editBtn.classList.remove("skewY-plus-20");
        editBtn.classList.add("skewY-minus-20");

        setTimeout(() => {
            wrapper.classList.add("hidden");
            wrapper.classList.remove("bottom-111");
            editBtn.classList.remove("skewY-plus-20");
            editBtn.classList.remove("skewY-minus-20");
            editBtn.classList.replace("fa-x", "fa-pen");
        }, 200);
    }
}

function handlePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const passwordToggle = document.getElementById("password-toggle");
    const passwordSecondInput = document.getElementById("password-second");
    const passwordSecondToggle = document.getElementById(
        "password-second-toggle"
    );

    if (passwordToggle.textContent.trim() === "visibility_off") {
        passwordToggle.textContent = "visibility";
        passwordInput.type = "text";
    } else {
        passwordToggle.textContent = "visibility_off";
        passwordInput.type = "password";
    }

    if (passwordSecondToggle.textContent.trim() === "visibility_off") {
        passwordSecondToggle.textContent = "visibility";
        passwordSecondInput.type = "text";
    } else {
        passwordSecondToggle.textContent = "visibility_off";
        passwordSecondInput.type = "password";
    }
}

function allowIntegerOnly(input) {
    input.value = input.value.replace(/[^0-9]/g, "");
}

function switchEventManagerSignup() {
    const mainWrapper = document.querySelector("#sign-up-main");
    const eventManagerWrapper = document.querySelector(
        "#sign-up-event-manager"
    );
    const attendeeWrapper = document.querySelector("#sign-up-attendee");

    mainWrapper.classList.remove("show-signup-wrapper");
    mainWrapper.classList.add("hide-signup-wrapper");

    attendeeWrapper.classList.remove("show-signup-wrapper");
    attendeeWrapper.classList.add("hide-signup-wrapper");

    mainWrapper.classList.remove("block");
    mainWrapper.classList.add("hidden");

    attendeeWrapper.classList.remove("block");
    attendeeWrapper.classList.add("hidden");

    eventManagerWrapper.classList.add("block");
    eventManagerWrapper.classList.remove("hidden");

    eventManagerWrapper.classList.add("show-signup-wrapper");
}

function switchAttendeeSignup() {
    const mainWrapper = document.querySelector("#sign-up-main");
    const eventManagerWrapper = document.querySelector(
        "#sign-up-event-manager"
    );
    const attendeeWrapper = document.querySelector("#sign-up-attendee");

    mainWrapper.classList.remove("show-signup-wrapper");
    mainWrapper.classList.add("hide-signup-wrapper");

    eventManagerWrapper.classList.remove("show-signup-wrapper");
    eventManagerWrapper.classList.add("hide-signup-wrapper");

    mainWrapper.classList.remove("block");
    mainWrapper.classList.add("hidden");

    eventManagerWrapper.classList.remove("block");
    eventManagerWrapper.classList.add("hidden");

    attendeeWrapper.classList.add("block");
    attendeeWrapper.classList.remove("hidden");

    attendeeWrapper.classList.add("show-signup-wrapper");
}

function handleAvatarImageSelect(avtarImageWrapper) {
    const displayImage = document.querySelector(".display-image-profile-image");
    const avtarImage = avtarImageWrapper.querySelector(
        ".profile-dp-avtar-image"
    );
    const allAvtarImages = document.querySelectorAll(".profile-dp-avtar-image");
    const upploadBtn = document.querySelector(".profile-dp-submit-btn");
    const cropBtn = document.querySelector(".profile-dp-crop-btn");

    // Convert to src To Base64
    const imageUrlToBase64 = async (url) => {
        const data = await fetch(url);
        const blob = await data.blob();
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = () => {
                const base64data = reader.result;
                resolve(base64data);
            };
            reader.onerror = reject;
        });
    };

    imageUrlToBase64(avtarImage.src).then((base64data) => {
        displayImage.src = base64data;
    });

    avtarImage.classList.add("selected-avtar");
    cropBtn.classList.add("hidden");
    upploadBtn.classList.remove("hidden");

    allAvtarImages.forEach((img) => {
        if (img !== avtarImage) {
            img.classList.remove("selected-avtar");
        }
    });
}

function handleCoverAvatarSelect(avtarImageWrapper) {
    const displayImage = document.querySelector(".cover-image-profile-page");
    const avtarImage = avtarImageWrapper.querySelector(
        ".cover-image-avtar-image"
    );
    const allAvtarImages = document.querySelectorAll(
        ".cover-image-avtar-image"
    );
    const upploadBtn = document.querySelector(".cover-image-submit-btn");
    const cropBtn = document.querySelector(".cover-image-crop-btn");

    // Convert to src To Base64
    const imageUrlToBase64 = async (url) => {
        const data = await fetch(url);
        const blob = await data.blob();
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = () => {
                const base64data = reader.result;
                resolve(base64data);
            };
            reader.onerror = reject;
        });
    };

    imageUrlToBase64(avtarImage.src).then((base64data) => {
        displayImage.src = base64data;
    });

    avtarImage.classList.add("selected-avtar");
    cropBtn.classList.add("hidden");
    upploadBtn.classList.remove("hidden");

    allAvtarImages.forEach((img) => {
        if (img !== avtarImage) {
            img.classList.remove("selected-avtar");
        }
    });
}

function handleProfileDpChange() {
    const inputImage = document.querySelector("#profile-dp-input-image");
    const displayImage = document.querySelector(".display-image-profile-image");
    let cropper;

    inputImage.click();

    inputImage.addEventListener("change", (event) => {
        const file = event.target.files[0];

        if (file) {
            const validImageTypes = ["image/jpeg", "image/png"];

            if (!validImageTypes.includes(file.type)) {
                alert("Please upload a valid image file (JPEG, PNG, or GIF).");
                inputImage.value = "";
                return;
            }

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                displayImage.src = reader.result;

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(displayImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                });

                const cropButton = document.querySelector(
                    ".profile-dp-crop-btn"
                );
                const upploadBtn = document.querySelector(
                    ".profile-dp-submit-btn"
                );

                upploadBtn.classList.add("hidden");
                cropButton.classList.remove("hidden");

                cropButton.addEventListener("click", () => {
                    const croppedCanvas = cropper.getCroppedCanvas();
                    const croppedImageDataUrl = croppedCanvas.toDataURL();
                    displayImage.src = croppedImageDataUrl;

                    cropper.destroy();
                    cropper = null;

                    cropButton.classList.add("hidden");
                    upploadBtn.classList.remove("hidden");
                });
            };
        }
    });
}

function handleCoverPictureChange() {
    const inputImage = document.querySelector("#cover-input-image");
    const displayImage = document.querySelector(".cover-image-profile-page");
    let cropper;

    inputImage.click();

    inputImage.addEventListener("change", (event) => {
        const file = event.target.files[0];

        if (file) {
            const validImageTypes = ["image/jpeg", "image/png"];

            if (!validImageTypes.includes(file.type)) {
                alert("Please upload a valid image file (JPEG, PNG, or GIF).");
                inputImage.value = "";
                return;
            }

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                displayImage.src = reader.result;

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(displayImage, {
                    aspectRatio: 2.74 / 1,
                    viewMode: 1,
                });

                const cropButton = document.querySelector(
                    ".cover-image-crop-btn"
                );
                const upploadBtn = document.querySelector(
                    ".cover-image-submit-btn"
                );

                upploadBtn.classList.add("hidden");
                cropButton.classList.remove("hidden");

                cropButton.addEventListener("click", () => {
                    const croppedCanvas = cropper.getCroppedCanvas();
                    const croppedImageDataUrl = croppedCanvas.toDataURL();
                    displayImage.src = croppedImageDataUrl;

                    cropper.destroy();
                    cropper = null;

                    cropButton.classList.add("hidden");
                    upploadBtn.classList.remove("hidden");
                });
            };
        }
    });
}

function handleSearchDropdown(input) {
    const mainWrapper = document.querySelector(".search-dropdown-main-wrapper");
    const innerWrapper = document.querySelector(".search-items-inner-wrapper");
    const noResults = innerWrapper.querySelector(".search-no-results");
    const results = innerWrapper.querySelector(".search-results");
    const searchTerm = input.value.toLowerCase().trim();

    // Remove previous results
    const trulyItems = [
        ...results.querySelectorAll(".search-dropdown-wrapper a"),
    ].filter((item) => !item.classList.contains("no-bottom-border"));
    trulyItems[trulyItems.length - 1].classList.remove("no-bottom-border");

    if (searchTerm === "") {
        noResults.classList.add("hidden");
        results.classList.add("hidden");
        return;
    } else {
        const searchItems = [
            ...results.querySelectorAll(".search-dropdown-wrapper a"),
        ];
        let hasResults = false;

        const searchChars = searchTerm.split("").filter((char) => char !== "");

        searchItems.forEach((item) => {
            const itemText = item.textContent.toLowerCase();
            const matches = searchChars.every((char) =>
                itemText.includes(char)
            );

            if (matches) {
                item.classList.remove("hidden");
                hasResults = true;

                item.addEventListener("click", () => {
                    input.value = item.textContent;
                    results.classList.add("hidden");
                });
            } else {
                item.classList.add("hidden");
            }
        });

        if (hasResults) {
            noResults.classList.add("hidden");
            results.classList.remove("hidden");
            const trulyItems = [
                ...results.querySelectorAll(".search-dropdown-wrapper a"),
            ].filter((item) => !item.classList.contains("hidden"));
            trulyItems[trulyItems.length - 1].classList.add("no-bottom-border");
        } else {
            noResults.classList.remove("hidden");
            results.classList.add("hidden");
        }
    }

    document.addEventListener("click", (event) => {
        if (
            !mainWrapper.contains(event.target) &&
            !innerWrapper.contains(event.target)
        ) {
            noResults.classList.add("hidden");
            results.classList.add("hidden");
        }
    });
}

// 30-10-2024

function setImagePreview() {
    const wrappers = document.querySelectorAll(".choose-image-wrapper");

    wrappers.forEach((wrapper) => {
        const prevImg = wrapper.querySelector(".prev-img");
        const uploadBtn = wrapper.querySelector(".upload-btn");
        const inputImg = wrapper.querySelector(".input-img");
        const errorText = wrapper.querySelector(".error-text");

        console.log(inputImg);

        uploadBtn.addEventListener("click", () => {
            inputImg.click();

            inputImg.addEventListener("change", (event) => {
                const file = event.target.files[0];
                if (file) {
                    const validImageTypes = ["image/jpeg", "image/png"];
                    if (!validImageTypes.includes(file.type)) {
                        errorText.textContent =
                            "Invalid file type. Please upload a JPEG or PNG file.";
                        inputImg.value = "";
                        return;
                    }
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        prevImg.src = reader.result;
                        errorText.textContent = "";
                    };
                }
            });
        });
    });
}

// 30-10-2024

function showCheckoutModel() {
    const checkoutModal = document.getElementById("checkout-modal");
    const body = document.body;
    checkoutModal.classList.add("show-modal");
    body.classList.add("overflow-hidden");

    document.addEventListener("click", (event) => {
        if (event.target === checkoutModal) {
            closeModal();
        }
    });
}

function closeModal() {
    const checkoutModal = document.getElementById("checkout-modal");
    const body = document.body;
    checkoutModal.classList.remove("show-modal");
    body.classList.remove("overflow-hidden");
}

// 11-11-2024
function copyShareLink() {
    const linkWrappers = document.querySelectorAll(".share-current-link");
    linkWrappers.forEach((wrapper) => {
        const linkButton = wrapper.querySelector(".share-current-link-btn");
        const linkInput = wrapper.querySelector(".share-link-input");
        const currentURL = window.location.href;

        linkInput.value = currentURL;
        linkButton.addEventListener("click", () => {
            navigator.clipboard
                .writeText(currentURL)
                .then(function () {
                    setTimeout(() => {
                        linkInput.select();
                    }, 300);
                })
                .catch(function (err) {
                    console.error("Failed to copy text: ", err);
                });
        });
    });
}

function closeShareModal(button) {
    const shareModal = document.querySelector(".share-modal");
    shareModal.classList.remove("show");
}

// 12-11-2024
function openShareModal() {
    const shareModal = document.querySelector(".share-modal");
    // Call copyShareLink fun to get the card share link
    shareModal.classList.add("show");

    // Remove Share Modal If Clicked Outside

    document.addEventListener("click", (event) => {
        if (event.target === shareModal) {
            shareModal.classList.remove("show");
        }
    });
}
// 12-11-2024

// 12-11-2024
function handleTicketCardMenu(wrapper) {
    const menuWrapper = wrapper.querySelector(".menu-wrapper");
    const mainMenuWrapper = menuWrapper.querySelector(".main-menu-wrapper");
    const editMenuBtn = menuWrapper.querySelector(".edit-menu-btn");
    const editMenuWrapper = menuWrapper.querySelector(".edit-menu-wrapper");
    const backBtn = menuWrapper.querySelector(".cards-menu-back-btn");

    mainMenuWrapper.classList.add("show");

    editMenuBtn.addEventListener("click", () => {
        editMenuWrapper.classList.add("show");

        backBtn.removeEventListener("click", closeEditMenu);
        backBtn.addEventListener("click", closeEditMenu);

        function closeEditMenu() {
            editMenuWrapper.classList.remove("show");
        }
    });

    // Event listener to close the menu if clicked outside
    document.addEventListener("click", (event) => {
        if (
            !mainMenuWrapper.contains(event.target) &&
            !wrapper.contains(event.target)
        ) {
            mainMenuWrapper.classList.remove("show");
        }
        if (
            !editMenuWrapper.contains(event.target) &&
            !wrapper.contains(event.target)
        ) {
            editMenuWrapper.classList.remove("show");
        }
    });
}
// 12-11-2024

// 15-11-2024
function showCheckoutModel() {
    const checkoutModal = document.getElementById("checkout-modal");
    const body = document.body;
    checkoutModal.classList.add("show-modal");
    body.classList.add("overflow-hidden");

    document.addEventListener("click", (event) => {
        if (event.target === checkoutModal) {
            closeModal();
        }
    });
}
// 15-11-2024

// 12-12-2024
function customDocUpload() {
    const uploadWrappers = document.querySelectorAll(
        ".custom-doc-upload-wrapper"
    );
    uploadWrappers.forEach((wrapper) => {
        const uploadBtn = wrapper.querySelector(".custom-doc-upload-btn");
        const showFileBtn = wrapper.querySelector(".custom-doc-show-file-btn");
        const showFileBtnText = showFileBtn.querySelector("span");
        const input = wrapper.querySelector("input");

        uploadBtn.addEventListener("click", () => {
            input.click();
        });

        input.addEventListener("change", () => {
            const file = input.files[0];

            if (!file) return;

            // Check if the file is PDF, JPG, PNG
            const validFileTypes = ["application/pdf", "image/jpeg"];

            if (!validFileTypes.includes(file.type)) {
                input.value = "";
                showFileBtn.classList.add("hidden");
                showFileBtnText.textContent = "";
                alert("Please select a valid file type (PDF, or JPG).");
            } else {
                const fileName = file.name;
                showFileBtnText.textContent = fileName;
                showFileBtn.classList.remove("hidden");
            }
        });

        showFileBtn.addEventListener("click", () => {
            input.value = "";
            showFileBtn.classList.add("hidden");
            showFileBtnText.textContent = "";
        });
    });
}

function populateTimeSelect(
    selectElement,
    selectedStartTime = null,
    selectedEndTime = null
) {
    const startTime = 0; // 12:00 AM (midnight)
    const endTime = 23.5; // 11:30 PM
    const timeInterval = 0.5; // 30 minutes

    // Loop through the time range, adding 30-minute intervals
    for (let time = startTime; time <= endTime; time += timeInterval) {
        // Format the time as AM/PM
        let hours = Math.floor(time);
        let minutes = time % 1 === 0 ? "00" : "30";
        let period = hours < 12 ? "AM" : "PM";

        // Adjust 12:00 AM/PM formatting
        if (hours === 0) {
            hours = 12; // 12:00 AM
        } else if (hours > 12) {
            hours -= 12; // Convert to 12-hour format
        }
        const timeString = `${hours}:${minutes} ${period}`;

        // Create a new option element
        const option = document.createElement("option");
        option.value = timeString;
        option.textContent = timeString;

        // Check if the selected time is already selected in the select element and set it as selected
        if (
            (selectedStartTime && timeString === selectedStartTime) ||
            (selectedEndTime && timeString === selectedEndTime)
        ) {
            option.selected = true;
        }

        selectElement.appendChild(option);
    }
}

function handleInitialStartEndTime() {
    const start = document.querySelectorAll(".event-start-time");
    const end = document.querySelectorAll(".event-end-time");

    start.forEach((item) => {
        populateTimeSelect(item, "10:00 AM", null);
    });

    end.forEach((item) => {
        populateTimeSelect(item, null, "5:30 PM");
    });
}

document.addEventListener("DOMContentLoaded", () => {
    handleInitialStartEndTime();
    customDocUpload();
    setImagePreview();
    // handleMultipleTicketMenu();
    // tabMenu();
});

function handleFaq() {
    const accordionHeaders = document.querySelectorAll(".faq-question-wrapper");

    accordionHeaders.forEach((header) => {
        // Add click event listener to each accordion header
        header.addEventListener("click", function () {
            // Toggle the visibility of the content associated with the clicked header
            const content = this.nextElementSibling;
            const headerIcon = header.querySelector(
                ".faq-expand-collapse-icon"
            );

            // Toggle the current item's content and icon
            if (!content.classList.contains("hide-faq-answer")) {
                content.classList.add("hide-faq-answer");
                handleIconReplace(headerIcon, "fa-minus", "fa-plus");
            } else {
                content.classList.remove("hide-faq-answer");
                handleIconReplace(headerIcon, "fa-plus", "fa-minus");
            }

            // Close all other top-level accordion items except the current one
            const allItems = document.querySelectorAll(".faq-item");
            allItems.forEach((item) => {
                const itemHeader = item.querySelector(".faq-question-wrapper");
                const itemContent = item.querySelector(".faq-answer-wrapper");
                const itemIcon = item.querySelector(
                    ".faq-expand-collapse-icon"
                );

                // Close all top-level items, except the current one (its parent or clicked item)
                if (item !== this.closest(".faq-item")) {
                    itemContent.classList.add("hide-faq-answer");
                    handleIconReplace(itemIcon, "fa-minus", "fa-plus");
                }
            });

            // Ensure that the parent item remains open (if any)
            let parent =
                this.closest(".faq-item").parentElement.closest(".faq-item");

            while (parent) {
                const parentHeader = parent.querySelector(
                    ".faq-question-wrapper"
                );
                const parentContent = parent.querySelector(
                    ".faq-answer-wrapper"
                );
                const parentIcon = parent.querySelector(
                    ".faq-expand-collapse-icon"
                );

                // Make sure the parent remains open with the correct icon
                parentContent.classList.remove("hide-faq-answer");
                handleIconReplace(parentIcon, "fa-plus", "fa-minus");
                parent = parent.parentElement.closest(".faq-item");
            }
        });
    });

    function handleIconReplace(element, currentClass, newClass) {
        // Check if the element has the current class
        if (element.classList.contains(currentClass)) {
            element.classList.remove(currentClass);
            element.classList.add(newClass);
        }
    }
}

// 12-12-2024

/* 04-04-2025 */

function toggleAmenities(wrapperClass) {
    const wrapper = document.querySelector(wrapperClass);
    if (!wrapper) return;

    wrapper.addEventListener("click", (e) => {
        const item = e.target.closest(".item");
        const deleteIcon = e.target.closest(".delete-icon");

        if (item && !deleteIcon) {
            const checkbox = item.querySelector(".amenities-checkbox");
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                item.classList.toggle("selected", checkbox.checked);
            }
        }
    });
}

function handleCustomAmenities(topWrapperClass, wrapperClass) {
    const topWrapper = document.querySelector(topWrapperClass);
    const wrapper = document.querySelector(wrapperClass);
    if (!wrapper || !topWrapper) return;

    const elements = {
        iconImg: wrapper.querySelector(".display-icon"),
        input: wrapper.querySelector("input[type=file].custom-amenities-input"),
        amenitiesText: wrapper.querySelector(".custom-amenities-text"),
        amenitiesBtn: wrapper.querySelector(".custom-amenities-btn"),
        imgErrorMessage: wrapper.querySelector(".error-text.img-error"),
        labelErrorMessage: wrapper.querySelector(".error-text.label-error"),
        personalizedAmenitiesWrapper: topWrapper.querySelector(
            ".personalized-amenities-wrapper"
        ),
    };

    elements.itemMainWrapper =
        elements.personalizedAmenitiesWrapper?.querySelector(
            ".amenities-icon-wrapper"
        );
    elements.defaultIconImage = elements.iconImg?.src;
    let selectedFile = null;

    if (!elements.itemMainWrapper) return;

    const VALID_IMAGE_TYPES = ["image/jpeg", "image/png", "image/svg+xml"];
    const ERROR_MESSAGES = {
        invalidType:
            "Invalid file type. Please upload a JPEG, PNG, or SVG image.",
        emptyLabel: "Amenities label cannot be empty",
        noImage: "Please select an image",
    };

    const handleFileChange = () => {
        const file = elements.input.files[0];
        if (!file) return;

        if (!VALID_IMAGE_TYPES.includes(file.type)) {
            elements.input.value = "";
            elements.imgErrorMessage.textContent = ERROR_MESSAGES.invalidType;
            return;
        }

        selectedFile = file;
        const reader = new FileReader();
        reader.onload = (event) => (elements.iconImg.src = event.target.result);
        reader.readAsDataURL(file);
        elements.imgErrorMessage.textContent = "";
    };

    const createAmenityItem = () => {
        const itemWrapper = document.createElement("div");
        itemWrapper.classList.add("item");

        const amenityName = elements.amenitiesText.value.trim();

        itemWrapper.innerHTML = `
            <input class="hidden" type="file" name="amenity_images[]">
            <input type="checkbox" name="custom_amenities[]" value="${amenityName}" class="hidden amenities-checkbox" checked>
            <button class="amenities-btn" type="button" title="${amenityName}">
                <img class="amenities-icon" src="${elements.iconImg.src}" 
                    alt="${amenityName}" draggable="false">
                <p>${amenityName}</p>
                <i class="delete-icon">x</i>
            </button>
        `;

        const fileInput = itemWrapper.querySelector('input[type="file"]');
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(selectedFile);
        fileInput.files = dataTransfer.files;

        const deleteButton = itemWrapper.querySelector(".delete-icon");
        deleteButton.addEventListener("click", (e) => {
            e.stopPropagation();
            itemWrapper.remove();

            if (elements.itemMainWrapper.children.length === 0) {
                elements.personalizedAmenitiesWrapper?.classList.add("hidden");
            }
        });

        itemWrapper.addEventListener("click", (e) => {
            if (!e.target.closest(".delete-icon")) {
                const checkbox = itemWrapper.querySelector(
                    ".amenities-checkbox"
                );
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    itemWrapper.classList.toggle("selected", checkbox.checked);
                }
            }
        });

        return itemWrapper;
    };

    const handleAmenitiesClick = () => {
        let hasError = false;

        if (!elements.amenitiesText.value.trim()) {
            elements.labelErrorMessage.textContent = ERROR_MESSAGES.emptyLabel;
            hasError = true;
        } else {
            elements.labelErrorMessage.textContent = "";
        }

        if (!elements.input.value) {
            elements.imgErrorMessage.textContent = ERROR_MESSAGES.noImage;
            hasError = true;
        }

        if (hasError) return;

        elements.personalizedAmenitiesWrapper?.classList.remove("hidden");
        const newItem = createAmenityItem();
        elements.itemMainWrapper.appendChild(newItem);

        elements.input.value = "";
        elements.amenitiesText.value = "";
        elements.iconImg.src = elements.defaultIconImage;
    };

    elements.input.addEventListener("change", handleFileChange);
    elements.amenitiesBtn.addEventListener("click", handleAmenitiesClick);
}

document.addEventListener("DOMContentLoaded", () => {
    toggleAmenities(".amenities-icon-wrapper");
    handleCustomAmenities(
        ".add-ticket-paid-items.default",
        ".custom-amenities-wrapper"
    );
});

/* 04-04-2025 */

function initializeTableNumberInputs() {
    const tableInputs = document.querySelectorAll(".no-of-table, .no-of-seats");

    tableInputs.forEach((input) => {
        const min = parseInt(input.getAttribute("min")) || 1;
        const max = parseInt(input.getAttribute("max")) || 999999;

        input.addEventListener("input", function () {
            let cleaned = this.value.replace(/\D/g, "");

            if (cleaned) {
                let num = parseInt(cleaned);
                if (num < min) num = min;
                if (num > max) num = max;
                this.value = num;
            } else {
                this.value = "";
            }
        });

        input.addEventListener("paste", function (e) {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData(
                "text"
            );
            const cleaned = pasteData.replace(/\D/g, "");
            if (cleaned) {
                let num = parseInt(cleaned);
                if (num < min) num = min;
                if (num > max) num = max;
                this.value = num;
            }
        });

        input.addEventListener("blur", function () {
            let value = parseInt(this.value);
            if (isNaN(value) || value < min) this.value = min;
            else if (value > max) this.value = max;
        });
    });
}

initializeTableNumberInputs();