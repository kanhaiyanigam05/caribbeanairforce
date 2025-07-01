var fulleventdata = null;
var bookedslotdata = null;
var userdetail = null;

function fancyDateFormat(dateString) {
    const date = new Date(dateString);

    const day = date.getUTCDate();
    const month = date.toLocaleString("default", { month: "short" });
    const year = date.getUTCFullYear();

    return `${day} ${month} ${year}`;
}

class CheckOutForm {
    constructor() {
        this.slotsData = new Object();
        this.slotsData.subTotal = 0;
        this.slotsData.donationAmount = 0;
        this.slotsData.grandTotal = 0;
        this.slotsData.totalPackages = 0;
        this.slotsData.totalDates = 0;
        this.slotsData.selectedSlots = new Array();
        this.slotsData.selectedFlag = {
            dateString: "",
            packageName: "",
            isFlag: false,
        };
        this.paginator = document.querySelector(".checkout-form-paginator");
        this.paginatorFill = this.paginator.querySelector(
            ".checkout-form-paginator-fill"
        );
        this.paginatorItemBtns = this.paginator.querySelectorAll(
            ".checkout-form-paginator-item"
        );
        this.form = document.querySelector(".checkout-multi-step-wrapper");
        this.formSteps = this.form.querySelectorAll(
            ".checkout-multi-step-item"
        );
        this.currentStep = 0;
        this.nextButton0 = this.formSteps[0].querySelector(
            ".event-date-time-check-out-next0"
        );
        this.nextButton1 = this.formSteps[0].querySelector(
            ".event-date-time-check-out-next"
        );
        this.nextButton02 = this.formSteps[0].querySelector(
            ".event-date-time-check-out-next02"
        );
        this.nextButton2 = this.formSteps[1].querySelector(
            ".aside-checkout-next"
        );
        this.nextButton1.addEventListener("click", () => {
            this.paginatorItemBtns[1].click();
        });
        this.nextButton0.addEventListener("click", () => {
            this.paginatorItemBtns[1].click();
        });
        this.nextButton02.addEventListener("click", () => {
            this.paginatorItemBtns[1].click();
        });
        this.nextButton2.addEventListener("click", () => {
            this.paginatorItemBtns[2].click();
            this.generateStepThird();
        });

        this.data = new Object();
        this.newData = { ...this.data };
        this.newData.packages = new Object();
        this.newData.totalTickets = 0;

        //  =================================
        this.reset = false;
        // ===============================


        // ===============================================================================
        this.seatingPlanLoader = undefined;
        this.init();
    }

    init() {
        if (this.paginatorItemBtns.length !== this.formSteps.length) {
            // console.error("Paginator and form steps count mismatch");
            return;
        }

        this.configureForm();
        this.configureSteps();
    }

    configureForm(defaultIndex = 0) {
        this.currentStep = defaultIndex;

        this.formSteps.forEach((step, index) => {
            if (index === defaultIndex) {
                step.classList.remove("hidden");
            } else {
                step.classList.add("hidden");
            }
        });
    }

    configureSteps() {
        this.paginatorItemBtns.forEach((btn, index) => {
            btn.addEventListener("click", () => {
                const stepValidationMethods = {
                    0: this.validateStepFirst.bind(this),
                    1: this.validateStepSecond.bind(this),
                };

                if (index > this.currentStep) {
                    // Forward navigation with validation
                    const validateStep =
                        stepValidationMethods[this.currentStep];
                    if (validateStep && validateStep()) {
                        this.switchStep(index);
                        if (index === 2) this.generateStepThird();
                    }
                } else if (index < this.currentStep) {
                    // Backward navigation without validation
                    this.switchStep(index);
                } else if (this.currentStep === 3 && index === 1) {
                    // Special case for step 3 to step 1
                    const isValid = this.validateStepFirst();
                    if (isValid) {
                        this.switchStep(index);
                    }
                }
            });
        });
    }

    switchStep(index) {
        const percent = Math.round(
            (index / (this.paginatorItemBtns.length - 1)) * 100
        );
        this.paginatorFill.style.width = `${percent}%`;

        this.paginatorItemBtns.forEach((btn_, index_) => {
            this.configureForm(index);
            const icon = btn_.querySelector("i");
            if (index_ <= index) {
                this.paginatorItemBtns[index].classList.remove(
                    "cursor-not-allowed"
                );
                this.paginatorItemBtns[index].classList.add("cursor-pointer");
                icon.classList.remove(
                    "fa-regular",
                    "bg-white",
                    "text-gray-300",
                    "fa-circle"
                );
                icon.classList.add("fa-solid", "fa-circle", "text-primary");
            } else {
                this.paginatorItemBtns[index].classList.remove(
                    "cursor-not-allowed"
                );
                this.paginatorItemBtns[index].classList.add("cursor-pointer");
                icon.classList.remove("fa-solid", "fa-circle", "text-primary");
                icon.classList.add(
                    "fa-regular",
                    "bg-white",
                    "text-gray-300",
                    "fa-circle"
                );
            }
        });
    }

    updateTotals(subTotalElement) {
        const newSubtotal = this.getSubTotal(this.newData);

        subTotalElement.textContent = `$${newSubtotal}`;
        this.newData.subTotal = newSubtotal;

        this.newData.totalTickets = this.updateTotalTickets(this.newData);
    }

    getSubTotal(data) {
        let subTotal = 0;
        const pkgList = data.packages;

        for (const key in pkgList) {
            const pkg = pkgList[key];
            subTotal += pkg.price * pkg.qty;
        }
        return subTotal;
    }

    updateTotalTickets(data) {
        let totalTickets = 0;
        for (const key in data.packages) {
            totalTickets += data.packages[key].qty;
        }
        return totalTickets;
    }

