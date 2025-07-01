var ticketvalue 
 
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

class CustomCheckoutCalendar {
    constructor(calendarButtonInput) {
        this.calendarType = "null"; // Can be single-date | multi-date | range | multi-range | null
        this.calendarButtonInput = calendarButtonInput;

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
                console.error(element.errorMessage);
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

        this.calendarButtonInputText = this.calendarButtonInput.querySelector(
            ".text"
        )
            ? this.calendarButtonInput.querySelector(".text")
            : this.calendarButtonInput;

        this.calendar = null;
        this.leftBtn = null;
        this.rightBtn = null;
        this.displayMonthYear = null;
        this.calendarDaysWrapper = null;
        this.errorWrapper = null;
        this.errorElement = null;
        this.calendarSaveButton = null;
        this.calendarCancelButton = null;
        this.calendarAside = null;
        this.timeBaseWrapper = null;

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
        this.calendar = parentWrapper.querySelector(".calendar-modal");
        this.calendar ? this.calendar.remove() : (this.calendar = null);
        const calendarHtml = `
        <div class="calendar-modal">
            <div class="calendar-container">
                <div class="calendar-inner-container">
                    <div class="container-new">
                        <div class="custom-calendar">
                        <header class="calendar-header">
                            <button class="left" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"></path>
                            </svg>
                            </button>
                            <div class="header-display">
                            <p class="current-month-year">January 2025</p>
                            </div>
                            <button class="right" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"></path>
                            </svg>
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
                    </div>
                    <aside class="aside-time-slots-wrapper hidden">
                        <h5 class="header-aside-heading">Select Time Slots</h5>
                        <div class="time-base-wrapper"></div>
                    </aside>
                </div>
                <div class="calendar-footer-btn-wrapper">
                    <button type="button" class="save-calendar-btn transition">Save</button>
                    <button type="button" class="cancel-calendar-btn transition">Cancel</button>
                </div>
            </div>
        </div>
        `;

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
        this.calendarAside = parentWrapper.querySelector(
            ".aside-time-slots-wrapper"
        );
        this.timeBaseWrapper =
            this.calendarAside.querySelector(".time-base-wrapper");

        this.attachEventListeners();
    }

    attachEventListeners() {
        this.leftBtn.addEventListener("click", () => this.changeMonth("prev"));
        this.rightBtn.addEventListener("click", () => this.changeMonth("next"));
    }

