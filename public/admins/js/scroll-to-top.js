const scrollTopBtn = document.getElementById("scrollTopBtn");
const offset = 100; // Adjust this value as needed

function handleScroll() {
    if (window.scrollY > offset) {
        scrollTopBtn.classList.remove("hidden");
        scrollTopBtn.classList.add("fixed");
    } else {
        scrollTopBtn.classList.add("hidden");
        scrollTopBtn.classList.remove("fixed");
    }
}

document.addEventListener("scroll", handleScroll);

// Scroll to top when the button is clicked
scrollTopBtn.addEventListener("click", function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});