    validateStepFirst() {
        const step = this.formSteps[0];
        const hiddenInputWrapper = step.querySelector(".hidden-slots-wrapper");

        function handleDisplayError(isError) {
            const errorText = step.querySelector(
                ".type-area-ticket-validatation.error-message"
            );

            if (isError) {
                errorText.textContent = "Please select both date and time";
                errorText.classList.add("error-shake", "text-primary");
                setTimeout(() => {
                    errorText.classList.remove("error-shake");
                    errorText.classList.add("text-white");
                }, 300);
            } else {
                errorText.textContent = "";
            }
        }

        if (hiddenInputWrapper) {
            const selectedPkgWrapperInner = document.querySelector(
                ".selected-pkgs-wrapper"
            );
            if (selectedPkgWrapperInner !== null) {
                this.slotsData.selectedSlots = [];
                selectedPkgWrapperInner.innerHTML = "";
            }
            const hiddenInput =
                hiddenInputWrapper.querySelector(".slot-dates-input");
            if (hiddenInput.value === "") {
                handleDisplayError(true);
                return false;
            }

            this.data = JSON.parse(hiddenInput.value);

            handleDisplayError(false);
            this.generateStepSecond();
            this.configureForm(1);
            return true;
        }

        handleDisplayError(true);
        return false;
    }

    handlePkgQty(element, subTotalElement = null) {
        const pkgName = element.getAttribute("data-pkg-name");
        const input = element.querySelector(".number-quantity");
        const maxValue = parseInt(input.getAttribute("data-max"));
        const minValue = parseInt(input.getAttribute("data-min"));
        const incrementBtn = element.querySelector(".number-right");
        const decrementBtn = element.querySelector(".number-left");

        incrementBtn.addEventListener("click", () => {
            const currentValue = parseInt(input.value);
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
                this.newData.packages[pkgName].qty = currentValue + 1;

                if (subTotalElement) {
                    this.updateTotals(subTotalElement);
                }
            }
        });