    setCalendarDate(options, method) {
        if (!options) {
            this.calendarType = "null";
            console.error(
                `Error: The 'options' object is required but was not provided in the '${method}' method.`
            );
            return;
        }

        if (!options.dataSet) {
            this.calendarType = "null";
            console.error(
                `Error: The 'dataSet' property is required in the 'options' object.`
            );
            return;
        } else {
            if (this.calendarType === "single-date") {
                const calendarData = initializeCalendarData(options);
                this.singleDate = { ...this.singleDate, ...calendarData };
                this.singleDate.calendarType = this.calendarType;
                this.singleDate.dataSet = options.dataSet;
                this.singleDate.selectedDate = new Object();

                if (options.defaultButtonText) {
                    this.singleDate.defaultButtonText =
                        options.defaultButtonText;
                } else {
                    this.singleDate.defaultButtonText = "Enter A New Date";
                }
                this.generateButtonText();
                this.generateDateDisplay();
            }

            if (this.calendarType === "multi-date") {
                const calendarData = initializeCalendarData(options);
                this.multiDate = { ...this.multiDate, ...calendarData };
                this.multiDate.dataSet = options.dataSet;
                this.multiDate.calendarType = this.calendarType;
                this.multiDate.selectedDates = new Array();

                if (options.defaultButtonText) {
                    this.multiDate.defaultButtonText =
                        options.defaultButtonText;
                } else {
                    this.multiDate.defaultButtonText = "Enter A New Date";
                }

                this.generateDateDisplay();
                this.generateButtonText();
                console.log(this.multiDate);
            }

            if (this.calendarType === "range") {
                const calendarData = initializeCalendarData(options);
                this.rangeDate = { ...this.rangeDate, ...calendarData };
                this.rangeDate.dataSet = options.dataSet;
                this.rangeDate.calendarType = this.calendarType;
                this.rangeDate.selectedDates = new Array();

                if (options.defaultButtonText) {
                    this.rangeDate.defaultButtonText =
                        options.defaultButtonText;
                } else {
                    this.rangeDate.defaultButtonText = "Enter A New Date";
                }

                this.generateDateDisplay();
                this.generateButtonText();
                console.log(this.rangeDate);
            }

            if (this.calendarType === "multi-range") {
                const calendarData = initializeCalendarData(options);
                this.multiRangeDate = {
                    ...this.multiRangeDate,
                    ...calendarData,
                };
                this.multiRangeDate.dataSet = options.dataSet;
                this.multiRangeDate.calendarType = this.calendarType;
                this.multiRangeDate.selectedDates = new Array();

                if (options.defaultButtonText) {
                    this.multiRangeDate.defaultButtonText =
                        options.defaultButtonText;
                } else {
                    this.multiRangeDate.defaultButtonText = "Enter A New Date";
                }

                this.generateDateDisplay();
                this.generateButtonText();
                console.log(this.multiRangeDate);
            }
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
                    // console.log(currentDate);

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

        const rebuildCalendarTicketView = (data) => {
            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");
            data.availableDates = new Array();
            const slots = data.dataSet.slots;

            slots.forEach((slot) => {
                const date = slot.date;
                const time = slot.time;
                const isValidTimeArray =
                    Array.isArray(slot.time) && slot.time.length > 0;
                const ticketsAvailable = slot.paid_tickets >= 1;

                if (isValidTimeArray && ticketsAvailable)
                    data.availableDates.push(date);
            });

            allDateElements.forEach((day) => {
                if (day.dataset.date) {
                    const divDate = day.dataset.date.split("T")[0];

                    if (data.availableDates.includes(divDate)) {
                        day.classList.remove("disabled-date");
                        day.classList.add("available-date");
                    } else {
                        day.classList.remove("available-date");
                        day.classList.add("disabled-date");
                    }
                }
            });
        };

        const rebuildCalendarPassView = (data) => {
            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");
            data.availableDates = new Array();
            const slots = data.dataSet.slots;

            allDateElements.forEach((day) => {
                day.classList.remove("available-date");
                day.classList.add("disabled-date");
            });

            slots.forEach((slot) => {
                const startDate = slot.start_date;
                const endDate = slot.end_date;

                const isValidTimeArray =
                    Array.isArray(slot.time) && slot.time.length > 0;
                const ticketsAvailable = slot.paid_tickets >= 1;

                if (isValidTimeArray && ticketsAvailable) {
                    data.availableDates.push(`${startDate} - ${endDate}`);
                    const datesBetween = getDatesBetween(startDate, endDate);

                    datesBetween.forEach((date) => {
                        const dateString = `${date}T00:00:00.000Z`;
                        const availableDateDiv =
                            this.calendarDaysWrapper.querySelector(
                                `div[data-date="${dateString}"]`
                            );
                        if (availableDateDiv) {
                            availableDateDiv.classList.remove("disabled-date");
                            availableDateDiv.classList.add("available-date");
                        }
                    });
                }
            });
        };

        if (this.calendarType === "single-date") {
            buildCalendarView(this.singleDate);

            if (this.singleDate.dataSet) {
                rebuildCalendarTicketView(this.singleDate);
            }
        }
        if (this.calendarType === "multi-date") {
            buildCalendarView(this.multiDate);

            if (this.multiDate.dataSet) {
                rebuildCalendarTicketView(this.multiDate);
            }
        }
        if (this.calendarType === "range") {
            buildCalendarView(this.rangeDate);
            if (this.rangeDate.dataSet) {
                rebuildCalendarPassView(this.rangeDate);
            }
        }

        if (this.calendarType === "multi-range") {
            buildCalendarView(this.multiRangeDate);
            if (this.multiRangeDate.dataSet) {
                rebuildCalendarPassView(this.multiRangeDate);
            }
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

    singleDaySelection(options) {
        if (Object.keys(this.singleDate).length === 0) {
            this.setCalendarDate(options, "singleDaySelection");
        }

        if (this.calendarType === "single-date") {
            this.renderCalendar();
            this.errorElement.textContent = "";

            if (Object.keys(this.singleDate.selectedDate).length >= 1) {
                const dateString = `${
                    this.singleDate.selectedDate.date.split("T")[0]
                }T00:00:00.000Z`;
                const activeDiv = this.calendarDaysWrapper.querySelector(
                    `div[data-date="${dateString}"]`
                );
                if (activeDiv) activeDiv.classList.add("active-date");
            }

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    this.errorElement.textContent = "";
                    allDateElements.forEach((dt) =>
                        dt.classList.remove("active-date")
                    );

                    const clickedDate = day.dataset.date.split("T")[0];
                    const currentSlot = this.getTicketSlot(
                        this.singleDate,
                        clickedDate
                    );
                    const selectedDate = this.singleDate.selectedDate.date;

                    this.timeBaseWrapper.innerHTML = "";

                    if (selectedDate) {
                        if (clickedDate === selectedDate) {
                            day.classList.remove("active-date");
                            this.singleDate.selectedDate = new Object();
                            this.calendarAside.classList.add("hidden");
                        } else {
                            day.classList.add("active-date");
                            this.singleDate.selectedDate = currentSlot;
                            this.calendarAside.classList.remove("hidden");
                        }
                    } else {
                        day.classList.add("active-date");
                        this.singleDate.selectedDate = currentSlot;
                        this.calendarAside.classList.remove("hidden");
                    }
                    this.generateButtonText();
                    this.generateDateDisplay();
                    this.generateTimeSlot();
                    this.generateHiddenInput();

                    console.log(this.singleDate, currentSlot);
                });

                day.addEventListener("mouseover", () => {
                    this.handleIndividualDateHover(day.dataset.date);
                });

                day.addEventListener("mouseout", () => {
                    this.handleIndividualDateHover(null, false);
                });
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.errorElement.textContent = "";
                this.calendarType = "single-date";
            });

            this.calendarCancelButton.addEventListener("click", () => {
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.generateButtonText();
                this.calendarType = null;
            });

            this.calendarSaveButton.addEventListener("click", () => {

                if (!this.singleDate.selectedDate.date) {
                    this.generateError(
                        "Please select a date",
                        this.errorElement
                    );
                    return;
                } else if (!this.singleDate.selectedDate.isSelected) {
                    this.generateError(
                        "Please select a time slot",
                        this.errorElement
                    );
                    return;
                }
                this.generateButtonText();
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.calendarType = null;
            });
        }
    }

    multiDaySelection(options) {
        if (Object.keys(this.multiDate).length === 0) {
            this.setCalendarDate(options, "multiDaySelection");
        }

        if (this.calendarType === "multi-date") {
            this.renderCalendar();
            this.errorElement.textContent = "";

            if (this.multiDate.selectedDates.length > 0) {
                this.multiDate.selectedDates.forEach((selectedDate) => {
                    const dateString = `${selectedDate.date}T00:00:00.000Z`;
                    const activeDiv = this.calendarDaysWrapper.querySelector(
                        `div[data-date="${dateString}"]`
                    );
                    if (activeDiv) activeDiv.classList.add("active-date");
                });
            }

            const saveUniqueSlot = (slotData, clickedDate) => {
                let isSameSlot = false;
                const slotDataDate = slotData.date;
                const slotDataStartTime = slotData.time[0].startTime;
                const slotDataEndTime = slotData.time[0].endTime;

                // Check if the selected slot is already in the selectedDates array
                this.multiDate.selectedDates.forEach((item, index) => {
                    const itemDate = item.date;
                    const itemStartTime = item.time[0].startTime;
                    const itemEndTime = item.time[0].endTime;

                    const areSame =
                        slotDataDate === itemDate &&
                        slotDataStartTime === itemStartTime &&
                        slotDataEndTime === itemEndTime;

                    if (areSame) {
                        isSameSlot = true;
                        this.multiDate.selectedDates.splice(index, 1);
                    }
                });

                const activeDateDiv = this.calendarDaysWrapper.querySelector(
                    `div[data-date="${clickedDate}T00:00:00.000Z"]`
                );

                if (!isSameSlot) {
                    this.multiDate.selectedDates.push(slotData);
                    if (activeDateDiv)
                        activeDateDiv.classList.add("active-date");
                } else {
                    if (activeDateDiv)
                        activeDateDiv.classList.remove("active-date");
                }
            };

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    this.errorElement.textContent = "";
                    const selectedDates = this.multiDate.selectedDates;
                    const clickedDate = day.dataset.date.split("T")[0];

                    const currentSlot = this.getTicketSlot(
                        this.multiDate,
                        clickedDate
                    );
                    saveUniqueSlot(currentSlot, clickedDate);
                    this.multiDate.selectedDates.length > 0
                        ? this.calendarAside.classList.remove("hidden")
                        : this.calendarAside.classList.add("hidden");
                    this.timeBaseWrapper.innerHTML = "";
                    this.generateTimeSlot();

                    selectedDates.forEach((item) => {
                        if (item.isSelected) {
                            const timeSlotBtn =
                                this.timeBaseWrapper.querySelector(
                                    `button[data-date="${item.date}"]`
                                );
                            if (timeSlotBtn)
                                timeSlotBtn.classList.add(
                                    "available-time-slot"
                                );
                        }
                    });

                    console.log(this.multiDate);
                    this.generateButtonText();
                    this.generateDateDisplay();
                    this.generateHiddenInput();
                });

                day.addEventListener("mouseover", () => {
                    this.handleIndividualDateHover(day.dataset.date);
                });

                day.addEventListener("mouseout", () => {
                    this.handleIndividualDateHover(null, false);
                });
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.errorElement.textContent = "";
                this.calendarType = "multi-date";
            });

            this.calendarCancelButton.addEventListener("click", () => {
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.generateButtonText();
                this.calendarType = null;
            });

            this.calendarSaveButton.addEventListener("click", () => {
                if (this.multiDate.selectedDates.length === 0) {
                    this.generateError(
                        "Please select at least one date",
                        this.errorElement
                    );
                    return;
                } else {
                    const selectedDates = this.multiDate.selectedDates;
                    let isValid = true;

                    for (const index in selectedDates) {
                        if (!selectedDates[index].isSelected) {
                            isValid = false;
                            break;
                        }
                    }

                    if (!isValid) {
                        this.generateError(
                            "Please select time slot for each selected date",
                            this.errorElement
                        );
                        return;
                    } else {
                        this.calendar.classList.remove("show");
                        this.errorElement.textContent = "";
                        this.calendarType = null;
                        this.generateButtonText();
                    }
                }
            });
        }
    }

    rangeSelection(options) {
        if (Object.keys(this.rangeDate).length === 0) {
            this.setCalendarDate(options, "rangeSelection");
        }

        if (this.calendarType === "range") {
            this.renderCalendar();
            this.errorElement.textContent = "";
            this.handleRanges(this.rangeDate);

            const toggleRangeSave = (slot) => {
                const data = {
                    isSelected: false,
                    startDate: slot.start_date,
                    endDate: slot.end_date,
                    paidTickets: slot.paid_tickets,
                    freeTickets: slot.free_tickets,
                    donatedTickets: slot.donated_tickets,
                    packages: slot.packages,
                    totalTickets: slot.total_tickets,
                    time: [
                        {
                            endTime: slot.time[0].end_time,
                            startTime: slot.time[0].start_time,
                        },
                    ],
                };
                this.timeBaseWrapper.innerHTML = "";

                if (this.rangeDate.selectedDates.length === 0) {
                    this.rangeDate.selectedDates.push(data);
                    this.calendarAside.classList.remove("hidden");
                } else {
                    const areStartDatesEqual =
                        this.rangeDate.selectedDates[0].startDate ===
                        data.startDate;
                    const areEndDatesEqual =
                        this.rangeDate.selectedDates[0].endDate ===
                        data.endDate;

                    if (areStartDatesEqual && areEndDatesEqual) {
                        this.rangeDate.selectedDates.length = 0;
                        this.calendarAside.classList.add("hidden");
                    } else {
                        this.rangeDate.selectedDates.length = 0;
                        this.rangeDate.selectedDates.push(data);
                        this.calendarAside.classList.remove("hidden");
                    }
                }
            };

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    allDateElements.forEach((dt) =>
                        dt.classList.remove("active-date", "highlighted-date")
                    );
                    this.errorElement.textContent = "";
                    const clickedDate = day.dataset.date.split("T")[0];
                    const clickedRange = this.getClickedRange(
                        this.rangeDate,
                        clickedDate
                    );
                    const curentSlotRange =
                        this.rangeDate.dataSet.slots[clickedRange.index];
                    toggleRangeSave(curentSlotRange);
                    this.handleRanges(this.rangeDate);
                    this.generateTimeSlot();
                    this.generateDateDisplay();
                    this.generateButtonText();
                    this.generateHiddenInput();
                    console.log(this.rangeDate);
                });

                day.addEventListener("mouseover", () => {
                    const hoveredDate = day.dataset.date.split("T")[0];
                    this.handleRangeHover(this.rangeDate, hoveredDate);
                });

                day.addEventListener("mouseout", () => {
                    const hoveredDate = day.dataset.date.split("T")[0];
                    this.handleRangeHover(this.rangeDate, hoveredDate, false);
                });
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.errorElement.textContent = "";
                this.calendarType = "range";
            });

            this.calendarCancelButton.addEventListener("click", () => {
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.generateButtonText();
                this.calendarType = null;
            });

            this.calendarSaveButton.addEventListener("click", () => {
                if (this.rangeDate.selectedDates.length === 0) {
                    this.generateError(
                        "Please select at least one date range",
                        this.errorElement
                    );
                    return;
                } else {
                    if (!this.rangeDate.selectedDates[0].isSelected) {
                        this.generateError(
                            "Please select a time slot for the selected date range",
                            this.errorElement
                        );
                        return;
                    }

                    this.calendar.classList.remove("show");
                    this.errorElement.textContent = "";
                    this.calendarType = null;
                    this.generateButtonText();
                }
            });
        }
    }

    multiRangeSelection(options) {
        if (Object.keys(this.multiRangeDate).length === 0) {
            this.setCalendarDate(options, "multiRangeSelection");
        }

        if (this.calendarType === "multi-range") {
            this.renderCalendar();
            this.errorElement.textContent = "";
            this.handleRanges(this.multiRangeDate);

            const saveUniqueRange = (slot) => {
                const data = {
                    isSelected: false,
                    startDate: slot.start_date,
                    endDate: slot.end_date,
                    paidTickets: slot.paid_tickets,
                    freeTickets: slot.free_tickets,
                    donatedTickets: slot.donated_tickets,
                    packages: slot.packages,
                    totalTickets: slot.total_tickets,
                    time: [
                        {
                            endTime: slot.time[0].end_time,
                            startTime: slot.time[0].start_time,
                        },
                    ],
                };
                this.timeBaseWrapper.innerHTML = "";

                if (this.multiRangeDate.selectedDates.length === 0) {
                    this.multiRangeDate.selectedDates.push(data);
                } else {
                    let found = false;

                    for (const index in this.multiRangeDate.selectedDates) {
                        const item = this.multiRangeDate.selectedDates[index];

                        if (
                            item.startDate === data.startDate &&
                            item.endDate === data.endDate
                        ) {
                            this.multiRangeDate.selectedDates.splice(index, 1);
                            found = true;
                            break;
                        }
                    }

                    if (!found) {
                        this.multiRangeDate.selectedDates.push(data);
                    }
                }

                if (this.multiRangeDate.selectedDates.length === 0) {
                    this.calendarAside.classList.add("hidden");
                } else {
                    this.calendarAside.classList.remove("hidden");
                }
            };

            const allDateElements =
                this.calendarDaysWrapper.querySelectorAll("div");

            allDateElements.forEach((day) => {
                day.addEventListener("click", () => {
                    const clickedDate = day.dataset.date.split("T")[0];
                    const clickedRange = this.getClickedRange(
                        this.multiRangeDate,
                        clickedDate
                    );
                    const curentSlotRange =
                        this.multiRangeDate.dataSet.slots[clickedRange.index];
                    allDateElements.forEach((dt) =>
                        dt.classList.remove("active-date", "highlighted-date")
                    );
                    saveUniqueRange(curentSlotRange);
                    this.handleRanges(this.multiRangeDate);
                    this.generateTimeSlot();
                    this.generateButtonText();
                    this.generateHiddenInput();
                });

                day.addEventListener("mouseover", () => {
                    const hoveredDate = day.dataset.date.split("T")[0];
                    this.handleRangeHover(this.multiRangeDate, hoveredDate);
                });

                day.addEventListener("mouseout", () => {
                    const hoveredDate = day.dataset.date.split("T")[0];
                    this.handleRangeHover(
                        this.multiRangeDate,
                        hoveredDate,
                        false
                    );
                });
            });

            this.calendarButtonInput.addEventListener("click", () => {
                this.calendar.classList.add("show");
                this.errorElement.textContent = "";
                this.calendarType = "multi-range";
            });

            this.calendarCancelButton.addEventListener("click", () => {
                this.calendar.classList.remove("show");
                this.errorElement.textContent = "";
                this.calendarType = null;
            });

            this.calendarSaveButton.addEventListener("click", () => {
                if (this.multiRangeDate.selectedDates.length === 0) {
                    this.generateError(
                        "Please select at least one date range",
                        this.errorElement
                    );
                    return;
                } else {
                    for (let item of this.multiRangeDate.selectedDates) {
                        if (!item.isSelected) {
                            this.generateError(
                                "Please select a time slot for the selected date range",
                                this.errorElement
                            );
                            return;
                        }
                    }

                    this.calendar.classList.remove("show");
                    this.errorElement.textContent = "";
                    this.calendarType = null;
                    this.generateButtonText();
                    console.log(this.multiRangeDate);
                }
            });
        }
    }

    getTicketSlot(data, clickedDate) {
        const curentSlot = data.dataSet.slots.find(
            (slot) => slot.date === clickedDate
        );

        const slotData = {
            date: curentSlot.date,
            isSelected: false,
            donatedTickets: curentSlot.donated_tickets,
            freeTickets: curentSlot.free_tickets,
            packages: curentSlot.packages,
            paidTickets: curentSlot.paid_tickets,
            time: [
                {
                    startTime: curentSlot.time[0].start_time,
                    endTime: curentSlot.time[0].end_time,
                },
            ],
            totalTickets: curentSlot.total_tickets,
        };
        return slotData;
    }

    getClickedRange(data, dateString) {
        let result = null;

        for (let index = 0; index < data.dataSet.slots.length; index++) {
            const item = data.dataSet.slots[index];
            const start_date = item.start_date;
            const end_date = item.end_date;
            const datesBetween = getDatesBetween(start_date, end_date);

            if (datesBetween.includes(dateString)) {
                result = {
                    startDate: start_date,
                    endDate: end_date,
                    index: index,
                };
                break;
            }
        }

        return result;
    }

    handleRanges(data) {
        data.selectedDates.forEach((selected) => {
            const datesBetween = getDatesBetween(
                selected.startDate,
                selected.endDate
            );
            if (datesBetween.length > 0) {
                const activeStartDate = this.calendarDaysWrapper.querySelector(
                    `div[data-date="${datesBetween[0]}T00:00:00.000Z"]`
                );
                const activeEndDate = this.calendarDaysWrapper.querySelector(
                    `div[data-date="${
                        datesBetween[datesBetween.length - 1]
                    }T00:00:00.000Z"]`
                );

                if (activeStartDate) {
                    activeStartDate.classList.add("active-date");
                }
                if (activeEndDate) {
                    activeEndDate.classList.add("active-date");
                }

                datesBetween.forEach((date) => {
                    const activeDiv = this.calendarDaysWrapper.querySelector(
                        `div[data-date="${date}T00:00:00.000Z"]`
                    );
                    if (activeDiv) activeDiv.classList.add("highlighted-date");
                });
            }
        });
    }

    handleRangeHover(data, hoveredDate, isHovered = true) {
        const hoveredRange = data.availableDates
            .map((element) => {
                const [startDate, endDate] = element.split(" - ");
                const datesBetween = getDatesBetween(startDate, endDate);

                const isHoveredDateInRange = datesBetween.includes(hoveredDate);

                if (isHoveredDateInRange) return datesBetween;

                return null;
            })
            .filter((dates) => dates !== null);

        if (isHovered) {
            hoveredRange.forEach((dates) => {
                dates.forEach((date) => {
                    const activeDiv = this.calendarDaysWrapper.querySelector(
                        `div[data-date="${date}T00:00:00.000Z"]`
                    );
                    if (activeDiv) activeDiv.classList.add("highlighted-date");
                });
            });
        } else {
            hoveredRange.forEach((dates) => {
                dates.forEach((date) => {
                    const activeDiv = this.calendarDaysWrapper.querySelector(
                        `div[data-date="${date}T00:00:00.000Z"]`
                    );
                    if (activeDiv)
                        activeDiv.classList.remove("highlighted-date");
                });
            });
        }

        this.handleRanges(data);
    }

    handleIndividualDateHover(hoveredDate, isHovered = true) {
        const allDateElements =
            this.calendarDaysWrapper.querySelectorAll("div");

        if (isHovered) {
            const selectedDate = this.calendarDaysWrapper.querySelector(
                `div[data-date="${hoveredDate}"]`
            );
            if (selectedDate) {
                selectedDate.classList.toggle("highlighted-date");
            }
        } else {
            allDateElements.forEach((days) =>
                days.classList.remove("highlighted-date")
            );
        }
    }

    generateError(errorMessage, errorElement) {
        errorElement.textContent = errorMessage;
        errorElement.classList.add("error-shake");
        setTimeout(() => {
            errorElement.classList.remove("error-shake");
        }, 500);
    }

    generateTimeSlot() {
        const generateHTML = (key, dateSting, startTime, endTime) => {
            const baseHTML = `
            <div class="time-base-item-date-wrapper">
                <p class="time-base-item-date">${this.fancyDateGlow(
                    dateSting
                )}</p>
            </div>
            <div class="time-base-item-btn-wrapper"></div>
            `;

            const wrapper = document.createElement("div");
            wrapper.classList.add("time-base-item-wrapper");
            wrapper.insertAdjacentHTML("beforeend", baseHTML);

            const timeSlotBtn = document.createElement("button");
            timeSlotBtn.classList.add("time-base-item-btn");
            timeSlotBtn.textContent = `${startTime} - ${endTime}`;
            timeSlotBtn.setAttribute("type", "button");
            timeSlotBtn.setAttribute("data-date", key);
            timeSlotBtn.setAttribute("data-start_time", startTime);
            timeSlotBtn.setAttribute("data-end_time", endTime);

            const btnWrapper = wrapper.querySelector(
                ".time-base-item-btn-wrapper"
            );
            btnWrapper.appendChild(timeSlotBtn);

            timeSlotBtn.addEventListener("click", () => {
                this.errorElement.textContent = "";

                if (this.calendarType === "single-date") {
                    const isSelected = this.singleDate.selectedDate.isSelected;

                    if (!isSelected) {
                        this.singleDate.selectedDate.isSelected = true;
                        timeSlotBtn.classList.add("available-time-slot");
                    } else {
                        this.singleDate.selectedDate.isSelected = false;
                        timeSlotBtn.classList.remove("available-time-slot");
                    }
                    console.log(this.singleDate);
                }

                if (this.calendarType === "multi-date") {
                    const selectedDates = this.multiDate.selectedDates;

                    if (selectedDates.length > 0) {
                        selectedDates.forEach((item) => {
                            const itemDate = item.date;
                            const itemSelected = item.isSelected;

                            if (itemDate === dateSting) {
                                if (!itemSelected) {
                                    item.isSelected = true;
                                    timeSlotBtn.classList.add(
                                        "available-time-slot"
                                    );
                                } else {
                                    item.isSelected = false;
                                    timeSlotBtn.classList.remove(
                                        "available-time-slot"
                                    );
                                }
                            }
                        });
                    }
                }

                if (this.calendarType === "range") {
                    const selectedDates = this.rangeDate.selectedDates;
                    selectedDates.forEach((item, index) => {
                        const startDate = item.startDate;
                        const endDate = item.endDate;
                        const dateString = `${startDate} - ${endDate}`;
                        this.generateButtonText();

                        if (timeSlotBtn.dataset.date === dateString) {
                            if (!item.isSelected) {
                                this.rangeDate.selectedDates[
                                    index
                                ].isSelected = true;
                                timeSlotBtn.classList.add(
                                    "available-time-slot"
                                );
                            } else {
                                this.rangeDate.selectedDates[
                                    index
                                ].isSelected = false;
                                timeSlotBtn.classList.remove(
                                    "available-time-slot"
                                );
                            }
                        }
                    });
                }

                if (this.calendarType === "multi-range") {
                    const selectedDates = this.multiRangeDate.selectedDates;
                    selectedDates.forEach((item, index) => {
                        const itemStartDate = item.startDate;
                        const itemEndDate = item.endDate;
                        const itemDateKey = `${itemStartDate} - ${itemEndDate}`;
                        const isSelected = item.isSelected;

                        if (itemDateKey === key) {
                            if (isSelected) {
                                timeSlotBtn.classList.remove(
                                    "available-time-slot"
                                );
                                this.multiRangeDate.selectedDates[
                                    index
                                ].isSelected = false;
                            } else {
                                timeSlotBtn.classList.add(
                                    "available-time-slot"
                                );
                                this.multiRangeDate.selectedDates[
                                    index
                                ].isSelected = true;
                            }
                            console.log(isSelected);
                        }
                    });
                }

                this.generateDateDisplay();
                this.generateButtonText();
                this.generateHiddenInput();
            });

            this.timeBaseWrapper.appendChild(wrapper);
        };

        if (this.calendarType === "single-date") {
            if (this.singleDate.selectedDate.date) {
                const selectedDate = this.singleDate.selectedDate.date;
                const startTime =
                    this.singleDate.selectedDate.time[0].startTime;
                const endTime = this.singleDate.selectedDate.time[0].endTime;

                generateHTML(selectedDate, selectedDate, startTime, endTime);
            }
        }

        if (this.calendarType === "multi-date") {
            this.multiDate.selectedDates.forEach((item) => {
                const dateString = item.date;
                const startTime = item.time[0].startTime;
                const endTime = item.time[0].endTime;

                generateHTML(dateString, dateString, startTime, endTime);
            });
        }

        if (this.calendarType === "range") {
            this.rangeDate.selectedDates.forEach((item) => {
                const datedKey = `${item.startDate} - ${item.endDate}`;
                const dateString = item.startDate;
                const startTime = item.time[0].startTime;
                const endTime = item.time[0].endTime;
                generateHTML(datedKey, dateString, startTime, endTime);
            });
        }

        if (this.calendarType === "multi-range") {
            this.multiRangeDate.selectedDates.forEach((item) => {
                const datedKey = `${item.startDate} - ${item.endDate}`;
                const dateString = item.startDate;
                const startTime = item.time[0].startTime;
                const endTime = item.time[0].endTime;
                generateHTML(datedKey, dateString, startTime, endTime);

                this.multiRangeDate.selectedDates.forEach((item) => {
                    if (item.isSelected) {
                        const activeTimeBtn =
                            this.timeBaseWrapper.querySelector(
                                `button[data-date="${item.startDate} - ${item.endDate}"]`
                            );
                        if (activeTimeBtn)
                            activeTimeBtn.classList.add("available-time-slot");
                    }
                });
            });
        }
    }

    generateDateDisplay() {
        function generateDateSVG() {
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

        function generateTimeSVG() {
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
                "m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Z"
            );

            svg.appendChild(path);
            return svg;
        }

        const selectedDay = this.calendar.querySelector(".display-selected");
        const wrapper = selectedDay.querySelector(".display-selected-wrapper");

        if (this.calendarType === "single-date") {
            let date = this.singleDate.selectedDate.date;

            let startTime, endTime;

            if (date) {
                date = this.fancyDateFormat(date);
                startTime = this.singleDate.selectedDate.time[0].startTime;
                endTime = this.singleDate.selectedDate.time[0].endTime;
            } else {
                date = "DD-MM, YYYY";
                startTime = "00-00";
                endTime = "00-00";
            }

            if (wrapper) {
                const selectedDateText = wrapper.querySelector(
                    ".calendar-start-date.date span"
                );
                const selectedTimeText = wrapper.querySelector(
                    ".calendar-start-date.time span"
                );
                selectedDateText.textContent = date;
                selectedTimeText.textContent = `${startTime} - ${endTime}`;
            } else {
                const baseHTML = `
                <div class="display-selected-wrapper">
                    <div class="calendar-start-date-wrapper">
                        ${generateDateSVG().outerHTML}
                        <p class="calendar-start-date date">Date: <span>${date}</span></p>
                    </div>
                    <div class="calendar-start-date-wrapper">
                        ${generateTimeSVG().outerHTML}
                        <p class="calendar-start-date time">Time: <span>${startTime} - ${endTime}</span></p>
                    </div>
                </div>
                `;

                selectedDay.innerHTML = baseHTML;
            }
        }
        if (this.calendarType === "multi-date") {
            const selectedDay =
                this.calendar.querySelector(".display-selected");
            const wrapper = selectedDay.querySelector(
                ".display-selected-wrapper"
            );
            const selectedDates = this.multiDate.selectedDates;
            let validLength = 0;

            selectedDates.forEach((item) => {
                if (item.isSelected) {
                    validLength = validLength + 1;
                }
            });

            validLength = validLength >= 100 ? "100+" : validLength;

            if (wrapper) {
                const selectedDatesText = wrapper.querySelector(
                    ".calendar-start-date"
                );
                selectedDatesText.textContent = `Selected Slots: ${validLength}`;
            } else {
                const selectedWrapper = document.createElement("div");
                selectedWrapper.classList.add("display-selected-wrapper");

                const startDateWrapper = document.createElement("div");
                startDateWrapper.classList.add("calendar-start-date-wrapper");

                const svgElement = generateDateSVG();
                const calendarStartDate = document.createElement("p");
                calendarStartDate.classList.add("calendar-start-date");
                calendarStartDate.innerHTML = `Selected Slots: ${validLength}`;

                startDateWrapper.appendChild(svgElement);
                startDateWrapper.appendChild(calendarStartDate);
                selectedWrapper.appendChild(startDateWrapper);
                selectedDay.appendChild(selectedWrapper);
            }
        }
        if (this.calendarType === "range") {
            const selectedDay =
                this.calendar.querySelector(".display-selected");
            const wrapper = selectedDay.querySelector(
                ".display-selected-wrapper"
            );
            const selectedDates = this.rangeDate.selectedDates;
            let startDate = "DD-MM, YYYY";
            let endDate = "DD-MM, YYYY";

            if (selectedDates.length > 0) {
                if (selectedDates[0].isSelected) {
                    startDate = this.fancyDateFormat(
                        selectedDates[0].startDate
                    );
                    endDate = this.fancyDateFormat(selectedDates[0].endDate);
                }
            }

            if (wrapper) {
                const selectedStartDateText = wrapper.querySelector(
                    ".calendar-start-date.start-date span"
                );
                const selectedEndDateText = wrapper.querySelector(
                    ".calendar-start-date.end-date span"
                );
                selectedStartDateText.textContent = startDate;
                selectedEndDateText.textContent = `${endDate}`;
            } else {
                const baseHTML = `
                <div class="display-selected-wrapper">
                    <div class="calendar-start-date-wrapper">
                        ${generateDateSVG().outerHTML}
                        <p class="calendar-start-date start-date">Start Date: <span>${startDate}</span></p>
                    </div>
                    <div class="calendar-start-date-wrapper">
                        ${generateDateSVG().outerHTML}
                        <p class="calendar-start-date end-date">End Date: <span>${endDate}</span></p>
                    </div>
                </div>
                `;

                selectedDay.innerHTML = baseHTML;
            }
        }
        if (this.calendarType === "multi-range") {
            const selectedDay =
                this.calendar.querySelector(".display-selected");
            const wrapper = selectedDay.querySelector(
                ".display-selected-wrapper"
            );
            const selectedDates = this.multiRangeDate.selectedDates;
            let validSlotsLength = 0;

            selectedDates.forEach((item) => {
                if (item.isSelected) {
                    validSlotsLength = validSlotsLength + 1;
                }
            });

            validSlotsLength =
                validSlotsLength >= 100 ? "100+" : validSlotsLength;

            if (wrapper) {
                const selectedDatesText = wrapper.querySelector(
                    ".calendar-start-date"
                );
                selectedDatesText.textContent = `Selected Slots: ${validSlotsLength}`;
            } else {
                const selectedWrapper = document.createElement("div");
                selectedWrapper.classList.add("display-selected-wrapper");
                const startDateWrapper = document.createElement("div");
                startDateWrapper.classList.add("calendar-start-date-wrapper");

                const svgElement = generateDateSVG();
                const calendarStartDate = document.createElement("p");
                calendarStartDate.classList.add("calendar-start-date");
                calendarStartDate.innerHTML = `Selected Slots: ${validSlotsLength}`;

                startDateWrapper.appendChild(svgElement);
                startDateWrapper.appendChild(calendarStartDate);
                selectedWrapper.appendChild(startDateWrapper);
                selectedDay.appendChild(selectedWrapper);
            }
        }
    }

    fancyDateFormat(dateString) {
        const date = new Date(dateString);

        const day = date.getUTCDate();
        const month = date.toLocaleString("default", { month: "short" });
        const year = date.getUTCFullYear();

        return `${day} ${month} ${year}`;
    }

    fancyDateGlow(dateString) {
        const date = new Date(dateString);

        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
            timeZone: "UTC",
        };

        return date.toLocaleDateString("en-US", options);
    }

    formatDate(dateString) {
        const newDate = new Date(dateString);
        return newDate.toISOString().split("T")[0];
    }

    generateButtonText() {
        if (this.calendarType === "single-date") {
            if (this.singleDate.selectedDate.date) {
                if (this.singleDate.selectedDate.isSelected) {
                    const date = this.formatDate(
                        this.singleDate.selectedDate.date
                    );
                    const startTime =
                        this.singleDate.selectedDate.time[0].startTime;
                    const endTime =
                        this.singleDate.selectedDate.time[0].endTime;
                    this.calendarButtonInput.value = `${date} | ${startTime} - ${endTime}`;
                    this.calendarButtonInputText.textContent = `${date} | ${startTime} - ${endTime}`;
                    return;
                }

                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.singleDate.defaultButtonText;
            } else {
                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.singleDate.defaultButtonText;
            }
        }

        if (this.calendarType === "multi-date") {
            if (this.multiDate.selectedDates.length === 0) {
                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.multiDate.defaultButtonText;
            } else {
                let validSelectedDates = 0;
                let firstDate, firstStartTime, firstEndTime;

                this.multiDate.selectedDates.forEach((item) => {
                    if (item.isSelected) {
                        validSelectedDates = validSelectedDates + 1;

                        if ((!firstDate, !firstStartTime, !firstEndTime)) {
                            firstDate = item.date;
                            firstStartTime = item.time[0].startTime;
                            firstEndTime = item.time[0].endTime;
                        }
                    }
                });

                if (validSelectedDates === 0) {
                    this.calendarButtonInput.value = "";
                    this.calendarButtonInputText.textContent =
                        this.multiDate.defaultButtonText;
                } else {
                    if (validSelectedDates === 1) {
                        this.calendarButtonInput.value = `${firstDate} | ${firstStartTime} - ${firstEndTime}`;
                        this.calendarButtonInputText.textContent = `${firstDate} | ${firstStartTime} - ${firstEndTime}`;
                    } else {
                        const buttonText = `${firstDate} | ${firstStartTime} - ${firstEndTime} and ${
                            validSelectedDates - 1
                        } more...`;
                        this.calendarButtonInput.value = buttonText;
                        this.calendarButtonInputText.textContent = buttonText;
                    }
                }
            }
        }

        if (this.calendarType === "range") {
            if (this.rangeDate.selectedDates.length === 0) {
                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.rangeDate.defaultButtonText;
            } else {
                const selectedDates = this.rangeDate.selectedDates;

                if (selectedDates[0].isSelected) {
                    let startDate = selectedDates[0].startDate;
                    let endDate = selectedDates[0].endDate;
                    let startTime = selectedDates[0].time[0].startTime;
                    let endTime = selectedDates[0].time[0].endTime;

                    this.calendarButtonInput.value = `${startDate} to ${endDate} | ${startTime} to ${endTime}`;
                    this.calendarButtonInputText.textContent = `${startDate} to ${endDate} | ${startTime} to ${endTime}`;
                } else {
                    this.calendarButtonInput.value = "";
                    this.calendarButtonInputText.textContent =
                        this.rangeDate.defaultButtonText;
                }
            }
        }

        if (this.calendarType === "multi-range") {
            if (this.multiRangeDate.selectedDates.length === 0) {
                this.calendarButtonInput.value = "";
                this.calendarButtonInputText.textContent =
                    this.multiRangeDate.defaultButtonText;
            } else {
                let selectedDates = this.multiRangeDate.selectedDates;
                let firstStartDate, firstEndDate, firstStartTime, firstEndTime;
                let selectedSlotsLength = 0;

                selectedDates.forEach((item) => {
                    if (item.isSelected) {
                        let allSelected =
                            !firstStartDate &&
                            !firstEndDate &&
                            !firstStartTime &&
                            !firstEndTime;

                        if (allSelected) {
                            firstStartDate = item.startDate;
                            firstEndDate = item.endDate;
                            firstStartTime = item.time[0].startTime;
                            firstEndTime = item.time[0].endTime;
                        }

                        selectedSlotsLength = selectedSlotsLength + 1;
                    }
                });

                if (selectedSlotsLength >= 1) {
                    if (selectedSlotsLength === 1) {
                        const buttonsText = `${firstStartDate} to ${firstEndDate} | ${firstStartTime} to ${firstEndTime}`;
                        this.calendarButtonInput.value = buttonsText;
                        this.calendarButtonInputText.textContent = buttonsText;
                    } else {
                        const buttonsText = `${firstStartDate} to ${firstEndDate} | ${firstStartTime} to ${firstEndTime} and ${
                            selectedSlotsLength - 1
                        } more...`;
                        this.calendarButtonInput.value = buttonsText;
                        this.calendarButtonInputText.textContent = buttonsText;
                    }
                }
            }
        }
    }

    generateHiddenInput() {
        const wrapper = this.calendar.querySelector(".hidden-slots-wrapper");
        let inputData;

        if (this.calendarType === "single-date") {
            inputData = this.singleDate.selectedDate.isSelected
                ? JSON.stringify(this.singleDate)
                : "";
        } else if (this.calendarType === "multi-date") {
            let areAllSelected = true;
            this.multiDate.selectedDates.forEach((item) => {
                if (!item.isSelected) {
                    areAllSelected = false;
                }
            });

            inputData = areAllSelected ? JSON.stringify(this.multiDate) : "";
        } else if (this.calendarType === "range") {
            let areAllSelected = true;
            this.rangeDate.selectedDates.forEach((item) => {
                if (!item.isSelected) {
                    areAllSelected = false;
                }
            });

            inputData = areAllSelected ? JSON.stringify(this.rangeDate) : "";
        } else if (this.calendarType === "multi-range") {
            let areAllSelected = true;
            this.multiRangeDate.selectedDates.forEach((item) => {
                if (!item.isSelected) {
                    areAllSelected = false;
                }
            });
            inputData = areAllSelected
                ? JSON.stringify(this.multiRangeDate)
                : "";
        }

        if (wrapper) {
            const slotDatesInput = wrapper.querySelector(".slot-dates-input");
            slotDatesInput.value = inputData;
        } else {
            const parentDiv = document.createElement("div");
            parentDiv.classList.add("hidden-slots-wrapper", "hidden");
            const slotDatesInput = document.createElement("input");
            slotDatesInput.type = "input";
            slotDatesInput.classList.add("slot-dates-input");
            slotDatesInput.value = inputData;
            parentDiv.appendChild(slotDatesInput);
            this.calendar.appendChild(parentDiv);
        }
    }
}






