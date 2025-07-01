

function toggleVenueModal(index = 0) {
    const venueBtn = document.querySelector("#launch-venue-map-designer");

    const closeButtons = document.querySelectorAll(".close-btn");


    // const toggleModal = (showCreateEventModal = true) => {
    //     createEventModal.classList.remove("show-modal");
    //     reservedTopModal.classList.remove("show-modal");

    //     if (showCreateEventModal) {
    //         reservedTopModal.classList.add("hidden");
    //         createEventModal.classList.remove("hidden");

    //         setTimeout(() => {
    //             createEventModal.classList.add("show-modal");
    //         }, 10);
    //     } else {
    //         createEventModal.classList.add("hidden");
    //         reservedTopModal.classList.remove("hidden");

    //         // ======================================================== To open table & chair modal ================================================================
    //         handleReservedNext(index);
    //         // ======================================================== To open table & chair modal ================================================================
    //         setTimeout(() => {
    //             reservedTopModal.classList.add("show-modal");
    //         }, 10);
    //     }
    // };


    // exportSeatingPLan(seatingPlan);
    // handleResetSeatingPlan(seatingPlan);


    // venueBtn.addEventListener("click", () => toggleModal(false));
    // closeButtons.forEach((btn) => {
    //     btn.addEventListener("click", () => toggleModal(true));
    // });


    /*venueBtn.addEventListener("click", () => toggleEventModal(false));
    closeButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            toggleEventModal(true);
            seatingPlanClass.resetSeatingPlan();
        });
    });*/
}




const toggleEventModal = (showCreateEventModal = true, index = 0) => {
    const createEventModal = document.querySelector("#create-event-modal");
    const reservedTopModal = document.querySelector(".reserved-top-modal");
    createEventModal.classList.remove("show-modal");
    reservedTopModal.classList.remove("show-modal");

    if (showCreateEventModal) {
        reservedTopModal.classList.add("hidden");
        createEventModal.classList.remove("hidden");

        setTimeout(() => {
            createEventModal.classList.add("show-modal");
        }, 10);
    } else {
        createEventModal.classList.add("hidden");
        reservedTopModal.classList.remove("hidden");

        // ======================================================== To open table & chair modal ================================================================
        handleReservedNext(index);
        // ======================================================== To open table & chair modal ================================================================
        setTimeout(() => {
            reservedTopModal.classList.add("show-modal");
        }, 10);
    }
};


function handleReservedNext(currentIndex) {
    const modalWrapper = document.querySelector(".venue-map-slider-wrapper");
    const children = Array.from(modalWrapper.children);

    modalWrapper.setAttribute("data-index", currentIndex + 1);

    children.forEach((child, index) => {
        const subChildren = child.children[0];

        if (index === currentIndex + 1) {
            child.classList.remove("hidden");
        } else {
            if (index !== currentIndex + 1) {
                child.classList.add("hidden");
            }
        }
    });
}


const switchEditCreateSeatingMapWrapper = () => {
    console.log("switchEditCreateSeatingMapWrapper");

    const reservedSeatingSwitch = document.querySelector("#reserved-seating-switch");
    const venueMapWrapper = document.querySelector(".venue-map-wrapper");
    const createVenueMapWrapper = document.querySelector(".create-venue-map");
    const editVenueMapWrapper = document.querySelector(".edit-venue-map");
    const seatingMap = document.querySelector("#seating_map");
    const seatingPlan = document.querySelector("#seating_plan");

    if (reservedSeatingSwitch.checked) {
        venueMapWrapper.classList.remove("hidden");
        console.log("seatingMap.value", seatingMap.value);
        console.log("seatingPlan.value", seatingPlan.value);

        if (seatingMap.value.trim() !== '' && seatingPlan.value.trim() !== '') {
            createVenueMapWrapper?.classList.add("hidden");
            editVenueMapWrapper?.classList.remove("hidden");
        }
        else {
            createVenueMapWrapper.classList.remove("hidden");
            editVenueMapWrapper.classList.add("hidden");
        }

    } else {
        venueMapWrapper.classList.add("hidden");
        createVenueMapWrapper.classList.add("hidden");
        editVenueMapWrapper.classList.add("hidden");
    }
}
document.addEventListener("DOMContentLoaded", () => {

    const seatingContainer = document.querySelector('.seating-plan-container');
    const rect = seatingContainer.parentElement.getBoundingClientRect();

    const width = (rect.width);
    const height = (rect.height);
    if (!seatingContainer) {
        console.error("Seating container not found!");
        // return;
    }
    const seatingPlanClass = new SeatingPlan({ container: seatingContainer, width: 1200, height: 700 });

    // toggleVenueModal();
    switchEditCreateSeatingMapWrapper();
    document.querySelector("#reserved-seating-switch").addEventListener("change", () => {
        console.log("Checkbox changed!");
        switchEditCreateSeatingMapWrapper();
    });
    const createVenueMapWrapper = document.querySelector(".create-venue-map");
    const editVenueMapWrapper = document.querySelector(".edit-venue-map");
    const seatingMap = document.querySelector("#seating_map");
    const seatingPlan = document.querySelector("#seating_plan");
    const createSeatingMapBtn = createVenueMapWrapper?.querySelector(".create-event-default-btn");
    const editSeatingMapBtn = editVenueMapWrapper?.querySelector(".create-event-default-btn");
    createSeatingMapBtn?.addEventListener("click", () => toggleEventModal(false));
    editSeatingMapBtn?.addEventListener("click", () => {
        console.log("editSeatingMapBtn clicked");

        toggleEventModal(false, 3);
        document.querySelector(".tiers-sidebar.tiers").innerHTML = "";
        document.querySelector(".holds-sidebar.holds").innerHTML = "";
        seatingPlanClass.setSeatingPlanData(JSON.parse(seatingMap.value), seatingPlan.value);
    });
});