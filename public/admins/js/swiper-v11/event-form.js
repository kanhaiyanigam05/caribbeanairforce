let areEventListenersAdded = {
    singleDate: false,
    daily: false,
    weekly: false,
    monthly: false,
    custom: false,
};

let valuesToDisplay = {
    bannerMedia: [],
    eventName: null,
    scheduleBy: null,
    eventDate: null,
    timeDuration: null,
    customPass: [],
    defaultPrice: null,
    venueName: null,
    description: null,
    faq: [],
};

function passDataToObject(data) {
    valuesToDisplay = data;
}
function calculateDurationInHours(startTime, endTime) {
    function parseTimeTo24Hour(timeString) {
        console.log("Hello ", timeString);

        const [time, modifier] = timeString.split(" ");
        let [hours, minutes] = time.split(":").map((num) => parseInt(num, 10));

        if (modifier === "PM" && hours !== 12) {
            hours += 12;
        }
        if (modifier === "AM" && hours === 12) {
            hours = 0;
        }

        return new Date(1970, 0, 1, hours, minutes);
    }

    let start = parseTimeTo24Hour(startTime);
    let end = parseTimeTo24Hour(endTime);
    let durationMs = end - start;

    if (durationMs < 0) {
        durationMs += 24 * 60 * 60 * 1000;
    }

    let durationHours = durationMs / (1000 * 60 * 60);
    let hours = Math.floor(durationHours);
    let minutes = Math.round((durationHours - hours) * 60);

    let timeFormatted;

    if (hours === 0) {
        timeFormatted = `${minutes} minutes`;
    } else {
        timeFormatted = `${hours}:${minutes < 10 ? "0" + minutes : minutes
            } hours`;
    }

    return timeFormatted;
}

let isSwitchEventTypeInitialized = false;

class FormValidator {
    constructor() {
        this.sliderWrapper = document.querySelector("#create-event-container");
        // 09-01-2025
        this.seatingMap = document.querySelector("#seating_map");
        this.seatingPlan = document.querySelector("#seating_plan");
        this.seatingValidationError = document.querySelector("#seating-validation-error");
        this.reservedSwitch = document.querySelector("#reserved-seating-switch");

        this.organizerInfoWrapper = document.querySelector(
            "#organizer-name-wrapper"
        );
        this.organizerInfoItem =
            this.organizerInfoWrapper.querySelectorAll(".organizer-item");
        this.typeOfEventWrapper = document.querySelector(
            ".type-of-event-wrapper"
        );
        this.typeOfEventBtns = document.querySelectorAll(".type-of-event-btn");
        this.typeOfEventList = document.querySelector(".type-of-event-list");
        this.typeOfEventBtnError = document.querySelector(
            ".type-of-event-btn-error"
        );
        // 09-01-2025

        this.eventName = document.querySelector("#event-name");
        this.eventNameError = document.querySelector(
            "#event-name + .error-text"
        );

        this.eventCategory = document.querySelector("#event-category");
        this.eventCategoryError = document.querySelector(
            "#event-category + .error-text"
        );

        this.eventShrtDes = document.querySelector("#event-short-description");
        this.eventShrtError = document.querySelector(
            "#event-short-description + .error-text"
        );


        this.eventStartEndDateRange = document.querySelector(
            ".event-start-end-date-range"
        );
        this.eventStartDate = document.querySelector(".event-start-date");
        this.eventEndDate = document.querySelector(".event-end-date");
        this.eventStartTime = document.querySelector(".event-start-time");
        this.eventStartsError = document.querySelector(
            ".event-start-time + .error-text"
        );
        this.eventEndTime = document.querySelector(".event-end-time");
        this.eventEndsError = document.querySelector(
            ".event-end-time + .error-text"
        );
        this.eventStartEndDateRangeError = document.querySelector(
            ".event-start-end-date-range + .error-text"
        );
        this.eventDescriptionError = document.querySelector(
            "#event-description-error-text"
        );
        this.eventBannerError = document.querySelector(
            "#event-banner-error-text"
        );
        this.eventDateWrapper = document.querySelector(".event-date-wrapper");
        this.venueName = document.querySelector("#event-venue-name");
        this.eventLocationWrapper = document.querySelector(
            "#event-location-wrapper"
        );
        this.eventDescription = document.querySelector("#event-description");
        this.meadaWrapper = document.querySelector(".display-img-create-order");
        this.paymentMode = document.querySelector("#payment-mode");
        this.paymentModeError = document.querySelector(
            "#payment-mode + .error-text"
        );
        this.purchaseLocationWrapper = document.querySelector(
            "#purchase-location-wrapper"
        );
        this.purchaseLocation = document.querySelector("#purchase-location");
        this.purchaseLocationError = document.querySelector(
            "#purchase-location + .error-text"
        );
        this.ticketLocationMap = document.querySelector(".ticket-location-map");
        this.ticketLocationMapError = document.querySelector(
            ".ticket-location-map-error-text"
        );
        this.refundOption = document.querySelector("#refund-option");
        this.refundOptionError = document.querySelector(
            "#refund-option + .error-text"
        );

        // 30-10-2024
        this.eventHeaderInputImage = document.querySelector(
            ".event-header-input-image"
        );
        this.eventHeaderPrevImage =
            document.querySelector(".header-image-prev");
        this.eventHeaderError = document.querySelector(".event-header-error");
        // 30-10-2024

        // 07-12-2024
        this.eventSingleDateWrapper = document.querySelector(
            ".event-single-date-wrapper"
        );
        this.eventDailyWrapper = document.querySelector(".event-daily-wrapper");
        this.eventWeeklyWrapper = document.querySelector(
            ".event-weekly-wrapper"
        );
        this.eventMonthlyWrapper = document.querySelector(
            ".event-monthly-wrapper"
        );
        this.eventCustomWrapper = document.querySelector(
            ".event-custom-wrapper"
        );

        this.evDateInput = document.querySelector("#event-date-input");
        this.stTimeInput = document.querySelector("#start_time_input");
        this.enTimeInput = document.querySelector("#end_time_input");
        // 07-12-2024


        this.init();
    }

    init() {
        this.paymentMode.addEventListener(
            "change",
            this.togglePurchaseLocation.bind(this)
        );
        this.switchEventType();
    }

    validateOrganizerInformation() {
        let isValid = true;

        this.organizerInfoItem.forEach((wrapper) => {
            const label = wrapper.querySelector("label");
            const input = wrapper.querySelector("input");
            const inputValue = input.value.trim();
            const errorText = wrapper.querySelector(".error-text");
            const errorMessage = `${label.textContent} is required!`;

            if (!inputValue) {
                errorText.textContent = errorMessage;
                this.sliderWrapper.classList.add("error-shake");
                input.classList.add("error-border");

                setTimeout(() => {
                    this.sliderWrapper.classList.remove("error-shake");
                    input.classList.remove("error-border");
                }, 500);

                isValid = false;
            } else {
                errorText.textContent = "";
            }
        });

        return isValid;
    }

    validateName() {
        const eventName = this.eventName.value.trim();
        const eventCategory = this.eventCategory.value.trim();
        const eventShortDesc = this.eventShrtDes.value.trim();

        let isValid = true;

        if (!eventName) {
            this.sliderWrapper.classList.add("error-shake");
            this.eventName.classList.add("error-border");
            this.eventNameError.textContent = "Event name is required!";
            isValid = false;
        } else {
            this.eventName.classList.remove("error-border");
            this.eventNameError.textContent = "";
            valuesToDisplay.eventName = eventName;
        }

        if (!eventCategory) {
            this.eventCategory.classList.add("error-border");
            this.eventCategoryError.textContent = "Event category is required!";
            isValid = false;
        } else {
            this.eventCategory.classList.remove("error-border");
            this.eventCategoryError.textContent = "";
            valuesToDisplay.eventCategory = eventCategory;
        }

        /*if (!eventShortDesc) {
            this.eventShrtDes.classList.add("error-border");
            this.eventShrtError.textContent = "Event short description is required!";
            isValid = false;
        } else {
            this.eventShrtDes.classList.remove("error-border");
            this.eventShrtError.textContent = "";
            valuesToDisplay.eventShrtDes = eventShortDesc;
        }*/

        if (!isValid) {
            setTimeout(() => {
                this.sliderWrapper.classList.remove("error-shake");
                this.eventName.classList.remove("error-border");
                this.eventCategory.classList.remove("error-border");
                this.eventShrtDes.classList.remove("error-border");
            }, 500);
        }

        return isValid;
    }