function handleSeperateType(type,event){
    console.log(event)
    ticketvalue=event
  let typeareapass=document.querySelector(".type-area-pass")
  let typeareaticket=document.querySelector(".type-area-ticket")
  let calenderarea=document.querySelector(".custom-calendar-wrapper")
   let calenderbutton=document.querySelector(".calender-input-button")
   console.log(typeareapass,typeareaticket)

    if(type==="pass"){
        handleCustomPassCollection()
        typeareapass.classList.remove("hidden")
        typeareaticket.classList.add("hidden")
        calenderarea.classList.add("single-date")
        calenderbutton.classList.add("single-date")
        calenderbutton.setAttribute("data-calendar-type", "single-date");
        const singleDaycalendarWrapper = document.querySelector(".custom-calendar-wrapper.single-date");
        const singleDayButton = singleDaycalendarWrapper.querySelector(".calender-input-button");
        const singleDayCalendar = new CustomCheckoutCalendar(singleDayButton);
        singleDayCalendar.singleDaySelection({
            disablePastDates: true,
            defaultButtonText: "Ticket",
            dataSet: modifyForCustomDate(ticketvalue),
        });
        console.log(event.slots[0].time[0].end_time)
        document.querySelector(".pass-time-detail").innerHTML=`Time: ${event.slots[0].time[0].start_time} -  ${event.slots[0].time[0].end_time}`
        document.querySelector(".pass-time-detail1").innerHTML=`Time: ${event.slots[0].time[0].start_time} -  ${event.slots[0].time[0].end_time}`
    }
    else {
       typeareapass.classList.add("hidden");
       typeareaticket.classList.remove("hidden");
       calenderarea.classList.add("multi-date")
       calenderbutton.classList.add("multi-date")
       calenderbutton.setAttribute("data-calendar-type", "multi-date");
       const multiDaycalendarWrapper = document.querySelector(".custom-calendar-wrapper.multi-date");
       console.log(multiDaycalendarWrapper);
       const multiDayButton = multiDaycalendarWrapper.querySelector(".calender-input-button");
       const multiDayCalendar = new CustomCheckoutCalendar(multiDayButton);
       
       multiDayCalendar.multiDaySelection({
         defaultDate: "2025-02-12",
         disablePastDates: true,
         'dataSet': ticketvalue
       });

    }
}


