class KonvaSeatingPlan {
    constructor({ container, width = 1000, height = 700 }) {
        this._initProperties(container, width, height);
        this._initStage();
        this._bindZoomControls();
        this.initialize();
    }

    _initProperties(container, width, height) {
        this.mainWrapper = document.querySelector(".reserved-top-modal");
        this.container = container;
        this.parent = this.container.parentElement;

        this.data = {
            type: "table",  // setting default layout type table means it will initialize direct table modal
            seatings: [],
            amenities: [],
            planData: [],
            tiers: {},
            tierCounter: 0,
            holds: {},
            holdCounter: 0
        };


        this.gridSize = 40;
        this.seatId = 1;
        this.scaleFactor = 1.1;
        this.currentScale = 1;
        this.activeTab = "tier";
        this.activeGroup = null;

        this.width = width;
        this.height = height;
    }

    _initStage() {
        this.stage = new Konva.Stage({ container: this.container, width: this.width, height: this.height });

        this.ensureLayerExists();

        this._handleStageClick();
        this.layer.draw();
    }
    _handleStageClick() {
        this.ensureLayerExists();

        this.stage.on("click", (e) => {
            if (!e.target.getParent() || e.target.getParent().name() !== "section") {
                this._deselectAllSeats();
                this.updateTierOverlays();
                this.updateHoldOverlays();
            }
        });
    }
    _deselectAllSeats() {
        const allSeats = this.layer.find(".seat");

        allSeats.forEach(seat => {
            const metadata = seat.getAttr("metadata") || {};
            metadata.selected = false;
            seat.setAttr("metadata", metadata);

            const tier = this._findTierOfSeat(seat);
        });
        this.updateSeatColors();
    }

    _findTierOfSeat(seat) {
        return Object.values(this.data.tiers).find(t => t.seats.includes(seat.id()));
    }
    ensureLayerExists() {
        if (!this.layer || !this.layer.getParent()) {
            console.warn("Layer is missing or not attached to the stage. Reinitializing...");
            this.layer = new Konva.Layer();
            this.stage.add(this.layer);
        }
    }
    _bindZoomControls() {
        this.zoomIn = this.parent.querySelector("#zoomInBtn");
        this.zoomOut = this.parent.querySelector("#zoomOutBtn");

        this.zoomIn.addEventListener("click", () => this.zoomStage(true));
        this.zoomOut.addEventListener("click", () => this.zoomStage(false));
    }

    initialize() {
        this.drawGrid();
        this.zoomEvents();
        this.setActiveTab();
    };
    drawGrid() {
        const { width, height } = this.stage.size();

        const gridGroup = new Konva.Group({ name: 'grid-lines' });

        for (let i = 0; i < width; i += this.gridSize) {
            gridGroup.add(this._createLine([i, 0, i, height]));
        }
        for (let j = 0; j < height; j += this.gridSize) {
            gridGroup.add(this._createLine([0, j, width, j]));
        }

        this.layer.add(gridGroup);
        // this.layer.draw();
    }


    _createLine(points) {
        return new Konva.Line({
            points,
            stroke: '#e0e0e0',
            strokeWidth: 1,
            listening: false, // not interactive
        });
    }

