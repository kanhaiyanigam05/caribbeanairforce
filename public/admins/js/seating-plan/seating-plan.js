class SeatingPlan extends KonvaSeatingPlan {
    constructor({ container, width = 1000, height = 700, edit = false }) {
        super({ container, width, height });
        this.edit = edit;

        if (this.mainWrapper) {
            this.setupLayoutSelection();
            this.handleMultipleTiers();
            this.handleMultipleHolds();
            this.exportSeatingPLan();
            this.handleResetSeatingPlan();
        }
    }

    setupLayoutSelection() {

        const chooseLayoutWrapper = this.mainWrapper.querySelector(".reserved-layout-type");

        if (chooseLayoutWrapper) {
            const layoutBtns = chooseLayoutWrapper.querySelectorAll("button");
            layoutBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    this.data.type = btn.dataset.value;
                    this.init();

                });
            });
        }

        // for initializing table & chair call init method directly below
        this.init();
    }

    init() {

        const layoutsWrapper = this.mainWrapper.querySelector(".reserved-layout-options");
        const amenitiesWrapper = this.mainWrapper.querySelector(".stencil-wrapper");
        const layoutGenerateBtn = layoutsWrapper.querySelector('.show-seat-map-btn');
        layoutGenerateBtn.addEventListener('click', () => {

            this.getSeatingInputs(layoutsWrapper);
            this.getAmenities(amenitiesWrapper);
            if (this.data.type === 'table') {

                this.generateLayout({ tables: this.data.seatings.tables, seats: this.data.seatings.seats, totalSeats: this.data.seatings.tables * this.data.seatings.seats });
            }

            handleReservedNext(3);
        });
    }

    getSeatingInputs(wrapper) {
        this.data.seatings = {}; // reset

        const inputWrapper = wrapper.querySelector(`.${this.data.type}`);
        if (!inputWrapper) return;

        const inputs = inputWrapper.querySelectorAll(".seat-map--input");


        inputs.forEach(input => {
            const key = input.name || input.id || 'unknown';
            this.data.seatings[key] = input.value;
            input.addEventListener('input', e => this.data.seatings[key] = e.target.value);
        });

    }

    getAmenities(wrapper) {
        const checkboxes = wrapper.querySelectorAll('input[type="checkbox"][name="seating-amenities[]"]');

        const updateAmenities = () => {
            const selected = new Set();
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selected.add(cb.value);
                }
            });
            this.data.amenities = Array.from(selected);
        };

        // initial fetch
        updateAmenities();

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateAmenities);
        });
    }
    handleMultipleTiers() {
        const addTicketSidebar = document.querySelector("#tiers-item");

        // Create New Tier
        const createNewCategoryBtn = addTicketSidebar.querySelector(".create-new-tiers-btn.tier");

        if (this.edit === false) {
            // this.generateTierItem({ name: 'Free', qty: 0, color: '#ff0f00', seats: [], type: 'free' }, false);
            // this.generateTierItem({ name: 'Donated', qty: 0, color: '#00f0ff', seats: [], type: 'donated' }, false);
        }
        createNewCategoryBtn.addEventListener("click", () => {
            this.generateTierItem();
        });
    }
    generateTierItem(tierData = null, deleteBtn = true) {
        const mainWrapper = document.querySelector(".tiers-sidebar");

        const addTicketPaidItems = document.createElement("div");
        addTicketPaidItems.classList.add("add-ticket-paid-items");

        // Increment tier counter and generate tierId
        if (!this.data.tierCounter) this.data.tierCounter = 0;
        this.data.tierCounter++;

        const tierId = tierData?.id || `tier-${this.data.tierCounter}`;

        const defaultTierData = {
            name: `Tier ${this.data.tierCounter}`,
            qty: 0,
            color: this.getRandomHexColor(),
            seats: [],
            type: tierData?.type || 'paid',
        };

        const mergedTierData = {
            ...defaultTierData,
            ...tierData,
            element: addTicketPaidItems,
        };

        // Check if a tier with the same data already exists
        const existingTierId = Object.keys(this.data.tiers).find((id) => {
            const existingTier = this.data.tiers[id];
            return (
                existingTier.name === mergedTierData.name &&
                existingTier.qty === mergedTierData.qty &&
                existingTier.color === mergedTierData.color &&
                JSON.stringify(existingTier.seats) === JSON.stringify(mergedTierData.seats)
            );
        });

        if (existingTierId) {
            this.data.tiers[existingTierId] = {
                ...this.data.tiers[existingTierId],
                ...mergedTierData,
            };
        }

        // Add the new tier to the data
        this.data.tiers[tierId] = mergedTierData;

        const fields = [
            {
                label: "Name",
                name: "tier_name[]",
                id: `add-tier-name-${this.data.tierCounter}`,
                placeholder: "Tier 1",
                type: "text",
                value: mergedTierData.name,
                key: "name",
            },
            {
                label: "Available quantity",
                name: "tier_qty[]",
                id: `add-tier-quantity-${this.data.tierCounter}`,
                placeholder: "0",
                type: "text",
                events: {
                    oninput: "validateInteger(this, 0)",
                    onpaste: "validateInteger(this, 0)",
                },
                value: mergedTierData.qty,
                key: "qty",
            },
            {
                label: "Tier Color",
                name: "tier_color[]",
                id: `add-tier-color-${this.data.tierCounter}`,
                placeholder: "select color",
                value: mergedTierData.color,
                type: "color",
                key: "color",
            },
        ];

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

            const label = document.createElement("label");
            label.setAttribute("for", field.id);
            label.classList.add("transition", "border-box", "add-ticket-paid-label");
            label.textContent = field.label;
            wrapper.appendChild(label);

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
            input.value = field.value;

            if (field.key === "qty") input.readOnly = true;

            // Bind value to tier data
            mergedTierData[field.key] = input.value;

            input.addEventListener("input", () => {
                mergedTierData[field.key] = input.value;

                if (field.key === "color") {
                    mergedTierData.seats.forEach((seatId) => {
                        const seat = this.layer.findOne(`#${seatId}`);
                        if (seat) seat.fill(input.value);
                    });

                    this.updateSeatColors();
                    this.layer.draw();
                }
            });

            // Set inline events if needed
            if (field.events) {
                for (const event in field.events) {
                    input.setAttribute(event, field.events[event]);
                }
            }

            if (field.label === "Tier Color") {
                const inputWrapper = document.createElement("div");
                inputWrapper.classList.add("ticket-price-wrapper");
                inputWrapper.appendChild(input);
                wrapper.appendChild(inputWrapper);
            } else {
                wrapper.appendChild(input);
            }

            const errorText = document.createElement("p");
            errorText.classList.add("error-text", "border-box");
            wrapper.appendChild(errorText);

            addTicketPaidItems.appendChild(wrapper);
        });

        if (deleteBtn) {
            // Create delete button
            const deleteButtonWrapper = document.createElement("div");
            deleteButtonWrapper.classList.add(
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

            const deleteButton = document.createElement("button");
            deleteButton.classList.add("delete-category-btn", "transition");
            deleteButton.type = "button";
            deleteButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                <path d="M200-440v-80h560v80H200Z"/>
            </svg>
            Delete Tier
        `;

            deleteButton.addEventListener("click", (event) => {
                event.stopPropagation();
                mainWrapper.removeChild(addTicketPaidItems);
                delete this.data.tiers[tierId];
                this.updateSeatColors();
            });

            deleteButtonWrapper.appendChild(deleteButton);
            addTicketPaidItems.appendChild(deleteButtonWrapper);
        }

        // Append to wrapper
        mainWrapper.appendChild(addTicketPaidItems);

        // Trigger UI updates
        if (!tierData) {
            this.updateTierOverlays?.();
            this.updateSeatColors?.();
        }
    }

    getRandomHexColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    };
    handleMultipleHolds() {
        const addTicketSidebar = document.querySelector("#holds-item");

        // Create New hold
        const createNewCategoryBtn = addTicketSidebar.querySelector(".create-new-tiers-btn.hold");

        createNewCategoryBtn.addEventListener("click", () => this.generateHoldItem());
    }
    generateHoldItem(holdDataInput = null) {
        const mainWrapper = document.querySelector(".holds-sidebar");

        const addTicketPaidItems = document.createElement("div");
        addTicketPaidItems.classList.add("add-ticket-paid-items");

        // Increment hold counter and generate holdId
        if (!this.data.holdCounter) this.data.holdCounter = 0;
        this.data.holdCounter++;
        const holdId = holdDataInput?.id || `hold-${this.data.holdCounter}`;

        const defaultHoldData = {
            name: `Hold ${this.data.holdCounter}`,
            abbr: `H${this.data.holdCounter}`,
            qty: 0,
            seats: [],
        };

        const mergedHoldData = {
            ...defaultHoldData,
            ...holdDataInput,
            element: addTicketPaidItems,
        };

        // Check if a hold with the same data already exists
        const existingHoldId = Object.keys(this.data.holds).find((id) => {
            const existingHold = this.data.holds[id];
            return (
                existingHold.name === mergedHoldData.name &&
                existingHold.abbr === mergedHoldData.abbr &&
                existingHold.qty === mergedHoldData.qty &&
                JSON.stringify(existingHold.seats) === JSON.stringify(mergedHoldData.seats)
            );
        });

        if (existingHoldId) {
            this.data.holds[existingHoldId] = {
                ...this.data.holds[existingHoldId],
                ...mergedHoldData,
            };
        }

        // Add the new hold to the data
        this.data.holds[holdId] = mergedHoldData;

        const fields = [
            {
                label: "Name",
                name: "hold_name[]",
                id: `add-holds-name-${this.data.holdCounter}`,
                placeholder: `Hold ${this.data.holdCounter}`,
                type: "text",
                value: mergedHoldData.name,
                key: "name",
            },
            {
                label: "Abbreviation",
                name: "hold_abbr[]",
                id: `add-holds-abbr-${this.data.holdCounter}`,
                placeholder: `H${this.data.holdCounter}`,
                type: "text",
                value: mergedHoldData.abbr,
                key: "abbr",
                maxlength: "3",
            },
            {
                label: "Quantity",
                name: "hold_qty[]",
                id: `add-hold-qty-${this.data.holdCounter}`,
                placeholder: "0",
                type: "text",
                events: {
                    oninput: "validateInteger(this, 0)",
                    onpaste: "validateInteger(this, 0)",
                },
                value: mergedHoldData.qty,
                key: "qty",
            },
        ];

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

            const label = document.createElement("label");
            label.setAttribute("for", field.id);
            label.classList.add("transition", "border-box", "add-ticket-paid-label");
            label.textContent = field.label;
            wrapper.appendChild(label);

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
            input.value = field.value;

            if (field.maxlength) {
                input.maxLength = parseInt(field.maxlength);
            }

            if (field.key === "qty") {
                input.readOnly = true;
            }

            // Bind input value to hold data
            mergedHoldData[field.key] = input.value;

            input.addEventListener("input", () => {
                mergedHoldData[field.key] = input.value;

                if (field.key === "abbr") {
                    // Could be used for visual indication or debugging
                    this.layer.find((node) => mergedHoldData.seats.includes(node.id())).forEach((seat) => {
                        // Optional: update tooltip or label with abbr
                    });

                    this.updateSeatColors();
                    this.layer.draw();
                }
            });

            // Set any inline event attributes
            if (field.events) {
                for (const event in field.events) {
                    input.setAttribute(event, field.events[event]);
                }
            }

            wrapper.appendChild(input);

            const errorText = document.createElement("p");
            errorText.classList.add("error-text", "border-box");
            wrapper.appendChild(errorText);

            addTicketPaidItems.appendChild(wrapper);
        });

        // Create delete button
        const deleteButtonWrapper = document.createElement("div");
        deleteButtonWrapper.classList.add(
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

        const deleteButton = document.createElement("button");
        deleteButton.classList.add("delete-category-btn", "transition");
        deleteButton.type = "button";
        deleteButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                    <path d="M200-440v-80h560v80H200Z"/>
                </svg>
                Delete Hold
            `;

        deleteButton.addEventListener("click", (event) => {
            event.stopPropagation();
            mainWrapper.removeChild(addTicketPaidItems);
            delete this.data.holds[holdId];
            this.updateSeatColors();
        });

        deleteButtonWrapper.appendChild(deleteButton);
        addTicketPaidItems.appendChild(deleteButtonWrapper);

        // Append to wrapper
        mainWrapper.appendChild(addTicketPaidItems);

        // Update visual overlays
        if (!holdDataInput) {
            this.updateHoldOverlays?.();
            this.updateSeatColors?.();
        }
    }
    destroySeatingPlan() {

        // Destroy all layers and stage
        if (this.stage) {
            // this.stage.destroy(); // Destroys the stage and all its children
            this.stage = null;
        }

        // Reset properties in KonvaSeatingPlan
        this.layer = null;
        this.data.tierCounter = 0;
        this.data.holds = [];
        this.data.holdCounter = 0;
        this.data = {
            type: "table",
            seatings: [],
            amenities: [],
            planData: [],
            tiers: [],
            tierCounter: 0,
            holds: [],
            holdCounter: 0
        };
        this.activeTab = "tier";
        this.activeGroup = null;

        // Remove event listeners from DOM elements
        if (this.zoomIn) {
            this.zoomIn.removeEventListener("click", this.zoomStage);
        }
        if (this.zoomOut) {
            this.zoomOut.removeEventListener("click", this.zoomStage);
        }
    }
    resetSeatingPlan() {
        // Reset all amenities checkboxes
        const amenitiesCheckboxes = document.querySelectorAll('input[type="checkbox"][name="seating-amenities[]"]');
        amenitiesCheckboxes.forEach((cb, i) => {
            i === 0 ? cb.checked = true : cb.checked = false;
        });


        // Clear internal amenities data and set first checkbox value
        this.data.amenities = [];
        if (amenitiesCheckboxes.length > 0) {
            this.data.amenities.push(amenitiesCheckboxes[0].value);
        }


        // Reset seating inputs with conditional default values
        const inputWrapper = document.querySelector(`.${this.data.type}`);
        if (inputWrapper) {
            const inputs = inputWrapper.querySelectorAll(".seat-map--input");
            this.data.seatings = {};

            inputs.forEach((input, index) => {
                const key = input.name || input.id || `input-${index}`;
                let defaultValue = 8; // default fallback

                // Set based on this.data.type and index
                if (this.data.type === "table" || this.data.type === "section") {
                    if (index === 0) defaultValue = 14;
                } else if (this.data.type === "mixed") {
                    if (index === 0 || index === 2) defaultValue = 14;
                }

                input.value = defaultValue;
                this.data.seatings[key] = defaultValue;
            });
        }


        // Reset active tab to 'tier' visually and logically
        const tabsWrapper = this.mainWrapper.querySelector(".seat-map-wrapper .left-side");
        const tabs = tabsWrapper.querySelectorAll(".map-item");

        tabs.forEach(tab => {
            if (tab.dataset.value === "tier") {
                tab.classList.add("active");
                tab.click();
            } else {
                tab.classList.remove("active");
            }

        });

        this.activeTab = "tier";

        const tiersSidebar = document.querySelector(".tiers-sidebar.tiers");
        if (tiersSidebar) {
            tiersSidebar.innerHTML = '';
        }

        const holdsSidebar = document.querySelector(".holds-sidebar.holds");
        if (holdsSidebar) {
            holdsSidebar.innerHTML = '';
        }
        this.destroySeatingPlan();
        // Reinitialize the seating plan
        this._initProperties(this.container, this.width, this.height);
        this._initStage();
        this._bindZoomControls();
        this.initialize();


    }
    setSeatingPlanData(jsonData, layoutData) {

        // Parse layoutData if it's a string
        if (typeof layoutData === "string") {
            try {
                layoutData = JSON.parse(layoutData);
            } catch (error) {
                console.error("Error parsing layoutData:", error);
                return;
            }
        }
        // Deep clone layoutData to avoid mutation
        this.data = {
            type: layoutData.type || "table",
            seatings: layoutData.seatings || {},
            amenities: layoutData.amenities || [],
            planData: layoutData.planData || [],
            tiers: JSON.parse(JSON.stringify(layoutData.tiers || {})),
            tierCounter: layoutData.tierCounter || 0,
            holds: JSON.parse(JSON.stringify(layoutData.holds || {})),
            holdCounter: layoutData.holdCounter || 0,
        };

        console.log("this.data: ", this.data);


        this.data.tiers = this.getUniqueData(this.data.tiers, "tier");
        this.data.holds = this.getUniqueData(this.data.holds, "hold");
        // this.data.tiers = {};
        // this.data.holds = {};
        // console.log("tiers", tiers, "holds", holds);
        // console.log("this.data.tiers", this.data.tiers, "this.data.holds", this.data.holds);
        // this.data.tiers = tiers;
        // this.data.holds = holds;

        console.log("this.data: ", this.data);

        // Update tier/hold categories
        Object.entries(this.data.tiers).forEach(([tierId, tier], index) => {
            const deleteBtn = tier.type === "paid";
            this.generateTierItem(tier, deleteBtn);
            /*if (!tier.element || !(tier.element instanceof HTMLElement)) {
                console.warn(`Skipping tier with ID ${tierId} as it does not have a valid element.`);
                delete this.data.tiers[tierId]; // Optionally remove invalid tiers
                return;
            }*/

        });

        Object.entries(this.data.holds).forEach(([holdId, hold], index) => {
            this.generateHoldItem(hold);
            /*if (!hold.element || !(hold.element instanceof HTMLElement)) {
                console.warn(`Skipping hold with ID ${holdId} as it does not have a valid element.`);
                delete this.data.holds[holdId];
                return;
            }*/

        });
        this.data.tiers = this.getUniqueData(this.data.tiers, "tier");
        this.data.holds = this.getUniqueData(this.data.holds, "hold");
        // Update UI checkboxes for amenities
        const amenitiesCheckboxes = document.querySelectorAll('input[type="checkbox"][name="seating-amenities[]"]');
        amenitiesCheckboxes.forEach(cb => {
            cb.checked = this.data.amenities.includes(cb.value);
        });

        // Update seating input fields
        const inputWrapper = document.querySelector(`.${this.data.type}`);
        if (inputWrapper) {
            const inputs = inputWrapper.querySelectorAll(".seat-map--input");
            inputs.forEach((input, index) => {
                const key = input.name || input.id || `input-${index}`;
                if (this.data.seatings[key] !== undefined) {
                    input.value = this.data.seatings[key];
                }
            });
        }

        // Set active tab
        if (jsonData.activeTab) {
            this.activeTab = "tier";
            const tabs = this.mainWrapper.querySelectorAll(".map-item");
            tabs.forEach(tab => {
                if (tab.dataset.value === this.activeTab) {
                    tab.classList.add("active");
                } else {
                    tab.classList.remove("active");
                }
            });
        }

        // Create Konva stage from JSON
        try {
            this.stage = Konva.Node.create(jsonData, this.container);
            this.layer = this.stage.findOne('Layer') || this.stage.getLayers()[0];

            // Ensure the layer exists
            this.ensureLayerExists();

            // Resize stage to container
            const containerWidth = this.container.clientWidth;
            const containerHeight = this.container.clientHeight;
            this.stage.width(containerWidth);
            this.stage.height(containerHeight);
            this._handleStageClick();

            // Reset zoom and position
            this.currentScale = 1;
            this.stage.scale({ x: 1, y: 1 });
            this.stage.position({ x: 0, y: 0 });

            // Restore event listeners
            this.restoreEventListenersFromStage();

            // Update overlays
            this.updateTierOverlays();
            this.updateHoldOverlays();
            this.updateSeatColors();

            this.layer.draw();

        } catch (error) {
            console.error("Error parsing Konva stage JSON:", error);
        }
    }
    getData(str) {
        // setTimeout(() => {
        return this.data;
        // }, 5000);
    }


    exportSeatingPLan() {

        const eventForm = document.querySelector("#event-create-form");

        const saveBtn = this.mainWrapper.querySelector(".save-btn");
        if (saveBtn) {
            saveBtn.addEventListener("click", () => {

                // this.ensureLayerExists();
                try {
                    const json = this.stage.toJSON();
                    const seatingMapInput = eventForm.querySelector('input[name="seating_map"]');
                    if (seatingMapInput) {
                        seatingMapInput.value = JSON.stringify(json);
                    }
                    const seatingDataInput = eventForm.querySelector('input[name="seating_plan"]');
                    if (seatingDataInput) {
                        seatingDataInput.value = JSON.stringify(this.data);

                    }

                    this.container.innerHTML = '';
                    this.resetSeatingPlan();
                    // toggleModal();
                    toggleEventModal();
                    switchEditCreateSeatingMapWrapper();
                    handleEventCheckNext(2);
                } catch (error) {
                    console.error("Error exporting seating plan:", error);
                }
            });
        }
    }

    handleResetSeatingPlan() {
        const modalBackBtns = this.mainWrapper.querySelectorAll(".back-btn");
        if (modalBackBtns) {
            modalBackBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    this.resetSeatingPlan();
                });
            });
        }
        const modalCloseBtns = this.mainWrapper.querySelectorAll(".close-btn");
        if (modalCloseBtns) {
            modalCloseBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    this.resetSeatingPlan();
                    toggleEventModal();
                });
            });
        }
    }
    getUniqueData(data, type = "tier") {
        const seen = new Set();
        const result = {};

        for (const [key, item] of Object.entries(data)) {
            // Normalize: Convert qty to number and sort seats
            const normalized = {
                ...item,
                qty: Number(item.qty),
                seats: [...item.seats].sort(),
            };

            // Check uniqueness by color property only
            const isUnique = !Object.values(result).some(existingItem => {
                if (type === "tier") {
                    return existingItem.color === normalized.color;
                }
                else if (type === "hold") {
                    return existingItem.abbr === normalized.abbr;
                }
            });

            // If unique, add to the result
            if (isUnique) {
                result[key] = item; // Keep original key name (e.g., "tier-3")
            }

            console.log(key, item);
        }

        console.log(result);
        return result;
    }





}
