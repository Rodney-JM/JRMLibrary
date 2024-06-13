const password = document.querySelector("#senha");
const passwordConfirm = document.querySelector("#senhaConfirm");
const btn = document.querySelector("#btn");
const form = document.querySelector("#form");

function verifyPasswordConfirmation(event) {

    if (password.value !== passwordConfirm.value) {
        event.preventDefault();
        let text = document.createElement("p");
        text.textContent = "As senhas não se coincidem, tente novamente!";
        text.style.color = "red";
        form.appendChild(text);
        passwordConfirm.style.borderColor = "red";
        passwordConfirm.style.borderWidth = "3px";
    }
}
btn.addEventListener('click', verifyPasswordConfirmation);

document.addEventListener("DOMContentLoaded", ()=> {
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get('errorMessage');

    if (errorMessage) {
        const errorDiv = document.getElementById('error-message');
        if (errorMessage === 'cdtEx') {
            errorDiv.textContent = 'O email fornecido já está cadastrado.';
            errorDiv.style.display = 'block';
        }
    }
});