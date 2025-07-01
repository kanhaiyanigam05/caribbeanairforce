// Initialize Swiper
const scrollContainer = new Swiper(".scroll-container", {
    direction: "horizontal",
    spaceBetween: 10,
    slidesPerView: "auto",
    freeMode: true,
    scrollbar: {
        el: ".swiper-scrollbar",
        draggable: true, // Make scrollbar draggable
    },
    mousewheel: true,
});


const feedInner = new Swiper(".feed-inner-swiper", {
    direction: "horizontal",
    spaceBetween: 20,
    slidesPerView: "auto",
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    scrollbar: {
        el: ".swiper-scrollbar",
        draggable: true, // If you have a scrollbar element
    },
    navigation: {
        nextEl: ".feed-inner-navigation-next",
        prevEl: ".feed-inner-navigation-prev",
    },
});


const createEventPreview = new Swiper(".create-event-preview-slider", {
    // Create Event preview
    slidesPerView: "auto",
    spaceBetween: 15,
    navigation: {
        nextEl: ".preview-event-navigation-next",
        prevEl: ".preview-event-navigation-prev",
    },
    pagination: {
        el: ".preview-event-pagination",
        clickable: true,
    },
});


const moreFeeds = new Swiper(".more-feeds", {
    spaceBetween: 10,
    autoHeight: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        650: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        1080: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
    },
});


const userSuggestionsSwiper = new Swiper(".user-suggestions-swiper", {
    slidesPerView: 1,
    spaceBetween: 10,

    breakpoints: {
        400: {
            slidesPerView: 2,
        },
        640: {
            slidesPerView: 3,
        },
        800: {
            slidesPerView: 4,
        },
        1024: {
            slidesPerView: 5,
        },
    }
})

const swiper = new Swiper('.carousel', {
    slidesPerView: 'auto',
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});