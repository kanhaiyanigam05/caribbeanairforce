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

function handleDetailsMenu(event, menuItem) {
    const dropdownDetails = menuItem.querySelector(".dropdown-details");
    const isDropdownVisible = !dropdownDetails.classList.contains("hidden");

    // Close all open dropdowns first
    const allDropdowns = document.querySelectorAll(".dropdown-details");
    allDropdowns.forEach((dropdown) => {
        if (!dropdown.classList.contains("hidden")) {
            dropdown.classList.add("hidden");
        }
    });

    // Toggle the visibility of the clicked dropdown
    if (!isDropdownVisible) {
        dropdownDetails.classList.remove("hidden");
    }

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
        { once: true } // Use { once: true } to automatically remove the event listener after the first click
    );
}

/*const scrollTopBtn = document.getElementById("scrollTopBtn");
const offset = 100; // Adjust this value as needed

function handleScroll() {
    if (window.scrollY > offset) {
        scrollTopBtn.classList.remove("hidden");
        scrollTopBtn.classList.add("fixed");
    } else {
        scrollTopBtn.classList.add("hidden");
        scrollTopBtn.classList.remove("fixed");
    }
}

document.addEventListener("scroll", handleScroll);

// Scroll to top when the button is clicked
scrollTopBtn.addEventListener("click", function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});*/

class SearchDropdown {
    constructor(wrapper, dropdownInput, dropdownToggle, dropdownWrapper) {
        this.wrapper = wrapper;
        this.dropdownInput = dropdownInput;
        this.toggleButton = dropdownToggle;
        this.dropdownWrapper = dropdownWrapper;

        this.noResults = dropdownWrapper.querySelector(".search-no-results");
        this.results = dropdownWrapper.querySelector(".search-results");
        this.searchItems = [
            ...dropdownWrapper.querySelectorAll(".search-results button"),
        ];

        // Bind events
        this.dropdownInput.addEventListener(
            "input",
            this.handleSearchDropdown.bind(this)
        );
        this.dropdownWrapper.addEventListener(
            "click",
            this.handleSearchResultSelection.bind(this)
        );
        document.addEventListener(
            "click",
            this.closeDropdownOnOutsideClick.bind(this)
        );
        this.toggleButton.addEventListener(
            "click",
            this.toggleDropdownVisibility.bind(this)
        );
    }

    // Handle search term input and filter results
    handleSearchDropdown(event) {
        const searchTerm = event.target.value.toLowerCase().trim();
        this.clearPreviousResults();

        if (!searchTerm) {
            this.dropdownWrapper.classList.add("hidden");
            return;
        }

        this.dropdownWrapper.classList.remove("hidden");
        const filteredItems = this.filterSearchResults(searchTerm);
        this.displaySearchResults(filteredItems);
    }

    // Clears previous search results and hides them
    clearPreviousResults() {
        this.searchItems.forEach((item) =>
            item.classList.remove("no-bottom-border", "hidden")
        );
        this.noResults.classList.add("hidden");
        this.results.classList.add("hidden");
    }

    // Filters the search results based on the search term
    filterSearchResults(searchTerm) {
        return this.searchItems.filter((item) =>
            item.textContent.toLowerCase().includes(searchTerm)
        );
    }

    // Displays filtered results or shows the 'no results' message
    displaySearchResults(filteredItems) {
        if (filteredItems.length > 0) {
            this.results.classList.remove("hidden");
            this.noResults.classList.add("hidden");

            this.searchItems.forEach((item) => {
                if (filteredItems.includes(item)) {
                    item.classList.remove("hidden"); // Show the item if it matches
                } else {
                    item.classList.add("hidden"); // Hide the item if it doesn't match
                }
            });

            filteredItems.forEach((item, index) => {
                if (index === filteredItems.length - 1) {
                    item.classList.add("no-bottom-border");
                }
            });
        } else {
            // Show 'No results' message if no matches found
            this.results.classList.add("hidden");
            this.noResults.classList.remove("hidden");
        }
    }

    // Toggle dropdown visibility on button click
    toggleDropdownVisibility(event) {
        if (this.results.classList.contains("hidden")) {
            this.dropdownWrapper.classList.remove("hidden");
            this.results.classList.remove("hidden");
            this.noResults.classList.add("hidden");
            this.searchItems.forEach((item) => item.classList.remove("hidden"));
        } else {
            this.dropdownWrapper.classList.add("hidden");
            this.results.classList.add("hidden");
        }

        event.stopPropagation();
    }