    generateLayout(data) {
        if (this.data.type === "table") {
            this._generateTableLayout(data);
        }
    }
    addAmenities() {

        const stageWidth = this.stage.width();
        const stageHeight = this.stage.height();

        const amenityGroup = new Konva.Group({ name: "amenities" });

        const visibleAmenities = this.data.amenities || [];

        const createAmenity = (name, config, labelText, iconText = "") => {
            if (!visibleAmenities.includes(name)) return;

            // Group for individual amenity
            const singleAmenityGroup = new Konva.Group({
                name: `amenity-${name}`,
                x: config.x,
                y: config.y,
                draggable: true,
            });

            const rect = new Konva.Rect({
                x: 0,
                y: 0,
                width: config.width,
                height: config.height,
                fill: "#C2E3F2",
                stroke: "#C2E3F2",
                strokeWidth: 1,
            });

            // Icon text
            const icon = new Konva.Text({
                text: iconText,
                fontSize: 16,
                fontFamily: 'Material Symbols Outlined',
                fill: '#6C727A',
            });

            // Label text
            const label = new Konva.Text({
                text: labelText,
                fontSize: 11,
                fontFamily: 'Arial',
                fill: '#6C727A',
            });

            // Measure total label height
            const totalLabelHeight = icon.height() + label.height();

            // Center the labels inside the rectangle
            icon.position({
                x: (config.width / 2) - (icon.width() / 2),
                y: (config.height / 2) - (totalLabelHeight / 2),
            });

            label.position({
                x: (config.width / 2) - (label.width() / 2),
                y: icon.y() + icon.height(),
            });

            // Add elements to the amenity group
            singleAmenityGroup.add(rect);
            singleAmenityGroup.add(icon);
            singleAmenityGroup.add(label);

            // Add the single amenity group to the parent amenities group
            amenityGroup.add(singleAmenityGroup);
        };

        // Stage
        createAmenity("stage", {
            x: stageWidth * 0.25,
            y: 0,
            width: stageWidth * 0.5,
            height: 100,
            fill: "#73a4d9",
            stroke: "#73a4d9",
            strokeWidth: 1,
        }, "Stage", "mic_external_on");

        // Food
        createAmenity("food", {
            x: stageWidth * 0.25,
            y: stageHeight - 50,
            width: stageWidth * 0.5,
            height: 40,
            fill: "#73a4d9",
            stroke: "#73a4d9",
            strokeWidth: 1,
        }, "Food", "restaurant");

        // Bathroom
        createAmenity("bathroom", {
            x: 20,
            y: stageHeight - 60,
            width: 100,
            height: 70,
            fill: "#73a4d9",
            stroke: "#73a4d9",
            strokeWidth: 1,
        }, "Bathroom", "wc");

        // Exit
        createAmenity("exit", {
            x: stageWidth - 80,
            y: stageHeight - 60,
            width: 100,
            height: 70,
            fill: "#73a4d9",
            stroke: "#73a4d9",
            strokeWidth: 1,
        }, "Exit", "logout");

        // Dance
        createAmenity("dance", {
            x: (stageWidth / 2) - 75,
            y: (stageHeight / 2) - 150,
            width: 150,
            height: 400,
            fill: "#73a4d9",
            stroke: "#73a4d9",
            strokeWidth: 1,
        }, "Dance", "taunt");

        // Bar
        createAmenity("bar", {
            x: 80,
            y: (stageHeight / 2) - 150,
            width: 40,
            height: 400,
            fill: "#73a4d9",
            stroke: "#73a4d9",
            strokeWidth: 1,
        }, "Bar", "local_bar");

        this.layer.add(amenityGroup);

    }

    _generateTableLayout({ tables, seats, totalSeats }) {
        this.tables = tables;
        this.seats = seats;
        this.totalSeats = totalSeats;
        this.layer.find(node => node.name() !== 'grid-lines').forEach(node => node.destroy());

        const layoutProps = this._calculateLayoutProps(tables, seats);
        this._applyStageScale(layoutProps.scale);

        this.addAmenities();

        // ✅ Get all amenity shapes
        const amenities = this.layer.find(node => node.name().startsWith('amenity-'));

        // Setup some bounds to calculate the safe zone
        let topBound = 0;
        let bottomBound = this.stage.height();
        let leftBound = 0;
        let rightBound = this.stage.width();

        // ✅ Loop through all amenity shapes and adjust safe zone edges
        amenities.forEach(amenity => {
            const rect = amenity.getClientRect({ relativeTo: this.layer });
            const name = amenity.name();

            if (name.includes("stage")) {
                topBound = Math.max(topBound, rect.y + rect.height);
            } else if (name.includes("food") || name.includes("bathroom") || name.includes("exit")) {
                bottomBound = Math.min(bottomBound, rect.y);
            }

            if (name.includes("bar")) {
                leftBound = Math.max(leftBound, rect.x + rect.width);
            } /*else if (name.includes("exit")) {
                rightBound = Math.min(rightBound, rect.x);
            }*/
        });

        // Add margin so tables don't hug the amenities
        const margin = 20;
        const safeX = leftBound + margin;
        const safeY = topBound + margin;
        const safeWidth = rightBound - leftBound - 2 * margin;
        const safeHeight = bottomBound - topBound - 2 * margin;


        // ✅ Create and position the tableGroup within the safe zone
        this.tableGroup = new Konva.Group({
            name: "tableGroup",
            x: safeX,
            y: safeY,
            width: safeWidth,
            height: safeHeight,
            stroke: "#000",
            strokeWidth: 1,
        });
        this.layer.add(this.tableGroup);

        // ✅ Add a Konva.Rect as the visual stroke/border inside the group
        /*const groupBorder = new Konva.Rect({
            x: 0,
            y: 0,
            width: safeWidth,
            height: safeHeight,
            stroke: "#000",
            strokeWidth: 1,
            listening: false, // optional: don't trigger events
        });
        this.tableGroup.add(groupBorder);*/
        this._generateTableGrid(layoutProps);
        this._ensureTableGroupDoesNotTouchAmenities();
        this.layer.draw();
    }