        decrementBtn.addEventListener("click", () => {
            const currentValue = parseInt(input.value);
            if (currentValue > minValue) {
                input.value = currentValue - 1;
                this.newData.packages[pkgName].qty = currentValue - 1;

                if (subTotalElement) {
                    this.updateTotals(subTotalElement);
                }
            }
        });
    }

    validateStepSecond() {
        const step = this.formSteps[1];
        const personalDetailsWrapper = step.querySelector(
            ".aside-checkout-personal-details-wrapper"
        );
        const detailItems =
            personalDetailsWrapper.querySelectorAll(".detail-item");

        const noPackageElement =
            personalDetailsWrapper.querySelector(".no-package-error");

        handlePersonalDetailValue(detailItems);
        function handleError(element, errorMessage, itemsToShake = null) {
            if (element) {
                element.textContent = errorMessage;
                element.classList.add("error-shake", "text-white");
                if (itemsToShake)
                    itemsToShake.forEach((item) =>
                        item.classList.add("error-shake")
                    );
                setTimeout(() => {
                    element.classList.remove("error-shake");
                    if (itemsToShake)
                        itemsToShake.forEach((item) =>
                            item.classList.remove("error-shake")
                        );
                }, 300);
            }
        }

        function validateAllInputs() {
            let isValid = true;

            detailItems.forEach((item) => {
                const label = item.querySelector(".detail-item-label");
                const input = item.querySelector(".detail-item-input");
                const errorElement = item.querySelector(".error-message");
                const labelText = label.textContent
                    .toLowerCase()
                    .replace("*", "")
                    .trim();

                if (!input.value.trim()) {
                    const errorMessage = `${labelText} cannot be empty`;
                    handleError(errorElement, errorMessage);
                    isValid = false;
                } else {
                    errorElement.textContent = "";

                    if (input.type === "email") {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(input.value)) {
                            const errorMessage = "Invalid email address";
                            handleError(errorElement, errorMessage);
                            isValid = false;
                        }
                    }
                }
            });

            return isValid;
        }

        if (this.data.dataSet.reserved) {
            this.getSeatingPlanSeatSlots();
        }

        let isBothValid = true;

        if (this.slotsData.selectedSlots.length > 0) {
            let hasValidSelection = false; // Start with false
            let validationMsg = "Please select at least one valid package before proceeding...";

            this.slotsData.selectedSlots.forEach(item => {
                if (item.type === "paid" && item.selectedQty > 0) {
                    hasValidSelection = true; // Set to true if any valid item is found
                }
                else if (item.type === "free" || item.type === "donated") {
                    hasValidSelection = true;
                }
                if (item.type === "donated" && item.donateAmount <= 0) {
                    hasValidSelection = false;
                    validationMsg = "Please donate at least one doller before proceeding...";
                }
                else {
                    hasValidSelection = true;
                    handleError(
                        noPackageElement,
                        ""
                    );
                }
            });

            isBothValid = hasValidSelection;
            if (!isBothValid) {
                handleError(
                    noPackageElement,
                    validationMsg
                );
            }
        } else {
            isBothValid = false;
            handleError(
                noPackageElement,
                "Select your desired package before proceeding..."
            );
        }

        if (!validateAllInputs()) {
            isBothValid = false;
        }

        if (isBothValid) {
            this.configureForm(2);
            return true;
        }

        return false;
    }
    getSeatingPlanSeatSlots() {
        let selectedSlots = [];
        const seatingPlanLayout = typeof this.data.dataSet.seating_plan === "string" ? JSON.parse(this.data.dataSet.seating_plan) : this.data.dataSet.seating_plan;

        this.seatingPlanLoader.data.forEach((item) => {
            const seatCountByPackage = {};

            item.seats.forEach(id => {
                const seat = this.seatingPlanLoader.stage.findOne(`#${id}`);
                if (seat) {
                    const tierId = seat.getAttr("metadata")?.tierId;
                    if (tierId && seatingPlanLayout.tiers[tierId]) {
                        const tier = seatingPlanLayout.tiers[tierId];
                        const matchingPackage = item.packages.find(pkg => {
                            if ((pkg.type === "donated" || pkg.type === "free") && pkg.type === tier.type) {
                                return true;
                            } else if (pkg.type === "paid" && pkg.name === tier.name) {
                                return true;
                            } else {
                                return false;
                            }
                        });

                        if (matchingPackage) {
                            if (!seatCountByPackage[matchingPackage.name]) {
                                if (item.type === "pass") {
                                    seatCountByPackage[matchingPackage.name] = {
                                        dateString: item.dateString,
                                        start_date: item.start_date,
                                        end_date: item.end_date,
                                        packageName: matchingPackage.name,
                                        price: matchingPackage.price,
                                        maxQty: matchingPackage.qty,
                                        selectedQty: 0,
                                        type: matchingPackage.type,
                                        seats: item.seats,
                                    };
                                } else {
                                    seatCountByPackage[matchingPackage.name] = {
                                        dateString: item.dateString,
                                        date: item.date,
                                        packageName: matchingPackage.name,
                                        price: matchingPackage.price,
                                        maxQty: matchingPackage.qty,
                                        selectedQty: 0,
                                        type: matchingPackage.type,
                                        seats: item.seats,
                                    };
                                }
                            }
                            seatCountByPackage[matchingPackage.name].selectedQty += 1;
                        }
                    }
                }
            });

            // Push all packages with selectedQty > 0
            Object.values(seatCountByPackage).forEach(slot => {
                if (slot.selectedQty > 0) {
                    selectedSlots.push(slot);
                }
            });
        });
        this.slotsData.selectedSlots = selectedSlots;


        const updateSeatPlanSubTotal = () => {
            this.slotsData.subTotal = 0;
            this.slotsData.grandTotal = 0;

            this.slotsData.selectedSlots.forEach((item) => {
                if (!item) return;

                if (item.type === 'paid') {
                    const price = Number(item.price) || 0;
                    const qty = Number(item.selectedQty) || 0;
                    const itemSubTotal = price * qty;

                    this.slotsData.subTotal += itemSubTotal;
                    this.slotsData.grandTotal += itemSubTotal;
                }
            });

            console.log("this.slotsData.subTotal", `$${this.slotsData.subTotal.toFixed(2)}`);
        }



        updateSeatPlanSubTotal();

    }
    getParsedDate(dateString) {
        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ];
        const [year, month, date] = dateString.split("-");
        const monthName = months[parseInt(month) - 1];
        return `${monthName} ${parseInt(date)
            .toString()
            .padStart(2, "0")}, ${year}`;
    }

    optimizeDateRange(dateRange) {
        const [startDate, endDate] = dateRange.split(" - ");
        const [startMonth, startDay, startYear] = startDate
            .replace(",", "")
            .split(" ");
        const [endMonth, endDay, endYear] = endDate.replace(",", "").split(" ");

        const isBothDatesSame = startDay === endDay;
        const isSameYear = startYear === endYear;
        const isSameMonth = startMonth === endMonth;

        if (startDate === endDate) {
            return startDate;
        } else if (isSameMonth && isSameYear && !isBothDatesSame) {
            return `${startMonth} ${startDay}-${endDay}, ${startYear}`;
        } else if (isSameMonth && !isBothDatesSame && !isSameYear) {
            return `${startMonth} ${startDay}-${endDay}, ${endYear}`;
        } else if (isSameYear && !isSameMonth) {
            return `${startMonth} ${startDay} - ${endMonth} ${endDay}, ${startYear}`;
        } else {
            return `${startMonth} ${startDay}, ${startYear} - ${endMonth} ${endDay}, ${endYear}`;
        }
    }

    handleCalendarJsonData() {
        const hiddenDatesSlotsInput =
            this.formSteps[0].querySelector(".slot-dates-input");
        const hiddenDatesSlotsJson = JSON.parse(hiddenDatesSlotsInput.value);

        const data = { ...hiddenDatesSlotsJson };

        if (data.calendarType === "single-date") {
            data.selectedDates = new Array();
            data.selectedDates.push(data.selectedDate);
            data.selectedDates[0].dateString = this.getParsedDate(
                data.selectedDates[0].date
            );
            data.selectedDates[0].type = "ticket";

        } else if (data.calendarType === "multi-date") {
            data.selectedDates.forEach((item) => {
                item.dateString = this.getParsedDate(item.date);
            });
            data.selectedDates[0].type = "ticket";
        } else {
            data.selectedDates.forEach((item) => {
                const parsedStartDate = this.getParsedDate(item.startDate);
                const parsedEndDate = this.getParsedDate(item.endDate);
                const optimizeDateString = this.optimizeDateRange(
                    `${parsedStartDate} - ${parsedEndDate}`
                );
                item.dateString = optimizeDateString;
            });
            data.selectedDates[0].type = "pass";
        }

        return data;
    }

    generateStepSecond() {
        const step = this.formSteps[1];
        const mainWrapper = step.querySelector(".check-out-box-2-inner-wrapper");
        const seatingPlanWrapper = step.querySelector(".seating-plan-wrapper");
        const seatSelectionTopWrapper = seatingPlanWrapper.querySelector(".checkout-seat-selection-top-wrapper");
        const seatSelectionBottomWrapper = seatingPlanWrapper.querySelector(".checkout-seat-selection-bottom-wrapper");
        const addPkgWrapper = mainWrapper.querySelector(".add-pkg-wrapper");
        const calendarData = this.handleCalendarJsonData();

        const hasReservedArrangement = calendarData.dataSet.reserved;
        const selectedDates = calendarData.selectedDates;


        if (hasReservedArrangement) {
            mainWrapper.classList.add("hidden");
            seatingPlanWrapper.classList.remove("hidden");
            seatSelectionTopWrapper.innerHTML = "";

            let initialized = false;
            console.log("selectedDates", selectedDates);

            selectedDates.forEach((date, index) => {
                const button = document.createElement("button");
                button.classList.add("date-btn");
                button.setAttribute("type", "button");
                button.textContent = date.dateString;
                seatSelectionTopWrapper.appendChild(button);

                let originalSlot = null;

                for (const slot of this.data.dataSet.slots) {
                    if (date.date && date.type === "pass") {

                        const dateValue = new Date(date.date);
                        const start = new Date(slot.start_date);
                        const end = new Date(slot.end_date);

                        // If date falls within the slot range, treat it as a ticket-type
                        if (dateValue >= start && dateValue <= end) {
                            date.type = "ticket";
                            date.date = date.dateString;
                        }
                    } else if (date.type === "ticket") {
                        slot.date === date.date;
                        originalSlot = slot;
                        break;
                    }
                    else if (date.type === "pass") {
                        slot.start_date === date.startDate && slot.end_date === date.endDate;
                        originalSlot = slot;
                        break;
                    }
                }

                const seatingPlanLayout = this.data.dataSet.seating_plan;

                button.addEventListener("click", () => {
                    if (button.classList.contains("active")) return;

                    const allBtns = seatSelectionTopWrapper.querySelectorAll(".date-btn");
                    allBtns.forEach(item => item.classList.toggle("active", item === button));
                    console.log(originalSlot, "originalSlot", date, "date", this.data.dataSet.slots, "this.data.dataSet.slots");

                    this.seatingPlanLoader.updateSeatingPlanSlot(
                        date.dateString,
                        originalSlot?.booked_seats || [],
                        true
                    );
                });

                // Initialize loader on first button only
                if (index === 0 && !initialized) {
                    button.classList.add("active");

                    const baseURL = window.location.origin;
                    const jsonFileName = this.data.dataSet.seating_map;
                    const endpoint = `${baseURL}/seating-plan/${jsonFileName}`;

                    this.seatingPlanLoader = new SeatingPlanLoader({
                        containerId: "seating-plan-container",
                        endpoint: endpoint,
                        layout: seatingPlanLayout,
                        disabled_seats: originalSlot?.booked_seats || [],
                        selectedDates, activeDate: date.dateString
                    });

                    initialized = true;
                }
            });

            /*selectedDates.forEach((originalDate, index) => {
                const button = document.createElement("button");
                button.classList.add("date-btn");
                button.setAttribute("type", "button");
                button.textContent = originalDate.dateString;
                seatSelectionTopWrapper.appendChild(button);

                const seatingPlanLayout = this.data.dataSet.seating_plan;

                // Determine the correct slot for this specific date
                const resolveSlot = (date) => {
                    const type = date.type || "ticket";
                    if (type === "ticket") {
                        return this.data.dataSet.slots.find(slot => slot.date === date.dateString);
                    } else if (type === "pass") {
                        return this.data.dataSet.slots.find(
                            slot =>
                                slot.start_date === (date.startDate || date.start_date) &&
                                slot.end_date === (date.endDate || date.end_date)
                        );
                    }
                    return null;
                };

                const slot = resolveSlot(originalDate);

                button.addEventListener("click", () => {
                    if (button.classList.contains("active")) return;

                    // Set active class on clicked button only
                    const allBtns = seatSelectionTopWrapper.querySelectorAll(".date-btn");
                    allBtns.forEach(item => item.classList.remove("active"));
                    button.classList.add("active");

                    // Get fresh slot each click to ensure correctness
                    const currentSlot = resolveSlot(originalDate);

                    console.log(currentSlot, "currentSlot", originalDate, "date");

                    this.seatingPlanLoader.updateSeatingPlanSlot(
                        originalDate.dateString,
                        currentSlot?.booked_seats || [],
                        true
                    );
                });

                // Initialize on the first date only
                if (index === 0 && !initialized) {
                    button.classList.add("active");

                    const baseURL = window.location.origin;
                    const jsonFileName = this.data.dataSet.seating_map;
                    const endpoint = `${baseURL}/seating-plan/${jsonFileName}`;

                    const initSlot = resolveSlot(originalDate);

                    this.seatingPlanLoader = new SeatingPlanLoader({
                        containerId: "seating-plan-container",
                        endpoint: endpoint,
                        layout: seatingPlanLayout,
                        disabled_seats: initSlot?.booked_seats || [],
                        selectedDates,
                        activeDate: originalDate.dateString
                    });

                    initialized = true;
                }
            });*/



        }

        const handleAlreadyAddedPackageHighlight = (
            slotDateString,
            slotPackageName
        ) => {
            const selectedPkgWrapper = mainWrapper.querySelector(
                ".selected-pkgs-wrapper"
            );
            const itemWrapper =
                selectedPkgWrapper.querySelectorAll(".pkg-wrapper");

            itemWrapper.forEach((item) => {
                const itemDateString = item.querySelector(".pkg-datestring");
                const itemPkgName = item.querySelector(".pkg-name");

                if (
                    slotDateString === itemDateString.textContent.trim() &&
                    slotPackageName === itemPkgName.textContent.trim()
                ) {
                    item.classList.add("bg-gray-200");

                    setTimeout(() => {
                        item.classList.remove("bg-gray-200");
                        this.slotsData.dateString = "";
                        this.slotsData.packageName = "";
                        this.slotsData.isFlag = false;
                    }, 200);
                }
            });
        };

        const generateAddPkgItems = () => {
            addPkgWrapper.innerHTML = "";
            calendarData.selectedDates.sort(
                (a, b) => new Date(a.date) - new Date(b.date)
            );
            calendarData.selectedDates.forEach((item) => {
                const dateString = item.dateString;
                const itemWrapper = document.createElement("div");
                itemWrapper.classList.add(
                    "px-[0.5rem]",
                    "relative",
                    "flex",
                    "justify-center",
                    "items-center",
                    "border-b"
                );

                const itemHtml = `
            <div class="w-full bg-gray-100 border-b border-gray-100 p-[0.2rem] accordion-wrapper">
              <div class="py-[0.7rem] flex justify-between items-center cursor-pointer transition-all duration-150 ease-in active:scale-95 accordion-head">
                <p class="text-gray-600 font-semibold rounded">${dateString}</p>
                <span class="text-gray-500">
                  <i class="fa-solid fa-sort-down"></i>
                </span>
              </div>
              <div class="accordion-body ">
                <!-- Package items will go here -->
              </div>
            </div>
          `;
                itemWrapper.innerHTML = itemHtml;

                item.packages.forEach((pkg) => {
                    const pkgName = pkg.name;

                    const pkgItemWrapper = document.createElement("div");
                    pkgItemWrapper.classList.add(
                        "p-1",
                        "transition-all",
                        "duration-150",
                        "ease-in",
                        "active:scale-95",
                        "hover:bg-gray-200",
                        "rounded",
                        "accordion-body-item"
                    );
                    const type = item.type;
                    pkgItemWrapper.dataset.packageDate = dateString;
                    pkgItemWrapper.dataset.packageName = pkgName;
                    if (type === "pass") {
                        pkgItemWrapper.dataset.packageData = JSON.stringify({
                            type: type,
                            start_date: item.start_date,
                            end_date: item.end_date,
                        });
                    } else {
                        pkgItemWrapper.dataset.packageData = JSON.stringify({
                            type: type,
                            date: item.date,
                        });
                    }
                    const pkgItemHtml = `
              <button class="flex justify-between items-center select-none w-full" type="button">
                <span>${pkgName}</span>
                <i class="fa-solid fa-plus text-sm"></i>
              </button>
            `;
                    pkgItemWrapper.innerHTML = pkgItemHtml;
                    itemWrapper
                        .querySelector(".accordion-body")
                        .appendChild(pkgItemWrapper);
                });

                addPkgWrapper.appendChild(itemWrapper);
            });

            addPkgWrapper.addEventListener("click", (event) => {
                const isAccordionHead = event.target.closest(".accordion-head");
                const isPkgItem = event.target.closest(".accordion-body-item");

                if (isAccordionHead) {
                    const body = isAccordionHead.nextElementSibling;
                    const isVisible =
                        !body.classList.contains("hide-accordion");

                    const allBodies =
                        addPkgWrapper.querySelectorAll(".accordion-body");
                    allBodies.forEach((b) => b.classList.add("hide-accordion"));

                    if (!isVisible) {
                        body.classList.remove("hide-accordion");
                    }
                } else if (isPkgItem) {
                    const pkgDate = isPkgItem.dataset.packageDate;
                    const pkgName = isPkgItem.dataset.packageName;
                    const pkgData = isPkgItem.dataset.packageData;
                    this.generateSelectdPackageData(pkgDate, pkgName, pkgData);

                    if (this.slotsData.selectedFlag.isFlag) {
                        handleAlreadyAddedPackageHighlight(
                            this.slotsData.selectedFlag.dateString,
                            this.slotsData.selectedFlag.packageName
                        );
                    }
                }
            });
        };

        generateAddPkgItems();
    }



    generateSelectdPackageData(dateString, pkgName, pkgData) {
        let dateFound = false;
        pkgData = JSON.parse(pkgData);
        const calendarData = this.handleCalendarJsonData();
        calendarData.selectedDates.forEach((item) => {
            if (item.dateString === dateString) {
                dateFound = true;

                let packageFound = false;

                item.packages.forEach((pkg, index) => {
                    if (pkg.name === pkgName) {
                        const alreadySelected =
                            this.slotsData.selectedSlots.some(
                                (slot) =>
                                    slot.dateString === dateString &&
                                    slot.packageName === pkgName
                            );

                        if (!alreadySelected) {
                            if (pkgData.type === "pass") {
                                this.slotsData.selectedSlots.push({
                                    dateString: dateString,
                                    start_date: pkgData.start_date,
                                    end_date: pkgData.end_date,
                                    packageName: pkg.name,
                                    price: pkg.price,
                                    maxQty: pkg.qty,
                                    selectedQty: 1,
                                    type: pkg.type,
                                });
                            } else {
                                this.slotsData.selectedSlots.push({
                                    dateString: dateString,
                                    date: pkgData.date,
                                    packageName: pkg.name,
                                    price: pkg.price,
                                    maxQty: pkg.qty,
                                    selectedQty: 1,
                                    type: pkg.type,
                                });
                            }

                            // Clear the previous selected flag
                            this.slotsData.selectedFlag = {
                                dateString: "",
                                packageName: "",
                                isFlag: false,
                            };
                        } else {
                            this.slotsData.selectedFlag = {
                                dateString: dateString,
                                packageName: pkg.name,
                                isFlag: true,
                            };
                        }

                        packageFound = true;
                        return;
                    }
                });

                if (!packageFound) {
                    // console.warn("ERROR: package not found");
                }
                return;
            }
        });

        if (!dateFound) {
            // console.warn("ERROR: Invalid Date String");
        }

        this.generateSelectdPackageHtml(); // Update the displayed packages
    }

    generateSelectdPackageHtml() {
        const step = this.formSteps[1];
        const mainWrapper = step.querySelector(
            ".check-out-box-2-inner-wrapper"
        );
        const selectedPkgWrapper = mainWrapper.querySelector(
            ".selected-pkgs-wrapper"
        );
        const subTotal = mainWrapper.querySelector(".sub-total");

        selectedPkgWrapper.innerHTML = "";

        this.slotsData.selectedSlots.forEach((pkg) => {
            const wrapper = document.createElement("div");
            wrapper.classList.add(
                "grid",
                "grid-cols-4",
                "text-center",
                "border-b",
                "items-center",
                "rounded",
                "transition-all",
                "duration-150",
                "ease-in",
                "pkg-wrapper"
            );

            const wrapperPaidHtml = `
                <div class="border-r">
                    <div class="p-2">
                    <button class="flex justify-between select-none items-center w-full transition-all duration-150 ease-in active:scale-95 hover:text-primary selected-pkg-item" type="button" title="Remove Package">
                        <span class="pkg-name">${pkg.packageName}</span>
                        <i class="fa-solid fa-x text-xs"></i>
                    </button>
                    </div>
                </div>
                <div class="border-r">
                    <div class="p-2 flex items-center justify-center min-w-44 select-none qty-wrapper">
                    <span class="transition-all duration-150 ease-in active:scale-95 bg-white before:p-[2px] before:content-['-'] before:rounded-tl before:rounded-bl before:flex before:justify-center before:items-center before:border before:border-gray-300 before:text-primary before:font-medium min-w-12 cursor-pointer qty-decrement"></span>
                    <input class="disabled:bg-white p-[2px] w-full border-t border-b text-center border-gray-300 pkg-qty" type="text" value="${pkg.selectedQty}" disabled="">
                    <span class="transition-all duration-150 ease-in active:scale-95 bg-white after:p-[2px] after:content-['+'] after:rounded-tr after:rounded-br after:flex after:justify-center after:items-center after:border after:border-gray-300 after:text-primary after:font-medium min-w-12 cursor-pointer qty-increment"></span>
                    </div>
                </div>
                <div class="border-r">
                    <p class="select-none text-sm pkg-datestring">${pkg.dateString}</p>
                </div>
                <div class="border-r">
                    <p class="select-none">${pkg.price}</p>
                </div>
            `;

            const wrapperDonatedHtml = `
                <div class="border-r">
                    <div class="p-2">
                    <button class="flex justify-between select-none items-center w-full transition-all duration-150 ease-in active:scale-95 hover:text-primary selected-pkg-item" type="button" title="Remove Package">
                        <span class="pkg-name">${pkg.packageName}</span>
                        <i class="fa-solid fa-x text-xs"></i>
                    </button>
                    </div>
                </div>
                <div class="border-r">
                    <div class="p-2 flex items-center justify-center min-w-44 select-none qty-wrapper">
                    <span class="transition-all duration-150 ease-in active:scale-95 bg-white before:p-[2px] before:content-['-'] before:rounded-tl before:rounded-bl before:flex before:justify-center before:items-center before:border before:border-gray-300 before:text-primary before:font-medium min-w-12 cursor-pointer qty-decrement"></span>
                    <input class="disabled:bg-white p-[2px] w-full border-t border-b text-center border-gray-300 pkg-qty" type="text" value="${pkg.selectedQty}" disabled="">
                    <span class="transition-all duration-150 ease-in active:scale-95 bg-white after:p-[2px] after:content-['+'] after:rounded-tr after:rounded-br after:flex after:justify-center after:items-center after:border after:border-gray-300 after:text-primary after:font-medium min-w-12 cursor-pointer qty-increment"></span>
                    </div>
                </div>
                <div class="border-r">
                    <p class="select-none text-sm pkg-datestring">${pkg.dateString}</p>
                </div>
                <div class="border-r">
                    <div class="p-2 relative flex flex-col items-center justify-center min-w-44 select-none donate-amt-wrapper">
                        <p class="select-none donated-amount-label">To Be Donated</p>
                        <input style="padding-left: 1.1rem;" class="disabled:bg-white rounded border outline-none p-[2px] w-full text-center border-gray-300 donate-input" type="text" value="${pkg.selectedQty}">
                        <p class="select-none absolute" style="left: 13px;top: 48%;">$</p>
                    </div>
                </div>
            `;

            const wrapperFreeHtml = `
                <div class="border-r">
                    <div class="p-2">
                    <button class="flex justify-between select-none items-center w-full transition-all duration-150 ease-in active:scale-95 hover:text-primary selected-pkg-item" type="button" title="Remove Package">
                        <span class="pkg-name">${pkg.packageName}</span>
                        <i class="fa-solid fa-x text-xs"></i>
                    </button>
                    </div>
                </div>
                <div class="border-r">
                    <div class="p-2 flex items-center justify-center min-w-44 select-none qty-wrapper">
                    <span class="transition-all duration-150 ease-in active:scale-95 bg-white before:p-[2px] before:content-['-'] before:rounded-tl before:rounded-bl before:flex before:justify-center before:items-center before:border before:border-gray-300 before:text-primary before:font-medium min-w-12 cursor-pointer qty-decrement"></span>
                    <input class="disabled:bg-white p-[2px] w-full border-t border-b text-center border-gray-300 pkg-qty" type="text" value="${pkg.selectedQty}" disabled="">
                    <span class="transition-all duration-150 ease-in active:scale-95 bg-white after:p-[2px] after:content-['+'] after:rounded-tr after:rounded-br after:flex after:justify-center after:items-center after:border after:border-gray-300 after:text-primary after:font-medium min-w-12 cursor-pointer qty-increment"></span>
                    </div>
                </div>
                <div class="border-r">
                    <p class="select-none text-sm pkg-datestring">${pkg.dateString}</p>
                </div>
                <div class="border-r">
                    <p class="select-none" value=0>Free</p>
                </div>
            `;

            if (pkg.type === "paid") {
                wrapper.innerHTML = wrapperPaidHtml;
                selectedPkgWrapper.appendChild(wrapper);
            } else {
                if (pkg.type === "donated") {
                    wrapper.innerHTML = wrapperDonatedHtml;
                    selectedPkgWrapper.appendChild(wrapper);
                } else if (pkg.type === "free") {
                    wrapper.innerHTML = wrapperFreeHtml;
                    selectedPkgWrapper.appendChild(wrapper);
                }
            }

            const handleQtyChange = (wrapper) => {
                const inputWrapper = wrapper.querySelectorAll(".qty-wrapper");

                inputWrapper.forEach(item => {
                    const input = item.querySelector(".pkg-qty");
                    const qtyDecrement = item.querySelector(".qty-decrement");
                    const qtyIncrement = item.querySelector(".qty-increment");

                    qtyDecrement.addEventListener("click", () => {
                        const currentValue = parseInt(input.value);
                        if (currentValue > 1) {
                            input.value = currentValue - 1;
                            pkg.selectedQty = Number(input.value);
                            updateSubTotal();
                        }

                    });

                    qtyIncrement.addEventListener("click", () => {
                        const currentValue = parseInt(input.value);

                        if (pkg.maxQty > currentValue) {
                            input.value = currentValue + 1;
                            pkg.selectedQty = Number(input.value);
                        }
                        else {
                            input.value = pkg.maxQty;
                            pkg.selectedQty = pkg.maxQty;
                        }

                        updateSubTotal();
                    });
                });
            }

            const updateSubTotal = () => {
                this.slotsData.subTotal = 0;
                this.slotsData.donationAmount = 0;
                this.slotsData.grandTotal = 0;
                const subTotalElement = document.querySelector(".check-out-box-2-inner-wrapper .sub-total");

                this.slotsData.selectedSlots.forEach((item) => {
                    if (!item) return;

                    if (item.type === 'paid') {
                        const price = Number(item.price) || 0;
                        const qty = Number(item.selectedQty) || 0;
                        const itemSubTotal = price * qty;

                        this.slotsData.subTotal += itemSubTotal;
                        this.slotsData.grandTotal += itemSubTotal;
                    }
                    else if (item.type === "donated") {
                        const donateAmount = Number(item.donateAmount) || 0;
                        if (item.selectedQty > 0) {
                            this.slotsData.donationAmount += donateAmount;
                            this.slotsData.grandTotal += donateAmount;
                        }
                    }
                });

                subTotalElement.textContent = `$${this.slotsData.subTotal.toFixed(2)}`;
            };


            const donateNumberOnly = () => {
                const inputs = wrapper.querySelectorAll(".donate-input");

                inputs.forEach(input => {
                    input.value = pkg.donateAmount || "0";
                    pkg.donateAmount = Number(input.value) || 0;
                    updateSubTotal();

                    input.addEventListener("input", () => {
                        input.value = Number(input.value) || 0;
                        pkg.donateAmount = Number(input.value) || 0;
                        updateSubTotal();
                    });

                    input.addEventListener("keydown", (event) => {
                        if (event.key === "ArrowUp") {
                            event.preventDefault();
                            input.value = Number(parseInt(input.value || "0", 10) + 1) || 0;;
                            pkg.donateAmount = Number(input.value) || 0;
                            updateSubTotal();
                        }
                        else if (event.key === "ArrowDown") {
                            event.preventDefault();
                            let newValue = parseInt(input.value || "0", 10) - 1;
                            input.value = newValue < 0 ? "0" : Number(newValue) || 0;
                            pkg.donateAmount = Number(input.value) || 0;
                            updateSubTotal();
                        }
                    });

                    input.addEventListener("paste", (event) => {
                        event.preventDefault();
                        let pastedText = (event.clipboardData || window.clipboardData).getData("text");
                        input.value = Number(pastedText) || 0;
                        pkg.donateAmount = Number(input.value) || 0;
                        updateSubTotal();
                    });
                });
            };


            const handleRemovePackage = () => {
                const selectedPackage = wrapper.querySelector(".selected-pkg-item");

                selectedPackage.addEventListener("click", () => {
                    if (pkg.type === "donated") pkg.price = 0;

                    for (let index = 0; index < this.slotsData.selectedSlots.length; index++) {
                        const element = this.slotsData.selectedSlots[index];
                        const isSameName = element.packageName === pkg.packageName;
                        const isSameDate = element.dateString === pkg.dateString;

                        if (isSameName && isSameDate) {
                            this.slotsData.selectedSlots.splice(index, 1);
                            wrapper.remove();
                            updateSubTotal();
                            break;
                        }
                    }
                })
            }



            handleQtyChange(wrapper);
            donateNumberOnly();
            handleRemovePackage();

            // Handle hover effects for the package item
            selectedPkgWrapper.addEventListener("mouseover", (event) => {
                const isSelectedPkgWrapper =
                    event.target.closest(".pkg-wrapper");

                if (isSelectedPkgWrapper) {
                    isSelectedPkgWrapper.classList.add("bg-gray-200");
                }
            });

            selectedPkgWrapper.addEventListener("mouseout", (event) => {
                const isSelectedPkgWrapper =
                    event.target.closest(".pkg-wrapper");

                if (isSelectedPkgWrapper) {
                    isSelectedPkgWrapper.classList.remove("bg-gray-200");
                }
            });
        });

        // Optional: Update the subtotal whenever changes are made
        this.updateSubTotal();
    }

    updateSubTotal() {
        const subTotalElement = document.querySelector(".sub-total");
        let total = 0;
        let totalPrice = 0;

        this.slotsData.selectedSlots.forEach((item, index) => {
            if (item.selectedQty >= 1) {
                total = item.selectedQty + total;
                totalPrice = item.price + totalPrice;
            }
        });

        // this.slotsData.selectedSlots.forEach((pkg) => {
        //     total += pkg.price * pkg.selectedQty;
        // });

        // subTotalElement.textContent = `$${total.toFixed(2)}`;
    }

    generateStepThird() {
        handleFillStepThirdData();
        bookedslotdata = this.slotsData;
        const step = this.formSteps[2];
        const ticketQty = step.querySelector(".total-ticket-qty");
        const subtotal = step.querySelectorAll(".sub-total-amount");

        // ticketQty.textContent = this.newData.totalTickets;
        // subtotal.forEach(
        //     (item) => (item.textContent = `${this.newData.subTotal}`)
        // );

        // Handle Create Input Field
        /*const jsonInput = step.querySelector(".json-input");
    
        if (jsonInput) {
            jsonInput.value = JSON.stringify(this.newData);
        } else {
            const jsonInput = document.createElement("input");
            jsonInput.setAttribute("type", "text");
            jsonInput.setAttribute("name", "checkout_user_data");
            jsonInput.classList.add("json-input");
            jsonInput.setAttribute("value", JSON.stringify(this.newData));
            step.appendChild(jsonInput);
        }*/
    }
}

