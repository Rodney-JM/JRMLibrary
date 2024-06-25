document.addEventListener("DOMContentLoaded", () => {
    const addBtn = document.querySelector("#btnAdd");
    const formContainer = document.querySelector(".form_container");
    const exitButton = document.querySelector(".fa-circle-xmark");
    const editBtns = document.querySelectorAll(".editBtn");

    function activateFormContainer() {
        formContainer.classList.remove('active');
    }

    if (addBtn && formContainer && exitButton && editBtns.length >= 0) {
        addBtn.addEventListener('click', activateFormContainer);
    } else {
        console.error("Um ou mais elementos não foram encontrados.");
    }

    // Verifica se há um 'id' na URL e ativa o formulário se encontrado
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (id) {
        formContainer.classList.remove('active');
    }
});