function modifyForCustomDate(data) {

    let formattedSlots = {
        type: "pass",
        slots: [],
    };

    data.slots.forEach((slot) => {
        let startDate = new Date(slot.start_date);
        let endDate = new Date(slot.end_date);

        for (
            let d = new Date(startDate);
            d <= endDate;
            d = new Date(d.setDate(d.getDate() + 1))
        ) {
            formattedSlots.slots.push({
                date: d.toISOString().split("T")[0], 
                // time: JSON.parse(JSON.stringify([slot.start_time,slot.end_date])), 
                time: JSON.parse(JSON.stringify(slot.time)),
                free_tickets: slot.free_tickets,
                donated_tickets: slot.donated_tickets,
                paid_tickets: slot.paid_tickets,
                total_tickets: slot.total_tickets,
                packages: JSON.parse(JSON.stringify(slot.packages)), 
            });
        }
    });

    return formattedSlots;
}

// const multiDaycalendarWrapper = document.querySelector(".custom-calendar-wrapper.multi-date");
// const multiDayButton = multiDaycalendarWrapper.querySelector(".calender-input-button");
// const multiDayCalendar = new CustomCheckoutCalendar(multiDayButton);

// multiDayCalendar.multiDaySelection({
//   defaultDate: "2025-02-12",
//   disablePastDates: true,
//   'dataSet': ticketDataSet
// });