    // Handle selection from search results
    handleSearchResultSelection(event) {
        if (event.target.tagName.toLowerCase() === "button") {
            this.dropdownInput.value = event.target.value;
            this.results.classList.add("hidden");
            this.dropdownWrapper.classList.add("hidden");
        }
    }

    // Close the dropdown if the click is outside
    closeDropdownOnOutsideClick(event) {
        if (
            !this.dropdownWrapper.contains(event.target) &&
            event.target !== this.dropdownInput
        ) {
            this.noResults.classList.add("hidden");
            this.results.classList.add("hidden");
            this.dropdownWrapper.classList.add("hidden");
        }
    }
}

// Initialize the search dropdown functionality
const searchDropdowns = document.querySelectorAll(".search-wrapper");

searchDropdowns.forEach((wrapper) => {
    const dropdownInput = wrapper.querySelector(".recipients");
    const dropdownToggle = wrapper.querySelector(".dropdown-toggle");
    const dropdownWrapper = wrapper.querySelector(".search-dropdown");
    new SearchDropdown(wrapper, dropdownInput, dropdownToggle, dropdownWrapper);
});

function handleTemplateCardSelection() {
    const cards = document.querySelectorAll(
        ".template-slider .template-card-item"
    );

    cards.forEach((card) => {
        const checkboxBtn = card.querySelector(".checkbox-btn");
        const checkbox = checkboxBtn.querySelector(".checkbox-input");
        const cardThumb = card.querySelector(".card-item-img");

        card.addEventListener("click", () => {
            // Deselect all other cards
            cards.forEach((otherCard) => {
                if (otherCard !== card) {
                    const otherCheckboxBtn =
                        otherCard.querySelector(".checkbox-btn");
                    const otherCheckbox =
                        otherCheckboxBtn.querySelector(".checkbox-input");
                    const otherCardThumb =
                        otherCard.querySelector(".card-item-img");

                    if (otherCheckbox.checked) {
                        otherCheckboxBtn.classList.replace(
                            "fa-check",
                            "fa-circle-notch"
                        );
                        otherCardThumb.classList.remove("brightness-0-75");
                        otherCheckbox.checked = false;
                    }
                }
            });

            // Toggle the selected card's state
            if (checkbox.checked) {
                checkboxBtn.classList.replace("fa-check", "fa-circle-notch");
                cardThumb.classList.remove("brightness-0-75");
                checkbox.checked = false;
            } else {
                checkboxBtn.classList.replace("fa-circle-notch", "fa-check");
                cardThumb.classList.add("brightness-0-75");
                checkbox.checked = true;
            }
        });
    });
}

// Handle Modal Functionality
function showModal() {
    const showModalBtns = document.querySelectorAll(".show-modal-btn");

    showModalBtns.forEach((showModalBtn) => {
        const modalTarget = showModalBtn.getAttribute("data-target");
        const modal = document.querySelector(modalTarget);

        // Check if the modal exists and contains the class 'modal'
        if (!modal || !modal.classList.contains("modal")) {
            console.warn(`No valid modal found for target: ${modalTarget}`);
            return;
        }

        showModalBtn.addEventListener("click", () => {
            // Show the modal
            modal.classList.replace("hidden", "flex");

            // Add animation for showing the modal
            setTimeout(() => {
                modal.classList.replace("hide", "show");
            }, 350);
        });
    });
}

function closeModal() {
    const allModals = document.querySelectorAll(".modal");
    allModals.forEach((modal) => {
        const closeModalBtn = modal.querySelector(".close-btn");
        closeModalBtn.addEventListener("click", () => {
            modal.classList.replace("show", "hide");
            setTimeout(() => {
                modal.classList.replace("flex", "hidden");
            }, 350);
        });
    });
}

function showUploadThumbModal() {
    const wrappers = document.querySelectorAll(".base-template-item");

    wrappers.forEach((wrapper) => {
        const uploadThumbBtn = wrapper.querySelector(".upload-thumb-modal-btn");
        const uploadThumbModal = document.querySelector("#upload-thumb-modal");

        uploadThumbBtn.addEventListener("click", () => {
            uploadThumbModal.classList.replace("hidden", "flex");
            setTimeout(() => {
                uploadThumbModal.classList.replace("hide", "show");
            }, 350);
        });
    });
}

