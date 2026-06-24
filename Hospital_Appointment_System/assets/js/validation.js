document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('form[data-validate="true"]');
  forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
      const email = form.querySelector('input[type="email"]');
      if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        event.preventDefault();
        alert('Please enter a valid email address.');
        return;
      }
      const password = form.querySelector('input[name="password"]');
      if (password && password.value.length < 6) {
        event.preventDefault();
        alert('Password must be at least 6 characters long.');
      }
    });
  });
});
