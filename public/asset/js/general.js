function handleDetailsMenu(event, menuItem) {
    const dropdownDetails = menuItem.querySelector(".dropdown-details");
    const isDropdownVisible = !dropdownDetails.classList.contains("hidden");

    // Toggle dropdown visibility
    dropdownDetails.classList.toggle("hidden");

    // Stop the click event from propagating to the document
    event.stopPropagation();

    // Add a click event listener to the document
    document.addEventListener(
        "click",
        function handleClickOutside(event) {
            const targetElement = event.target;

            // If the click is outside the dropdown and menu item
            if (
                !menuItem.contains(targetElement) &&
                !dropdownDetails.contains(targetElement)
            ) {
                dropdownDetails.classList.add("hidden");
            }
        },
        { once: true }
    ); // Use { once: true } to automatically remove the event listener after the first click
}

function handleHamburgerClickAction(humburger) {
    const hamburgerIcon = humburger.querySelector("i");
    const navListMenu = document.getElementById("nav-list-menu");

    if (navListMenu.classList.contains("hidden")) {
        navListMenu.classList.remove("hidden");
        navListMenu.classList.add("flex");

        hamburgerIcon.classList.remove("fa-bars");
        hamburgerIcon.classList.add("fa-xmark");
        hamburgerIcon.classList.add("border");
    } else {
        navListMenu.classList.remove("flex");
        navListMenu.classList.add("hidden");

        hamburgerIcon.classList.remove("fa-xmark");
        hamburgerIcon.classList.add("fa-bars");
        hamburgerIcon.classList.remove("border");
    }
}

// 13-11-2024
function handleInputSearch() {
    const searchWrappers = document.querySelectorAll(".search-wrapper");

    searchWrappers.forEach((wrapper) => {
        const searchInput = wrapper.querySelector(".search-input");
        const dropdownItemsWrapper = wrapper.querySelector(
            ".dropdown-items-wrapper"
        );
        const dropdownItems =
            dropdownItemsWrapper.querySelectorAll(".dropdown-item");

        searchInput.addEventListener("input", () => {
            dropdownItems.forEach((dropdownItem) => {
                const itemName = dropdownItem.textContent.toLowerCase();
                const query = searchInput.value.trim().toLowerCase();

                if (itemName.includes(query)) {
                    dropdownItem.classList.remove("hidden");
                } else {
                    dropdownItem.classList.add("hidden");
                }
            });
        });
    });
}

function handleDropdownClick() {
    const searchWrappers = document.querySelectorAll(".search-wrapper");

    searchWrappers.forEach((wrapper) => {
        const searchInput = wrapper.querySelector(".search-input");
        const dropdownItemsWrapper = wrapper.querySelector(
            ".dropdown-items-wrapper"
        );

        searchInput.addEventListener("click", () => {
            dropdownItemsWrapper.classList.remove("hidden");
        });

        // Hide dropdown when clicking outside
        document.addEventListener("click", (event) => {
            if (!wrapper.contains(event.target)) {
                dropdownItemsWrapper.classList.add("hidden");
            }
        });
    });
}

function handleDropdownSelect() {
    const searchWrappers = document.querySelectorAll(".search-wrapper");

    searchWrappers.forEach((wrapper) => {
        const searchInput = wrapper.querySelector(".search-input");
        const dropdownItemsWrapper = wrapper.querySelector(
            ".dropdown-items-wrapper"
        );
        const dropdownItems =
            dropdownItemsWrapper.querySelectorAll(".dropdown-item");

        dropdownItems.forEach((item) => {
            item.addEventListener("click", () => {
                const itemText = item.textContent.trim();
                searchInput.value = itemText;
                dropdownItemsWrapper.classList.add("hidden");
            });
        });
    });
}

function handleClearFiler() {
    const allInputs = document.querySelectorAll(".filter-input");

    allInputs.forEach((input) => {
        input.value = "";
    });
}

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

function allowOnlyNumbers(event) {
    const value = event.value.replace(/[^0-9]/g, "");
    event.value = value;

    if (value && Number(value) < 1) {
        event.value = "1";
    }
}