    switchEventType() {
        if (!isSwitchEventTypeInitialized) {
            isSwitchEventTypeInitialized = true;

            const buttonWrapper = document.querySelector(
                ".type-of-event-wrapper"
            );
            const buttons =
                buttonWrapper.querySelectorAll(".type-of-event-btn");
            const typeOfEventBtnError = document.querySelector(
                ".type-of-event-btn-error"
            );
            const scheduleByWrapper = document.querySelector(
                ".schedule-by-wrapper"
            );
            const custompassWrapper = document.querySelector(
                ".custom-pass-selector-wrapper"
            );
            const scheduleBy = scheduleByWrapper.querySelector("#schedule-by");
            const scheduleByError = scheduleByWrapper.querySelector(
                "#schedule-by + .error-text"
            );

            const createEventTypeWrapper = document.querySelector(
                ".create-event-type-wapper"
            );
            const ticketWrappers =
                createEventTypeWrapper.querySelectorAll(".ticket-type");
            const weekDaySelectWrapper = createEventTypeWrapper.querySelector(
                ".week-day-select-wrapper"
            );
            const monthDateSelectWrapper = createEventTypeWrapper.querySelector(
                ".month-date-select-wrapper"
            );
            const eventTypeItems =
                createEventTypeWrapper.querySelectorAll(".event-type-items");
            const calendarWrapper = createEventTypeWrapper.querySelector(
                ".custom-calendar-wrapper"
            );

            // initialize multi range date picker
            const calendarInputButton = calendarWrapper.querySelector(
                ".calender-input-button"
            );
            const eventType = document.querySelector("#event-type");
            new CustomCalendar(calendarInputButton).singleDaySelection({
                disablePastDates: true,
            });

            buttons.forEach((btn) => {
                btn.addEventListener("click", () => {
                    custompassWrapper.classList.add("hidden");
                    scheduleByError.textContent = "";
                    typeOfEventBtnError.textContent = "";
                    const monthDateSelectError =
                        monthDateSelectWrapper.querySelector(
                            ".month-date-select-error"
                        );
                    const weekDaySelectError =
                        weekDaySelectWrapper.querySelector(
                            ".week-day-select-error"
                        );

                    monthDateSelectError.textContent = "";
                    weekDaySelectError.textContent = "";

                    eventTypeItems.forEach((item) => {
                        const errorText = item.querySelector(
                            ".error-text, .calender-error-text"
                        );
                        errorText.textContent = "";
                    });

                    createEventTypeWrapper.classList.remove("hidden");
                    weekDaySelectWrapper.classList.add("hidden");
                    monthDateSelectWrapper.classList.add("hidden");
                    scheduleBy.value = "";

                    // Reset all buttons and their icons
                    buttons.forEach((b) => {
                        const bIcon = b.querySelector("i");
                        b.classList.remove("active");
                        bIcon.className = "fa-regular fa-circle";
                    });

                    // Activate the clicked button
                    btn.classList.add("active");
                    const btnIcon = btn.querySelector("i");
                    btnIcon.className = "fa-solid fa-check";
                    // Show or hide ticket wrappers based on the button's value
                    if (btn.value === "ticket") {
                        ticketWrappers.forEach((wrapper) =>
                            wrapper.classList.remove("hidden")
                        );

                        calendarInputButton.setAttribute(
                            "data-calendar-type",
                            "single-date"
                        );
                        new CustomCalendar(
                            calendarInputButton
                        ).singleDaySelection({ disablePastDates: true });
                        eventType.value = "ticket";
                    } else if (btn.value === "pass") {
                        ticketWrappers.forEach((wrapper) =>
                            wrapper.classList.add("hidden")
                        );

                        calendarInputButton.setAttribute(
                            "data-calendar-type",
                            "multi-range"
                        );
                        new CustomCalendar(
                            calendarInputButton
                        ).multiRangeSelection({ disablePastDates: true });

                        custompassWrapper.classList.remove("hidden");
                        eventType.value = "pass";
                    }
                });
            });

            scheduleBy.addEventListener("change", () => {
                const monthDateSelectError =
                    monthDateSelectWrapper.querySelector(
                        ".month-date-select-error"
                    );
                const weekDaySelectError = weekDaySelectWrapper.querySelector(
                    ".week-day-select-error"
                );

                monthDateSelectError.textContent = "";
                weekDaySelectError.textContent = "";

                scheduleByError.textContent = "";
                eventTypeItems.forEach((item) => {
                    const errorText = item.querySelector(
                        ".error-text, .calender-error-text"
                    );
                    errorText.textContent = "";
                });
                const scheduleByValue = scheduleBy.value.trim();

                if (scheduleByValue === "singleDay") {
                    calendarInputButton.setAttribute(
                        "data-calendar-type",
                        "single-date"
                    );
                    new CustomCalendar(calendarInputButton).singleDaySelection({
                        disablePastDates: true,
                    });
                } else if (scheduleByValue === "daily") {
                    // initialize multi range date picker
                    calendarInputButton.setAttribute(
                        "data-calendar-type",
                        "range"
                    );
                    new CustomCalendar(calendarInputButton).rangeSelection({
                        disablePastDates: true,
                    });
                } else if (scheduleByValue === "weekly") {
                    weekDaySelectWrapper.classList.remove("hidden");
                    monthDateSelectWrapper.classList.add("hidden");
                    calendarInputButton.setAttribute(
                        "data-calendar-type",
                        "range"
                    );
                    new CustomCalendar(calendarInputButton).rangeSelection({
                        disablePastDates: true,
                    });
                } else if (scheduleByValue === "monthly") {
                    weekDaySelectWrapper.classList.add("hidden");
                    monthDateSelectWrapper.classList.remove("hidden");
                    calendarInputButton.setAttribute(
                        "data-calendar-type",
                        "range"
                    );
                    new CustomCalendar(calendarInputButton).rangeSelection({
                        disablePastDates: true,
                    });
                } else {
                    weekDaySelectWrapper.classList.add("hidden");
                    monthDateSelectWrapper.classList.add("hidden");
                    calendarInputButton.setAttribute(
                        "data-calendar-type",
                        "single-date"
                    );
                    new CustomCalendar(calendarInputButton).singleDaySelection({
                        disablePastDates: true,
                    });
                }
            });
        }
    }

    generateError(
        errorMessage,
        errorElement,
        extraEls = null,
        extraElsShake = false,
        extraElsBorder = false
    ) {
        errorElement.textContent = errorMessage;
        if (extraEls) {
            extraEls.forEach((el) => {
                if (extraElsShake) {
                    el.classList.add("error-shake");
                }

                if (extraElsBorder) {
                    el.classList.add("error-border");
                }
            });
        }
        setTimeout(() => {
            errorElement.classList.remove("error-shake");
            if (extraEls) {
                extraEls.forEach((el) => {
                    if (extraElsShake) {
                        el.classList.remove("error-shake");
                    }

                    if (extraElsBorder) {
                        el.classList.remove("error-border");
                    }
                });
            }
        }, 500);
    }

