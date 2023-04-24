const passwordInput = document.getElementById('password');
const showPasswordButton = document.getElementById('show-password');

showPasswordButton.addEventListener('click', function() {
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    showPasswordButton.classList.add('visible');
  } else {
    passwordInput.type = 'password';
    showPasswordButton.classList.remove('visible');
  }
});