let form = new CheckOutForm();

function handleFillStepThirdData() {
    let eventdata = JSON.parse(localStorage.getItem("ticketDetail"));
    console.log(eventdata, bookedslotdata, userdetail);
    if ((fulleventdata, bookedslotdata)) {
        document.querySelector(".os-name").innerText = userdetail.firstName;
        document.querySelector(".os-lastname").innerText = userdetail.lastName;
        document.querySelector(".os-phone").innerText = userdetail.phone;
        document.querySelector(".os-email").innerText = userdetail.email;
        document.querySelector(".os-event-name").innerText = eventdata.title;
        document.querySelector(".os-event-category").innerText =
            eventdata.category_title;
        document.querySelector(".os-event-venue").innerText = eventdata.venue;
        document.querySelector(".os-event-subtotal").innerText =
            "$" + bookedslotdata.subTotal;
        if (bookedslotdata.donationAmount > 0) {
            document.querySelector(".os-event-donation").innerText = "$" + bookedslotdata.donationAmount;
            document.querySelector(".os-event-donation-label").classList.remove('hidden');
            document.querySelector(".os-event-donation").classList.remove('hidden');
        }
        else {
            document.querySelector(".os-event-donation-label").classList.add('hidden');
            document.querySelector(".os-event-donation").classList.add('hidden');
        }
        document.querySelector(".os-event-total").innerText =
            "$" + bookedslotdata.grandTotal;

        let tablebody = document.querySelector(".os-table-body");
        tablebody.innerHTML = "";
        bookedslotdata.selectedSlots.forEach((item, index) => {
            const itemPrice = item.price;
            let row = `
                <tr>
                    <td>
                        <p class="">${item.dateString}</p>
                    </td>
                    <td>
                        <p class="">${item.packageName}</p>
                    </td>
                    <td>
                        <p class="text-center">${item.selectedQty}</p>
                    </td>
                    <td>
                        <p class="text-end">$${itemPrice}</p>
                    </td>
                </tr>
            `;
            let checkoutData = {};
            // checkoutData = userdetail;
            // checkoutData.slots = bookedslotdata.selectedSlots;
            checkoutData.slots = bookedslotdata.selectedSlots;
            checkoutData.sub_total = bookedslotdata.subTotal;
            checkoutData.donation_amount = bookedslotdata.donationAmount;
            checkoutData.grand_total = bookedslotdata.grandTotal;
            console.log(bookedslotdata, checkoutData);
            const wrapper = document.querySelector(".place-order");
            const jsonInput = wrapper.querySelector(".json-input");
            if (jsonInput) {
                jsonInput.value = JSON.stringify(checkoutData);
            } else {
                const jsonInput = document.createElement("input");
                jsonInput.setAttribute("type", "hidden");
                jsonInput.setAttribute("name", "checkout_user_data");
                jsonInput.classList.add("json-input");
                jsonInput.setAttribute("value", JSON.stringify(checkoutData));
                wrapper.appendChild(jsonInput);
            }
            // Append the row to the table body
            tablebody.innerHTML += row;
        });
    }
}

