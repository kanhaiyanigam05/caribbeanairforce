function getDatesBetween(startDate, endDate) {
    if (startDate && endDate) {
        const dateArray = [];

        // Make sure the start and end dates are in UTC format
        const start = new Date(
            new Date(startDate).toISOString().split("T")[0] + "T00:00:00.000Z"
        );
        const end = new Date(
            new Date(endDate).toISOString().split("T")[0] + "T00:00:00.000Z"
        );

        // Loop through the dates between start and end date
        while (start <= end) {
            dateArray.push(start.toISOString().split("T")[0]);
            start.setUTCDate(start.getUTCDate() + 1); // Use UTC-based methods
        }

        return dateArray;
    }
}

function validateDate(date) {
    return !isNaN(Date.parse(date)) ? date : "";
}

function ToUtcDate(dateString) {
    const date = new Date(dateString);
    return new Date(date.toLocaleString("en-US", { timeZone: "UTC" }));
}

class CustomCalendar {
    constructor(calendarButtonInput, options = {}) {
        this.calendarType = "null"; // Can be single-date | multi-date | range | multi-range | null
        this.calendarButtonInput = calendarButtonInput;
        console.log(
            this.calendarButtonInput,
            this.calendarButtonInput.querySelector(".text")
        );

        this.calendarButtonInputText = this.calendarButtonInput.querySelector(
            ".text"
        )
            ? this.calendarButtonInput.querySelector(".text")
            : this.calendarButtonInput;

        const required = [
            {
                name: "calendarButtonInput",
                value: calendarButtonInput,
                errorMessage:
                    "The calendar button input is required but missing.",
            },
        ];

        const missingElements = required.filter((element) => !element.value);

        if (missingElements.length > 0) {
            missingElements.forEach((element) => {
                this.showError(element.errorMessage);
            });
            return;
        }

        if (this.calendarButtonInput.dataset.calendarType) {
            const availableTypes = [
                "single-date",
                "multi-date",
                "range",
                "multi-range",
            ];
            const datasetValue = calendarButtonInput.dataset.calendarType;

            // Check if the dataset value is in the available types
            if (!availableTypes.includes(datasetValue)) {
                console.error(
                    `Invalid calendar type. Available types are: ${availableTypes.join(
                        ", "
                    )}`
                );
                return;
            }

            // Set the calendarType if it's valid
            this.calendarType = datasetValue;
        }

        this.calendar = null;
        this.leftBtn = null;
        this.rightBtn = null;
        this.displayMonthYear = null;
        this.calendarDaysWrapper = null;
        this.errorWrapper = null;
        this.errorElement = null;
        this.calendarSaveButton = null;
        this.calendarCancelButton = null;

        this.singleDate = new Object();
        this.multiDate = new Object();
        this.rangeDate = new Object();
        this.multiRangeDate = new Object();
        this.init();
    }

    init() {
        this.generateBaseCalendar();
    }

    generateBaseCalendar() {
        const parentWrapper = this.calendarButtonInput.parentElement;
        const calendarHtml = `
        <div class="calendar-modal">
            <div class="calendar-container">
                <div class="container-new">
                    <div class="custom-calendar">
                        <header class="calendar-header">
                            <button class="left" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg>
                            </button>
                            <div class="header-display">
                                <p class="current-month-year"></p>
                            </div>
                            <button class="right" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
                            </button>
                        </header>
                        <div class="calendar-week-wrapper">
                            <div>Su</div>
                            <div>Mo</div>
                            <div>Tu</div>
                            <div>We</div>
                            <div>Th</div>
                            <div>Fr</div>
                            <div>Sa</div>
                        </div>
                        <div class="calendar-days-wrapper"></div>
                    </div>
                    <div class="display-selected"></div>
                    <div class="calendar-error-wrapper">
                        <p class="error-message transition text-red-500"></p>
                    </div>
    
                    <div class="calendar-footer-btn-wrapper">
                        <button type="button" class="save-calendar-btn transition">Save</button>
                        <button type="button" class="cancel-calendar-btn transition">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        `;

        if (parentWrapper.querySelector(".calendar-modal")) {
            parentWrapper.querySelector(".calendar-modal").remove();
        }

        this.calendarButtonInput.insertAdjacentHTML("afterend", calendarHtml);
        this.calendar = parentWrapper.querySelector(".calendar-modal");
        this.leftBtn = this.calendar.querySelector("header .left");
        this.rightBtn = this.calendar.querySelector("header .right");
        this.displayMonthYear = this.calendar.querySelector(
            ".current-month-year"
        );
        this.calendarDaysWrapper = this.calendar.querySelector(
            ".calendar-days-wrapper"
        );
        this.errorWrapper = this.calendar.querySelector(
            ".calendar-error-wrapper"
        );
        this.errorElement = this.errorWrapper.querySelector(".error-message");
        this.calendarSaveButton = this.calendar.querySelector(
            ".calendar-footer-btn-wrapper .save-calendar-btn"
        );
        this.calendarCancelButton = this.calendar.querySelector(
            ".calendar-footer-btn-wrapper .cancel-calendar-btn"
        );
        this.attachEventListeners();
    }

    attachEventListeners() {
        this.leftBtn.addEventListener("click", () => this.changeMonth("prev"));
        this.rightBtn.addEventListener("click", () => this.changeMonth("next"));
    }

