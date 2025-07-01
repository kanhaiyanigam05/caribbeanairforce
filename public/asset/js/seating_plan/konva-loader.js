class SeatingPlanLoader {
    constructor({ containerId, endpoint, layout, disabled_seats = [], selectedDates = [], activeDate = null }) {
        this.containerId = containerId;
        this.container = document.getElementById(containerId);
        this.parent = this.container?.parentElement;
        const containerWidth = this.parent.clientWidth;
        const containerHeight = this.parent.clientHeight;

        console.log(containerWidth, containerHeight);

        this.layoutData = typeof layout === 'string' ? JSON.parse(layout) : layout;
        this.disabled_seats = disabled_seats;


        this.endpoint = endpoint;
        this.stage = null;
        this.layer = null;
        this.currentScale = 1;
        this.scaleFactor = 1.1;
        this.isDragging = false;
        this.lastPos = { x: 0, y: 0 };
        this.data = selectedDates.map(item => {
            const type = item.type || "ticket";
            const baseData = {
                donated_tickets: item.donated_tickets || 0,
                free_tickets: item.free_tickets || 0,
                packages: item.packages || [],
                time: item.time || null,
                total_tickets: item.total_tickets || 0,
                type: type,
                paid_tickets: item.paid_tickets || 0,
                booked_seats: item.booked_seats || [],
                seats: [],
            };
            if (type === "ticket") {
                return {
                    ...baseData,
                    date: item.date,
                    dateString: item.dateString || item.date,
                };
            } else if (type === "pass") {
                return {
                    ...baseData,
                    startDate: item.startDate || item.start_date,
                    start_date: item.start_date,
                    endDate: item.endDate || item.end_date,
                    end_date: item.end_date,
                    dateString: item.dateString || `${item.start_date}-${item.end_date}`,
                };
            }
            return baseData;
        });

        this.activeDate = activeDate;

        this.seats = [];
        this.selectedDates = selectedDates;
        if (this.container) {
            this.createLoader();
            this.init(); // Load and render
        }

        this._bindZoomControls(); // Setup zoom buttons
    }

    createLoader() {
        if (!document.querySelector(".loader")) {
            const loaderWrapper = document.createElement("div");
            loaderWrapper.className = "loader-wrapper";
            this.container.appendChild(loaderWrapper);

            const loader = document.createElement("div");
            loader.className = "loader";
            loaderWrapper.appendChild(loader);
        }
    }

    toggleLoader(show = true) {
        const loader = document.querySelector(".loader");
        if (!loader) return;
        loader.classList.toggle("hidden", !show);
    }

    static destroyExistingStage(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        Konva.stages.forEach(stage => {
            if (stage.container().id === containerId) {
                stage.destroy();
            }
        });
        container.innerHTML = '';
    }

    async init() {
        try {
            this.toggleLoader(true);
            SeatingPlanLoader.destroyExistingStage(this.containerId);
            this.createLoader();

            const response = await fetch(this.endpoint);
            if (!response.ok) throw new Error("Failed to fetch stage data");

            const json = await response.json();
            this.loadStageFromJSON(json);
        } catch (error) {
            console.error("Error loading seating plan:", error);
        } finally {
            this.toggleLoader(false);
        }
    }
    loadStageFromJSON(jsonData) {
        try {
            this.stage = Konva.Node.create(jsonData, this.containerId);
            this.layer = this.stage.findOne('Layer') || this.stage.getLayers()[0];

            // 💡 Set stage dimensions to container size
            const containerWidth = this.container.clientWidth;
            const containerHeight = this.container.clientHeight;
            this.stage.width(containerWidth);
            this.stage.height(containerHeight);

            // Reset zoom and position
            this.currentScale = 1;
            this.stage.scale({ x: 1, y: 1 });
            this.stage.position({ x: 0, y: 0 });

            // 🔒 Disable dragging on groups named 'section' or starting with 'amenity-'
            this.stage.find(node =>
                node.getClassName() === 'Group' &&
                (
                    node.name() === 'section' ||
                    node.name()?.startsWith('amenity-')
                )
            ).forEach(group => {
                group.draggable(false);
            });

            this.stage.find(node => node.name() === 'seat').forEach(seat => {
                this.seats.push(seat);
            });

            this.setupInteractions();
            this.fitStageToContainer();
            this.handleSeatSelection();
            this.updateSeatingPlanSlot(this.activeDate, this.disabled_seats, true);
            this.restoreSeatColors();
            this.stage.fire('click', { target: this.stage });
            console.log("Stage loaded successfully");
        } catch (error) {
            console.error("Error parsing Konva JSON:", error);
        }
    }


    fitStageToContainer() {
        if (!this.stage || !this.container) return;

        const containerWidth = this.container.clientWidth;
        const containerHeight = this.container.clientHeight;

        const contentRect = this.stage.getClientRect({ skipTransform: true });

        const paddingRatio = 0.95;
        const scaleX = (containerWidth * paddingRatio) / contentRect.width;
        const scaleY = (containerHeight * paddingRatio) / contentRect.height;

        let scale = Math.min(scaleX, scaleY);

        scale = Math.min(1, scale);

        this.currentScale = scale;
        this.stage.scale({ x: scale, y: scale });

        const horizontalPadding = (containerWidth - contentRect.width * scale) / 2;
        const verticalPadding = 0;

        const extraTopPadding = 15;

        const newPos = {
            x: horizontalPadding - contentRect.x * scale,
            y: verticalPadding - contentRect.y * scale + extraTopPadding
        };

        this.stage.position(newPos);
        this.stage.batchDraw();
    }

    handleSeatSelection() {
        if (!this.stage) return;

        // 🔍 Find all table groups (named 'section')
        const tableGroups = this.stage.find(node =>
            node.getClassName() === 'Group' && node.name() === 'section'
        );

        tableGroups.forEach(group => {
            // 🔹 1. Group click — select all seats in the table
            group.on('click', (e) => {
                // Prevent group click if a seat was clicked
                if (e.target.name() === 'seat') return;

                const seats = group.find(node =>
                    node.getClassName() === 'Circle' && node.name() === 'seat'
                );

                seats.forEach(seat => {
                    if (seat.getAttr('disabled')) return; // 🚫 Skip disabled seats

                    // Select the seat if it's not already selected
                    seat.setAttr('selected', true);
                    seat.fill('#1EA83C');
                    seat.stroke('#1EA83C');

                    const dateData = this.data.find(item => item.dateString === this.activeDate);
                    if (dateData) {
                        if (!dateData.seats.includes(seat.id())) {
                            dateData.seats.push(seat.id());
                        }
                    }
                });
                this.layer?.draw();

                // 🔥 Trigger custom event after seat selection
                this.triggerSeatSelectionEvent();
            });

            // 🔹 2. Individual seat click — toggle only that seat
            const seats = group.find(node =>
                node.getClassName() === 'Circle' && node.name() === 'seat'
            );

            seats.forEach(seat => {
                seat.on('click', (e) => {
                    e.cancelBubble = true;

                    if (seat.getAttr('disabled')) return; // 🚫 Don't allow selecting disabled seats

                    seat.setAttr('selected', true);
                    seat.fill('#1EA83C');
                    seat.stroke('#1EA83C');

                    // Store the selected seat in the data for the current date
                    const dateData = this.data.find(item => item.dateString === this.activeDate); // Assumes first date is selected
                    if (dateData) {
                        if (!dateData.seats.includes(seat.id())) {
                            dateData.seats.push(seat.id());
                        }
                    }

                    this.layer?.draw();

                    // 🔥 Trigger custom event after seat selection
                    this.triggerSeatSelectionEvent();
                });
            });
        });

        // 🔹 3. Deselect all when clicking outside any table group
        this.stage.on('click', (e) => {
            const clickedOn = e.target;

            // If the clicked element is inside a table group, ignore
            const isInsideTable = clickedOn.findAncestor('.section');
            if (isInsideTable) return;

            // Deselect all (but skip disabled ones)
            const allSeats = this.stage.find(node =>
                node.getClassName() === 'Circle' && node.name() === 'seat'
            );

            allSeats.forEach(seat => {
                // Skip disabled seats (don't deselect them)
                if (seat.getAttr('disabled')) return;

                // Deselect the seat if it's selected
                if (seat.getAttr('selected')) {
                    seat.setAttr('selected', false);
                    seat.fill('#d9d9d9');
                    seat.stroke('#9c9c9c');

                    // Remove the seat from the data for the current date
                    const dateData = this.data.find(item => item.dateString === this.activeDate); // Assumes first date is selected
                    if (dateData) {
                        const index = dateData.seats.indexOf(seat.id());
                        if (index !== -1) {
                            dateData.seats.splice(index, 1);
                        }
                    }
                }
            });

            // Make sure the clicked seat itself is not disabled when deselecting
            if (clickedOn.getClassName() === 'Circle' && clickedOn.name() === 'seat') {
                if (clickedOn.getAttr('disabled')) return;
                if (!clickedOn.getAttr('disabled') && clickedOn.getAttr('selected')) {
                    clickedOn.setAttr('selected', false);
                    clickedOn.fill('#d9d9d9');
                    clickedOn.stroke('#9c9c9c');

                    // Remove the seat ID from this.data
                    const index = this.data.seats.indexOf(clickedOn.id());
                    if (index !== -1) {
                        this.data.seats.splice(index, 1);
                    }
                }
            }
            this.restoreSeatColors();
            this.disableSeatsNotInTiers();
            this.layer?.draw();

            // 🔥 Trigger custom event after deselection
            this.triggerSeatSelectionEvent();
        });
    }

    // 🔥 Add this new method to dispatch custom events
    triggerSeatSelectionEvent() {
        const selectedSeats = this.getSelectedSeats();
        const eventData = {
            activeDate: this.activeDate,
            selectedSeats: selectedSeats,
            data: this.data
        };

        // Dispatch custom event on the container element
        const customEvent = new CustomEvent('seatSelectionChanged', {
            detail: eventData
        });

        this.container.dispatchEvent(customEvent);
    }

    // 🔥 Add this helper method to get currently selected seats
    getSelectedSeats() {
        if (!this.stage) return [];

        const selectedSeats = this.stage.find(node =>
            node.getClassName() === 'Circle' &&
            node.name() === 'seat' &&
            node.getAttr('selected')
        );

        return selectedSeats.map(seat => ({
            id: seat.id(),
            metadata: seat.getAttr('metadata')
        }));
    }


    _bindZoomControls() {
        if (!this.parent) return;
        this.zoomIn = this.parent.querySelector("#zoomInBtn");
        this.zoomOut = this.parent.querySelector("#zoomOutBtn");

        this.zoomIn?.addEventListener("click", () => this.zoomStage(true));
        this.zoomOut?.addEventListener("click", () => this.zoomStage(false));
    }

    zoomStage(isZoomIn = true) {
        if (!this.stage) return;

        const oldScale = this.currentScale;
        const scaleBy = isZoomIn ? this.scaleFactor : 1 / this.scaleFactor;
        this.currentScale *= scaleBy;
        this.currentScale = Math.max(this.currentScale, 0.5);

        const center = {
            x: this.stage.width() / 2,
            y: this.stage.height() / 2,
        };

        const mousePointTo = {
            x: (center.x - this.stage.x()) / oldScale,
            y: (center.y - this.stage.y()) / oldScale,
        };

        const newPos = {
            x: center.x - mousePointTo.x * this.currentScale,
            y: center.y - mousePointTo.y * this.currentScale,
        };

        this.stage.scale({ x: this.currentScale, y: this.currentScale });
        this.stage.position(newPos);
        this.layer?.draw();
    }

    setupInteractions() {
        if (!this.stage) return;

        // 🔍 Mouse wheel zoom
        this.stage.on("wheel", (e) => {
            e.evt.preventDefault();

            const oldScale = this.currentScale;
            const pointer = this.stage.getPointerPosition();
            const scaleBy = this.scaleFactor;

            let direction = e.evt.deltaY > 0 ? -1 : 1;
            let newScale = direction > 0 ? oldScale * scaleBy : oldScale / scaleBy;
            newScale = Math.max(0.5, Math.min(2.5, newScale));

            const mousePointTo = {
                x: (pointer.x - this.stage.x()) / oldScale,
                y: (pointer.y - this.stage.y()) / oldScale,
            };

            const newPos = {
                x: pointer.x - mousePointTo.x * newScale,
                y: pointer.y - mousePointTo.y * newScale,
            };

            this.currentScale = newScale;
            this.stage.scale({ x: newScale, y: newScale });
            this.stage.position(newPos);
            this.layer?.draw();
        });

        // 🖱️ Mouse drag to pan
        this.stage.on("mousedown", (e) => {
            this.isDragging = true;
            this.lastPos = { x: e.evt.clientX, y: e.evt.clientY };
        });

        this.stage.on("mousemove", (e) => {
            if (!this.isDragging) return;

            const dx = e.evt.clientX - this.lastPos.x;
            const dy = e.evt.clientY - this.lastPos.y;

            const oldPos = this.stage.position();
            const newPos = {
                x: oldPos.x + dx / this.currentScale,
                y: oldPos.y + dy / this.currentScale,
            };

            this.stage.position(newPos);
            this.lastPos = { x: e.evt.clientX, y: e.evt.clientY };
            this.layer?.draw();
        });

        this.stage.on("mouseup", () => {
            this.isDragging = false;
        });

        // Optional: stop dragging if mouse leaves canvas
        this.stage.on("mouseleave", () => {
            this.isDragging = false;
        });
    }


    restoreSeatColors() {
        if (!this.stage || !this.layoutData) return;

        const allSeats = this.stage.find(node =>
            node.getClassName() === 'Circle' && node.name() === 'seat'
        );

        allSeats.forEach(seat => {
            const seatId = seat.id();
            const meta = seat.getAttr('metadata') || {};

            let color = '#d9d9d9'; // default color
            let stroke = '#9c9c9c';

            if (meta.tierId && this.layoutData.tiers[meta.tierId]) {
                const tierInfo = this.layoutData.tiers[meta.tierId];
                color = "transparent";
                stroke = tierInfo.color || stroke;
            }/* else if (meta.holdId && this.layoutData.holds[meta.holdId]) {
                const holdInfo = this.layoutData.holds[meta.holdId];
                color = "#000000" || color;
                stroke = holdInfo.color || stroke;
            }*/

            seat.fill(color);
            seat.stroke(stroke);
            seat.strokeWidth(3);
            seat.setAttr('disabled', false);
            seat.listening(true);
        });

        this.layer?.draw();
    }

    updateSeatingPlanSlot(activeDate, seatIds = [], reset = false) {
        if (!this.stage) return;
        this.disabled_seats = seatIds;
        this.disableSeatsNotInTiers();
        this.activeDate = activeDate;
        this.setSelectedDisabledSeats();
    }

    disableSeatsNotInTiers() {
        if (!this.stage || !this.layoutData || !this.layoutData.tiers) return;

        const allSeats = this.stage.find(node =>
            node.getClassName() === 'Circle' && node.name() === 'seat'
        );

        allSeats.forEach(seat => {
            const meta = seat.getAttr('metadata') || {};
            const seatTier = meta.tierId;

            const isValidTier = seatTier && this.layoutData.tiers.hasOwnProperty(seatTier);

            if (!isValidTier) {
                seat.setAttr('disabled', true);
                seat.fill('#EEEEEE'); // light gray
                seat.stroke('#EEEEEE');
                seat.listening(false);
                seat.off(); // remove events
            }
        });
        this.disabled_seats.forEach(id => {
            const seat = this.stage.findOne(`#${id}`);
            if (seat) {
                seat.setAttr('disabled', true);
                seat.fill('#EEEEEE'); // light gray
                seat.stroke('#EEEEEE');
                seat.listening(false);
                seat.off(); // remove events
            }
        })
        this.layer?.draw();
    }
    setSelectedDisabledSeats() {
        this.data.forEach(dataItem => {
            console.log(dataItem.booked_seats);

            if (dataItem.dateString === this.activeDate) {
                this.restoreSeatColors();
                this.disableSeatsNotInTiers();

                // dataItem.booked_seats.forEach(id => {
                //     const seat = this.stage.findOne(`#${id}`);
                //     if (seat) {
                //         seat.setAttr('disabled', true);
                //         seat.fill('#EEEEEE'); // light gray
                //         seat.stroke('#EEEEEE');
                //         seat.listening(false);
                //         seat.off(); // remove events
                //     }
                // })
                dataItem.seats.forEach(id => {
                    const seat = this.stage.findOne(`#${id}`);
                    if (seat) {
                        seat.setAttr('selected', true);
                        seat.fill('#1EA83C'); // light gray
                        seat.stroke('#1EA83C');
                        seat.listening(false);
                        seat.off(); // remove any event listeners
                    }
                })
            }
        })
    }
}