function closeUploadThumbModal() {
    const uploadThumbModal = document.querySelector("#upload-thumb-modal");
    const closeUploadThumbBtn = uploadThumbModal.querySelector(".close-btn");

    closeUploadThumbBtn.addEventListener("click", () => {
        uploadThumbModal.classList.replace("show", "hide");
        setTimeout(() => {
            uploadThumbModal.classList.replace("flex", "hidden");
        }, 350);
    });
}

function deleteTemplateShowModal() {
    const deleteTemplateBtns = document.querySelectorAll(
        ".delete-template-modal-btn"
    );
    const deleteTemplateModal = document.querySelector(
        "#delete-template-modal"
    );

    deleteTemplateBtns.forEach((deleteTemplateBtn) => {
        deleteTemplateBtn.addEventListener("click", () => {
            deleteTemplateModal.classList.replace("hidden", "flex");
            setTimeout(() => {
                deleteTemplateModal.classList.replace("hide", "show");
            }, 350);
        });
    });
}

function closeDeleteTemplateModal() {
    const deleteTemplateModal = document.querySelector(
        "#delete-template-modal"
    );
    const closeDeleteTemplateBtn =
        deleteTemplateModal.querySelector(".close-btn");

    closeDeleteTemplateBtn.addEventListener("click", () => {
        deleteTemplateModal.classList.replace("show", "hide");
        setTimeout(() => {
            deleteTemplateModal.classList.replace("flex", "hidden");
        }, 350);
    });
}

function handleDropdown() {
    const wrappers = document.querySelectorAll(".dropdown-wrapper");

    wrappers.forEach((wrapper) => {
        const dropdown = wrapper.querySelector(".dropdown");
        const dropdownBody = wrapper.querySelector(".dropdown-body");

        dropdown.addEventListener("click", () => {
            dropdownBody.classList.toggle("hidden");
        });
    });
}

function customDropdown() {
    const dropdownWrappers = document.querySelectorAll(".custom-dropdown");

    dropdownWrappers.forEach((wrapper) => {
        const dropdownInput = wrapper.querySelector(".dropdown-input");
        const dropdownInputText = dropdownInput.querySelector(".text");
        const dropdownInputIcon = dropdownInput.querySelector(".icon");
        const dropdownBody = wrapper.querySelector(".dropdown-body");
        let dropdownValue = wrapper.querySelector(".dropdown-input-value");
        const dropdownItems = dropdownBody.querySelectorAll(
            ".body-item.available"
        );

        function updateValue(value) {
            if (dropdownValue) {
                dropdownValue.value = value;
            } else {
                dropdownValue = document.createElement("input");
                dropdownValue.classList.add("dropdown-input-value", "hidden");
                dropdownValue.value = value;
                dropdownValue.setAttribute(
                    "name",
                    dropdownInput.getAttribute("name")
                );
                wrapper.append(dropdownValue);
            }
        }

        const initialValue =
            dropdownInput.value || dropdownInputText.textContent;
        if (initialValue) {
            dropdownItems.forEach((item) => {
                const itemText = item.querySelector(".text").textContent;
                if (itemText === initialValue) {
                    item.querySelector(".fa-check").classList.remove("hidden");
                    dropdownInputText.textContent = itemText;
                    dropdownInput.value = itemText;
                    updateValue(itemText);
                }
            });
        }

        dropdownInput.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdownBody.classList.toggle("hidden");
            dropdownInputIcon.classList.toggle("rotate-180");
        });

        dropdownItems.forEach((item) => {
            item.addEventListener("click", () => {
                const selectedText = item.querySelector(".text").textContent;
                dropdownInputText.textContent = selectedText;
                dropdownInput.value = selectedText;
                updateValue(selectedText);

                dropdownItems.forEach((i) =>
                    i.querySelector(".fa-check").classList.add("hidden")
                );
                item.querySelector(".fa-check").classList.remove("hidden");

                dropdownBody.classList.add("hidden");
                dropdownInputIcon.classList.add("rotate-180");
            });
        });
    });

    document.addEventListener("click", (e) => {
        const isClickInsideDropdown = Array.from(dropdownWrappers).some(
            (wrapper) => wrapper.contains(e.target)
        );

        if (!isClickInsideDropdown) {
            dropdownWrappers.forEach((wrapper) => {
                const dropdownBody = wrapper.querySelector(".dropdown-body");
                const dropdownInputIcon = wrapper.querySelector(".icon");
                dropdownBody.classList.add("hidden");
                dropdownInputIcon.classList.add("rotate-180");
            });
        }
    });
}