    validateEventType() {
        const createEventTypeWrapper = document.querySelector(
            ".create-event-type-wapper"
        );
        const buttonWrapper = document.querySelector(".type-of-event-wrapper");
        const buttons = buttonWrapper.querySelectorAll(".type-of-event-btn");
        const typeOfEventBtnError = document.querySelector(
            ".type-of-event-btn-error"
        );
        const createEventTypeWapper = document.querySelector(
            ".create-event-type-wapper"
        );
        const customCalendarInput = createEventTypeWapper.querySelector(
            ".calender-input-button"
        );

        let isValid = true;
        let hasActiveTypeOfEvent = false;
        let eventType = null;

        // Check if any button is active
        for (const btn of buttons) {
            if (btn.classList.contains("active")) {
                typeOfEventBtnError.textContent = "";
                hasActiveTypeOfEvent = true;
                eventType = btn.value;
                break;
            }
        }

        // If no active event type, show an error
        if (!hasActiveTypeOfEvent) {
            this.generateError(
                "Event type is required!",
                typeOfEventBtnError,
                buttons,
                true,
                true
            );
            isValid = false;
        }

        if (hasActiveTypeOfEvent) {
            const eventTypeItems =
                createEventTypeWrapper.querySelectorAll(".event-type-items");
            const scheduleByWrapper = document.querySelector(
                ".schedule-by-wrapper"
            );
            const scheduleBy = scheduleByWrapper.querySelector("#schedule-by");
            const scheduleByError = scheduleByWrapper.querySelector(
                "#schedule-by + .error-text"
            );
            const scheduleByValue = scheduleBy?.value?.trim();
            const customPassInput = document.querySelectorAll(".custom-pass");

            // Validate the "Schedule By" input
            if (!scheduleByValue && eventType !== "pass") {
                this.generateError(
                    "Schedule by is required!",
                    scheduleByError,
                    [scheduleByWrapper],
                    true
                );
                isValid = false;
            } else {
                scheduleByError.textContent = "";
            }

            if (scheduleByValue === "singleDay" && eventType !== "pass") {
                valuesToDisplay.scheduleBy = "singleDay";
                valuesToDisplay.eventDate =
                    customCalendarInput.value.split(" to ")[0];
            } else if (scheduleByValue === "daily" && eventType !== "pass") {
                valuesToDisplay.scheduleBy = "daily";
                valuesToDisplay.eventDate =
                    customCalendarInput.value.split(" to ")[0];
            } else if (scheduleByValue === "weekly" && eventType !== "pass") {
                const weekDaySelectWrapper =
                    createEventTypeWrapper.querySelector(
                        ".week-day-select-wrapper"
                    );
                const weekDaySelect =
                    weekDaySelectWrapper.querySelector(".week-day-select");
                const weekDaySelectError = weekDaySelectWrapper.querySelector(
                    ".week-day-select-error"
                );

                if (!weekDaySelect.value) {
                    this.generateError(
                        "Weekday is required!",
                        weekDaySelectError,
                        [weekDaySelectWrapper],
                        true
                    );
                    isValid = false;
                } else {
                    valuesToDisplay.scheduleBy = "weekly";
                    valuesToDisplay.eventDate =
                        customCalendarInput.value.split(" to ")[0];
                    weekDaySelectError.textContent = "";
                }
            } else if (scheduleByValue === "monthly" && eventType !== "pass") {
                const monthDateSelectWrapper =
                    createEventTypeWrapper.querySelector(
                        ".month-date-select-wrapper"
                    );
                const monthDateSelect =
                    monthDateSelectWrapper.querySelector(".month-date-select");
                const monthDateSelectError =
                    monthDateSelectWrapper.querySelector(
                        ".month-date-select-error"
                    );

                if (!monthDateSelect.value) {
                    this.generateError(
                        "Month date is required!",
                        monthDateSelectError,
                        [monthDateSelectWrapper],
                        true
                    );
                    isValid = false;
                } else {
                    valuesToDisplay.scheduleBy = "monthly";
                    valuesToDisplay.eventDate =
                        customCalendarInput.value.split(" to ")[0];
                    monthDateSelectError.textContent = "";
                }
            } else if (eventType === "pass") {
                valuesToDisplay.scheduleBy = "custom";
                valuesToDisplay.eventDate =
                    customCalendarInput.value.split(" to ")[0];

                customPassInput.forEach((item) => {
                    if (item.checked) {
                        if (!valuesToDisplay.customPass.includes(item.value)) {
                            valuesToDisplay.customPass.push(item.value);
                        }
                    } else {
                        valuesToDisplay.customPass =
                            valuesToDisplay.customPass.filter(
                                (val) => val !== item.value
                            );
                    }
                });
            }

            let startTime = null;
            let endTime = null;

            // Validate each event type item
            eventTypeItems.forEach((item) => {
                const label = item.querySelector("label");
                const input = item.querySelector(
                    "input, select, .calender-input-button"
                );
                const errorText = item.querySelector(
                    ".error-text, .calender-error-text"
                );

                if (input) {
                    const inputValue = input.value?.trim() || "";
                    if (!inputValue) {
                        const labelText = label?.textContent || "This field";
                        this.generateError(
                            `${labelText} is required!`,
                            errorText,
                            [item],
                            true
                        );
                        isValid = false;
                    } else {
                        errorText.textContent = "";

                        if (input.classList.contains("event-start-time")) {
                            startTime = input.value;
                        }
                        if (input.classList.contains("event-end-time")) {
                            endTime = input.value;
                        }
                    }
                }
            });

            /*if (startTime && endTime) {
                const duration = calculateDurationInHours(startTime, endTime);
                console.log(duration);
                valuesToDisplay.timeDuration = duration;
            }*/


            if (this.reservedSwitch.checked) {
                if (this.seatingMap.value.trim() == '' || this.seatingPlan.value.trim() == '') {
                    this.generateError(
                        "Seating Plan is required!",
                        this.seatingValidationError,
                        [this.seatingValidationError],
                        true
                    );
                    isValid = false;
                }
                else {
                    /*const wrapper = document.querySelector(".add-ticket-tab-bottom");
                    // wrapper.querySelector(".add-ticket-bottom.tickets").innerHTML = "";
                    const deleteBtns = wrapper.querySelectorAll(".delete-category-btn");
                    deleteBtns.forEach(btn => btn.click());
                    console.log("reservedSwitch: ", this.reservedSwitch, "seatingMap: ", this.seatingMap, "seatingPlan: ", this.seatingPlan.value);
                    const seatingPlan = JSON.parse(this.seatingPlan.value);
                    let freeTier = {}, donatedTier = {}, paidTiers = {};
                    Object.entries(seatingPlan.tiers).forEach(([key, tier]) => {

                        if (tier.type === "free") {
                            freeTier = tier;
                        }
                        else if (tier.type === "donated") {
                            donatedTier = tier
                        }
                        else if (tier.type === "paid") {
                            paidTiers[key] = tier;
                        }
                    });
                    console.log("freeTier", freeTier, "donatedTier", donatedTier, "paidTiers", paidTiers);

                    if (Object.keys(freeTier).length > 0) {
                        const free_tickets = document.querySelector('input[name="free_tickets"]');
                        if (free_tickets) {
                            free_tickets.value = freeTier.qty;
                            free_tickets.setAttribute("readonly", true);
                        }
                    }
                    if (Object.keys(donatedTier).length > 0) {
                        const donated_tickets = document.querySelector('input[name="donated_tickets"]');
                        if (donated_tickets) {
                            donated_tickets.value = donatedTier.qty;
                            donated_tickets.setAttribute("readonly", true);
                        }
                    }
                    if (Object.keys(paidTiers).length > 0) {
                        // Add new category buttons if needed
                        Object.entries(paidTiers).slice(0, -1).forEach(() => {
                            wrapper.querySelector(".create-new-category-btn").click();
                        });

                        Object.entries(paidTiers).forEach(([key, tier], i) => {
                            const items = wrapper.querySelectorAll(".add-ticket-paid-items");
                            if (i < items.length) {
                                const item = items[i];

                                const packageNameInput = item.querySelector('[name="package_name[]"]');
                                if (packageNameInput) {
                                    packageNameInput.value = tier.name;
                                    packageNameInput.setAttribute("readonly", true);
                                }

                                const packageQtyInput = item.querySelector('[name="package_qty[]"]');
                                if (packageQtyInput) {
                                    packageQtyInput.value = tier.qty;
                                    packageQtyInput.setAttribute("readonly", true);
                                }

                                // Keep price input enabled
                                const packagePriceInput = item.querySelector('[name="package_price[]"]');
                                if (packagePriceInput) {
                                    packagePriceInput.removeAttribute("readonly");
                                }
                            }
                        });
                    }*/
                    const wrapper = document.querySelector(".add-ticket-tab-bottom");
                    const seatingPlan = JSON.parse(this.seatingPlan.value);

                    let freeTier = {}, donatedTier = {}, paidTiers = {};
                    Object.entries(seatingPlan.tiers).forEach(([key, tier]) => {
                        if (tier.type === "free") {
                            freeTier = tier;
                        } else if (tier.type === "donated") {
                            donatedTier = tier;
                        } else if (tier.type === "paid") {
                            paidTiers[key] = tier;
                        }
                    });

                    // Remove only unmatched paid tiers
                    const paidTierNames = Object.values(paidTiers).map(t => t.name);
                    const paidItems = wrapper.querySelectorAll(".add-ticket-paid-items");

                    paidItems.forEach(item => {
                        const packageNameInput = item.querySelector('[name="package_name[]"]');
                        if (packageNameInput && !paidTierNames.includes(packageNameInput.value)) {
                            const deleteBtn = item.querySelector(".delete-category-btn");
                            if (deleteBtn) deleteBtn.click();
                        }
                    });

                    // Populate free and donated tiers
                    if (Object.keys(freeTier).length > 0) {
                        const free_tickets = document.querySelector('input[name="free_tickets"]');
                        if (free_tickets) {
                            free_tickets.value = freeTier.qty;
                            free_tickets.setAttribute("readonly", true);
                        }
                    }
                    if (Object.keys(donatedTier).length > 0) {
                        const donated_tickets = document.querySelector('input[name="donated_tickets"]');
                        if (donated_tickets) {
                            donated_tickets.value = donatedTier.qty;
                            donated_tickets.setAttribute("readonly", true);
                        }
                    }

                    // Add missing paid tier UI blocks if needed
                    const currentPaidItems = wrapper.querySelectorAll(".add-ticket-paid-items");
                    const currentCount = currentPaidItems.length;
                    const neededCount = Object.keys(paidTiers).length;

                    for (let i = currentCount; i < neededCount; i++) {
                        wrapper.querySelector(".create-new-category-btn").click();
                    }

                    // Update each paid tier block with correct data
                    Object.entries(paidTiers).forEach(([key, tier], i) => {
                        const items = wrapper.querySelectorAll(".add-ticket-paid-items");
                        if (i < items.length) {
                            const item = items[i];

                            const packageNameInput = item.querySelector('[name="package_name[]"]');
                            if (packageNameInput) {
                                packageNameInput.value = tier.name;
                                packageNameInput.setAttribute("readonly", true);
                            }

                            const packageQtyInput = item.querySelector('[name="package_qty[]"]');
                            if (packageQtyInput) {
                                packageQtyInput.value = tier.qty;
                                packageQtyInput.setAttribute("readonly", true);
                            }

                            const packagePriceInput = item.querySelector('[name="package_price[]"]');
                            if (packagePriceInput) {
                                packagePriceInput.removeAttribute("readonly");
                            }
                        }
                    });

                    this.seatingValidationError.textContent = "";
                }
            }
            else {
                this.seatingValidationError.textContent = "";
                this.seatingMap.value == '';
                this.seatingPlan.value == ''
            }

        }
        return isValid;
    }