    setCalendarDate(options) {
        if (this.calendarType === "single-date") {
            const calendarData = initializeCalendarData(options);
            this.singleDate = { ...this.singleDate, ...calendarData };

            if (options.selectedDate) {
                this.singleDate.selectedDate = new Date(options.selectedDate);
                this.calendarButtonInput.value = this.formatDate(
                    options.selectedDate
                );
                this.calendarButtonInputText.textContent = this.fancyDateFormat(
                    options.selectedDate
                );
            } else if (options.defaultButtonText) {
                this.singleDate.defaultButtonText = options.defaultButtonText;
            } else {
                this.singleDate.defaultButtonText = "Enter A New Date";
            }

            this.generateButtonText();
        }

        if (this.calendarType === "multi-date") {
            const calendarData = initializeCalendarData(options);
            this.multiDate = { ...this.multiDate, ...calendarData };

            if (options.defaultButtonText) {
                this.multiDate.defaultButtonText = options.defaultButtonText;
            } else {
                this.multiDate.defaultButtonText = "Enter A New Date";
            }

            if (options.selectedDates && Array.isArray(options.selectedDates)) {
                this.multiDate.selectedDates = options.selectedDates
                    .map((dateStr) => new Date(dateStr))
                    .filter((dateObj) => !isNaN(dateObj.getTime()))
                    .map((dateObj) => this.formatDate(dateObj));

                if (
                    !options.defaultButtonText &&
                    this.multiDate.selectedDates.length <= 0
                ) {
                    this.multiDate.defaultButtonText = "Enter A New Date";
                }
            }

            if (!options.selectedDates) {
                this.multiDate.selectedDates = [];
            }
            this.generateButtonText();
        }

        if (this.calendarType === "range") {
            this.calendarType = "range";
            const calendarData = initializeCalendarData(options);
            this.rangeDate = { ...this.rangeDate, ...calendarData };
            this.rangeDate.selectedDates = {
                startDate: "",
                endDate: "",
                datesBetween: [],
            };
            this.rangeDate.selectedDates.lastClickedStartDate = "";

            if (options.defaultButtonText) {
                this.rangeDate.defaultButtonText = options.defaultButtonText;
            } else {
                this.rangeDate.defaultButtonText = "Enter A New Date";
            }

            if (
                options.selectedDates &&
                typeof options.selectedDates === "object"
            ) {
                if (
                    options.selectedDates.startDate &&
                    options.selectedDates.endDate
                ) {
                    // Final Verification if given dates are valid or not.
                    const startDate = validateDate(
                        new Date(options.selectedDates.startDate)
                    );
                    const endDate = validateDate(
                        new Date(options.selectedDates.endDate)
                    );

                    if (!startDate || !endDate) {
                        return;
                    }

                    this.rangeDate.selectedDates = {
                        startDate: new Date(
                            validateDate(options.selectedDates.startDate)
                        ),
                        endDate: new Date(
                            validateDate(options.selectedDates.endDate)
                        ),
                        datesBetween: getDatesBetween(
                            options.selectedDates.startDate,
                            options.selectedDates.endDate
                        ),
                    };
                }
            }
            console.log("rangeDate", this.rangeDate);
        }

        if (this.calendarType === "multi-range") {
            this.calendarType = "multi-range";
            const calendarData = initializeCalendarData(options);
            this.multiRangeDate = { ...this.multiRangeDate, ...calendarData };

            if (options.defaultButtonText) {
                this.multiRangeDate.defaultButtonText =
                    options.defaultButtonText;
            } else {
                this.multiRangeDate.defaultButtonText = "Enter A New Date";
            }

            function validateStartEndDates(selectedData) {
                if (!selectedData || !Array.isArray(selectedData.allDates)) {
                    return [];
                }

                return selectedData.allDates
                    .map((item) => {
                        if (
                            item.startDate &&
                            item.endDate &&
                            !isNaN(new Date(item.startDate).getTime()) &&
                            !isNaN(new Date(item.endDate).getTime())
                        ) {
                            return {
                                startDate: new Date(item.startDate),
                                endDate: new Date(item.endDate),
                                datesBetween: getDatesBetween(
                                    item.startDate,
                                    item.endDate
                                ),
                            };
                        }
                        return null;
                    })
                    .filter((item) => item !== null);
            }

            const selectedDates = validateStartEndDates(options.selectedDates);

            this.multiRangeDate.selectedDates = new Object();
            this.multiRangeDate.selectedDates.allDates = selectedDates;
            this.multiRangeDate.selectedDates.lastClickedStartDate = "";
        }

        function initializeCalendarData(options) {
            // Logic to set dates for the calendar based on the available dates

            const data = new Object();
            // Set defaultDate: This make sure the calendar shows the correct month and year
            if (options.defaultDate) {
                data.defaultDate = new Date(options.defaultDate);
            } else if (!options.defaultDate) {
                // If defaultDate is not provided, set it to the current date
                data.defaultDate = new Date();
            }

            if (options.disablePastDates) {
                data.disablePastDates = true;
            } else {
                data.disablePastDates = false;
            }

            if (
                options.availableDates &&
                Array.isArray(options.availableDates)
            ) {
                // Convert the available dates into Date objects for easier comparison
                data.availableDates = options.availableDates.map((date) =>
                    new Date(date).toDateString()
                );
            } else {
                data.availableDates = [];
            }

            return data;
        }
    }

    renderCalendar() {
        // Render the calendar based on the calendar data
        const buildCalendarView = (calendarData) => {
            const defaultDate = new Date(calendarData.defaultDate); // Get default date (in UTC)

            const year = defaultDate.getFullYear();
            const month = defaultDate.getMonth(); // Get month (0-indexed in JS)

            const firstDay = new Date(Date.UTC(year, month, 1)); // First day of the month (UTC)
            const lastDay = new Date(Date.UTC(year, month + 1, 0)); // Last day of the month (UTC)

            const firstDayIndex = firstDay.getUTCDay(); // Day of the week (0 = Sunday)
            const numberOfDays = lastDay.getUTCDate(); // Get the number of days in the month (UTC)
            const formattedMonth = defaultDate.toLocaleString("default", {
                month: "long",
            });

            // Update month and year display
            this.displayMonthYear.innerHTML = `${formattedMonth} ${year}`;
            this.calendarDaysWrapper.innerHTML = "";

            // Create empty divs for the days before the 1st of the month
            for (let x = 1; x <= firstDayIndex; x++) {
                const div = document.createElement("div");
                div.innerHTML = "";
                div.classList.add("pointer-events-none");
                this.calendarDaysWrapper.appendChild(div);
            }

            // Loop through each day of the month
            for (let i = 1; i <= numberOfDays; i++) {
                let div = document.createElement("div");

                // Create a UTC date for the current day in the loop
                let currentDate = new Date(Date.UTC(year, month, i)); // Ensure it's in UTC
                const formattedDate =
                    currentDate.toISOString().split("T")[0] + "T00:00:00.000Z"; // Get full ISO string in UTC

                div.dataset.date = formattedDate;
                div.innerHTML = i;

                if (calendarData.disablePastDates) {
                    // Disable past dates except the current date (in UTC)
                    const nowUTC = new Date();
                    const defaultDateISOString = `${
                        nowUTC.toISOString().split("T")[0]
                    }T00:00:00.000Z`;
                    const nowUTCISOString = new Date(
                        defaultDateISOString
                    ).toISOString();

                    // Compare current date with the looped date in UTC
                    if (
                        currentDate.getTime() < nowUTC.getTime() &&
                        currentDate.toISOString() !== nowUTCISOString
                    ) {
                        div.classList.add("disabled-date");
                    } else {
                        div.classList.add("available-date");
                    }
                } else {
                    div.classList.add("available-date");
                }

                // Check if this date is in the availableDates list
                if (calendarData.availableDates.length >= 1) {
                    // Check if the current date is in the availableDates list
                    const dateString = new Date(formattedDate).toDateString();

                    if (calendarData.availableDates.includes(dateString)) {
                        div.classList.remove("disabled-date");
                        div.classList.add("available-date");
                    } else {
                        div.classList.remove("available-date");
                        div.classList.add("disabled-date");
                    }
                }

                // Append the div to the calendar days wrapper
                this.calendarDaysWrapper.appendChild(div);
            }
        };

        if (this.calendarType === "single-date") {
            buildCalendarView(this.singleDate);
        }

        if (this.calendarType === "multi-date") {
            buildCalendarView(this.multiDate);
        }

        if (this.calendarType === "range") {
            buildCalendarView(this.rangeDate);
        }

        if (this.calendarType === "multi-range") {
            buildCalendarView(this.multiRangeDate);
        }
    }