// const rangeDaycalendarWrapper = document.querySelector(".custom-calendar-wrapper.range");
// const rangeDayButton = rangeDaycalendarWrapper.querySelector(".calender-input-button");
// const rangeDayCalendar = new CustomCheckoutCalendar(rangeDayButton);

// rangeDayCalendar.rangeSelection({
//   disablePastDates: true,
//   'dataSet': passDataSet
// });

// const multiRangeDaycalendarWrapper = document.querySelector(
//   ".custom-calendar-wrapper.multi-range"
// );
// const multiRangeDayButton = multiRangeDaycalendarWrapper.querySelector(
//   ".calender-input-button"
// );
// const multiRangeDayCalendar = new CustomCheckoutCalendar(multiRangeDayButton);

// multiRangeDayCalendar.multiRangeSelection({
//   disablePastDates: true,
//   dataSet: passDataSet,
// });

// Pass Functionality
function handleCustomPassCollection() {
    // document.querySelector(".pass-modal").classList.add("show");
    // // let a = document.querySelector(".calendar-container")
    // // a.innerHTML = ""
    // document.querySelector(".statick-pass-area").innerHTML = "";
    // document.querySelector(".custom-pass-area").innerHTML = "";

    // let asideWrapper = document.querySelector(".aside-pass-slots-wrapper");
    // asideWrapper.classList.add("hidden");
 console.log("ji")
    createCustomPass();
    createStaticPass();
}








