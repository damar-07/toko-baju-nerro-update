const container = document.getElementById('container');
const registerBtn = document.getElementById('sign-up');
const loginBtn = document.getElementById('sign-in');
const BelumBtn = document.getElementById('belum');

function toggleForm(formType) {
    if (formType === 'sign-up') {
        container.classList.add("active");
    } else {
        container.classList.remove("active");
    }
}

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

BelumBtn.addEventListener('click', () => {
    container.classList.add("active");
});