    _ensureTableGroupDoesNotTouchAmenities() {
        const amenitiesGroup = this.layer.findOne('.amenities');
        const tableGroupBox = this.tableGroup.getClientRect({ relativeTo: this.layer });
        const amenityBoxes = amenitiesGroup.getChildren().map(child => child.getClientRect({ relativeTo: this.layer }));

        for (const amenityBox of amenityBoxes) {
            if (Konva.Util.haveIntersection(tableGroupBox, amenityBox)) {
                // Move tableGroup upward to avoid overlap (you can enhance this logic)
                const offsetY = amenityBox.y + amenityBox.height - tableGroupBox.y + 10;
                this.tableGroup.y(this.tableGroup.y() + offsetY);
            }
        }
    }


    _calculateLayoutProps(tables, seats) {
        let tableRadius = 40;
        let tableSpacing = 80;
        let seatRadius = seats <= 10 ? 10 : seats <= 20 ? 6 : 4;

        let scale = 1;
        let tablesPerRow = 4;

        if (tables <= 20) {
            scale = tables <= 10 ? 1 : 0.9;
            tablesPerRow = tables <= 10 ? 4 : 5;
        } else if (tables <= 28) {
            scale = 0.75; tablesPerRow = 7;
            tableRadius = 30;
            tableSpacing = 70;
        } else if (tables <= 40) {
            scale = 0.6; tablesPerRow = 8;
            tableRadius = 25;
            tableSpacing = 60;
            seatRadius = seats <= 10 ? 7 : seats <= 20 ? 4 : 3;
        } else if (tables <= 50) {
            scale = 0.5; tablesPerRow = 10;
            tableRadius = 30;
            tableSpacing = 40;
            seatRadius = seats <= 10 ? 6 : seats <= 20 ? 4 : 3;
        }

        return { tableRadius, tableSpacing, seatRadius, scale, tablesPerRow };
    }
    _applyStageScale(scale) {
        this.stage.scale({ x: scale, y: scale });
        const offsetX = (this.stage.width() * (1 - scale)) / 2;
        const offsetY = (this.stage.height() * (1 - scale)) / 2;
        // const offsetX = 0;
        // const offsetY = 0;
        this.stage.position({ x: offsetX, y: offsetY });
    }
    _generateTableGrid({ tableRadius, tableSpacing, seatRadius, scale, tablesPerRow }) {
        const tableWidth = tableRadius * 2 + tableSpacing;

        // ✅ Group-local center point (not absolute stage pos)
        const centerX = this.tableGroup.width() / 2;
        const centerY = this.tableGroup.height() / 2;

        const rows = Math.ceil(this.tables / tablesPerRow);
        let currentTable = 0;

        for (let row = 0; row < rows; row++) {
            const isLastRow = row === rows - 1;
            const tablesInRow = isLastRow ? this.tables % tablesPerRow || tablesPerRow : tablesPerRow;

            const rowWidth = tablesInRow * tableWidth;
            const startX = centerX - rowWidth / 2 + tableWidth / 2;
            const y = centerY - (rows * tableWidth) / 2 + tableWidth / 2 + row * tableWidth;

            for (let col = 0; col < tablesInRow; col++) {
                const x = startX + col * tableWidth;

                const group = this.addSeatGroup({
                    seats: this.seats,
                    rows,
                    tableNumber: currentTable + 1,
                    x,
                    y,
                    tableRadius,
                    seatRadius
                });

                // ✅ Add group directly to this.tableGroup (not layer!)
                this.tableGroup.add(group);

                currentTable++;
                if (currentTable >= this.tables) return;
            }
        }
    }