function createCustomPass() {
    let custom_pass_area = document.querySelector(".custom-pass-area");
    // document.querySelector(".aside-time-slots-wrapper").classList.add("hidden");
    let data=ticketvalue.passes

      data.forEach((item, index) => {
      let custompass = `
       <div class="checkbox-wrapper-16">
            <label class="checkbox-wrapper" for="flexRadioDefault${index}">
                <input type="radio" id="flexRadioDefault${index}"
                    onclick="handleCustomPassSelected(${Number(item.days)},'no')"
                    name="flexRadioDefault"
                    class="checkbox-input custom-pass"
                    value="full-event">
                <span class="checkbox-tile"
                    style="flex-direction: row;min-height: unset;">
                    <span class="checkbox-icon block">
                        <img src="../admins/images/pass-icon.png"
                            style="width:40px;">
                    </span>
                    <div
                        class="ticket-card-header-icon-content-wrapper justify-start items-start">
                        <p class="ticket-card-header-name "
                            style="text-align: start !important;">
                            ${item.name}</p>
                        <p class="ticket-card-header-date">
                            <span>${Number(item.days)} days pass</span>
                        </p>
                    </div>
                </span>
            </label>
        </div>
      
      
      
      `;
        custom_pass_area.insertAdjacentHTML("beforeend", custompass);
    });
    
  if(data.length===0){
    document.querySelector(".custom-pass-area").classList.add("hidden");
  }
}
function createStaticPass() {
    let custom_pass_area = document.querySelector(".statick-pass-area");

    ticketvalue.slots.forEach((item, index) => {
        let custompass = `
    <div class="checkbox-wrapper-16">
            <label class="checkbox-wrapper" for="staticradiobutton${index}">
                <input type="radio" id="staticradiobutton${index}" onclick="handleStatickPassSelected(${index})" name="flexRadioDefault" class="checkbox-input custom-pass" value="full-event">
                <span class="checkbox-tile" style="flex-direction: row;min-height: unset;">
                    <span class="checkbox-icon block">
                        <img src="../admins/images/pass-icon.png" style="width:40px;">
                    </span>
                    <div class="ticket-card-header-icon-content-wrapper justify-start items-start">
                        <p class="ticket-card-header-name " style="text-align: start !important;">${countDays(item.start_date, item.end_date)} ${countDays(item.start_date, item.end_date) === 1 ? "Day" : "Days"} pass</p>
                        <p class="ticket-card-header-date">
                            <span>${item.start_date} to ${item.end_date}</span>
                        </p>
                    </div>
                </span>
            </label>
        </div>
    
    
    
    
      `;
        custom_pass_area.insertAdjacentHTML("beforeend", custompass);
    });
}

