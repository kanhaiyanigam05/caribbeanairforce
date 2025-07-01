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
        this.slotsData = {};
        this.slotsData.subTotal = 0;
        this.slotsData.donationAmount = 0;
        this.slotsData.grandTotal = 0;
        this.slotsData.totalPackages = 0;
        this.slotsData.totalDates = 0;
        this.slotsData.selectedSlots = [];
        this.slotsData.amenitiesTotal = 0;
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

        console.log(this.slotsData);

        // 🔥 Listen for seat selection events
        this.setupSeatSelectionListener();
    }

    setupTiersColorPreview() {
        console.log(this.data.dataset)
        const isReserved = this.data.dataset.reserved;
        const seatingPlanColorPackages = document.querySelectorAll(".seating-plan-color-packages");
        if(isReserved) {
            if(seatingPlanColorPackages.classList.contains("hidden")) {
                seatingPlanColorPackages.classList.remove("hidden");
            }
            const seatingPlanLayout = typeof this.data.dataSet.seating_plan === "string"
                ? JSON.parse(this.data.dataSet.seating_plan)
                : this.data.dataSet.seating_plan;
            console.log(seatingPlanLayout);
        }
        else {
            if(!seatingPlanColorPackages.classList.contains("hidden")) {
                seatingPlanColorPackages.classList.add("hidden");
            }
        }
    }

    // 🔥 Add this new method to listen for seat selection events
    setupSeatSelectionListener() {
        // Wait for seatingPlanLoader to be initialized
        const checkForSeatingPlan = () => {
            if (this.seatingPlanLoader && this.seatingPlanLoader.container) {
                this.seatingPlanLoader.container.addEventListener('seatSelectionChanged', (event) => {
                    this.handleSeatSelectionChange(event.detail);
                });
            } else {
                // Check again after a short delay
                setTimeout(checkForSeatingPlan, 100);
            }
        };

        checkForSeatingPlan();
    }


    // 🔥 Add this method to handle seat selection changes
    handleSeatSelectionChange(eventData) {
        console.log('Seat selection changed:', eventData);
        console.log(this.slotsData, 'this.slotsData', this.data);

        // Update subtotal and other calculations
        this.updateSeatingPlanCalculations();

        // Update UI elements
        this.updateSubtotalDisplay();

        // Any other tasks you want to perform when seats are selected
        this.onSeatSelectionChanged(eventData);
    }

    // 🔥 Add this method for additional custom logic
    onSeatSelectionChanged(eventData) {
        // Custom logic when seats are selected/deselected
        console.log(`Seats changed for date: ${eventData.activeDate}`);
        console.log(`Selected seats count: ${eventData.selectedSeats.length}`);
        console.log(this.slotsData);

        const amenitiesSelectedPkgWrapper = document.querySelector(".amenities-selected-pkg-wrapper");

        amenitiesSelectedPkgWrapper.innerHTML = "";
        this.slotsData.selectedSlots.forEach((pkg) => {
            const wrapper = document.createElement("div");
            wrapper.classList.add(
                "max-w-md",
                "border",
                "rounded",
                "items-center",
                "rounded",
                "text-sm",
                "pkg-wrapper"
            );
            wrapper.style = "border:1px solid #A3A3A3;";
            let amenitiesHtml = ``;
            pkg.amenities?.forEach((item) => {
                const selectedAmnt = pkg.selectedAmenities.find(a => a.id === item.id);
                amenitiesHtml += `
                    <div class="divide-y amenity-package" data-amenity="${item.id}">
                        <div class="flex items-center justify-between px-4 py-1">
                            <div class="flex items-center space-x-4 gap-3">
                                <div style="background-color: #b9b7b7;padding: 5px 5px;align-items: center;border-radius: 5px;" class="flex">
                                    <img src="${window.location.origin}/uploads/amenities/${item.image}" alt="" style="width: 25px" />
                                </div>
                                <div>
                                    <p style="color:#585858;font-size: 12px;font-weight: 600;">${item.name}</p>
                                    <p style="color:#585858;font-size: 12px;font-weight: 500;">${item.price === 0 ? 'Free' : '$' + item.price}</p>
                                </div>
                            </div>
                            <div class="amenities-qty-wrapper">
                                <div class="${selectedAmnt ? '' : 'hidden'} items-center rounded overflow-hidden fooditem">
                                    <button class="amnt-qty-decrement" type="button" style="border-radius: 2.286px;background-color: #E6E6E6;padding: 3.429px 8px;font-size: 19px;font-weight: 600;" >−</button>
                                    <input style="font-weight: 600;font-size: 16px;width: 30px;" class="py-1 text-center amnt-qty" type="text" value="${selectedAmnt ? selectedAmnt.selectedQty : 0}" disabled="">
                                    <button class="amnt-qty-increment" type="button" style="border-radius: 2.286px;background-color: #2E9157;padding: 3.429px 8px;font-size: 19px;font-weight: 600;color: #fff;" >+</button>
                                </div>
                                <button class="add-amnt ${selectedAmnt ? 'hidden' : ''} " type="button" style="border-radius: 20px;background-color: #8f8e8e;padding: 3px 14px;font-size: 12px;font-weight: 600;color: #fff;">Add</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            const wrapperPaidHtml = `
                <div class="flex justify-between items-center px-3 py-4 border-b" style="border-color: #A3A3A3;gap: 5rem;position:relative;"  >
                    <div>
                        <h2 style="color:#BD191F;font-weight:600;font-size: 20px;">${pkg.packageName} </h2>
                        <p style="color:#6E6E6E; font-weight: 600; font-size: 14px;">$${pkg.price}</p>
                    </div>
                    <div class="flex items-center rounded overflow-hidden qty-wrapper" style="font-size: 40px; line-height: 40px;">${pkg.selectedQty}</div>
                </div>
                <div class="selected-package-amenities">
                    ${amenitiesHtml}
                </div>
            `;
            const wrapperPaidHtmlold = `
                <div class="border-r">
                    <div class="p-2">
                    <button class="flex justify-between select-none items-center w-full transition-all duration-150 ease-in active:scale-95 hover:text-primary selected-pkg-item" type="button" title="Remove Package">
                        <span class="pkg-name">${pkg.packageName} praddep</span>
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
                amenitiesSelectedPkgWrapper.appendChild(wrapper);
            } else {
                if (pkg.type === "donated") {
                    wrapper.innerHTML = wrapperDonatedHtml;
                    amenitiesSelectedPkgWrapper.appendChild(wrapper);
                } else if (pkg.type === "free") {
                    wrapper.innerHTML = wrapperFreeHtml;
                    amenitiesSelectedPkgWrapper.appendChild(wrapper);
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
                            this.updateSubTotal();
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

                        this.updateSubTotal();
                    });
                });
            }
            // Store unique handlers per element
            const incrementHandlers = new WeakMap();
            const decrementHandlers = new WeakMap();

            const handleAmenityQtyChange = (wrapper) => {
                const inputWrapper = wrapper.querySelectorAll(".amenities-qty-wrapper");

                inputWrapper.forEach(item => {
                    const input = item.querySelector(".amnt-qty");
                    const qtyDecrement = item.querySelector(".amnt-qty-decrement");
                    const qtyIncrement = item.querySelector(".amnt-qty-increment");
                    const addAmnt = item.querySelector(".add-amnt");

                    const amenityPkgId = item.closest(".amenity-package").dataset.amenity;
                    const amenityPkg = pkg.amenities?.find(item =>
                        item.id.toString() === amenityPkgId.toString()
                    );

                    // Create and store unique event handlers
                    let incrementQty = incrementHandlers.get(item);
                    let decrementQty = decrementHandlers.get(item);

                    if (!incrementQty) {
                        incrementQty = () => {
                            const currentValue = parseInt(input.value);
                            input.value = currentValue + 1;

                            const exists = pkg.selectedAmenities.find(a => a.id === amenityPkg.id);
                            if (!exists) {
                                addAmnt?.classList.add("hidden");
                                item.querySelector(".fooditem")?.classList.remove("hidden");
                                amenityPkg.selectedQty = Number(input.value);
                                pkg.selectedAmenities.push(amenityPkg);
                            } else {
                                exists.selectedQty = Number(input.value);
                            }

                            this.updateSeatPlanSubTotal();
                        };
                        incrementHandlers.set(item, incrementQty);
                    }

                    if (!decrementQty) {
                        decrementQty = () => {
                            const currentValue = parseInt(input.value);
                            if (currentValue > 1) {
                                input.value = currentValue - 1;
                                const exists = pkg.selectedAmenities.find(a => a.id === amenityPkg.id);
                                if (exists) exists.selectedQty = Number(input.value);
                            } else {
                                input.value = currentValue - 1;
                                addAmnt?.classList.remove("hidden");
                                item.querySelector(".fooditem")?.classList.add("hidden");
                                pkg.selectedAmenities = pkg.selectedAmenities.filter(a => a.id !== amenityPkg.id);
                            }

                            this.updateSeatPlanSubTotal();
                        };
                        decrementHandlers.set(item, decrementQty);
                    }

                    // Ensure listeners are attached only once
                    qtyIncrement.removeEventListener("click", incrementQty);
                    qtyIncrement.addEventListener("click", incrementQty);

                    qtyDecrement.removeEventListener("click", decrementQty);
                    qtyDecrement.addEventListener("click", decrementQty);

                    if (addAmnt) {
                        addAmnt.removeEventListener("click", incrementQty);
                        addAmnt.addEventListener("click", incrementQty);
                    }
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
                    this.updateSeatPlanSubTotal();

                    input.addEventListener("input", () => {
                        input.value = Number(input.value) || 0;
                        pkg.donateAmount = Number(input.value) || 0;
                        this.updateSeatPlanSubTotal();
                    });

                    input.addEventListener("keydown", (event) => {
                        if (event.key === "ArrowUp") {
                            event.preventDefault();
                            input.value = Number(parseInt(input.value || "0", 10) + 1) || 0;;
                            pkg.donateAmount = Number(input.value) || 0;
                            this.updateSeatPlanSubTotal();
                        }
                        else if (event.key === "ArrowDown") {
                            event.preventDefault();
                            let newValue = parseInt(input.value || "0", 10) - 1;
                            input.value = newValue < 0 ? "0" : Number(newValue) || 0;
                            pkg.donateAmount = Number(input.value) || 0;
                            this.updateSeatPlanSubTotal();
                        }
                    });

                    input.addEventListener("paste", (event) => {
                        event.preventDefault();
                        let pastedText = (event.clipboardData || window.clipboardData).getData("text");
                        input.value = Number(pastedText) || 0;
                        pkg.donateAmount = Number(input.value) || 0;
                        this.updateSeatPlanSubTotal();
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
                            this.updateSeatPlanSubTotal();
                            break;
                        }
                    }
                })
            }



            // handleQtyChange(wrapper);
            handleAmenityQtyChange(wrapper);
            donateNumberOnly();
            // handleRemovePackage();

            // Handle hover effects for the package item
            amenitiesSelectedPkgWrapper.addEventListener("mouseover", (event) => {
                const isSelectedPkgWrapper =
                    event.target.closest(".pkg-wrapper");

                if (isSelectedPkgWrapper) {
                    // isSelectedPkgWrapper.classList.add("bg-gray-200");
                }
            });

            amenitiesSelectedPkgWrapper.addEventListener("mouseout", (event) => {
                const isSelectedPkgWrapper =
                    event.target.closest(".pkg-wrapper");

                if (isSelectedPkgWrapper) {
                    // isSelectedPkgWrapper.classList.remove("bg-gray-200");
                }
            });
        });
    }

    // 🔥 Add this method to update calculations based on seat selection
    updateSeatingPlanCalculations() {
        if (this.data.dataSet && this.data.dataSet.reserved) {
            this.getSeatingPlanSeatSlots();
        }
    }

    // 🔥 Add this method to update subtotal display
    updateSubtotalDisplay() {
        const subTotalElements = document.querySelectorAll('.subtotal-display');
        subTotalElements.forEach(element => {
            element.textContent = `$${this.slotsData.subTotal.toFixed(2)}`;
        });
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
    /*getSeatingPlanSeatSlots() {
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
                        console.log(matchingPackage);

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
                                        amenities: matchingPackage.amenities,
                                        selectedAmenities: [],

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
                                        amenities: matchingPackage.amenities,
                                        selectedAmenities: [],
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

    }*/
    getSeatingPlanSeatSlots() {
        const seatingPlanLayout = typeof this.data.dataSet.seating_plan === "string"
            ? JSON.parse(this.data.dataSet.seating_plan)
            : this.data.dataSet.seating_plan;

        const affectedSlotMap = {}; // Newly computed affected slots

        this.seatingPlanLoader.data.forEach(item => {
            const seatCountByPackage = {};

            item.seats.forEach(id => {
                const seat = this.seatingPlanLoader.stage.findOne(`#${id}`);
                if (!seat) return;

                const tierId = seat.getAttr("metadata")?.tierId;
                const tier = seatingPlanLayout.tiers[tierId];
                if (!tier) return;

                const matchingPackage = item.packages.find(pkg => {
                    return (pkg.type === "donated" || pkg.type === "free")
                        ? pkg.type === tier.type
                        : pkg.type === "paid" && pkg.name === tier.name;
                });

                if (!matchingPackage) return;

                const slotKey = `${item.dateString}_${matchingPackage.name}_${matchingPackage.type}`;

                if (!seatCountByPackage[slotKey]) {
                    seatCountByPackage[slotKey] = {
                        dateString: item.dateString,
                        date: item.date,
                        start_date: item.start_date,
                        end_date: item.end_date,
                        packageName: matchingPackage.name,
                        price: matchingPackage.price,
                        maxQty: matchingPackage.qty,
                        selectedQty: 0,
                        type: matchingPackage.type,
                        seats: [],
                        amenities: matchingPackage.amenities,
                        selectedAmenities: [],
                    };
                }

                seatCountByPackage[slotKey].selectedQty += 1;
                seatCountByPackage[slotKey].seats.push(id);
            });

            Object.entries(seatCountByPackage).forEach(([key, slot]) => {
                if (slot.selectedQty > 0) {
                    affectedSlotMap[key] = slot;
                }
            });
        });

        // Preserve existing slots
        const currentSlots = this.slotsData.selectedSlots || [];
        const updatedSlotsMap = {};

        // Index current slots by key for quick lookup
        currentSlots.forEach(slot => {
            const key = `${slot.dateString}_${slot.packageName}_${slot.type}`;
            updatedSlotsMap[key] = slot;
        });

        // Apply updates from affectedSlotMap
        Object.entries(affectedSlotMap).forEach(([key, newSlot]) => {
            if (updatedSlotsMap[key]) {
                // Update existing slot
                updatedSlotsMap[key].selectedQty = newSlot.selectedQty;
                updatedSlotsMap[key].seats = newSlot.seats;
                updatedSlotsMap[key].price = newSlot.price;
                updatedSlotsMap[key].maxQty = newSlot.maxQty;
            } else {
                // Add new slot
                updatedSlotsMap[key] = newSlot;
            }
        });

        // Remove any slot that is no longer in the affected slots
        Object.keys(updatedSlotsMap).forEach(key => {
            if (!affectedSlotMap[key]) {
                delete updatedSlotsMap[key];
            }
        });

        // Reassign only changed list
        this.slotsData.selectedSlots = Object.values(updatedSlotsMap);

        // Update totals
        this.updateSeatPlanSubTotal();
    }

    updateSeatPlanSubTotal() {
        this.slotsData.subTotal = 0;
        this.slotsData.grandTotal = 0;
        this.slotsData.amenityTotal = 0;

        (this.slotsData.selectedSlots || []).forEach((item) => {
            if (!item || item.type !== 'paid') return;
            const price = Number(item.price) || 0;
            const qty = Number(item.selectedQty) || 0;
            const itemSubTotal = price * qty;

            this.slotsData.subTotal += itemSubTotal;
            this.slotsData.grandTotal += itemSubTotal;

            if(item.selectedAmenities && item.selectedAmenities.length > 0) {
                item.selectedAmenities.forEach(amenity => {
                    this.slotsData.amenityTotal += amenity.price * amenity.selectedQty;
                });
            }
        });
        const seatingPlanSubtotal = document.querySelector(".seating-plan-subtotal");
        seatingPlanSubtotal.textContent = `$${this.slotsData.subTotal.toFixed(2)}${this.slotsData.amenityTotal > 0 ? ' + $' + this.slotsData.amenityTotal.toFixed(2) : ''}`;
        console.log("this.slotsData.subTotal", `$${this.slotsData.subTotal.toFixed(2)}`);
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
                    const seatingPlans = typeof this.data.dataSet.seating_plan === "string"
                        ? JSON.parse(this.data.dataSet.seating_plan)
                        : this.data.dataSet.seating_plan;
                    const tiers = seatingPlans.tiers;
                    console.log(tiers, 'tiers');
                    const seatingPlanColorPackages = document.querySelector(".seating-plan-color-packages");
                    seatingPlanColorPackages.innerHTML = "";

                    if (tiers && typeof tiers === 'object') {
                        let tiersHTML = "";

                        // Use for...in if tiers is an object
                        for (const key in tiers) {
                            if (tiers.hasOwnProperty(key)) {
                                const tier = tiers[key];
                                tiersHTML += `
                                    <div class="flex gap-3" style="align-items: center;">
                                        <div style="height:15px;width:15px;background: ${tier.color};"></div>
                                        <span style="font-size: 14px;font-weight: 600;">${tier.name}</span>
                                    </div>
                                `;
                            }
                        }

                        seatingPlanColorPackages.innerHTML = tiersHTML;
                    }
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
                this.updateSubTotal();
            });
        };

        generateAddPkgItems();
    }



    generateSelectdPackageData(dateString, pkgName, pkgData) {
        console.log('clicked')
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
                                    amenities: pkg.amenities,
                                    selectedAmenities: [],
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
                                    amenities: pkg.amenities,
                                    selectedAmenities: [],
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

        this.generateSelectedPackageHtml(); // Update the displayed packages
    }

    generateSelectedPackageHtml() {
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
                "max-w-md",
                "border",
                "rounded",
                "items-center",
                "rounded",
                "text-sm",
                "pkg-wrapper"
            );
            wrapper.style = "border:1px solid #A3A3A3;";
            let amenitiesHtml = ``;
            pkg.amenities?.forEach((item) => {
                amenitiesHtml += `
                    <div class="divide-y amenity-package" data-amenity="${item.id}">
                        <div class="flex items-center justify-between px-4 py-1">
                            <div class="flex items-center space-x-4 gap-3">
                                <div style="background-color: #b9b7b7;padding: 5px 5px;align-items: center;border-radius: 5px;" class="flex">
                                    <img src="${window.location.origin}/uploads/amenities/${item.image}" alt="" style="width: 25px" />
                                </div>
                                <div>
                                    <p style="color:#585858;font-size: 12px;font-weight: 600;">${item.name}</p>
                                    <p style="color:#585858;font-size: 12px;font-weight: 500;">${item.price === 0 ? 'Free' : '$' + item.price}</p>
                                </div>
                            </div>
                            <div class="amenities-qty-wrapper">
                                <div class="hidden items-center rounded overflow-hidden fooditem">
                                    <button class="amnt-qty-decrement" type="button" style="border-radius: 2.286px;background-color: #E6E6E6;padding: 3.429px 8px;font-size: 19px;font-weight: 600;" >−</button>
                                    <input style="font-weight: 600;font-size: 16px;width: 30px;" class="py-1 text-center amnt-qty" type="text" value="0" disabled="">
                                    <button class="amnt-qty-increment" type="button" style="border-radius: 2.286px;background-color: #2E9157;padding: 3.429px 8px;font-size: 19px;font-weight: 600;color: #fff;" >+</button>
                                </div>
                                <button class="add-amnt" type="button" style="border-radius: 20px;background-color: #8f8e8e;padding: 3px 14px;font-size: 12px;font-weight: 600;color: #fff;">Add</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            const wrapperPaidHtml = `
                <div class="flex justify-between items-center px-3 py-4 border-b" style="border-color: #A3A3A3;gap: 5rem;position:relative;"  >
                    <div>
                        <h2 style="color:#BD191F;font-weight:600;font-size: 20px;">${pkg.packageName} </h2>
                        <p style="color:#6E6E6E;font-size:12px;font-weight: 600;font-size: 14px;">$${pkg.price}</p>
                    </div>
                    <div class="flex items-center  rounded overflow-hidden qty-wrapper">
                        <button type="button" class="px-3 py-1 text-lg font-semibold qty-decrement" style="background-color: #E6E6E6;font-size: 25px;">−</button>
                        <input style="font-weight: 600;font-size: 16px;width: 57px;" class="py-1 text-center pkg-qty" type="text" value="${pkg.selectedQty}" disabled="">
                        <button type="button" class="px-3 py-1 text-lg font-semibold qty-increment" style="background-color: #BD191F; font-size: 25px;color: #fff;">+</button>
                    </div>
                    <button style='position:absolute;right: -9px;text-align: end;width: fit-content;display: flex;justify-content: end;top: -5px;border: 1px solid black;background-color: #fff;padding: 2px 6px;border-radius: 50%;' class="flex justify-between select-none items-center w-full transition-all duration-150 ease-in active:scale-95 hover:text-primary selected-pkg-item" type="button" title="Remove Package">
                        <i class="fa-solid fa-x text-xs"></i>
                    </button>
                </div>
                <div class="selected-package-amenities">
                    ${amenitiesHtml}
                </div>
            `;
            const wrapperPaidHtmlold = `
                <div class="border-r">
                    <div class="p-2">
                    <button class="flex justify-between select-none items-center w-full transition-all duration-150 ease-in active:scale-95 hover:text-primary selected-pkg-item" type="button" title="Remove Package">
                        <span class="pkg-name">${pkg.packageName} praddep</span>
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
                            this.updateSubTotal();
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

                        this.updateSubTotal();
                    });
                });
            }
            // Store unique handlers per element
            const incrementHandlers = new WeakMap();
            const decrementHandlers = new WeakMap();

            const handleAmenityQtyChange = (wrapper) => {
                const inputWrapper = wrapper.querySelectorAll(".amenities-qty-wrapper");

                inputWrapper.forEach(item => {
                    const input = item.querySelector(".amnt-qty");
                    const qtyDecrement = item.querySelector(".amnt-qty-decrement");
                    const qtyIncrement = item.querySelector(".amnt-qty-increment");
                    const addAmnt = item.querySelector(".add-amnt");

                    const amenityPkgId = item.closest(".amenity-package").dataset.amenity;
                    const amenityPkg = pkg.amenities?.find(item =>
                        item.id.toString() === amenityPkgId.toString()
                    );

                    // Create and store unique event handlers
                    let incrementQty = incrementHandlers.get(item);
                    let decrementQty = decrementHandlers.get(item);

                    if (!incrementQty) {
                        incrementQty = () => {
                            const currentValue = parseInt(input.value);
                            input.value = currentValue + 1;

                            const exists = pkg.selectedAmenities.find(a => a.id === amenityPkg.id);
                            if (!exists) {
                                addAmnt?.classList.add("hidden");
                                item.querySelector(".fooditem")?.classList.remove("hidden");
                                amenityPkg.selectedQty = Number(input.value);
                                pkg.selectedAmenities.push(amenityPkg);
                            } else {
                                exists.selectedQty = Number(input.value);
                            }

                            this.updateSubTotal();
                        };
                        incrementHandlers.set(item, incrementQty);
                    }

                    if (!decrementQty) {
                        decrementQty = () => {
                            const currentValue = parseInt(input.value);
                            if (currentValue > 1) {
                                input.value = currentValue - 1;
                                const exists = pkg.selectedAmenities.find(a => a.id === amenityPkg.id);
                                if (exists) exists.selectedQty = Number(input.value);
                            } else {
                                input.value = currentValue - 1;
                                addAmnt?.classList.remove("hidden");
                                item.querySelector(".fooditem")?.classList.add("hidden");
                                pkg.selectedAmenities = pkg.selectedAmenities.filter(a => a.id !== amenityPkg.id);
                            }

                            this.updateSubTotal();
                        };
                        decrementHandlers.set(item, decrementQty);
                    }

                    // Ensure listeners are attached only once
                    qtyIncrement.removeEventListener("click", incrementQty);
                    qtyIncrement.addEventListener("click", incrementQty);

                    qtyDecrement.removeEventListener("click", decrementQty);
                    qtyDecrement.addEventListener("click", decrementQty);

                    if (addAmnt) {
                        addAmnt.removeEventListener("click", incrementQty);
                        addAmnt.addEventListener("click", incrementQty);
                    }
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
                    this.updateSubTotal();

                    input.addEventListener("input", () => {
                        input.value = Number(input.value) || 0;
                        pkg.donateAmount = Number(input.value) || 0;
                        this.updateSubTotal();
                    });

                    input.addEventListener("keydown", (event) => {
                        if (event.key === "ArrowUp") {
                            event.preventDefault();
                            input.value = Number(parseInt(input.value || "0", 10) + 1) || 0;;
                            pkg.donateAmount = Number(input.value) || 0;
                            this.updateSubTotal();
                        }
                        else if (event.key === "ArrowDown") {
                            event.preventDefault();
                            let newValue = parseInt(input.value || "0", 10) - 1;
                            input.value = newValue < 0 ? "0" : Number(newValue) || 0;
                            pkg.donateAmount = Number(input.value) || 0;
                            this.updateSubTotal();
                        }
                    });

                    input.addEventListener("paste", (event) => {
                        event.preventDefault();
                        let pastedText = (event.clipboardData || window.clipboardData).getData("text");
                        input.value = Number(pastedText) || 0;
                        pkg.donateAmount = Number(input.value) || 0;
                        this.updateSubTotal();
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
                            this.updateSubTotal();
                            break;
                        }
                    }
                })
            }



            handleQtyChange(wrapper);
            handleAmenityQtyChange(wrapper);
            donateNumberOnly();
            handleRemovePackage();

            // Handle hover effects for the package item
            selectedPkgWrapper.addEventListener("mouseover", (event) => {
                const isSelectedPkgWrapper =
                    event.target.closest(".pkg-wrapper");

                if (isSelectedPkgWrapper) {
                    // isSelectedPkgWrapper.classList.add("bg-gray-200");
                }
            });

            selectedPkgWrapper.addEventListener("mouseout", (event) => {
                const isSelectedPkgWrapper =
                    event.target.closest(".pkg-wrapper");

                if (isSelectedPkgWrapper) {
                    // isSelectedPkgWrapper.classList.remove("bg-gray-200");
                }
            });
        });

        // Optional: Update the subtotal whenever changes are made
        this.updateSubTotal();
    }

    updateSubTotal() {
        /*const subTotalElement = document.querySelector(".sub-total");
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

        // subTotalElement.textContent = `$${total.toFixed(2)}`;*/
        this.slotsData.subTotal = 0;
        this.slotsData.donationAmount = 0;
        this.slotsData.grandTotal = 0;
        this.slotsData.amenityTotal = 0;
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
            if(item.selectedAmenities && item.selectedAmenities.length > 0) {
                item.selectedAmenities.forEach(amenity => {
                    this.slotsData.amenityTotal += amenity.price * amenity.selectedQty;
                });
            }
        });
        console.log(this.slotsData);
        subTotalElement.textContent = `$${this.slotsData.subTotal.toFixed(2)}${this.slotsData.amenityTotal > 0 ? ' + $' + this.slotsData.amenityTotal.toFixed(2) : ''}`;
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




// New JS

/*function handleFoodItem(element) {
    // Get the parent container that has all the elements (the outermost div)
    const parent = element.parentElement;

    // Find the fooditem div inside this container
    const foodItemDiv = parent.querySelector('.fooditem');

    if (foodItemDiv) {
        // Remove 'hidden' and add 'flex'
        foodItemDiv.classList.remove('hidden');
        foodItemDiv.classList.add('flex');

        // Optionally hide the Add button itself
        element.style.display = 'none';
    }
}*/