function handleIncrementSeat(element) {
    const parent = element.parentElement;
    const input = parent.querySelector(".pkg-qty");
    input.value = parseInt(input.value) + 1;

    return;
    const packageWrapper = event.target.closest(".pkg-wrapper");
    if (packageWrapper) {
        const pkgQty = packageWrapper.querySelector(".pkg-qty");
        const currentValue = parseInt(pkgQty.value);
        if (currentValue > 0) {
            pkgQty.value = currentValue - 1;
        }
        handleupdateSubTotal();

        // const updatedPkg = this.slotsData.selectedSlots.find(p => p.packageName === packageWrapper.querySelector(".pkg-name").textContent.trim());
        // if (updatedPkg && updatedPkg.selectedQty < updatedPkg.maxQty) {
        //   updatedPkg.selectedQty++;
        //   pkgQty.value = updatedPkg.selectedQty;
        // new CheckOutForm().updateSubTotal();
        // }
    }
}
function handleDecrimentSeat(price) {
    return;
    const packageWrapper = event.target.closest(".pkg-wrapper");
    if (packageWrapper) {
        const pkgQty = packageWrapper.querySelector(".pkg-qty");
        const currentValue = parseInt(pkgQty.value);
        pkgQty.value = currentValue + 1;
        handleupdateSubTotal();

        // const updatedPkg = this.slotsData.selectedSlots.find(p => p.packageName === packageWrapper.querySelector(".pkg-name").textContent.trim());
        // if (updatedPkg && updatedPkg.selectedQty < updatedPkg.maxQty) {
        //   updatedPkg.selectedQty++;
        //   pkgQty.value = updatedPkg.selectedQty;
        // new CheckOutForm().updateSubTotal();
        // }
    }
}