function countDays(startDate, endDate) {
    let start = new Date(startDate);
    let end = new Date(endDate);
    let difference = end - start;
    let days = difference / (1000 * 60 * 60 * 24);
    return days + 1;
}

function handlePassSaveButton() {
        savedata.startDate = savedata.start_date;
        savedata.endDate = savedata.end_date;
        let newdata = {
            selectedDates: [savedata],
        };
        const existingDiv = document.querySelector(".hidden-slots-wrapper");
        if (existingDiv) {
            existingDiv.remove();
        }
        const parentDiv = document.createElement("div");
        parentDiv.classList.add("hidden-slots-wrapper", "hidden");
        const slotDatesInput = document.createElement("input");
        slotDatesInput.type = "input";
        slotDatesInput.classList.add("slot-dates-input");
        slotDatesInput.value = JSON.stringify(newdata);
        parentDiv.appendChild(slotDatesInput);
        document.querySelector(".calendar-modal").appendChild(parentDiv);
        document.querySelector(".pass-modal").classList.remove("show");
        let dateformet=formatDateRange1(savedata.startDate, savedata.endDate)
        document.querySelector(".pass-date-detail").innerHTML=`Date: ${dateformet}`
}

function formatDateRange1(startDate, endDate) {
    const options = { day: '2-digit', month: 'short', year: 'numeric' };

    const start = new Date(startDate).toLocaleDateString('en-US', options);
    const end = new Date(endDate).toLocaleDateString('en-US', options);

    return `${start} - ${end}`;
}


function handlePassCancelButton() {
    document.querySelector(".pass-modal").classList.remove("show");
    const existingDiv = document.querySelector(".hidden-slots-wrapper");
    if (existingDiv) {
        existingDiv.remove();
    }
}

function handleCustomPassSelected(avilable_day, type) {
    
    document.querySelector(".pass-modal").classList.add("show")
    let asideWrapper = document.querySelector(".aside-pass-slots-wrapper");
    asideWrapper.classList.add("hidden");
    clearSelection();
    selectcustomdays = avilable_day;
    generateCalendar(currentDate.getMonth(), currentDate.getFullYear());
}

function handleStatickPassSelected(index) {
    const DayCalendar = new CustomCheckoutCalendar();
    let range = ticketvalue.slots[index];
     let time = range.time[0]
     let dateformet=formatDateRange1(range.start_date, range.end_date)
     document.querySelector(".pass-date-detail").innerHTML=`Date: ${dateformet}`
    savedata = range;
        savedata.startDate = savedata.start_date;
        savedata.endDate = savedata.end_date;

        let newdata = {
            selectedDates: [savedata],
        };
        const parentDiv = document.createElement("div");
        parentDiv.classList.add("hidden-slots-wrapper", "hidden");
        const slotDatesInput = document.createElement("input");
        slotDatesInput.type = "input";
        slotDatesInput.classList.add("slot-dates-input");
        slotDatesInput.value = JSON.stringify(newdata);
        parentDiv.appendChild(slotDatesInput);
        document.querySelector(".calendar-modal").appendChild(parentDiv);
}

function formatDate(dateString) {
    let options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    return new Date(dateString).toLocaleDateString("en-US", options);
}

function getFormattedDates(start_date, end_date) {
    let startDate = new Date(start_date);
    let endDate = new Date(end_date);
    let formattedDates = [];

    while (startDate <= endDate) {
        formattedDates.push(formatDate(startDate.toISOString().split("T")[0]));
        startDate.setDate(startDate.getDate() + 1);
    }

    return formattedDates;
}

// For Custom Pass

let currentDate = new Date();
let selectedDates = new Set();
var selectcustomdays = 0;
var custompasstype = "no";
var savedata = null;
var customsavedata=null
var applySelectiondata = null;
function generateCalendar(month, year) {
   
    insertCalenderHTML();

    const calendarDaysWrapper = document.querySelector(
        ".calendar-days-wrapper-new"
    );
    const currentMonthYear = document.querySelector(".current-month-year-new");
    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    currentMonthYear.textContent = `${getMonthName(month)} ${year}`;
    calendarDaysWrapper.innerHTML = "";
    for (let i = 0; i < firstDayOfMonth; i++) {
        const emptyDay = document.createElement("div");
        emptyDay.classList.add("empty-day");
        calendarDaysWrapper.appendChild(emptyDay);
    }

   
        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.classList.add("calendar-day");
            dayDiv.textContent = day;
            const formattedMonth = month + 1 < 10 ? "0" + (month + 1) : month + 1;
            const formattedDay = day < 10 ? "0" + day : day;
            const dayString = `${year}-${formattedMonth}-${formattedDay}`;
            dayDiv.setAttribute("data-date", dayString);
            let allDates=generateDateRange(ticketvalue.slots)
            const isAvailable = checkAvailability(dayString,allDates);
            if (isAvailable) {
                dayDiv.classList.add("available-date");
            } 
            else {
                dayDiv.classList.add("disabled-date");
            }
            dayDiv.addEventListener("mouseenter", function () {
                handleIndividualDateHover(dayString, true);
            });
            dayDiv.addEventListener("mouseleave", function () {
                handleIndividualDateHover(dayString, false);
            });
            dayDiv.addEventListener("click", function () {
                handleDateSelection(dayDiv, dayString);
            });
            calendarDaysWrapper.appendChild(dayDiv);
        }
   
    restoreSelectedDates();
}

function insertCalenderHTML() {
    let asideWrapper = document.querySelector(".aside-pass-slots-wrapper");
    if (asideWrapper.classList.contains("hidden")) {
        asideWrapper.classList.remove("hidden");
    }

    let calenderhtml = `
     <div class="calender-area mt-2">
                                                  <div class="">
                                                      <div class="calendar-container-new">
                                                          <div class="calendar-inner-container-new block">
                                                              <div class="container-new ">
                                                                  <div class="custom-calendar-new">
                                                                      <header class="calendar-header-new">
                                                                          <button class="left" type="button"
                                                                              onclick="handlechangeMonth(-1)">
                                                                              <svg xmlns="http://www.w3.org/2000/svg"
                                                                                  height="24px" viewBox="0 -960 960 960"
                                                                                  width="24px" fill="#5f6368">
                                                                                  <path
                                                                                      d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z">
                                                                                  </path>
                                                                              </svg>
                                                                          </button>
                                                                          <div class="header-display">
                                                                              <p class="current-month-year-new">January
                                                                                  2025</p>
                                                                          </div>
                                                                          <button class="right" type="button"
                                                                              onclick="handlechangeMonth(1)">
                                                                              <svg xmlns="http://www.w3.org/2000/svg"
                                                                                  height="24px" viewBox="0 -960 960 960"
                                                                                  width="24px" fill="#5f6368">
                                                                                  <path
                                                                                      d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z">
                                                                                  </path>
                                                                              </svg>
                                                                          </button>
                                                                      </header>
                                                                      <div class="calendar-week-wrapper-new">
                                                                          <div>Su</div>
                                                                          <div>Mo</div>
                                                                          <div>Tu</div>
                                                                          <div>We</div>
                                                                          <div>Th</div>
                                                                          <div>Fr</div>
                                                                          <div>Sa</div>
                                                                      </div>
                                                                      <div class="calendar-days-wrapper-new"></div>
                                                                  </div>
                                                                  <div class="display-selected"></div>
                                                                  <div class="calendar-error-wrapper">
                                                                      <p class="error-message transition text-red-500">
                                                                      </p>
                                                                  </div>
                                                              </div>
                                                              <aside class="aside-time-slots-wrapper-new">
                                                              </aside>
                                                          </div>
                                                          
                                                      </div>
                                                  </div>
                                              </div>
      `;
    let timebase = document.querySelector(".time-pass-wrapper");
    timebase.innerHTML = "";
    timebase.insertAdjacentHTML("beforeend", calenderhtml);
}

