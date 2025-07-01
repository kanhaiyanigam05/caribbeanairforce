
const scrollTopBtn = document.getElementById("scrollTopBtn");
const offset = 100; // Adjust this value as needed

function handleScroll() {
    if (window.scrollY > offset) {
        scrollTopBtn.classList.remove("hidden"); // Show button
        scrollTopBtn.classList.add("fixed"); // Ensure it is fixed when scrolled down
    } else {
        scrollTopBtn.classList.add("hidden"); // Hide button
        scrollTopBtn.classList.remove("fixed"); // Remove fixed positioning
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