function handleupdateSubTotal(price) {
    const subTotal = document.querySelector(".sub-total");
    // const total = this.slotsData.selectedSlots.reduce((sum, pkg) => sum + (pkg.price * pkg.selectedQty), 0);
    // subTotal.textContent = `$${total.toFixed(2)}`;
}

function handlePersonalDetailValue(detailItems) {
    const fieldNames = ["firstName", "lastName", "email", "phone"]; // Define keys
    const inputValues = Array.from(detailItems).reduce((acc, item, index) => {
        const input = item.querySelector("input");
        if (input) {
            acc[fieldNames[index]] = input.value;
        }
        return acc;
    }, {});
    userdetail = inputValues;
}

const data = {
    packages: {
        "special-vip-admission": {
            qty: 2,
            price: 50,
            name: "SpecialVIPAdmission",
        },
    },
    totalTickets: 2,
    dates: {
        "2025-03-22": {
            date: "2025-03-22",
            time: {
                "10: 00AM-5: 30PM": {
                    start_time: "10: 00AM",
                    end_time: "5: 30PM",
                },
            },
        },
    },
    subTotal: 100,
};

const updatedJson = [
    {
        date: "21-feb-2025",
        start_time: "10:00 AM",
        end_time: "12:00 PM",
        package: "blue category",
        qty: 5,
        amount: "$100",
    },
    {
        date: "21-feb-2025",
        start_time: "10:00 AM",
        end_time: "12:00 PM",
        package: "blue category",
        qty: 5,
        amount: "$100",
    },
    {
        date: "21-feb-2025",
        start_time: "10:00 AM",
        end_time: "12:00 PM",
        package: "blue category",
        qty: 5,
        amount: "$100",
    },
];

handleFillStepThirdData();