    // --- Method: addSeatGroup ---
    addSeatGroup({ seats, rows, tableNumber = 0, x = 0, y = 0, tableRadius, seatRadius }) {
        const group = this.createTableGroup({ x, y });

        const tableCircle = this.createTableCircle(tableRadius);
        group.add(tableCircle);

        const tableText = this.createTableText(tableNumber);
        group.add(tableText);

        this.addSeatsToGroup({ group, seats, tableRadius, seatRadius, tableText });
        this.bindGroupEvents(group);

        return group; // ✅ Return so it can be added to this.tableGroup
    }


    createTableGroup({ x, y }) {
        return new Konva.Group({ x, y, draggable: true, name: "section" });
    }

    createTableCircle(radius) {
        return new Konva.Circle({
            x: 0,
            y: 0,
            radius,
            fill: "transparent",
            stroke: "#9c9c9c",
            strokeWidth: 2,
            name: "table",
        });
    }

    createTableText(text) {
        const tableText = new Konva.Text({ text, fontSize: 16, fill: "black" });
        tableText.offsetX(tableText.width() / 2);
        tableText.offsetY(tableText.height() / 2);
        return tableText;
    }

    addSeatsToGroup({ group, seats, tableRadius, seatRadius, tableText }) {
        const angleBetweenSeats = (Math.PI * 2) / seats;

        for (let i = 0; i < seats; i++) {
            const { seatX, seatY, fontSize } = this.calculateSeatPosition(seats, i, tableRadius);

            const seat = new Konva.Circle({
                x: seatX,
                y: seatY,
                radius: seatRadius,
                fill: "#d9d9d9",
                stroke: "#9c9c9c",
                strokeWidth: 1,
                draggable: false,
                name: "seat",
                id: `seat-${this.seatId}`,
            });
            seat.setAttr("metadata", {
                tableText,
                row: 1,
                col: i + 1,
                label: `${i + 1}`,
                selected: false,
            });

            const seatNumberText = new Konva.Text({
                x: seatX,
                y: seatY,
                text: `${i + 1}`,
                fontSize,
                fill: "#6C727A",
                name: `seat-number-text-${seat.id()}`,
                listening: false,
            });
            seatNumberText.offsetX(seatNumberText.width() / 2);
            seatNumberText.offsetY(seatNumberText.height() / 2);

            const holdAbbrText = new Konva.Text({
                x: seatX,
                y: seatY,
                text: "",
                fontSize: fontSize - 1,
                fill: "#d9d9d9",
                name: `seat-hold-text-${seat.id()}`,
                visible: false,
                listening: false,
            });
            holdAbbrText.offsetX(holdAbbrText.width() / 2);
            holdAbbrText.offsetY(holdAbbrText.height() / 2);


            this.seatId++;
            group.add(seat);
            group.add(seatNumberText);
            group.add(holdAbbrText);
        }
    }

    calculateSeatPosition(seats, i, tableRadius) {
        const angle = ((Math.PI * 2) / seats) * i;
        let seatTableSpace = this.tables > 40 ? 10 : 15;
        let seatX = Math.cos(angle) * (tableRadius + seatTableSpace);
        let seatY = Math.sin(angle) * (tableRadius + seatTableSpace);
        let fontSize = 10;

        if (seats > 10 && seats <= 20) {
            seatX = Math.cos(angle) * (tableRadius + 10);
            seatY = Math.sin(angle) * (tableRadius + 10);
            fontSize = 6;
        } else if (seats > 20 && seats <= 30) {
            seatX = Math.cos(angle) * (tableRadius + 8);
            seatY = Math.sin(angle) * (tableRadius + 8);
            fontSize = 3;
        }

        return { seatX, seatY, fontSize };
    }


    handleTierSeatClick(seat) {
        const selectedTierId = this.currentTierId;
        if (!selectedTierId) return;

        const seatMeta = seat.getAttr("metadata");
        const seatId = seat.id();
        const tier = this.data.tiers[selectedTierId];

        for (const [tierId, t] of Object.entries(this.data.tiers)) {
            if (t.seats.includes(seatId)) {
                t.seats = t.seats.filter(id => id !== seatId);
            }
        }

        const alreadyInTier = tier.seats.includes(seatId);

        if (alreadyInTier) {
            tier.seats = tier.seats.filter(id => id !== seatId);
            seatMeta.selected = false;
        } else {
            tier.seats.push(seatId);
            seatMeta.selected = true;
        }
        this.updateSeatColors();

        this.updateTierOverlays();
    }