function getMonthName(monthIndex) {
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    return months[monthIndex];
}

// function checkAvailability(dayString) {
//     const dayDate = new Date(dayString);
//     dayDate.setHours(0, 0, 0, 0);
//     console.log(dayString)
    
//     for (const slot of ticketvalue.slots) {
//         const startDate = new Date(slot.start_date);
//         const endDate = new Date(slot.end_date);
//         startDate.setHours(0, 0, 0, 0);
//         endDate.setHours(0, 0, 0, 0);
//         if (dayDate >= startDate && dayDate <= endDate) {
//             return slot.paid_tickets > 0;
//         }
//     }
//     return false;
// }
function checkAvailability(dayString, allDates) {
    return allDates.includes(dayString);
}

function generateDateRange(slots) {
    let allDates = [];

    slots.forEach(({ start_date, end_date }) => {
        let currentDate = new Date(start_date);
        let lastDate = new Date(end_date);

        while (currentDate <= lastDate) {
            const formattedDate = currentDate.toISOString().split("T")[0];
            allDates.push(formattedDate);
            currentDate.setDate(currentDate.getDate() + 1);
        }
    });

    return allDates;
}

function handleIndividualDateHover(hoveredDate, isHovered = true) {
    const selectedDate = document.querySelector(
        `div[data-date="${hoveredDate}"]`
    );
    if (selectedDate) {
        if (isHovered) {
            selectedDate.classList.add("highlighted-date");
        } else {
            selectedDate.classList.remove("highlighted-date");
        }
    }
}

function handleDateSelection(dayDiv, dayString) {
let customselectedSlot=null
customsavedata=null
    let avilable_day=handleCountDays(ticketvalue.slots,dayString)
    console.log(avilable_day,selectcustomdays)
    if(avilable_day>=selectcustomdays){
        clearSelection();
        const allDateElements = document.querySelectorAll(".calendar-day");
        allDateElements.forEach((day) => day.classList.remove("active-date"));
        dayDiv.classList.add("active-date");
        selectNextAvailableDates();
        // const selectedDate = new Date(dayString);
        // const normalizedSelectedDate = new Date(selectedDate.setHours(0, 0, 0, 0));
        savedata = getSelectedSlotForDate();
        generateTimeSlotCustom(dayString, savedata.time[0]);
        // if (customselectedSlot) {
            // console.log("Found matching slot:", applySelectiondata);
            // customselectedSlot.start_date = applySelectiondata[0];
            // customselectedSlot.end_date =
            // applySelectiondata[applySelectiondata.length - 1];
            // = customselectedSlot;
            // generateTimeSlotCustom(dayString, selectedSlot.time[0]);
        // } else {
        //     console.log("No matching slot found for this date.");
        // }
    }
    else{
     alert(`avilable days are less then ${selectcustomdays}`);
    }
    
    
    
    
}


function handleCountDays(dateRanges, fromDate) {
    const from = new Date(fromDate);
    let totalDays = 0;

    dateRanges.forEach(({ start_date, end_date }) => {
        const startDate = new Date(start_date);
        const endDate = new Date(end_date);

        if (from <= endDate) { 
            const effectiveStart = from > startDate ? from : startDate; 
            const differenceInDays = Math.ceil((endDate - effectiveStart) / (1000 * 60 * 60 * 24)) + 1;
            totalDays += differenceInDays;
        }
    });
    return totalDays;
}




function clearSelection() {
    selectedDates.clear();
    document
        .querySelectorAll(".calendar-day")
        .forEach((day) => day.classList.remove("active-date"));
}

function selectNextAvailableDates() {
    const allDateElements = Array.from(
        document.querySelectorAll(".calendar-day")
    );
    const availableDates = allDateElements.filter(
        (day) => !day.classList.contains("disabled-date")
    );
    const selectedIndex = availableDates.findIndex((day) =>
        day.classList.contains("active-date")
    );
    if (selectedIndex === -1) {
        console.log("No active date selected.");
        return;
    }
    let nextDates = availableDates.slice(
        selectedIndex,
        selectedIndex + selectcustomdays
    );
    nextDates.forEach((day) =>
        selectedDates.add(day.getAttribute("data-date"))
    );
    if (nextDates.length < selectcustomdays) {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendar(currentDate.getMonth(), currentDate.getFullYear());
        setTimeout(() => {
            const newMonthElements = Array.from(
                document.querySelectorAll(".calendar-day")
            );
            const newAvailableDates = newMonthElements.filter(
                (day) => !day.classList.contains("disabled-date")
            );
            const remainingSlots = selectcustomdays - nextDates.length;
            const additionalDates = newAvailableDates.slice(0, remainingSlots);
            additionalDates.forEach((day) =>
                selectedDates.add(day.getAttribute("data-date"))
            );
            applySelection();
        }, 500);
    } else {
        applySelection();
    }
}

function applySelection() {
    document.querySelectorAll(".calendar-day").forEach((day) => {
        const date = day.getAttribute("data-date");
        if (selectedDates.has(date)) {
            day.classList.add("active-date");
        } else {
            day.classList.remove("active-date");
        }
    });
    applySelectiondata = [...selectedDates];
    console.log("Selected Dates:", [...selectedDates]);
}

function restoreSelectedDates() {
    document.querySelectorAll(".calendar-day").forEach((day) => {
        const date = day.getAttribute("data-date");
        if (selectedDates.has(date)) {
            day.classList.add("active-date");
        }
    });
}

function getSelectedSlotForDate() {
    let data=ticketvalue.slots[0]
    
    
    
    
  let modifieddata=  {
        "time": data.time,
        "end_date": applySelectiondata[applySelectiondata.length - 1],
        "packages": data.packages,
        "start_date":applySelectiondata[0],
        "free_tickets": data.free_tickets,
        "paid_tickets": data.paid_tickets,
        "total_tickets":data.total_tickets,
        "donated_tickets": data.donated_tickets
    }
    
    // for (const slot of ticketvalue.slots) {
    //     const normalizedStartDate = new Date(
    //         new Date(slot.start_date).setHours(0, 0, 0, 0)
    //     );
    //     const normalizedEndDate = new Date(
    //         new Date(slot.end_date).setHours(0, 0, 0, 0)
    //     );
    //     if (
    //         normalizedSelectedDate >= normalizedStartDate &&
    //         normalizedSelectedDate <= normalizedEndDate
    //     ) {
    //         return slot;
    //     }
    // }
    return modifieddata;
}

function generateTimeSlotCustom(day, time) {
    const formattedDate = formatDate(day);
    let a = document.querySelector(".time-base-item-date-new");
    a = innerText = formattedDate;
    const timeButton = document.querySelector(".time-base-item-btn-new");

    if (timeButton) {
        timeButton.setAttribute("data-date", day);
        timeButton.setAttribute("data-start_time", time.start_time);
        timeButton.setAttribute("data-end_time", time.end_time);
        timeButton.innerText = `${time.start_time} - ${time.end_time}`;
        console.log("Updated time slot:", {
            date: day,
            start_time: time.start_time,
            end_time: time.end_time,
        });
    } else {
        console.error("Time slot button not found!");
    }
}
function formatDate(dateString) {
    const [year, month, day] = dateString.split("-").map(Number);
    const date = new Date(year, month - 1, day);

    return date.toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

function handlechangeMonth(direction) {
    currentDate.setMonth(currentDate.getMonth() + direction);
    generateCalendar(currentDate.getMonth(), currentDate.getFullYear());
}

function handleChangeTab(element,t){
if (element === "pass") {
    document.querySelector('.custom-ticket-tab').style.display = "none";
    document.querySelector('.custom-pass-tab').style.display = "flex";
    document.querySelector('.custom-tab-button-pass').classList.add('bg-white')
    document.querySelector('.custom-tab-button-pass').classList.remove('text-white')
    document.querySelector('.custom-tab-button-ticket').classList.remove('bg-white')
    document.querySelector('.custom-tab-button-ticket').classList.add('text-white')
} else {
    document.querySelector('.custom-ticket-tab').style.display = "flex";
    document.querySelector('.custom-pass-tab').style.display = "none";
       document.querySelector('.custom-tab-button-pass').classList.remove('bg-white')
       document.querySelector('.custom-tab-button-pass').classList.add('text-white')
    document.querySelector('.custom-tab-button-ticket').classList.add('bg-white')
    document.querySelector('.custom-tab-button-ticket').classList.remove('text-white')
}
    element.style="display:block"
}

