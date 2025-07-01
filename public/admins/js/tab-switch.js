function switchProfilePasswordRestTab() {
    const infoWrapper = document.querySelector(".profile-info-wrapper");
    const restPasswordWrapper = document.querySelector(
        ".profile-rest-pass-wrapper"
    );
    const personalInfoTitle = document.querySelector(".personal-info-title");
    const passwordResetTitle = document.querySelector(".password-reset-title");

    infoWrapper.classList.add("hidden");
    infoWrapper.classList.remove("show-signup-wrapper");
    infoWrapper.classList.add("hide-signup-wrapper");

    restPasswordWrapper.classList.remove("hidden");
    restPasswordWrapper.classList.remove("hide-signup-wrapper");
    restPasswordWrapper.classList.add("show-signup-wrapper");

    personalInfoTitle.textContent = "Reset Password";
    passwordResetTitle.textContent = "Personal Info?";
}

function switchProfileInfoTab() {
    const infoWrapper = document.querySelector(".profile-info-wrapper");
    const restPasswordWrapper = document.querySelector(
        ".profile-rest-pass-wrapper"
    );
    const personalInfoTitle = document.querySelector(".personal-info-title");
    const passwordResetTitle = document.querySelector(".password-reset-title");

    infoWrapper.classList.remove("hidden");
    infoWrapper.classList.remove("hide-signup-wrapper");
    infoWrapper.classList.add("show-signup-wrapper");

    restPasswordWrapper.classList.add("hidden");
    restPasswordWrapper.classList.add("hide-signup-wrapper");
    restPasswordWrapper.classList.remove("show-signup-wrapper");

    personalInfoTitle.textContent = "Personal Info";
    passwordResetTitle.textContent = "Reset Password?";
}

function handleTabMenu(button) {
    const buttonValue = button.textContent.trim();

    if (buttonValue === "Reset Password?") {
        switchProfilePasswordRestTab();
    } else if (buttonValue === "Personal Info?") {
        switchProfileInfoTab();
    }
}