    bindGroupEvents(group) {
        group.on("dragmove", () => this.restrictTableMovement(group));
        group.on("dragend", () => this.restrictTableMovement(group));

        group.on("click", (e) => this.handleGroupClick(e, group));
    }

    handleGroupClick(e, group) {
        const clickedNode = e.target;

        if (this.activeTab === "tier" || this.activeTab === "hold") {
            let targetSeat = null;

            if (clickedNode.name() === "seat") {
                targetSeat = clickedNode;
            } else if (clickedNode instanceof Konva.Text) {
                targetSeat = group.find(node => node.name() === "seat" && node.x() === clickedNode.x() && node.y() === clickedNode.y())[0];
            }

            if (targetSeat) {
                const selected = targetSeat.getAttr("metadata").selected;
                targetSeat.getAttr("metadata").selected = !selected;
                this.updateSeatColors();
                this.updateTierOverlays();
                this.updateHoldOverlays();
                return;
            }

            if (clickedNode.name() === "table" || clickedNode instanceof Konva.Text) {
                const seats = group.find(".seat");
                seats.forEach(seat => {
                    seat.getAttr("metadata").selected = true;
                });
                this.updateSeatColors();
                this.updateTierOverlays();
                this.updateHoldOverlays();
            }
        }

        this.activeGroup = group;
    }

    // --- Method: updateTierOverlays ---
    updateTierOverlays() {
        Object.entries(this.data.tiers).forEach(([tierId, tier]) => {
            const el = tier.element;
            if (el) {
                const oldOverlay = el.querySelector(".overlay");
                if (oldOverlay) oldOverlay.remove();


                const selectedSeats = this.layer.find(".seat").filter(seat => seat.getAttr("metadata")?.selected);

                if (selectedSeats.length > 0) {
                    const overlay = this.createTierOverlay(tierId, tier, selectedSeats);
                    el.appendChild(overlay);
                }
            }

        });
    }

    createTierOverlay(tierId, tier, selectedSeats) {
        const overlay = document.createElement("div");
        overlay.classList.add("overlay");

        const hasAlreadyAssigned = selectedSeats.every(seat => tier.seats.includes(seat.id()));
        const icon = document.createElement("i");
        icon.classList.add("fa", hasAlreadyAssigned ? "fa-minus" : "fa-plus");
        overlay.appendChild(icon);

        overlay.addEventListener("click", () => {
            const isRemoving = selectedSeats.every(seat => tier.seats.includes(seat.id()));

            selectedSeats.forEach(seat => {
                const seatId = seat.id();

                if (isRemoving) {
                    tier.seats = tier.seats.filter(id => id !== seatId);
                } else {
                    Object.values(this.data.tiers).forEach(t => {
                        t.seats = t.seats.filter(id => id !== seatId);
                    });
                    tier.seats.push(seatId);
                }
                seat.getAttr("metadata").selected = false;
                seat.getAttr("metadata").tierId = isRemoving ? null : tierId;
                this.updateSeatColors();
            });

            this.updateTierQuantities();
            this.updateTierOverlays();
        });

        return overlay;
    }
    updateHoldOverlays() {
        Object.entries(this.data.holds).forEach(([holdId, hold]) => {
            const el = hold.element;
            const oldOverlay = el.querySelector(".overlay");
            if (oldOverlay) oldOverlay.remove();

            const selectedSeats = this.layer.find(".seat").filter(seat => seat.getAttr("metadata")?.selected);

            if (selectedSeats.length > 0) {
                const overlay = this.createHoldOverlay(holdId, hold, selectedSeats);
                el.appendChild(overlay);
            }
        });
    }
    createHoldOverlay(holdId, hold, selectedSeats) {
        const overlay = document.createElement("div");
        overlay.classList.add("overlay");

        const hasAlreadyAssigned = selectedSeats.every(seat => hold.seats.includes(seat.id()));
        const icon = document.createElement("i");
        icon.classList.add("fa", hasAlreadyAssigned ? "fa-minus" : "fa-plus");
        overlay.appendChild(icon);

        overlay.addEventListener("click", () => {
            const isRemoving = selectedSeats.every(seat => hold.seats.includes(seat.id()));

            selectedSeats.forEach(seat => {
                const seatId = seat.id();

                if (isRemoving) {
                    hold.seats = hold.seats.filter(id => id !== seatId);
                    seat.getAttr("metadata").holdId = null;
                } else {
                    // Remove from all other holds
                    Object.values(this.data.holds).forEach(h => {
                        h.seats = h.seats.filter(id => id !== seatId);
                    });
                    hold.seats.push(seatId);
                    seat.getAttr("metadata").holdId = holdId;
                }

                seat.getAttr("metadata").selected = false;
                this.updateSeatColors();
            });

            this.updateHoldQuantities();
            this.updateHoldOverlays();
        });

        return overlay;
    }


