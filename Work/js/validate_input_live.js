
    const username_Input = document.getElementById('name');
    const username_Regex = /^\w{4,20}$/;

    username_Input.addEventListener('input', function () {
      const username = username_Input.value.trim();
      if (username_Regex.test(username)) {
        username_Input.classList.remove('is-invalid');
        username_Input.classList.add('is-valid');
      } else {
        username_Input.classList.remove('is-valid');
        username_Input.classList.add('is-invalid');
      }
    });

    const Email_Input = document.getElementById('email');
    const Email_Regex = /^([\w.]+)@((\[[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3})|(([\w]+\.)+))([a-zA-Z]{2,4}|[\d]{1,3})(\]?)$/;

    Email_Input.addEventListener('input', function () {
      const Email = Email_Input.value.trim();
      if (Email_Regex.test(Email)) {
        Email_Input.classList.remove('is-invalid');
        Email_Input.classList.add('is-valid');
      } else {
        Email_Input.classList.remove('is-valid');
        Email_Input.classList.add('is-invalid');
      }
    });

    const password_Input = document.getElementById('password');
    const password_Regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W])[a-zA-Z\d\W]{8,}$/;

    password_Input.addEventListener('input', function () {
      const Password = password_Input.value.trim();
      if (password_Regex.test(Password)) {
        password_Input.classList.remove('is-invalid');
        password_Input.classList.add('is-valid');
      } else {
        password_Input.classList.remove('is-valid');
        password_Input.classList.add('is-invalid');
      }
    });

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm_password');

    confirmInput.addEventListener('input', function () {
      const password = passwordInput.value.trim();
      const confirm = confirmInput.value.trim();
      if (confirm === password && password !== '') {
        confirmInput.classList.remove('is-invalid');
        confirmInput.classList.add('is-valid');
      } else {
        confirmInput.classList.remove('is-valid');
        confirmInput.classList.add('is-invalid');
      }
    });