    changeMonth(direction) {
        const adjustMonthView = (calendarDateOptions) => {
            const defaultDate = new Date(calendarDateOptions.defaultDate);
            const currentMonth = defaultDate.getMonth();
            const currentYear = defaultDate.getFullYear();

            if (direction === "prev") {
                calendarDateOptions.defaultDate = new Date(
                    currentYear,
                    currentMonth - 1,
                    1
                );
            } else if (direction === "next") {
                calendarDateOptions.defaultDate = new Date(
                    currentYear,
                    currentMonth + 1,
                    1
                );
            }
        };

        if (this.calendarType === "single-date") {
            // const calendarDateOptions = {...this.singleDate};
            adjustMonthView(this.singleDate);
            this.singleDaySelection(this.singleDate);
        }

        if (this.calendarType === "multi-date") {
            adjustMonthView(this.multiDate);
            this.multiDaySelection(this.multiDate);
        }

        if (this.calendarType === "range") {
            adjustMonthView(this.rangeDate);
            this.rangeSelection(this.rangeDate);
        }

        if (this.calendarType === "multi-range") {
            adjustMonthView(this.multiRangeDate);
            this.multiRangeSelection(this.multiRangeDate);
        }
    }

    selectDate() {
        const allDateElements =
            this.calendarDaysWrapper.querySelectorAll("div");

        allDateElements.forEach((dateElement) => {
            const dateString = dateElement.dataset.date;
            const currentDate = new Date(dateString);

            // Handle Single Date Selection
            if (this.calendarType === "single-date") {
                if (this.singleDate.selectedDate) {
                    const selectedDate = new Date(this.singleDate.selectedDate);

                    if (currentDate.getTime() === selectedDate.getTime()) {
                        if (dateElement.classList.contains("active-date")) {
                            dateElement.classList.remove("active-date");
                            this.singleDate.selectedDate = null;
                            this.generateDateDisplay();
                            this.generateHiddenInput();
                        } else {
                            allDateElements.forEach((dt) =>
                                dt.classList.remove("active-date")
                            );
                            dateElement.classList.add("active-date");
                            this.singleDate.selectedDate = currentDate;
                            this.generateDateDisplay();
                            this.generateHiddenInput();
                        }
                    }
                }
            }

            if (this.calendarType === "multi-date") {
                if (this.multiDate.selectedDates.length && dateString) {
                    const formattedDate = this.formatDate(currentDate);

                    if (this.multiDate.selectedDates.includes(formattedDate)) {
                        dateElement.classList.add("active-date");
                    }
                }
            }

            if (this.calendarType === "range") {
                if (
                    this.rangeDate.selectedDates.datesBetween.length >= 1 &&
                    dateString
                ) {
                    const startDate = this.rangeDate.selectedDates.startDate;
                    const endDate = this.rangeDate.selectedDates.endDate;
                    const datesBetween =
                        this.rangeDate.selectedDates.datesBetween;

                    if (
                        currentDate.getTime() === new Date(startDate).getTime()
                    ) {
                        dateElement.classList.add("active-date");
                    }

                    if (currentDate.getTime() === new Date(endDate).getTime()) {
                        dateElement.classList.add("active-date");
                    }

                    datesBetween.forEach((dateStr) => {
                        const date = new Date(dateStr);

                        if (currentDate.getTime() === date.getTime()) {
                            dateElement.classList.add("highlighted-date");
                        }
                    });
                }
            }

            if (this.calendarType === "multi-range") {
                const selectedDatesArray =
                    this.multiRangeDate.selectedDates.allDates;

                if (selectedDatesArray.length >= 1) {
                    selectedDatesArray.forEach((item) => {
                        const startDate = `${
                            new Date(item.startDate).toISOString().split("T")[0]
                        }T00:00:00.000Z`;
                        const endDate = `${
                            new Date(item.endDate).toISOString().split("T")[0]
                        }T00:00:00.000Z`;
                        const datesBetween = item.datesBetween;

                        // Compare startDate with dateString
                        if (startDate === dateString) {
                            dateElement.classList.add("active-date");
                        }

                        // Compare endDate with dateString
                        if (endDate === dateString) {
                            dateElement.classList.add("active-date");
                        }

                        datesBetween.forEach((dateStr) => {
                            const date = new Date(dateStr);
                            if (currentDate.getTime() === date.getTime()) {
                                dateElement.classList.add("highlighted-date");
                            }
                        });
                    });
                }
            }
        });
    }

    singleDaySelection(options = {}) {
        if (this.calendarType === "single-date") {
            this.setCalendarDate(options);
            this.renderCalendar();
            this.errorElement.textContent = "";

            if (this.singleDate.selectedDate || this.singleDate.defaultDate) {
                this.selectDate();
            }
            this.generateButtonText();
            this.generateHiddenInput();
            this.generateDateDisplay();

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    this.errorElement.textContent = "";
                    this.singleDate.selectedDate = new Date(day.dataset.date);
                    this.selectDate();
                    this.generateButtonText();
                });

                day.addEventListener("mouseenter", () => {
                    day.classList.add("highlighted-date");
                });