    updateSeatColors() {
        const seats = this.layer.find(".seat");

        seats.forEach(seat => {
            const metadata = seat.getAttr("metadata");
            if (!metadata) return;

            const tier = this.data.tiers[metadata?.tierId];
            const hold = this.data.holds[metadata?.holdId];

            const holdAbbrText = seat.getParent().findOne(`.seat-hold-text-${seat.id()}`);
            const seatNumberText = seat.getParent().findOne(`.seat-number-text-${seat.id()}`);

            let fillColor = "#d9d9d9";
            let strokeColor = "#9c9c9c";

            // Tier assigned
            if (metadata.tierId && tier) {
                fillColor = tier.color;
                strokeColor = tier.color;
            }

            // HOLD tab-specific visuals
            if (this.activeTab === "hold" && hold) {
                // Show abbr, hide number
                if (holdAbbrText) {
                    holdAbbrText.text(hold.abbr || "");
                    holdAbbrText.visible(true);
                    holdAbbrText.position({ x: seat.x(), y: seat.y() });
                    holdAbbrText.offsetX(holdAbbrText.width() / 2);
                    holdAbbrText.offsetY(holdAbbrText.height() / 2);
                }
                if (seatNumberText) seatNumberText.visible(false);

                // Black fill for hold
                if (tier) {
                    fillColor = "#000000";
                    strokeColor = tier.color;
                } else {
                    fillColor = "#000000";
                    strokeColor = "#000000";
                }
            } else {
                // Not HOLD tab – reset hold text visibility, show seat number
                if (holdAbbrText) holdAbbrText.visible(false);
                if (seatNumberText) seatNumberText.visible(true);
            }

            // Final styling
            this.setSeatColor({
                seat,
                fillColor,
                strokeColor,
                selected: metadata.selected,
                reset: !(metadata.tierId || metadata.holdId),
            });
        });

        this.layer.draw();
    }


