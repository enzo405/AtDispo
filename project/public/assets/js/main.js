function initPasswordToggle() {
    const togglePassword = document.querySelector(".toggle-password");
    const passwordField = document.querySelector("#passwordField");

    togglePassword.addEventListener("click", function () {
        const type =
            passwordField.getAttribute("type") === "password"
                ? "text"
                : "password";
        passwordField.setAttribute("type", type);

        const icon = type === "password" ? "fa-eye" : "fa-eye-slash";
        togglePassword.querySelector("i").className = `fa ${icon}`;
    });
}

// Call the function when the DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    initPasswordToggle();
});

async function confirmAction(event) {
    event.preventDefault(); // Stop la soumission du formulaire

    // Affiche une modale avec les boutons de sur-validations
    var confirmation = await createConfirmationBox(
        "Êtes-vous sûr de continuer?",
        "confirm"
    );

    // Si oui alors on valide le formulaire
    if (confirmation) {
        // Append hidden input for the clicked button
        var clickedButton = event.submitter;
        var buttonName = clickedButton.name;
        var hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = buttonName;
        hiddenInput.value = "true";
        event.target.appendChild(hiddenInput);

        // Submit the form
        event.target.submit();
    }
}

function createConfirmationBox(content, type) {
    return new Promise(resolve => {
        const modal = document.createElement("div");
        const contentModal = document.createElement("div");
        const titleModal = document.createElement("h4");
        const yesButton = document.createElement("button");
        const noButton = document.createElement("button");

        titleModal.textContent = content;
        yesButton.textContent = "Oui";
        noButton.textContent = "Non";

        yesButton.classList.add("yes-btn");
        noButton.classList.add("no-btn");
        modal.classList.add("modal");
        contentModal.classList.add("modal-content", type);
        contentModal.appendChild(titleModal);

        yesButton.addEventListener("click", () => {
            document.body.removeChild(modal);
            resolve(true); // Resolve the Promise with true if user clicks "Yes"
        });
        contentModal.appendChild(yesButton);

        noButton.addEventListener("click", () => {
            document.body.removeChild(modal);
            resolve(false); // Resolve the Promise with false if user clicks "No"
        });
        contentModal.appendChild(noButton);

        modal.appendChild(contentModal);
        document.body.appendChild(modal);
    });
}