    validateLocation() {
        const wrappers =
            this.eventLocationWrapper.querySelectorAll(".item-wrapper");
        const venueName =
            this.eventLocationWrapper.querySelector(".event-venue-name");

        let flag = true;

        wrappers.forEach((wrapper) => {
            const label = wrapper.querySelector("label");
            const input = wrapper.querySelector("input");
            const error = wrapper.querySelector(".error-text");

            if (!input.value) {
                this.sliderWrapper.classList.add("error-shake");
                input.classList.add("error-border");
                error.textContent = `${label.textContent.toLowerCase()} is required!`;
                setTimeout(() => {
                    this.sliderWrapper.classList.remove("error-shake");
                    input.classList.remove("error-border");
                }, 500);
                flag = false;
            } else {
                error.textContent = "";
            }
        });

        if (flag) {
            valuesToDisplay.venueName = venueName.value.trim();
        }

        return flag;
    }

    validateDescription() {
        const eventDescription = this.eventDescription.value.trim();
        console.log("Description ->", eventDescription);

        if (!eventDescription) {
            this.sliderWrapper.classList.add("error-shake");
            this.eventDescription.classList.add("error-border");

            this.eventDescriptionError.textContent =
                "Event description is required!";

            setTimeout(() => {
                this.sliderWrapper.classList.remove("error-shake");
                this.eventDescription.classList.remove("error-border");
            }, 500);
            return false;
        }
        this.eventDescriptionError.textContent = "";

        valuesToDisplay.description = eventDescription;
        return true;
    }

    validateEventHeaderImage() {
        const eventHeaderInputImage = this.eventHeaderInputImage.value;
        const eventHeaderPrevImage = this.eventHeaderPrevImage.src;

        const parsedUrl = new URL(eventHeaderPrevImage);
        const defaultPath = "/images/placeholder.png";
        const relativeUrl = parsedUrl.pathname;

        if (relativeUrl === defaultPath) {
            this.sliderWrapper.classList.add("error-shake");

            this.eventHeaderError.textContent =
                "Event header image is required!";
            setTimeout(() => {
                this.sliderWrapper.classList.remove("error-shake");
            }, 500);
            return false;
        }
        this.eventHeaderError.textContent = "";
        return true;
    }

    validateMedia() {
        const meadaWrapper = this.meadaWrapper.innerHTML;
        const mediaImages = this.meadaWrapper.querySelectorAll("img");
        const mediaVideos = this.meadaWrapper.querySelectorAll("video");

        if (!meadaWrapper) {
            this.sliderWrapper.classList.add("error-shake");

            this.eventBannerError.textContent = "Event banner is required!";
            setTimeout(() => {
                this.sliderWrapper.classList.remove("error-shake");
            }, 500);
            return false;
        }

        this.eventBannerError.textContent = "";
        valuesToDisplay.bannerMedia.length = 0; // Reset all values to default

        const mediaElements = [...mediaImages, ...mediaVideos];

        mediaElements.forEach((element) => {
            // Process images
            if (element.nodeName === "IMG" && element.src) {
                valuesToDisplay.bannerMedia.push({
                    src: element.src,
                    type: "image",
                });
            }
            // Process videos
            else if (element.nodeName === "VIDEO" && element.src) {
                valuesToDisplay.bannerMedia.push({
                    src: element.src,
                    type: "video",
                });
            }
        });

        return true;
    }

    togglePurchaseLocation() {
        const selectedMode = this.paymentMode.value;

        if (selectedMode === "offline") {
            this.purchaseLocationWrapper.classList.remove("hidden");
        } else {
            this.purchaseLocationWrapper.classList.add("hidden");
        }
    }

    // 30-10-2024
    validatePaymentMode() {
        const paymentMode = this.paymentMode.value.trim();
        const refundOption = this.refundOption.value;

        if (!paymentMode) {
            this.sliderWrapper.classList.add("error-shake");

            this.paymentModeError.textContent =
                "Event payment mode is required!";
            setTimeout(() => {
                this.sliderWrapper.classList.remove("error-shake");
            }, 500);
            return false;
        }
        this.togglePurchaseLocation();
        this.paymentModeError.textContent = "";

        if (!refundOption) {
            this.sliderWrapper.classList.add("error-shake");

            this.refundOptionError.textContent = "Refund option is required!";
            setTimeout(() => {
                this.sliderWrapper.classList.remove("error-shake");
            }, 500);
            return false;
        }

        this.refundOptionError.textContent = "";
        return true;
    }
    // 30-10-2024

    // 30-10-2024
    validateCreateTicketPrice() {
        const wrappers = document.querySelectorAll(".add-ticket-paid-items");
        const sidebar = document.querySelector(".add-ticket-sidebar.tickets");
        let flag = true;

        wrappers.forEach((wrapper) => {
            const inputWrappers = wrapper.querySelectorAll(
                ".add-ticket-input-item-wrapper"
            );

            inputWrappers.forEach((inputWrapper) => {
                const inputItem = inputWrapper.querySelector(
                    ".add-ticket-paid-input"
                );
                const inputLabel = inputWrapper.querySelector(
                    ".add-ticket-paid-label"
                );
                const inputError = inputWrapper.querySelector(".error-text");

                if (!inputItem.value.trim()) {
                    flag = false;

                    setTimeout(() => {
                        sidebar.classList.remove("opacity-0");
                        sidebar.classList.add("show", "sidebar-error");

                        inputWrapper.classList.add("error-shake");
                        inputItem.classList.add("error-border");
                        inputError.textContent = `${inputLabel.innerHTML} is required!`;

                        setTimeout(() => {
                            inputWrapper.classList.remove("error-shake");
                            inputItem.classList.remove("error-border");
                            sidebar.classList.remove("sidebar-error");
                        }, 500);
                    }, 150);
                } else {
                    inputLabel.classList.remove("error-border");
                    inputError.textContent = "";
                }
            });
        });

        if (flag) {
            const ticketDefaultPrice = document.querySelector(
                ".add-ticket-paid-price.default"
            );
            valuesToDisplay.defaultPrice = `$${ticketDefaultPrice.value.trim()}`;
        }

        return flag;
    }

    // 30-10-2024

    validateTicketLocation() {
        const ticketLocation = this.purchaseLocation.value.trim().toLowerCase();
        const ticketLocationMap = this.ticketLocationMap.value
            .trim()
            .toLowerCase();
        const paymentMode = this.paymentMode.value.trim().toLowerCase();

        if (paymentMode === "offline") {
            if (!ticketLocationMap && !ticketLocation) {
                this.sliderWrapper.classList.add("error-shake");
                this.purchaseLocationError.textContent =
                    "Ticket location is required For Offline Event!";
                this.ticketLocationMapError.textContent =
                    "Map link is required For Offline Event!";

                setTimeout(() => {
                    this.sliderWrapper.classList.remove("error-shake");
                }, 500);

                return false;
            } else if (!ticketLocation) {
                this.sliderWrapper.classList.add("error-shake");
                this.purchaseLocationError.textContent =
                    "Ticket location is required For Offline Event!";
                setTimeout(() => {
                    this.sliderWrapper.classList.remove("error-shake");
                }, 500);

                this.ticketLocationMapError.textContent = "";
                return false;
            } else if (!ticketLocationMap) {
                this.sliderWrapper.classList.add("error-shake");
                this.ticketLocationMapError.textContent =
                    "Map link is required For Offline Event!";
                setTimeout(() => {
                    this.sliderWrapper.classList.remove("error-shake");
                }, 500);

                this.purchaseLocationError.textContent = "";
                return false;
            }

            this.ticketLocationMapError.textContent = "";
            this.purchaseLocationError.textContent = "";
            return true;
        }
        return true;
    }

    // 30-10-2024
    validateTicketFAQ() {
        const wrappers = document.querySelectorAll(".event-faq-wrapper");
        let isValid = true;

        wrappers.forEach((wrapper) => {
            const faqlabels = wrapper.querySelectorAll(
                ".create-event-faq-label"
            );
            const faqInput = wrapper.querySelectorAll(
                ".create-event-faq-input"
            );

            faqlabels.forEach((label, index) => {
                const errorText = faqInput[index].nextElementSibling;

                if (!faqInput[index].value.trim()) {
                    this.sliderWrapper.classList.add("error-shake");
                    faqInput[index].classList.add("error-border");
                    errorText.textContent = `${label.innerHTML} is required!`;
                    isValid = false;

                    setTimeout(() => {
                        this.sliderWrapper.classList.remove("error-shake");
                        faqInput[index].classList.remove("error-border");
                    }, 500);
                } else {
                    errorText.textContent = "";
                }
            });
        });

        // Clear Faq items
        valuesToDisplay.faq.length = 0;

        if (isValid) {
            console.log(wrappers);

            wrappers.forEach((wrapper) => {
                const faqQuestion = wrapper.querySelector(
                    ".event-faq-question"
                );
                console.log(faqQuestion);
                const faqAnswer = wrapper.querySelector(".event-faq-answer");

                valuesToDisplay.faq.push({
                    question: faqQuestion.value.trim(),
                    answer: faqAnswer.value.trim(),
                });
            });
        }
        return isValid;
    }