    setSeatColor({ seat, fillColor = null, strokeColor = null, selected = false, reset = false }) {
        if (!seat || typeof seat.fill !== "function" || typeof seat.stroke !== "function") {
            console.warn("Invalid seat element provided to setSeatColor.");
            return;
        }

        const metadata = seat.getAttr("metadata");
        const tierId = metadata?.tierId;
        const inTier = tierId && this.data.tiers[tierId];
        const holdId = metadata?.holdId;
        const inHold = holdId && this.data.holds[holdId];

        const holdAbbrText = seat.getParent().findOne(`.seat-hold-text-${seat.id()}`);
        const seatNumberText = seat.getParent().findOne(`.seat-number-text-${seat.id()}`);
        if (holdAbbrText) {
            const showHold = this.activeTab === "hold" && !!holdId;
            holdAbbrText.visible(showHold);
            holdAbbrText.position({ x: seat.x(), y: seat.y() });
            holdAbbrText.offsetX(holdAbbrText.width() / 2);
            holdAbbrText.offsetY(holdAbbrText.height() / 2);
            if (seatNumberText) seatNumberText.visible(!showHold);
        }


        // Remove outline if no longer needed
        if (seat._outlineCircle && !(inTier && inHold)) {
            seat._outlineCircle.destroy();
            seat._outlineCircle = null;
        }

        if (this.activeTab === 'tier' || this.activeTab === 'hold') {
            if (selected) {
                if (this.activeTab === "hold" && inTier && inHold) {
                    seat.fill("transparent");
                    seat.stroke(this.data.tiers[tierId].color);
                    // Add outline circle only if not already added
                    if (!seat._outlineCircle) {
                        const outline = new Konva.Circle({
                            x: seat.x(),
                            y: seat.y(),
                            radius: seat.radius() - 1, // slightly larger for outer stroke
                            stroke: "#000000",
                            strokeWidth: 1,
                            fill: 'transparent',
                            listening: false,
                            name: 'seat-outline',
                        });
                        seat.getParent().add(outline);
                        // outline.moveToBottom(); // keep behind the main seat
                        outline.zIndex(seat.index - 1);
                        seat._outlineCircle = outline;
                    }

                    // Always sync position in case of movement
                    if (seat._outlineCircle) {
                        seat._outlineCircle.position(seat.position());
                    }
                } else if (inTier) {
                    seat.fill("transparent");
                    seat.stroke(this.data.tiers[tierId].color);
                } else if (this.activeTab === "hold" && inHold) {
                    seat.fill("transparent");
                    seat.stroke("#000000");
                } else {
                    seat.fill("transparent");
                    seat.stroke("#2855bf");
                }
            } else if (reset) {

                seat.fill("#d9d9d9");
                seat.stroke("#9c9c9c");
            }
            else {
                seat.fill(fillColor);
                seat.stroke(strokeColor);
            }

        }
    }
    updateTierQuantities() {
        Object.entries(this.data.tiers).forEach(([tierId, tier]) => {
            const el = tier.element;
            const qtyInput = el.querySelector('input[name="tier_qty[]"]');
            tier.qty = tier.seats.length;
            if (qtyInput) {
                qtyInput.value = tier.seats.length;
            }
        });
        console.log("tier:", this.data.tiers);

    }
    updateHoldQuantities() {
        Object.entries(this.data.holds).forEach(([holdId, hold]) => {
            const el = hold.element;
            const qtyInput = el.querySelector('input[name="hold_qty[]"]');
            hold.qty = hold.seats.length;
            if (qtyInput) {
                qtyInput.value = hold.seats.length;
            }
        });
    }
    setActiveTab() {
        const tabsWrapper = this.mainWrapper.querySelector(".seat-map-wrapper .left");

        const tabs = tabsWrapper.querySelectorAll(".map-item");

        tabs.forEach(tab => {
            if (tab.classList.contains("active")) {
                this.activeTab = tab.dataset.value;

            }

            tab.addEventListener("click", () => {
                this.activeTab = tab.dataset.value;

                const seats = this.layer.find(".seat");
                seats.forEach(seat => {
                    const metadata = seat.getAttr("metadata");
                    if (metadata) metadata.selected = false;
                });

                this.updateSeatColors();
                this.updateHoldOverlays();
                this.updateTierOverlays();

            })
        });
        this.updateSeatColors();
    }

    isSeatInAnyTier(seat) {
        const seatId = seat.id();
        return Object.values(this.data.tiers).some(tier => tier.seats.includes(seatId));
    }



    resetActiveGroup() {
        if (this.activeGroup) {
            // Remove the dashed border if it exists
            const dashedBorder = this.activeGroup.findOne(".dashed-border");
            if (dashedBorder) {
                dashedBorder.destroy();
            }

            // You can reset other styles here if needed (e.g., opacity, fill, stroke)
            // Example: reset fill of seats if you modified it
            // this.activeGroup.find(".seat").forEach(seat => seat.fill("#d9d9d9"));

            this.activeGroup = null;
        }
    };

    restrictTableMovement(group) {
        const canvasWidth = this.stage.width();
        const canvasHeight = this.stage.height();

        const bounds = group.getClientRect({ relativeTo: this.stage });

        let newX = group.x();
        let newY = group.y();

        // Shift X if going beyond left
        if (bounds.x < 0) {
            newX += -bounds.x;
        }

        // Shift X if going beyond right
        if (bounds.x + bounds.width > canvasWidth) {
            newX -= bounds.x + bounds.width - canvasWidth;
        }

        // Shift Y if going beyond top
        if (bounds.y < 0) {
            newY += -bounds.y;
        }

        // Shift Y if going beyond bottom
        if (bounds.y + bounds.height > canvasHeight) {
            newY -= bounds.y + bounds.height - canvasHeight;
        }

        group.position({ x: newX, y: newY });
        this.layer.draw();
    };
    zoomStage(isZoomIn = true) {
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
        this.layer.draw();

        this.restrictCanvasBoundary();
    };
    restrictSeatsInsideTable(seat, tableRadius) {
        const distance = Math.sqrt(seat.x() * seat.x() + seat.y() * seat.y());
        if (distance > tableRadius) {
            const angle = Math.atan2(seat.y(), seat.x());
            const newX = Math.cos(angle) * tableRadius;
            const newY = Math.sin(angle) * tableRadius;

            seat.position({ x: newX, y: newY });
            this.layer.draw();
        }
    };

