document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get('errorMessage');

    if (errorMessage) {
        const errorDiv = document.getElementById('error-message');
        if (errorMessage === 'wrongPassword') {
            errorDiv.textContent = 'Senha incorreta. Por favor, tente novamente.';
        } else if (errorMessage === 'emailNotFound') {
            errorDiv.textContent = 'Email não encontrado. Por favor, verifique o email e tente novamente.';
        }
        errorDiv.style.display = 'block';
    }
});