    generatePreview(data) {
        // Generate Preview Event Banner Slider
        generatePreviewEventBannerSlider(data.bannerMedia);
        // Generate Preview Event Location, Date-Time, Description & FAQ
        generatePreviewEventTitleLocationAndDateTime(
            data.eventName,
            data.defaultPrice,
            data.venueName,
            data.eventDate,
            data.timeDuration,
            data.description,
            data.faq_Items
        );
    }

    clearForm() {
        const allInputs = document.querySelectorAll(
            "input:not([type='checkbox']):not([type='radio']), textarea, select, button, .error-text, .grey-border, .add-ticket-paid-items.ticket, .event-faq-wrapper"
        );

        valuesToDisplay.bannerMedia = [];
        valuesToDisplay.eventName = null;
        valuesToDisplay.scheduleBy = null;
        valuesToDisplay.eventDate = null;
        valuesToDisplay.timeDuration = null;
        valuesToDisplay.defaultPrice = null;
        valuesToDisplay.venueName = null;
        valuesToDisplay.description = null;
        valuesToDisplay.faq = [];

        allInputs.forEach((item) => {
            if (item.nodeName === "INPUT") {
                item.value = "";
            } else if (item.nodeName === "SELECT") {
                if (!item.classList.contains("default")) {
                    item.value = "";
                }
            } else if (
                item.nodeName === "BUTTON" &&
                item.classList.contains("calender-input-button")
            ) {
                const defaultText = item.getAttribute("data-default-text");
                if (defaultText) {
                    item.textContent = defaultText;
                }
                /*if (item.classList.contains("calender-input-button")) {
                    item.setAttribute("data-calender-type", "single-date");
                    const calendar = new CustomCalendar(item);
                    calendar.singleDaySelection();
                    calendar.setOptions("single-date", {
                        defaultButtonText: "Select Date",
                        disablePastDates: true,
                        selectedDate: "",
                    });
                }*/
            } else if (item.classList.contains("grey-border")) {
                if (!item.classList.contains("default")) {
                    item.remove();
                }
            } else if (item.classList.contains("add-ticket-paid-items")) {
                if (!item.classList.contains("default")) {
                    item.remove();
                }
            } else if (item.classList.contains("event-faq-wrapper")) {
                if (!item.classList.contains("default")) {
                    item.remove();
                }
            }
        });
        const buttons = document.querySelectorAll(".type-of-event-btn ");
        buttons.forEach((button) => {
            button.classList.remove("active");
            const icon = button.querySelector("i");
            if (icon.classList.contains("fa-check")) {
                icon.classList.remove("fa-solid", "fa-check");
                icon.classList.add("fa-regular", "fa-circle");
            }
        });
        document
            .querySelector(".create-event-type-wapper")
            .classList.add("hidden");

        // Clear All Dates

        /*const calendarWrappers = document.querySelectorAll(
            ".custom-calendar-wrapper"
        );
        calendarWrappers.forEach((wrapper) => {
            const calendarInputButton = wrapper.querySelector(
                ".calender-input-button"
            );
            const customCalendar = wrapper.querySelector(".calendar-modal");

            const calendar = new CustomCalendar(
                customCalendar,
                calendarInputButton
            );

            if (customCalendar.classList.contains("single-date-selector")) {
                calendar.clearAll();
            }
            if (customCalendar.classList.contains("range-selector")) {
                calendar.clearAll();
            }
            if (customCalendar.classList.contains("multi-date-selector")) {
                calendar.clearAll();
            }
        });*/
    }

    // 30-10-2024
}

function validatePrice(input) {
    let value = input.value
        .replace(/[^0-9.]/g, "")
        .replace(/(\..*)\..*/g, "$1");

    const decimalIndex = value.indexOf(".");
    if (decimalIndex !== -1 && value.length - decimalIndex - 1 > 2) {
        value = value.slice(0, decimalIndex + 3); // Keep only two decimal places
    }

    input.value = value;
}

// 30-10-2024

function validateInteger(input, minValue = 1) {
    let value = input.value
        .replace(/[^0-9.]/g, "")
        .replace(/(\..*)\..*/g, "$1");
    input.value = Number(value.trim());

    if (input.value === "" || parseInt(input.value) < minValue) {
        input.value = Number(minValue);
    }
}

function tabMenu() {
    const tabWrappers = document.querySelectorAll(".tab-wrapper");

    tabWrappers.forEach((wrapper) => {
        const header = wrapper.querySelector(".tab-header");
        const tabBody = wrapper.querySelector(".tab-body");
        const headerBtns = header.querySelectorAll(".tab-btns");
        const tabBodyItems = tabBody.querySelectorAll(".tab-body-item");

        headerBtns.forEach((btn, index) => {
            btn.addEventListener("click", () => {
                tabBodyItems.forEach((tabBodyItem) => {
                    tabBodyItem.classList.add("hidden");
                });

                headerBtns.forEach((button) => {
                    button.classList.remove("active");
                });

                tabBodyItems[index].classList.remove("hidden");
                btn.classList.add("active");
            });
        });
    });
}