    restrictCanvasBoundary() {
        const canvasWidth = this.stage.width() * this.currentScale;
        const canvasHeight = this.stage.height() * this.currentScale;

        if (
            canvasWidth > this.stage.width() ||
            canvasHeight > this.stage.height()
        ) {
            this.container.style.overflow = "auto";
        } else {
            this.container.style.overflow = "hidden";
        }
    };
    zoomEvents() {
        this.isDragging = false;
        this.stage.on("mousedown", (e) => {
            this.isDragging = true;
            this.lastPos = { x: e.evt.clientX, y: e.evt.clientY };
            this.ensureLayerExists();
        });

        // Mouse move event to drag the stage
        this.stage.on("mousemove", (e) => {
            if (!this.isDragging) return;
            const dx = e.evt.clientX - this.lastPos.x;
            const dy = e.evt.clientY - this.lastPos.y;

            const oldPos = this.stage.position();

            // Apply offset based on the zoom scale
            const newPos = {
                x: oldPos.x + dx / this.currentScale,
                y: oldPos.y + dy / this.currentScale,
            };

            // Update the stage position based on the zoom level
            this.stage.position(newPos);
            this.lastPos = { x: e.evt.clientX, y: e.evt.clientY };
            this.ensureLayerExists();
            this.layer.draw();
        });
        // Mouse up event to stop dragging
        this.stage.on("mouseup", () => {
            this.isDragging = false;
            this.ensureLayerExists();
        });

        // Zooming behavior on mouse wheel (centered zoom)
        this.stage.on("wheel", (e) => {
            e.evt.preventDefault();

            const oldScale = this.currentScale;
            const pointer = this.stage.getPointerPosition();
            const scaleBy = this.scaleFactor;

            let direction = e.evt.deltaY > 0 ? -1 : 1;
            let newScale =
                direction > 0 ? oldScale * scaleBy : oldScale / scaleBy;

            // Clamp the scale
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
            this.ensureLayerExists();
            this.layer.draw();
        });
    };


    serializeStage(stage) {
        const serializedStage = {
            width: stage.width(),
            height: stage.height(),
            scale: stage.scale(),
            position: stage.position(),
            layers: [],
        };

        // Iterate through all layers
        stage.getChildren().forEach(layer => {
            const serializedLayer = {
                name: layer.name(),
                visible: layer.visible(),
                children: [],
            };

            // Iterate through all nodes in the layer
            layer.getChildren().forEach(node => {
                const serializedNode = this.serializeNode(node);
                serializedLayer.children.push(serializedNode);
            });

            serializedStage.layers.push(serializedLayer);
        });

        return serializedStage;
    }

    serializeNode(node) {
        const serializedNode = {
            type: node.getClassName(),
            attrs: node.getAttrs(),
        };

        // If the node has children (e.g., Group), serialize them recursively
        if (node.hasChildren && node.hasChildren()) {
            serializedNode.children = [];
            node.getChildren().forEach(child => {
                serializedNode.children.push(this.serializeNode(child));
            });
        }

        return serializedNode;
    }
    restoreEventListenersFromStage() {
        // Restore event listeners for seats
        const seats = this.stage.find('.seat');
        seats.forEach(seat => {
            seat.off('click'); // Remove any existing click listeners to avoid duplicates
            seat.on('click', () => this.handleTierSeatClick(seat));

            // Add other seat-specific event listeners if needed
            seat.off('mouseenter mouseleave');
            seat.on('mouseenter', () => {
                seat.strokeWidth(2); // Highlight on hover
                this.layer.draw();
            });
            seat.on('mouseleave', () => {
                seat.strokeWidth(1); // Reset stroke width
                this.layer.draw();
            });
        });

        // Restore event listeners for sections/groups
        const sections = this.stage.find('.section');
        sections.forEach(group => {
            this.bindGroupEvents(group);
        });

        // Restore event listeners for amenities (if applicable)
        const amenities = this.layer.find(node => node.name().startsWith('amenity-'));
        amenities.forEach(amenity => {
            amenity.off('dragmove dragend');
            amenity.on('dragmove', () => this.restrictTableMovement(amenity));
            amenity.on('dragend', () => this.restrictTableMovement(amenity));
        });

        // Restore zoom and drag events for the stage
        this.stage.off('wheel mousedown mousemove mouseup');
        this.zoomEvents();

        // Update seat colors to reflect the current state
        this.updateSeatColors();
    }
}
