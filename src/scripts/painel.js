const addBtn = document.querySelector("#btnAdd");
const formContainer = document.querySelector(".form_container");
const exitButton = document.querySelector(".fa-circle-xmark");

addBtn.addEventListener('click', ()=>{
    formContainer.classList.remove('active');
})

exitButton.addEventListener('click', ()=>{
    formContainer.classList.add('active');
})