function handleMultipleTicketMenu() {
    const createTicketsButtonMainWrapper = document.querySelector(
        ".create-tickets-button-main-wrapper"
    );
    const createTicketsButtons =
        createTicketsButtonMainWrapper.querySelectorAll(
            ".create-tickets-button"
        );
    const addTicketSidebar = document.querySelector(".add-ticket-sidebar.tickets");
    const addTicketButton = document.querySelectorAll(".add-ticket-button");

    let lastClickedButton = null; // Track the last clicked button

    createTicketsButtons.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            if (lastClickedButton === btn) {
                // If the same button is clicked, do nothing
                return;
            }

            lastClickedButton = btn; // Update the last clicked button
            addTicketSidebar.classList.remove("opacity-0");
            addTicketSidebar.classList.add("show");

            // Click the associated add ticket button
            addTicketButton[index].click();
        });

        // Remove Sidebar If Cancel or Save Button Clicked
        const SaveCancelButtons = addTicketSidebar.querySelectorAll(
            ".add-tickets-bottom-btn"
        );
        SaveCancelButtons.forEach((button) => {
            button.addEventListener("click", () => {
                addTicketSidebar.classList.remove("show");
                addTicketSidebar.classList.add("opacity-0");
                lastClickedButton = null;
            });
        });
    });

    // Create New Category For Paid Tickets
    const createNewCategoryBtn = addTicketSidebar.querySelector(
        ".create-new-category-btn"
    );
    createNewCategoryBtn.addEventListener("click", handleCreateNewCategory);

    function handleCreateNewCategory() {
        const mainWrapper = document.querySelector(".add-ticket-bottom");

        const addTicketPaidItems = document.createElement("div");
        addTicketPaidItems.classList.add("add-ticket-paid-items");

        const fields = [
            {
                label: "Name",
                name: "package_name[]",
                id: `add-ticket-paid-name-${Date.now()}`,
                placeholder: "General Admission",
                type: "text",
            },
            {
                label: "Available quantity",
                name: "package_qty[]",
                id: `add-ticket-paid-available-quantity-${Date.now()}`,
                placeholder: "1",
                type: "text",
                events: {
                    oninput: "validateInteger(this, 0)",
                    onpaste: "validateInteger(this, 0)",
                },
            },
            {
                label: "Ticket Price",
                name: "package_price[]",
                id: `add-ticket-paid-price-${Date.now()}`,
                placeholder: "250",
                type: "text",
                events: {
                    oninput: "validatePrice(this)",
                    onpaste: "validatePrice(this)",
                },
            },
        ];

        // Append Input Items
        fields.forEach((field) => {
            const wrapper = document.createElement("div");
            wrapper.classList.add(
                "add-ticket-input-item-wrapper",
                "mb-1",
                "transition",
                "flex",
                "flex-column",
                "gap-05",
                "justify-start",
                "items-start",
                "border-box"
            );

            // Create and append label
            const label = document.createElement("label");
            label.setAttribute("for", field.id);
            label.classList.add(
                "transition",
                "border-box",
                "add-ticket-paid-label"
            );
            label.textContent = field.label;
            wrapper.appendChild(label);

            // Create and append input
            const input = document.createElement("input");
            input.type = field.type;
            input.name = field.name;
            input.id = field.id;
            input.classList.add(
                "add-ticket-paid-input",
                "transition",
                "w-full",
                "event-input",
                "border-box"
            );
            input.placeholder = field.placeholder;

            if (field.label === "Ticket Price") {
                inputWrapper = document.createElement("div");
                inputWrapper.classList.add("ticket-price-wrapper");

                const currencySymbol = document.createElement("i");
                currencySymbol.classList.add(
                    "fa-solid",
                    "fa-dollar-sign",
                    "absolute"
                );

                inputWrapper.appendChild(currencySymbol);
                inputWrapper.appendChild(input);
                wrapper.appendChild(inputWrapper);
            } else {
                wrapper.appendChild(input);
            }

            // Attach events if any
            if (field.events) {
                for (const event in field.events) {
                    input.setAttribute(event, field.events[event]);
                }
            }

            // Create and append error text
            const errorText = document.createElement("p");
            errorText.classList.add("error-text", "border-box");
            wrapper.appendChild(errorText);

            // Append the wrapper to the addTicketPaidItems div
            addTicketPaidItems.appendChild(wrapper);
        });

        // Create and append the Delete Category button
        const deleteButtonWrapper = document.createElement("div");
        deleteButtonWrapper.classList.add(
            "mb-1",
            "transition",
            "flex",
            "flex-column",
            "gap-05",
            "justify-start",
            "items-start",
            "border-box"
        );

        const deleteButton = document.createElement("button");
        deleteButton.classList.add("delete-category-btn", "transition");
        deleteButton.type = "button";
        deleteButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                <path d="M200-440v-80h560v80H200Z"/>
            </svg>
            Delete Category
        `;

        // Add event listener to delete the category
        deleteButton.addEventListener("click", (event) => {
            event.stopPropagation();
            mainWrapper.removeChild(addTicketPaidItems);
        });

        deleteButtonWrapper.appendChild(deleteButton);
        addTicketPaidItems.appendChild(deleteButtonWrapper);

        // Append the complete addTicketPaidItems to the mainWrapper
        // mainWrapper.appendChild(addTicketPaidItems);

        const secondIndexChild = mainWrapper.children[1];
        if (secondIndexChild) {
            mainWrapper.insertBefore(addTicketPaidItems, secondIndexChild);
        } else {
            // Fallback if there's less than 2 children
            mainWrapper.appendChild(addTicketPaidItems);
        }
    }

    document.addEventListener("click", (event) => {
        const isClickInsideSidebar = addTicketSidebar.contains(event.target);
        const isClickInsideButton = Array.from(createTicketsButtons).some(
            (btn) => btn.contains(event.target)
        );

        if (!isClickInsideSidebar && !isClickInsideButton) {
            addTicketSidebar.classList.remove("show");
            addTicketSidebar.classList.add("opacity-0");
            lastClickedButton = null; // Reset the last clicked button
        }
    });
}

function createNewFaq() {
    const mainWrapper = document.querySelector(".event-faq-items-wrapper");
    const faqInputNamesObj = {
        question: "Question",
        answer: "Answer",
    };

    // Create a unique timestamp for IDs
    const timestamp = Date.now();

    // Create the FAQ wrapper
    const faqWrapper = document.createElement("div");
    faqWrapper.classList.add("event-faq-wrapper");

    // Create the FAQ Inner wrapper
    for (const key in faqInputNamesObj) {
        const faqInnerWrapper = document.createElement("div");
        faqInnerWrapper.classList.add(
            "mb-1",
            "transition",
            "flex",
            "flex-column",
            "gap-05",
            "justify-start",
            "items-start",
            "border-box"
        );

        const label = document.createElement("label");
        label.classList.add(
            "transition",
            "border-box",
            "create-event-faq-label"
        );
        label.textContent = faqInputNamesObj[key];
        label.setAttribute("for", `${key}-${timestamp}`); // Set unique 'for' attribute using timestamp

        const input = document.createElement("input");
        input.classList.add(
            "transition",
            "w-full",
            "event-input",
            "border-box",
            "create-event-faq-input"
        );
        input.type = "text"; // Set input type to text
        input.name = `${key}[]`; // Set unique name attribute using timestamp
        input.id = `${key}-${timestamp}`; // Set unique id for input using timestamp
        input.placeholder =
            key === "question"
                ? "Are there any service fees or additional charges?"
                : "Yes, a service fee may apply to your ticket purchase. The total cost, including any fees, will be displayed during checkout.";

        key === "question"
            ? input.classList.add("event-faq-question")
            : input.classList.add("event-faq-answer");

        const paragraph = document.createElement("p");
        paragraph.classList.add("error-text", "border-box");

        // Append label and input to the inner wrapper
        faqInnerWrapper.appendChild(label);
        faqInnerWrapper.appendChild(input);
        faqInnerWrapper.appendChild(paragraph);

        // Append the inner wrapper to the FAQ wrapper
        faqWrapper.appendChild(faqInnerWrapper);
    }

    // Create the delete button
    const deleteBtn = document.createElement("button");
    deleteBtn.classList.add("delete-faq-btn", "transition");
    deleteBtn.type = "button";
    deleteBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M200-440v-80h560v80H200Z"></path>
        </svg>
        Delete FAQ
    `;
    deleteBtn.addEventListener("click", function () {
        faqWrapper.remove(); // Remove the FAQ section
    });
    faqWrapper.appendChild(deleteBtn);
    mainWrapper.insertBefore(faqWrapper, mainWrapper.firstChild);
}

function handleEventFormNextSlide(currentIndex) {
    console.log(currentIndex);

    // Get the container with all event modal inner sections
    const modalInner = document.getElementById("create-event-modal-inner");

    // Get all direct children (sections) of the container
    const children = Array.from(modalInner.children);

    // Show and hide the back button on modal
    const backBtn = document.querySelector(".modal-event-back-btn");
    currentIndex + 1 === 0
        ? backBtn.classList.add("hidden")
        : backBtn.classList.remove("hidden");

    // Adding Current Index
    modalInner.setAttribute("data-index", currentIndex + 1);

    // Iterate through each child section
    children.forEach((child, index) => {
        if (index === currentIndex + 1) {
            // console.log("child", child);

            // Show the next section by removing scale-0 and hidden classes
            child.classList.remove("hidden");
            setTimeout(() => child.classList.remove("scale-0"), 50);
        } else {
            // Hide all other sections by adding scale-0 and hidden classes
            child.classList.add("hidden");
            setTimeout(() => child.classList.add("scale-0"), 200);
        }
    });
}

// 30-10-2024

function handleBackEventCreateModal() {
    // Get the container with all event modal inner sections
    const modalInner = document.getElementById("create-event-modal-inner");

    // Get the current index number of slide
    const currentIndex = parseInt(modalInner.getAttribute("data-index"));

    // Get all direct children (sections) of the container
    const children = Array.from(modalInner.children);

    // Show and hide the back button on modal
    const backBtn = document.querySelector(".modal-event-back-btn");
    currentIndex - 1 === 0
        ? backBtn.classList.add("hidden")
        : backBtn.classList.remove("hidden");

    // Adding Current Index
    modalInner.setAttribute("data-index", currentIndex - 1);

    // Iterate through each child section
    children.forEach((child, index) => {
        if (index === currentIndex - 1) {
            // Show the previous section by removing scale-0 and hidden classes
            child.classList.remove("hidden");
            setTimeout(() => child.classList.remove("scale-0"), 50);
        } else {
            // Hide all other sections by adding scale-0 and hidden classes
            child.classList.add("hidden");
            setTimeout(() => child.classList.add("scale-0"), 200);
        }
    });
}

// Function To Generate Preview Event Banner Slider
function generatePreviewEventBannerSlider(mediaItems) {
    const bannerWrapper = document.querySelector(
        ".event-prev-banner-item-wrapper"
    );
    bannerWrapper.innerHTML = "";

    mediaItems.forEach((item) => {
        const bannerItem = document.createElement("div");
        bannerItem.classList.add("swiper-slide");
        bannerItemInnerDiv = document.createElement("div");
        bannerItemInnerDiv.classList.add("overflow-hidden", "rounded-[4px]");

        if (item.type === "image") {
            const img = document.createElement("img");
            img.classList.add(
                "select-none",
                "object-cover",
                "transition-all",
                "duration-300",
                "ease-in-out",
                "hover:scale-[1.3]",
                "w-screen",
                "h-450px"
            );
            img.setAttribute("draggable", "false");
            img.src = item.src;
            bannerItemInnerDiv.appendChild(img);
            bannerItem.appendChild(bannerItemInnerDiv);
            bannerWrapper.appendChild(bannerItem);
        } else if (item.type === "video") {
            const video = document.createElement("video");
            video.classList.add(
                "select-none",
                "object-cover",
                "transition-all",
                "duration-300",
                "ease-in-out",
                "w-screen",
                "h-450px"
            );
            video.setAttribute("controls", "");
            video.setAttribute("muted", "");
            video.setAttribute("autoplay", "");
            video.setAttribute("loop", "");

            const source = document.createElement("source");
            source.setAttribute("src", item.src);
            source.setAttribute("type", "video/mp4");

            video.appendChild(source);
            const fallbackText = document.createTextNode(
                "Your browser does not support the video tag."
            );
            video.appendChild(fallbackText);
            bannerItemInnerDiv.appendChild(video);
            bannerItem.appendChild(bannerItemInnerDiv);
            bannerWrapper.appendChild(bannerItem);
        }
    });
}