function handleCustomNumberInput() {
    const inputNumberWrappers = document.querySelectorAll(
        ".input-number-wrapper"
    );

    inputNumberWrappers.forEach((wrapper) => {
        const input = wrapper.querySelector(".input-number");
        const buttonWrapper = wrapper.querySelector(
            ".input-number-buttons-wrapper"
        );
        const incrementBtn = buttonWrapper.querySelector(".input-number-increment");
        const decrementBtn = buttonWrapper.querySelector(".input-number-decrement");

        incrementBtn.addEventListener("click", () => {
            const currentValue = parseInt(input.value);
            input.value = currentValue + 1;
        });

        decrementBtn.addEventListener("click", () => {
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });
}

// 30-10-2024
function handleFaq() {
    const accordionHeaders = document.querySelectorAll(".faq-question-wrapper");

    accordionHeaders.forEach((header) => {
        // Add click event listener to each accordion header
        header.addEventListener("click", function () {
            // Toggle the visibility of the content associated with the clicked header
            const content = this.nextElementSibling;
            const headerIcon = header.querySelector(".faq-expand-collapse-icon");

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
                const itemIcon = item.querySelector(".faq-expand-collapse-icon");

                // Close all top-level items, except the current one (its parent or clicked item)
                if (item !== this.closest(".faq-item")) {
                    itemContent.classList.add("hide-faq-answer");
                    handleIconReplace(itemIcon, "fa-minus", "fa-plus");
                }
            });

            // Ensure that the parent item remains open (if any)
            let parent = this.closest(".faq-item").parentElement.closest(".faq-item");

            while (parent) {
                const parentHeader = parent.querySelector(".faq-question-wrapper");
                const parentContent = parent.querySelector(".faq-answer-wrapper");
                const parentIcon = parent.querySelector(".faq-expand-collapse-icon");

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


// 30-10-2024

// 09-11-2024

function handlePackageWrapper() {
    const selectPackageWrapper = document.querySelector(
        ".select-package-wrapper"
    );
    const selectBox = selectPackageWrapper.querySelector(
        ".ticket-package-select-box"
    );
    const ticketNumberWrapper = selectPackageWrapper.querySelector(
        ".ticket-count-wrapper"
    );
    const ticketCountInput = ticketNumberWrapper.querySelector(
        ".ticket-count-input"
    );
    const ticketCountbtns =
        ticketNumberWrapper.querySelectorAll(".ticket-count-btn");
    const ticketCountIncrement = ticketNumberWrapper.querySelector(
        ".ticket-count-increment"
    );
    const ticketCountDecrement = ticketNumberWrapper.querySelector(
        ".ticket-count-decrement"
    );

    selectBox.addEventListener("change", () => {
        alert(selectBox.value);
    });

    // Handle Ticket Number
    console.log(parseInt(ticketCountInput.value, 10));
    ticketCountbtns.forEach((countBtn) => {
        countBtn.addEventListener("click", () => {
            const currentValue = parseInt(ticketCountInput.value, 10); // Ensures base-10 conversion

            function changeTicketCountOnBtnClick(value) {
                if (countBtn.classList.contains("ticket-count-increment")) {
                    ticketCountInput.value = value + 1;
                } else if (countBtn.classList.contains("ticket-count-decrement")) {
                    if (value === 0) {
                        ticketCountInput.value = 0;
                    } else if (value > 0) {
                        ticketCountInput.value = value - 1;
                    }
                }
            }

            if (!isNaN(currentValue)) {
                // Check if currentValue is a valid number
                changeTicketCountOnBtnClick(currentValue);
            } else {
                changeTicketCountOnBtnClick(0); // Start with 0 if invalid number
            }
        });
    });

    // Handle Ticket Quantity Disabled When Ticket Package Not Selected or Ticket Quantity is Zero

    selectBox.addEventListener("change", () => {
        if (selectBox.value === "") {
            ticketNumberWrapper.classList.add("opacity-50", "select-none");
            ticketCountInput.value = 0;
            ticketCountbtns.forEach((btn) => {
                btn.disabled = true;
            });
        } else {
            ticketNumberWrapper.classList.remove("opacity-50", "select-none");
            ticketCountbtns.forEach((btn) => {
                btn.disabled = false;
            });
        }
    });
}

// 12-11-2024
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