                day.addEventListener("mouseleave", () => {
                    day.classList.remove("highlighted-date");
                });
            });

            this.calendarSaveButton.addEventListener("click", () => {
                if (this.singleDate.selectedDate) {
                    this.generateButtonText();
                    this.errorElement.textContent = "";
                    this.calendar.classList.remove("show");
                    this.calendarType = null;
                } else {
                    this.generateButtonText();
                    this.generateError(
                        "Please select at least one date.",
                        this.errorElement
                    );
                }
            });

            this.calendarCancelButton.addEventListener("click", () => {
                if (!this.singleDate.selectedDate) {
                    this.generateButtonText();
                }
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.calendarType = null;
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.generateDateDisplay();
                this.errorElement.textContent = "";
                this.calendarType = "single-date";
            });
        } else {
            console.error(
                "Calendar type not set. Please set the calendar type to 'single-date' before calling singleDaySelection method."
            );
        }
    }

    multiDaySelection(options = {}) {
        if (this.calendarType === "multi-date") {
            this.setCalendarDate(options);
            this.renderCalendar();
            this.errorElement.textContent = "";

            if (this.multiDate.selectedDates || this.multiDate.defaultDate) {
                this.selectDate();
            }
            this.generateButtonText();
            this.generateHiddenInput();
            this.generateDateDisplay();

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    this.errorElement.textContent = "";
                    const lastClickedDate = this.formatDate(day.dataset.date);
                    const isLastClickedDateIncludes =
                        this.multiDate.selectedDates.includes(lastClickedDate);

                    if (day.classList.contains("active-date")) {
                        day.classList.remove("active-date");
                        if (isLastClickedDateIncludes) {
                            const indexToRemove =
                                this.multiDate.selectedDates.indexOf(
                                    lastClickedDate
                                );
                            if (indexToRemove !== -1) {
                                this.multiDate.selectedDates.splice(
                                    indexToRemove,
                                    1
                                );
                            }
                        }
                    } else {
                        if (!isLastClickedDateIncludes) {
                            this.multiDate.selectedDates.push(lastClickedDate);
                        }
                        day.classList.add("active-date");
                    }
                    this.generateButtonText();
                    this.generateDateDisplay();
                    this.generateHiddenInput();
                });

                day.addEventListener("mouseenter", () => {
                    day.classList.add("highlighted-date");
                });

                day.addEventListener("mouseleave", () => {
                    day.classList.remove("highlighted-date");
                });
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.generateDateDisplay();
                this.errorElement.textContent = "";
                this.calendarType = "multi-date";
            });

            this.calendarSaveButton.addEventListener("click", () => {
                if (this.multiDate.selectedDates.length) {
                    this.generateButtonText();
                    this.errorElement.textContent = "";
                    this.calendar.classList.remove("show");
                    this.calendarType = null;
                } else {
                    this.generateButtonText();
                    this.generateError(
                        "Please select at least one date.",
                        this.errorElement
                    );
                }
            });

            this.calendarCancelButton.addEventListener("click", () => {
                if (!this.multiDate.selectedDates.length) {
                    this.generateButtonText();
                }
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.calendarType = null;
            });
        } else {
            console.error(
                "Calendar type not set. Please set the calendar type to 'multi-date' before calling multiDaySelection method."
            );
        }
    }

    rangeSelection(options = {}) {
        if (this.calendarType === "range") {
            const isNoDataSet =
                Object.keys(this.rangeDate).length === 0 &&
                this.rangeDate.constructor === Object;

            if (isNoDataSet) {
                this.setCalendarDate(options);
            }

            this.renderCalendar();
            this.errorElement.textContent = "";

            if (this.rangeDate.selectedDates || this.rangeDate.defaultDate) {
                this.selectDate();
            }

            this.generateHiddenInput();
            this.generateDateDisplay();
            this.generateButtonText();

            const resetSelection = (allDateElements) => {
                allDateElements.forEach((dt) =>
                    dt.classList.remove("active-date", "highlighted-date")
                );

                this.rangeDate.selectedDates.startDate = "";
                this.rangeDate.selectedDates.endDate = "";
                this.rangeDate.selectedDates.datesBetween.length = 0;
                this.rangeDate.selectedDates.lastClickedStartDate = "";
                this.errorElement.textContent = "";
                this.generateButtonText();
                this.generateDateDisplay();
                this.generateHiddenInput();
            };

            const startNewSelection = (startDateElement) => {
                // Start Date selection logic starts here
                const lastClickedDate = startDateElement.dataset.date;

                this.rangeDate.selectedDates.lastClickedStartDate = new Date(
                    lastClickedDate
                );
                startDateElement.classList.add("active-date");
                this.errorElement.textContent = "";
                this.generateButtonText();
                this.generateDateDisplay();
                this.generateHiddenInput();
            };

            const endNewSelection = (endDateElement) => {
                // End Date selection logic starts here

                const lastClickedStartDate =
                    this.rangeDate.selectedDates.lastClickedStartDate;

                const currentDate = new Date(endDateElement.dataset.date);
                this.errorElement.textContent = "";

                if (
                    this.formatDate(lastClickedStartDate) ===
                    this.formatDate(currentDate)
                ) {
                    // Reset the selection if the user tries to select the same date
                    return;
                }

                endDateElement.classList.add("active-date");

                // Update the selectedDates and generate the button text
                this.rangeDate.selectedDates.startDate = lastClickedStartDate;
                this.rangeDate.selectedDates.endDate = currentDate;
                this.rangeDate.selectedDates.datesBetween = getDatesBetween(
                    lastClickedStartDate,
                    currentDate
                );
                this.rangeDate.selectedDates.lastClickedStartDate = "";
                this.generateButtonText();
                this.generateDateDisplay();
                this.generateHiddenInput();

                console.log(console.log(lastClickedStartDate, currentDate));
            };

            const highlightBetweenDates = (startDate, endDate) => {
                const allDateElements =
                    this.calendarDaysWrapper.querySelectorAll("div");
                const allDatesInRange = getDatesBetween(startDate, endDate);

                allDateElements.forEach((day) => {
                    if (day.dataset.date) {
                        const currentDate = this.formatDate(day.dataset.date);
                        const currentStartDate =
                            this.rangeDate.selectedDates.startDate;
                        const currentEndDate =
                            this.rangeDate.selectedDates.endDate;

                        if (!currentStartDate || !currentEndDate) {
                            if (allDatesInRange.includes(currentDate)) {
                                day.classList.add("highlighted-date");
                            }
                        }
                    }
                });
            };

            const removeHighlightedDates = () => {
                const allDateElements =
                    this.calendarDaysWrapper.querySelectorAll("div");
                allDateElements.forEach((day) => {
                    day.classList.remove("highlighted-date");
                });
            };

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    if (
                        this.rangeDate.selectedDates.startDate &&
                        this.rangeDate.selectedDates.endDate
                    ) {
                        this.selectDate();
                        // Check if clicked date is not being reselected
                        const lastClickedDate = this.formatDate(
                            day.dataset.date
                        );

                        if (
                            this.rangeDate.selectedDates.datesBetween.includes(
                                lastClickedDate
                            )
                        ) {
                            // Remove active and highlighted classes and allow the user to re-select dates
                            resetSelection(allDateElements);
                        } else {
                            // Reselect Selection
                            resetSelection(allDateElements);
                            // Start Date selection logic starts here
                            startNewSelection(day);

                            // Start Date selection logic starts here
                            endNewSelection(day);
                        }
                    } else if (
                        this.rangeDate.selectedDates.lastClickedStartDate
                    ) {
                        // End Date selection logic starts here
                        const currentDate = new Date(day.dataset.date);
                        const lastClickedStartDate =
                            this.rangeDate.selectedDates.lastClickedStartDate;
                        // currentDate.setHours(0, 0, 0, 0);

                        if (currentDate > lastClickedStartDate) {
                            endNewSelection(day);
                        }
                        if (
                            currentDate.getTime() ===
                            lastClickedStartDate.getTime()
                        ) {
                            resetSelection(allDateElements);
                        }
                    } else {
                        // Start Date selection logic starts here
                        startNewSelection(day);
                    }
                });

                day.addEventListener("mouseenter", () => {
                    const lastClickedStartDate =
                        this.rangeDate.selectedDates.lastClickedStartDate;

                    if (lastClickedStartDate) {
                        const currentHoveredDate = new Date(day.dataset.date);

                        if (currentHoveredDate >= lastClickedStartDate) {
                            // Highlight all dates between start and hovered date
                            highlightBetweenDates(
                                lastClickedStartDate,
                                currentHoveredDate
                            );
                        }
                    }
                });

                day.addEventListener("mouseleave", () => {
                    if (
                        !this.rangeDate.selectedDates.startDate &&
                        !this.rangeDate.selectedDates.endDate
                    ) {
                        removeHighlightedDates();
                    }
                });
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.generateDateDisplay();
                this.errorElement.textContent = "";
                this.calendarType = "range";
            });

            this.calendarCancelButton.addEventListener("click", () => {
                if (
                    !this.rangeDate.selectedDates.startDate &&
                    !this.rangeDate.selectedDates.endDate
                ) {
                    this.generateButtonText();
                }
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.calendarType = null;
            });

            this.calendarSaveButton.addEventListener("click", () => {
                const lastClickedStartDate =
                    this.rangeDate.selectedDates.lastClickedStartDate;
                const startDate = this.rangeDate.selectedDates.startDate;
                const endDate = this.rangeDate.selectedDates.endDate;

                if (lastClickedStartDate) {
                    // this.selectDate();
                    this.generateError(
                        "Please select an end date",
                        this.errorElement
                    );
                    console.log(this.rangeDate);

                    return;
                }

                if (!startDate || !endDate) {
                    this.generateError(
                        "Please select a start and end date",
                        this.errorElement
                    );
                    return;
                }

                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.calendarType = null;
            });
        } else {
            console.error(
                "Calendar type not set. Please set the calendar type to 'range' before calling rangeSelection method."
            );
        }
    }

    multiRangeSelection(options) {
        if (this.calendarType === "multi-range") {
            if (!options) options = new Object();

            const isNoDataSet =
                Object.keys(this.multiRangeDate).length === 0 &&
                this.multiRangeDate.constructor === Object;

            if (isNoDataSet) {
                this.setCalendarDate(options);
            }

            this.renderCalendar();
            this.errorElement.textContent = "";

            if (this.multiRangeDate.selectedDates.allDates.length >= 1) {
                this.selectDate();
            }

            this.generateHiddenInput();
            this.generateButtonText();
            this.generateDateDisplay();

            const removeSelection = (index) => {
                this.multiRangeDate.selectedDates.allDates.splice(index, 1);
                const allDateElements =
                    this.calendarDaysWrapper.querySelectorAll("div");
                allDateElements.forEach((dt) =>
                    dt.classList.remove("active-date", "highlighted-date")
                );
                this.selectDate();
                this.generateHiddenInput();
                this.generateButtonText();
                this.generateDateDisplay();
            };

            const startNewSelection = (startDateElement) => {
                const currentDate = new Date(startDateElement.dataset.date);
                this.multiRangeDate.selectedDates.lastClickedStartDate =
                    currentDate;
                startDateElement.classList.add("active-date");
                this.generateHiddenInput();
                this.generateButtonText();
                this.generateDateDisplay();
            };

            const highlightBetweenDates = (hoveredDateElement) => {
                const hoveredDate = this.formatDate(
                    hoveredDateElement.dataset.date
                );
                const allDateElements =
                    this.calendarDaysWrapper.querySelectorAll("div");
                const lastClickedStartDate =
                    this.multiRangeDate.selectedDates.lastClickedStartDate;
                const allDatesInRange = getDatesBetween(
                    lastClickedStartDate,
                    hoveredDate
                );

                allDateElements.forEach((day) => {
                    const currentDate = new Date(day.dataset.date);
                    if (
                        lastClickedStartDate &&
                        allDatesInRange.includes(hoveredDate)
                    ) {
                        if (
                            currentDate <= new Date(hoveredDate) &&
                            currentDate >= lastClickedStartDate
                        ) {
                            day.classList.add("highlighted-date");
                        }
                    }
                });
            };

            const removeHighlightedDates = () => {
                const allDateElements =
                    this.calendarDaysWrapper.querySelectorAll("div");
                allDateElements.forEach((day) =>
                    day.classList.remove("highlighted-date")
                );
                this.selectDate();
            };

            const endDaySelection = (day) => {
                const lastClickedStartDate =
                    this.multiRangeDate.selectedDates.lastClickedStartDate;
                const newEndDate = new Date(day.dataset.date);
                const newDatesBetween = getDatesBetween(
                    lastClickedStartDate,
                    newEndDate
                );

                // Remove overlapping ranges
                this.multiRangeDate.selectedDates.allDates =
                    this.multiRangeDate.selectedDates.allDates.filter(
                        (range) => {
                            return (
                                newEndDate < range.startDate ||
                                lastClickedStartDate > range.endDate
                            );
                        }
                    );

                // Add new range
                this.multiRangeDate.selectedDates.allDates.push({
                    startDate: lastClickedStartDate,
                    endDate: newEndDate,
                    datesBetween: newDatesBetween,
                });

                // Remove active-date class from all elements
                const allDateElements =
                    this.calendarDaysWrapper.querySelectorAll("div");
                allDateElements.forEach((day) =>
                    day.classList.remove("active-date")
                );

                day.classList.add("active-date");
                this.multiRangeDate.selectedDates.lastClickedStartDate = "";
                this.generateHiddenInput();
                this.generateButtonText();
                this.generateDateDisplay();
            };

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    const clickedDate = new Date(day.dataset.date);
                    const allDatesArray =
                        this.multiRangeDate.selectedDates.allDates;
                    this.errorElement.textContent = "";

                    for (let index = 0; index < allDatesArray.length; index++) {
                        const datesBetween = allDatesArray[index].datesBetween;
                        if (
                            datesBetween.includes(this.formatDate(clickedDate))
                        ) {
                            removeSelection(index);
                            this.generateHiddenInput();
                            this.generateButtonText();
                            this.generateDateDisplay();
                            return;
                        }
                    }

                    // If no range contains the clicked date
                    if (
                        !this.multiRangeDate.selectedDates.lastClickedStartDate
                    ) {
                        startNewSelection(day);
                    } else {
                        if (
                            new Date(day.dataset.date).getTime() ===
                            this.multiRangeDate.selectedDates.lastClickedStartDate.getTime()
                        ) {
                            this.multiRangeDate.selectedDates.lastClickedStartDate =
                                null;

                            const allDateElements =
                                this.calendarDaysWrapper.querySelectorAll(
                                    "div"
                                );
                            allDateElements.forEach((dt) =>
                                dt.classList.remove("active-date")
                            );
                        } else if (
                            new Date(day.dataset.date) >
                            this.multiRangeDate.selectedDates
                                .lastClickedStartDate
                        ) {
                            console.log(this.multiRangeDate);
                            endDaySelection(day);
                        }
                    }
                });

                day.addEventListener("mouseenter", () => {
                    highlightBetweenDates(day);
                });

                day.addEventListener("mouseleave", () => {
                    removeHighlightedDates();
                });
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.generateDateDisplay();
                this.errorElement.textContent = "";
                this.calendarType = "multi-range";
            });

            this.calendarCancelButton.addEventListener("click", () => {
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.calendarType = null;
            });

            this.calendarSaveButton.addEventListener("click", () => {
                if (this.multiRangeDate.selectedDates.lastClickedStartDate) {
                    this.generateError(
                        "Please select an end date",
                        this.errorElement
                    );
                    return;
                } else if (
                    this.multiRangeDate.selectedDates.allDates.length >= 1
                ) {
                    this.generateButtonText();
                    this.generateHiddenInput();
                    this.generateDateDisplay();
                    this.errorElement.textContent = "";
                    this.calendar.classList.remove("show");
                    this.calendarType = null;
                } else {
                    this.generateButtonText();
                    this.generateError(
                        "Please select at least one date range.",
                        this.errorElement
                    );
                }
            });
        } else {
            console.error(
                "Calendar type not set. Please set the calendar type to 'multi-range' before calling multiRangeSelection method."
            );
        }
    }

    formatDate(dateString) {
        const newDate = new Date(dateString);
        return newDate.toISOString().split("T")[0];
    }

    fancyDateFormat(dateString) {
        const date = new Date(dateString);

        const day = date.getUTCDate();
        const month = date.toLocaleString("default", { month: "short" }); // Short month name (e.g., 'Dec')
        const year = date.getUTCFullYear();

        return `${day} ${month} ${year}`;
    }

    generateError(errorMessage, errorElement) {
        errorElement.textContent = errorMessage;
        errorElement.classList.add("error-shake");
        setTimeout(() => {
            errorElement.classList.remove("error-shake");
        }, 500);
    }

    generateDateDisplay() {
        function GenerateSVG() {
            const svg = document.createElementNS(
                "http://www.w3.org/2000/svg",
                "svg"
            );
            svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
            svg.setAttribute("height", "16px");
            svg.setAttribute("viewBox", "0 -960 960 960");
            svg.setAttribute("width", "16px");
            svg.setAttribute("fill", "black");

            const path = document.createElementNS(
                "http://www.w3.org/2000/svg",
                "path"
            );
            path.setAttribute(
                "d",
                "M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"
            );

            svg.appendChild(path);
            return svg;
        }

        if (this.calendarType === "single-date") {
            const selectedDay =
                this.calendar.querySelector(".display-selected");
            const wrapper = selectedDay.querySelector(
                ".display-selected-wrapper"
            );
            let selectedDate;

            if (this.singleDate.selectedDate) {
                selectedDate = this.fancyDateFormat(
                    this.singleDate.selectedDate
                );
            } else {
                selectedDate = "DD-MM, YYYY";
            }

            if (wrapper) {
                const selectedDateText = wrapper.querySelector(
                    ".calendar-start-date span"
                );
                selectedDateText.textContent = selectedDate;
            } else {
                const selectedWrapper = document.createElement("div");
                selectedWrapper.classList.add("display-selected-wrapper");

                const startDateWrapper = document.createElement("div");
                startDateWrapper.classList.add("calendar-start-date-wrapper");

                const svgElement = GenerateSVG();
                const calendarStartDate = document.createElement("p");
                calendarStartDate.classList.add("calendar-start-date");
                calendarStartDate.innerHTML = `Date: <span>${selectedDate}</span>`;

                startDateWrapper.appendChild(svgElement);
                startDateWrapper.appendChild(calendarStartDate);
                selectedWrapper.appendChild(startDateWrapper);
                selectedDay.appendChild(selectedWrapper);
            }
        }

        if (this.calendarType === "multi-date") {
            const selectedDay =
                this.calendar.querySelector(".display-selected");
            const wrapper = selectedDay.querySelector(
                ".display-selected-wrapper"
            );

            const selectedDatesNumber =
                this.multiDate.selectedDates.length >= 100
                    ? `Selected Days: ${100}+`
                    : `Selected Days: ${this.multiDate.selectedDates.length}`;

            if (wrapper) {
                const selectedDatesText = wrapper.querySelector(
                    ".calendar-start-date"
                );
                selectedDatesText.textContent = selectedDatesNumber;
            } else {
                const selectedWrapper = document.createElement("div");
                selectedWrapper.classList.add("display-selected-wrapper");

                const startDateWrapper = document.createElement("div");
                startDateWrapper.classList.add("calendar-start-date-wrapper");

                const svgElement = GenerateSVG();
                const calendarStartDate = document.createElement("p");
                calendarStartDate.classList.add("calendar-start-date");
                calendarStartDate.innerHTML = selectedDatesNumber;

                startDateWrapper.appendChild(svgElement);
                startDateWrapper.appendChild(calendarStartDate);
                selectedWrapper.appendChild(startDateWrapper);
                selectedDay.appendChild(selectedWrapper);
            }
        }

        if (this.calendarType === "range") {
            const displySelected =
                this.calendar.querySelector(".display-selected");
            const wrapper = displySelected.querySelector(
                ".display-selected-wrapper"
            );
            const startDate = this.rangeDate.selectedDates.startDate;
            const endDate = this.rangeDate.selectedDates.endDate;

            const startDateValue = validateDate(startDate)
                ? this.fancyDateFormat(startDate)
                : "DD-MM, YYYY";
            const endDateValue = validateDate(endDate)
                ? this.fancyDateFormat(endDate)
                : "DD-MM, YYYY";

            if (wrapper) {
                const startDateText = wrapper.querySelector(
                    ".calendar-start-date span"
                );
                const endDateText = wrapper.querySelector(
                    ".calendar-end-date span"
                );
                startDateText.textContent = startDateValue;
                endDateText.textContent = endDateValue;
            } else {
                const selectedWrapper = document.createElement("div");
                selectedWrapper.classList.add("display-selected-wrapper");

                const calendarStartDateWrapper = document.createElement("div");
                calendarStartDateWrapper.classList.add(
                    "calendar-start-date-wrapper"
                );

                const calendarStartDate = document.createElement("p");
                calendarStartDate.classList.add("calendar-start-date");
                calendarStartDate.textContent = "From: ";

                const startDateText = document.createElement("span");
                startDateText.textContent = startDateValue;

                calendarStartDate.appendChild(startDateText);
                calendarStartDateWrapper.appendChild(GenerateSVG());
                calendarStartDateWrapper.appendChild(calendarStartDate);
                selectedWrapper.appendChild(calendarStartDateWrapper);
                displySelected.appendChild(selectedWrapper);

                const calendarEndDateWrapper = document.createElement("div");
                calendarEndDateWrapper.classList.add(
                    "calendar-end-date-wrapper"
                );

                const calendarEndDate = document.createElement("p");
                calendarEndDate.classList.add("calendar-end-date");
                calendarEndDate.textContent = "To: ";

                const endDateText = document.createElement("span");
                endDateText.textContent = endDateValue;

                calendarEndDate.appendChild(endDateText);
                calendarEndDateWrapper.appendChild(GenerateSVG());
                calendarEndDateWrapper.appendChild(calendarEndDate);
                selectedWrapper.appendChild(calendarEndDateWrapper);
                displySelected.appendChild(selectedWrapper);
            }
        }

        if (this.calendarType === "multi-range") {
            const displySelected =
                this.calendar.querySelector(".display-selected");
            const wrapper = displySelected.querySelector(
                ".display-selected-wrapper"
            );
            const allDates = this.multiRangeDate.selectedDates.allDates;

            const selectedRangeNumber =
                allDates.length >= 100
                    ? `Selected: ${100}+ Range Seleted`
                    : `Selected: ${allDates.length} Range Seleted`;

            if (wrapper) {
                const selectedDatesText = wrapper.querySelector(
                    ".calendar-start-date"
                );
                selectedDatesText.textContent = selectedRangeNumber;
            } else {
                const selectedWrapper = document.createElement("div");
                selectedWrapper.classList.add("display-selected-wrapper");

                const startDateWrapper = document.createElement("div");
                startDateWrapper.classList.add("calendar-start-date-wrapper");

                const svgElement = GenerateSVG();
                const calendarStartDate = document.createElement("p");
                calendarStartDate.classList.add("calendar-start-date");
                calendarStartDate.innerHTML = selectedRangeNumber;

                startDateWrapper.appendChild(svgElement);
                startDateWrapper.appendChild(calendarStartDate);
                selectedWrapper.appendChild(startDateWrapper);
                displySelected.appendChild(selectedWrapper);
            }
        }
    }

    generateButtonText() {
        if (this.calendarType === "single-date") {
            if (this.singleDate.selectedDate) {
                this.calendarButtonInput.value = this.formatDate(
                    this.singleDate.selectedDate
                );
                this.calendarButtonInput.classList.remove("input-btn");
                this.calendarButtonInput.classList.add("input-btn-active");
                this.calendarButtonInputText.textContent = this.fancyDateFormat(
                    this.singleDate.selectedDate
                );
            } else {
                this.calendarButtonInput.value = "";
                this.calendarButtonInput.classList.remove("input-btn-active");
                this.calendarButtonInput.classList.add("input-btn");
                this.calendarButtonInputText.textContent =
                    this.singleDate.defaultButtonText;
            }
        }

        if (this.calendarType === "multi-date") {
            if (
                this.multiDate.selectedDates.length &&
                Array.isArray(this.multiDate.selectedDates)
            ) {
                const selectedDatesLength = this.multiDate.selectedDates.length;
                const firstSelectedDate = this.fancyDateFormat(
                    this.multiDate.selectedDates[0]
                );
                const buttonText =
                    selectedDatesLength >= 2
                        ? `${firstSelectedDate} and ${
                              selectedDatesLength - 1
                          } more...`
                        : firstSelectedDate;
                this.calendarButtonInput.value = buttonText;
                this.calendarButtonInputText.textContent = buttonText;
                this.calendarButtonInput.classList.remove("input-btn");
                this.calendarButtonInput.classList.add("input-btn-active");
            } else {
                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.multiDate.defaultButtonText;
                this.calendarButtonInput.classList.remove("input-btn-active");
                this.calendarButtonInput.classList.add("input-btn");
            }
        }

        if (this.calendarType === "range") {
            if (
                this.rangeDate.selectedDates.startDate &&
                this.rangeDate.selectedDates.endDate
            ) {
                const startDate = this.fancyDateFormat(
                    this.rangeDate.selectedDates.startDate
                );
                const endDate = this.fancyDateFormat(
                    this.rangeDate.selectedDates.endDate
                );
                this.calendarButtonInput.value = `${startDate} to ${endDate}`;
                this.calendarButtonInputText.textContent = `${startDate} to ${endDate}`;
                this.calendarButtonInput.classList.remove("input-btn");
                this.calendarButtonInput.classList.add("input-btn-active");
            } else {
                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.rangeDate.defaultButtonText;
                this.calendarButtonInput.classList.remove("input-btn-active");
                this.calendarButtonInput.classList.add("input-btn");
            }
        }

        if (this.calendarType === "multi-range") {
            const allDates = this.multiRangeDate.selectedDates.allDates;

            if (allDates.length >= 1) {
                const startDate = this.fancyDateFormat(allDates[0].startDate);
                const endDate = this.fancyDateFormat(allDates[0].endDate);
                const allDatesLength = allDates.length;

                const prefix = `${startDate} to ${endDate}`;
                const suffix =
                    allDatesLength - 1 >= 1
                        ? `and ${allDatesLength - 1} more...`
                        : "";

                const buttonText = `${prefix} ${suffix}`;
                this.calendarButtonInput.value = buttonText;
                this.calendarButtonInputText.textContent = buttonText;
                this.calendarButtonInput.classList.remove("input-btn");
                this.calendarButtonInput.classList.add("input-btn-active");
            } else {
                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.multiRangeDate.defaultButtonText;
                this.calendarButtonInput.classList.remove("input-btn-active");
                this.calendarButtonInput.classList.add("input-btn");
            }
        }
    }

    generateHiddenInput() {
        if (this.calendarType === "single-date") {
            const wrapper = this.calendar.querySelector(
                ".single-date-selector-wrapper"
            );
            let selectDate;

            if (this.singleDate.selectedDate) {
                selectDate = this.formatDate(this.singleDate.selectedDate);
            } else {
                selectDate = "";
            }

            if (wrapper) {
                const selectedDateInput = wrapper.querySelector(
                    ".selected-date-input"
                );
                selectedDateInput.value = selectDate;
            } else {
                const parentDiv = document.createElement("div");
                parentDiv.classList.add(
                    "single-date-selector-wrapper",
                    "hidden"
                );

                const selectedDateInput = document.createElement("input");
                selectedDateInput.type = "input";
                selectedDateInput.name = "date";
                selectedDateInput.value = selectDate;

                selectedDateInput.classList.add(
                    "selected-date-input",
                    "date-input"
                );
                parentDiv.appendChild(selectedDateInput);
                this.calendar.appendChild(parentDiv);
            }
        }

        if (this.calendarType === "multi-date") {
            const wrapper = this.calendar.querySelector(
                ".multi-date-selector-wrapper"
            );
            const selectedDates = this.multiDate.selectedDates.join(",");

            if (wrapper) {
                const selectedDatesInput = wrapper.querySelector(
                    ".selected-date-input"
                );
                selectedDatesInput.value = selectedDates;
            } else {
                const wrapper = document.createElement("div");
                wrapper.classList.add("multi-date-selector-wrapper", "hidden");

                const selectedDateInput = document.createElement("input");
                selectedDateInput.type = "text";
                selectedDateInput.name = "date";
                selectedDateInput.value = selectedDates;

                selectedDateInput.classList.add(
                    "selected-date-input",
                    "date-input"
                );
                wrapper.appendChild(selectedDateInput);
                this.calendar.appendChild(wrapper);
            }
        }

        if (this.calendarType === "range") {
            const wrapper = this.calendar.querySelector(
                ".range-selector-wrapper"
            );
            const startDate = this.rangeDate.selectedDates.startDate;
            const endDate = this.rangeDate.selectedDates.endDate;

            const startDateValue = startDate ? this.formatDate(startDate) : "";
            const endDateValue = endDate ? this.formatDate(endDate) : "";

            if (wrapper) {
                // Update Start and End Date Inputs Fields
                const startDateInput =
                    wrapper.querySelector(".start-date-input");
                const endDateInput = wrapper.querySelector(".end-date-input");

                startDateInput.value = startDateValue;
                endDateInput.value = endDateValue;
            } else {
                const wrapper = document.createElement("div");
                wrapper.classList.add("range-selector-wrapper", "hidden");
                const startDateInput = document.createElement("input");
                startDateInput.name = "start_date";
                startDateInput.type = "text";
                startDateInput.value = startDateValue;
                startDateInput.classList.add("start-date-input", "date-input");
                const endDateInput = document.createElement("input");
                endDateInput.type = "text";
                endDateInput.name = "end_date";
                endDateInput.value = endDateValue;
                endDateInput.classList.add("end-date-input", "date-input");
                wrapper.appendChild(startDateInput);
                wrapper.appendChild(endDateInput);
                this.calendar.appendChild(wrapper);
            }
        }

        if (this.calendarType === "multi-range") {
            const wrapper = this.calendar.querySelector(
                ".multi-range-selector-wrapper"
            );
            const selectedDates = this.multiRangeDate.selectedDates.allDates;
            let startDateValue = "";
            let endDateValue = "";

            selectedDates.forEach((date) => {
                startDateValue =
                    startDateValue === ""
                        ? this.formatDate(date.startDate)
                        : `${startDateValue},${this.formatDate(
                              date.startDate
                          )}`;
                endDateValue =
                    endDateValue === ""
                        ? this.formatDate(date.endDate)
                        : `${endDateValue},${this.formatDate(date.endDate)}`;
            });

            if (wrapper) {
                // Update Start and End Date Inputs Fields
                const startDateInput =
                    wrapper.querySelector(".start-date-input");
                const endDateInput = wrapper.querySelector(".end-date-input");

                startDateInput.value = startDateValue;
                endDateInput.value = endDateValue;
            } else {
                const wrapper = document.createElement("div");
                wrapper.classList.add("multi-range-selector-wrapper", "hidden");
                const startDateInput = document.createElement("input");
                startDateInput.type = "text";
                startDateInput.name = "start_date";
                startDateInput.value = startDateValue;
                startDateInput.classList.add("start-date-input", "date-input");
                const endDateInput = document.createElement("input");
                endDateInput.type = "text";
                endDateInput.name = "end_date";
                endDateInput.value = endDateValue;

                endDateInput.classList.add("end-date-input", "date-input");
                wrapper.appendChild(startDateInput);
                wrapper.appendChild(endDateInput);
                this.calendar.appendChild(wrapper);
            }
        }
    }

    setOptions(calendarType, newOptions) {
        const previouscalendarState = this.calendarType;

        if (calendarType === "single-date") {
            this.singleDate = new Object();
            this.singleDaySelection(newOptions);
            this.calendarType = previouscalendarState;
        }

        if (calendarType === "multi-date") {
            this.multiDate = new Object();
            this.multiDaySelection(newOptions);
            this.calendarType = previouscalendarState;
        }

        if (calendarType === "range") {
            this.rangeDate = new Object();
            this.rangeSelection(newOptions);
            this.calendarType = previouscalendarState;
        }

        if (calendarType === "multi-range") {
            this.multiRangeDate = new Object();
            this.multiRangeSelection(newOptions);
            this.calendarType = previouscalendarState;
        }
    }

    getOptions(calendarType) {
        if (calendarType === "single-date") {
            return this.singleDate;
        }
        if (calendarType === "multi-date") {
            return this.multiDate;
        }
        if (calendarType === "range") {
            return this.rangeDate;
        }
        if (calendarType === "multi-range") {
            return this.multiRangeDate;
        }
    }
}