// Function To Generate Preview Event Location, Date-Time, Description & FAQ
function generatePreviewEventTitleLocationAndDateTime(
    eventName,
    defaultPrice,
    venueName,
    eventDate,
    timeDuration,
    description,
    faq_Items
) {
    const eventPreviewWrapper = document.querySelector(
        "#event-preview-wrapper"
    );
    const displayEventTitle = eventPreviewWrapper.querySelector(
        ".event-prev-display-title"
    );
    const displayEventStartingPrice = eventPreviewWrapper.querySelector(
        ".event-prev-display-starting-price"
    );
    const displayEventVenueName = eventPreviewWrapper.querySelector(
        ".event-prev-display-venue-name"
    );
    const displayEventStartingDate = eventPreviewWrapper.querySelector(
        ".event-prev-display-starting-date"
    );
    const displayEventDurationTime = eventPreviewWrapper.querySelector(
        ".event-prev-display-duration-time"
    );
    const eventPrevDisplayDescription = eventPreviewWrapper.querySelector(
        ".event-prev-display-description"
    );
    const mainFaqWrapper = document.querySelector(
        ".event-prev-faq-item-wrapper"
    );

    displayEventTitle.innerHTML = eventName;
    displayEventStartingPrice.innerHTML = defaultPrice;
    displayEventVenueName.innerHTML = venueName;
    displayEventStartingDate.innerHTML = eventDate;
    displayEventDurationTime.innerHTML = timeDuration;
    eventPrevDisplayDescription.innerHTML = DOMPurify.sanitize(description);

    // Generate FAQ
    mainFaqWrapper.innerHTML = "";
    const mediaItems = faq_Items;

    mediaItems.forEach((item) => {
        const faqItem = document.createElement("div");
        faqItem.classList.add("border-b", "border-gray-100", "faq-item");

        const faqContent = `<div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                      <h3 class="text-lg font-semibold">${item.question}</h3>
                                      <span class="text-gray-500">
                                        <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                      </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                      <p class="py-4 pr-4 text-gray-700">${item.answer}</p>
                                    </div>`;

        faqItem.innerHTML = DOMPurify.sanitize(faqContent.trim());
        mainFaqWrapper.insertBefore(faqItem, mainFaqWrapper.firstChild);
    });

    // Handle FAQ expand/collapse
    handleFaq();
}

// Validate if new event is valid and pass all the checks
function handleEventCheckNext(currentIndex) {

    const validator = new FormValidator();
    console.log(valuesToDisplay);
    if (currentIndex === 0) {
        console.log(validator.validateOrganizerInformation());

        if (!validator.validateOrganizerInformation()) {
            return;
        }
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 1) {
        if (!validator.validateName()) {
            return;
        }
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 2) {
        if (!validator.validateEventType()) {
            return;
        } else if (!validateCustomPass(valuesToDisplay)) {
            return;
        }

        // const createEventModal = document.querySelector("#create-event-modal");
        const seatingSwitchBtn = document.querySelector("#reserved-seating-switch");
        // const reservedTopModal = document.querySelector(".reserved-top-modal");
        // const reservedModal = document.querySelector(".reserved-modal");
        // const closeBtns = reservedTopModal.querySelectorAll(".close-btn");
        // const reservedLayoutOptions = reservedTopModal.querySelector(".reserved-layout-options");
        // const seatMapWrapper = reservedTopModal.querySelector(".seat-map-wrapper");
        // const showSeatMapBtn = reservedTopModal.querySelector(".show-seat-map-btn");
        // const seatModalBackBtn = reservedTopModal.querySelector(".seat-modal-back-btn");


        // if (seatingSwitchBtn.checked && reservedTopModal && createEventModal) {
        // If Clicked on Close Btn

        //  ============================= Calling direct table & chair modal ========================================= //
        // handleResevedSelection('table-chair');
        //  ============================= Calling direct table & chair modal ========================================= //
        // closeBtns.forEach(btn => btn.addEventListener("click", () => toggleModal()));
        // toggleModal(false);

        // showSeatMapBtn.addEventListener("click", () => {
        //     reservedModal.classList.add("hidden");
        //     reservedLayoutOptions.classList.add("hidden");
        //     seatMapWrapper.classList.remove("hidden");
        // });

        // seatModalBackBtn.addEventListener("click", () => {
        //     seatMapWrapper.classList.add("hidden");

        //     reservedModal.classList.remove("hidden");
        //     reservedLayoutOptions.classList.remove("hidden");
        // });

        // return;
        // }




        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 3) {
        if (!validator.validateCreateTicketPrice()) {
            return;
        }
        // Switch To Next Slide
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 4) {
        if (!validator.validateLocation()) {
            return;
        }
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 5) {
        if (!validator.validateDescription()) {
            return;
        }
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 6) {
        if (!validator.validateEventHeaderImage()) {
            return;
        }
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 7) {
        if (!validator.validateMedia()) {
            return;
        }
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 8) {
        if (
            !validator.validatePaymentMode() ||
            !validator.validateTicketLocation()
        ) {
            return;
        }
        // Switch To Next Slide
        handleEventFormNextSlide(currentIndex);
    } else if (currentIndex === 9) {
        if (!validator.validateTicketFAQ()) {
            return;
        }

        // Generate Preview Event Banner Slider
        generatePreviewEventBannerSlider(valuesToDisplay.bannerMedia);
        // Generate Preview Event Location, Date-Time, Description & FAQ
        generatePreviewEventTitleLocationAndDateTime(
            valuesToDisplay.eventName,
            valuesToDisplay.defaultPrice,
            valuesToDisplay.venueName,
            valuesToDisplay.eventDate,
            valuesToDisplay.timeDuration,
            valuesToDisplay.description,
            valuesToDisplay.faq
        );
        // Switch To Next Slide
        handleEventFormNextSlide(currentIndex);
    }
}

// function handleResevedSelection(optionType) {
//     const reservedTopModal = document.querySelector(".reserved-top-modal");
//     const backBtn = reservedTopModal.querySelector(".back-btn");
//     const initialHeading = reservedTopModal.querySelector(".reserved-modal > .top > .heading.text");
//     const layoutType = reservedTopModal.querySelector(".reserved-layout-type");
//     const layoutOptions = reservedTopModal.querySelector(".reserved-layout-options");
//     const allOptions = layoutOptions.querySelectorAll(".layout-type-item");
//     const seatMapInputs = reservedTopModal.querySelectorAll(".seat-map--input");


//     console.log(initialHeading, "initialHeading");


//     const switchStep = (switchTolayoutOptions = true) => {
//         if (!switchTolayoutOptions) {
//             initialHeading.classList.add("hidden");
//             backBtn.classList.remove("hidden");
//             layoutType.classList.add("hidden");
//             layoutOptions.classList.remove("hidden");
//         }
//         else {
//             initialHeading.classList.remove("hidden");
//             backBtn.classList.add("hidden");
//             layoutType.classList.remove("hidden");
//             layoutOptions.classList.add("hidden");
//         }

//     }

//     const handleNumberMinMax = (element, value) => {
//         const min = parseInt(element.min) || 1;
//         const max = parseInt(element.max) || 50;

//         if (value < min) {
//             element.value = min;
//         } else if (value > max) {
//             element.value = max;
//         } else {
//             element.value = value;
//         }
//     };


//     if (reservedTopModal && backBtn && layoutType && layoutOptions && allOptions) {
//         switchStep(false);

//         backBtn.addEventListener("click", () => {

//             // for directly back to event duration step then comment switchStep function and run other code else comment other code and run switchStep function
//             // switchStep();
//             const reservedTopModal = document.querySelector(".reserved-top-modal");
//             const closeBtn = reservedTopModal.querySelector(".close-btn");
//             closeBtn.click();
//         });

//         seatMapInputs.forEach(seatMapInput => {
//             seatMapInput.addEventListener("input", (e) => handleNumberMinMax(seatMapInput, e.target.value));
//             seatMapInput.addEventListener("paste", (e) => setTimeout(() => handleNumberMinMax(seatMapInput, seatMapInput.value), 0));
//         });


//         allOptions.forEach(option => {
//             if (optionType === option.id) {
//                 option.classList.remove("hidden");
//             }
//             else {
//                 option.classList.add("hidden");
//             }
//         });
//     }



// }

function tabMenuSwitch(_id, el) {
    const headItems = document.querySelectorAll(".seat-map-wrapper .top-section .left .item");
    const bodyItems = document.querySelectorAll(".seat-map-wrapper .right-side > .item");

    headItems.forEach(headItem => {
        headItem.classList.toggle("active", headItem === el);
    });

    bodyItems.forEach(bodyItem => {
        bodyItem.classList.toggle("hidden", bodyItem.id !== _id);
    });
}



