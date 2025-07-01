import "./echo";

// This function will handle calling the /refresh-csrf route when triggered by WebSocket
function refreshCsrfTokenAndBroadcast() {
    fetch("/refresh-csrf")
        .then((response) => response.json())
        .then((data) => {
            console.log("CSRF Token refreshed:", data.csrf_token);

            // Update the CSRF token in the meta tag
            document
                .querySelector('meta[name="csrf-token"]')
                .setAttribute("content", data.csrf_token);
        })
        .catch((error) => console.error("Error refreshing CSRF token:", error));
}

// refreshCsrfTokenAndBroadcast();
window.Echo.channel("csrf-token").listen("CsrfUpdate", (data) => {
    console.log("Received CSRF Token:", data);
    document
        .querySelector('meta[name="csrf-token"]')
        .setAttribute("content", data.csrfToken);
});