// 26-11-2024
function populateFutureTimeSelect() {
    // Get the current date and time
    const now = new Date();
    let currentHours = now.getHours();
    let currentMinutes = now.getMinutes();

    // Adjust the current time to the nearest 30-minute increment
    if (currentMinutes >= 30) {
        currentHours += 1;
        currentMinutes = 0;
    } else {
        currentMinutes = 30;
    }

    // Define the time interval (30 minutes)
    const timeInterval = 0.5; // 30 minutes

    // Get all elements with the class '.event-time-select'
    const timeSelectElements = document.querySelectorAll(".event-time-select");

    // Loop through each select element
    timeSelectElements.forEach((selectElement) => {
        // Save the first child (which should be the placeholder option) and preserve it
        const firstOption = selectElement.querySelector("option");

        // Clear any existing time options but keep the placeholder
        selectElement.innerHTML = "";
        selectElement.appendChild(firstOption);

        // Loop through the time range, starting from the current time
        for (
            let time = currentHours + currentMinutes / 60;
            time <= 23.5;
            time += timeInterval
        ) {
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

            // Create the time string
            const timeString = `${hours}:${minutes} ${period}`;

            // Create a new option element
            const option = document.createElement("option");
            option.value = timeString; // Option value
            option.textContent = timeString; // Displayed text

            // Append the option to the select element
            selectElement.appendChild(option);
        }
    });
}

function showMultiTimesSidebar() {
    const multiTimesSidebar = document.querySelector(".multi-times-sidebar");
    multiTimesSidebar.classList.remove("opacity-0");
    multiTimesSidebar.classList.add("show");
}

function hideMultiTimesSidebar(sidebar) {
    sidebar.classList.remove("show");
    sidebar.classList.add("opacity-0");
}

function generateNewStartEndTimeInputs() {
    const uniqueId = `time-input-${Date.now()}`;

    const containerDiv = document.createElement("div");
    containerDiv.classList.add("grey-border");

    const startTimeWrapper = document.createElement("div");
    startTimeWrapper.classList.add(
        "add-ticket-input-item-wrapper",
        "mb-1",
        "transition",
        "flex",
        "flex-column",
        "gap-05",
        "justify-start",
        "items-start",
        "border-box"
    );

    const startTimeLabel = document.createElement("label");
    startTimeLabel.setAttribute("for", `${uniqueId}-start-time`);
    startTimeLabel.classList.add("manage-add-date", "transition", "border-box");
    startTimeLabel.textContent = "Start Time";

    const startTimeSelect = document.createElement("select");
    startTimeSelect.setAttribute("name", `${uniqueId}-event-start-time`);
    startTimeSelect.setAttribute("id", `${uniqueId}-event-start-time`);
    startTimeSelect.classList.add(
        "event-start-time",
        "event-time-select",
        "transition",
        "w-full",
        "event-input",
        "border-box"
    );

    const startTimeOption = document.createElement("option");
    startTimeOption.setAttribute("value", "");
    startTimeOption.textContent = "Start Time";

    startTimeSelect.appendChild(startTimeOption);

    const startTimeError = document.createElement("p");
    startTimeError.classList.add("error-text", "border-box");

    startTimeWrapper.appendChild(startTimeLabel);
    startTimeWrapper.appendChild(startTimeSelect);
    startTimeWrapper.appendChild(startTimeError);

    const endTimeWrapper = document.createElement("div");
    endTimeWrapper.classList.add(
        "add-ticket-input-item-wrapper",
        "transition",
        "flex",
        "flex-column",
        "gap-05",
        "justify-start",
        "items-start",
        "border-box"
    );

    const endTimeLabel = document.createElement("label");
    endTimeLabel.setAttribute("for", `${uniqueId}-end-time`);
    endTimeLabel.classList.add("manage-end-date", "transition", "border-box");
    endTimeLabel.textContent = "End Time";

    const endTimeSelect = document.createElement("select");
    endTimeSelect.setAttribute("name", `${uniqueId}-event-end-time`);
    endTimeSelect.setAttribute("id", `${uniqueId}-event-end-time`);
    endTimeSelect.classList.add(
        "event-end-time",
        "event-time-select",
        "transition",
        "w-full",
        "event-input",
        "border-box"
    );

    const endTimeOption = document.createElement("option");
    endTimeOption.setAttribute("value", "");
    endTimeOption.textContent = "End Time";

    endTimeSelect.appendChild(endTimeOption);

    const endTimeError = document.createElement("p");
    endTimeError.classList.add("error-text", "border-box");

    endTimeWrapper.appendChild(endTimeLabel);
    endTimeWrapper.appendChild(endTimeSelect);
    endTimeWrapper.appendChild(endTimeError);

    const deleteButton = document.createElement("button");
    deleteButton.setAttribute("type", "button");
    deleteButton.classList.add("delete-new-time-btn", "transition");
    deleteButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M200-440v-80h560v80H200Z"></path></svg> Delete Time`;

    containerDiv.appendChild(startTimeWrapper);
    containerDiv.appendChild(endTimeWrapper);
    containerDiv.appendChild(deleteButton);

    deleteButton.addEventListener("click", () => {
        containerDiv.remove();
    });

    populateTimeSelect(startTimeSelect, null, null);
    populateTimeSelect(endTimeSelect, null, null);

    return containerDiv;
}

// 26-11-2024

// Custom Pass

function validateCustomPass(valuesToDisplay) {
    document
        .querySelectorAll(".custom-pass-area .custom-pass-checkboax:checked")
        .forEach((checkbox) => {
            let passWrapper = checkbox.closest(".checkbox-wrapper");

            let passName = passWrapper
                .querySelector(".ticket-card-header-name")
                .innerText.trim();
            let passValue = checkbox.value;
            let selectableDaysMatch = passValue.match(/^(\d+)-days$/);
            let selectableDays = selectableDaysMatch
                ? parseInt(selectableDaysMatch[1])
                : 0;
            if (!valuesToDisplay.customPass) {
                valuesToDisplay.customPass = [];
            }
            valuesToDisplay.customPass.push({
                name: passName,
                selectableDays: selectableDays,
            });
        });

    return true;
}

function handleAddCustompass() {
    const validator = new FormValidator();
    if (!validator.validateEventType()) {
        return;
    }
    let a = document
        .querySelector(".add-custom-pass-sidebar")
        .classList.replace("opacity-0", "show");
    let inputarea = document.querySelector(".multi-range-selector-wrapper");
    let startdate = inputarea
        .querySelector(".start-date-input")
        .value.split(",");
    let enddate = inputarea.querySelector(".end-date-input").value.split(",");

    let datecount = 0;
    for (let i = 0; i < startdate.length; i++) {
        let count = handlecountDays(startdate[i], enddate[i]);
        datecount = datecount + count;
    }

    document.querySelector(".pass-day").setAttribute("max", datecount);
}

function handlecountDays(dayA, dayB) {
    const dateA = new Date(dayA);
    const dateB = new Date(dayB);
    const differenceInTime = dateB - dateA;
    const differenceInDays = differenceInTime / (1000 * 60 * 60 * 24) + 1;
    console.log(dayA, dayB, differenceInDays);
    return differenceInDays;
}

function handlePassCancel() {
    let a = document
        .querySelector(".add-custom-pass-sidebar")
        .classList.replace("show", "opacity-0");
    document.querySelector(".pass-name").value = "";
    document.querySelector(".pass-day").value = "";
}
function handlePassSave() {
    let name = document.querySelector(".pass-name").value;
    let days = document.querySelector(".pass-day").value;

    let newPass = document.createElement("div");
    newPass.classList.add("checkbox-wrapper-16");
    newPass.innerHTML = `
            <label class="checkbox-wrapper">
                <input type="checkbox" class="checkbox-input custom-pass-checkboax custom_passes" checked value="${days}-days">
                    <span class="checkbox-tile flex">
                        <span class="checkbox-icon block">
                            <img src="/asset/images/pass-icon.png" style="width:40px;">
                        </span>
                        <div class="ticket-card-header-icon-content-wrapper justify-start items-start">
                            <p class="ticket-card-header-name" style="text-align: start !important;">${name}</p>
                            <p class="ticket-card-header-date">
                                <span>${days} days pass </span>
                            </p>
                        </div>
                        <button class="delete-pass" onclick="deletePass(this)">❌</button>
                    </span>
            </label>
            `;

    if (checkCustomPass()) {
        let container = document.querySelector(".custom-pass-area");
        let addPassButton = document.querySelector(".create-custom-pass");
        container.insertBefore(newPass, addPassButton);
        let a = document
            .querySelector(".add-custom-pass-sidebar")
            .classList.replace("show", "opacity-0");
        let name = document.querySelector(".pass-name");
        let days = document.querySelector(".pass-day");

        // Store the passes in an array in the hidden input
        let passes = JSON.parse(
            document.querySelector(".custom-passes").value || "[]"
        );
        let tempPass = {
            name: name.value,
            days: days.value,
        };
        passes.push(tempPass);
        document.querySelector(".custom-passes").value = JSON.stringify(passes);
        name.value = "";
        days.value = "";
    }
}

function deletePass(button) {
    let passToDelete = button.closest(".checkbox-wrapper-16");
    passToDelete.remove();
}

function checkCustomPass() {
    let days = document.querySelector(".pass-day").value;
    let error = document.querySelector(".custom-days-error");
    let a = document.querySelector(".pass-day").getAttribute("max");
    if (Number(days) <= Number(a) && Number(days) > 1) {
        error.innerText = "";
        return true;
    } else {
        error.innerText = `Selected days should be less then ${a} and eqaul to 2`;
        return false;
    }
}


document.addEventListener("DOMContentLoaded", () => {
    handleMultipleTicketMenu();
    tabMenu();
});