
    const username_Input = document.getElementById('name');
    const name_error_message = document.getElementById('name_error_message');
    const username_Regex = /^\w{4,20}$/;

    username_Input.addEventListener('input', function () {
      const username = username_Input.value.trim();
      if (username_Regex.test(username)) {
        username_Input.classList.remove('is-invalid');
        username_Input.classList.add('is-valid');
        name_error_message.style.display = 'none';
      } else {
        username_Input.classList.remove('is-valid');
        username_Input.classList.add('is-invalid');
        name_error_message.style.display = 'block';
      }
      if (!/(?=.{4,20})/.test(username)) {
        name_error_message.innerHTML = 'Username must be at least 4 characters or numbers and at most 20 characters or numbers';
      }
      
    });

    const Email_Input = document.getElementById('email');
    const email_error_message = document.getElementById('email_error_message');
    const Email_Regex = /^([\w.]+)@((\[[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3})|(([\w]+\.)+))([a-zA-Z]{2,4}|[\d]{1,3})(\]?)$/;

    Email_Input.addEventListener('input', function () {
      const Email = Email_Input.value.trim();
      if (Email_Regex.test(Email)) {
        Email_Input.classList.remove('is-invalid');
        Email_Input.classList.add('is-valid');
        email_error_message.style.display = 'none';
      } else {
        Email_Input.classList.remove('is-valid');
        Email_Input.classList.add('is-invalid');
        email_error_message.innerHTML = 'Invalid email address';
        email_error_message.style.display = 'block';
      }
    });

    const password_Input = document.getElementById('password');
    const password_error_message = document.getElementById('password_error_message');
    const password_Regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W])[a-zA-Z\d\W]{8,}$/;

    password_Input.addEventListener('input', function () {
      const Password = password_Input.value.trim();
      if (password_Regex.test(Password)) {
        password_Input.classList.remove('is-invalid');
        password_Input.classList.add('is-valid');
        password_error_message.style.display = 'none';
      } else {
        password_Input.classList.remove('is-valid');
        password_Input.classList.add('is-invalid');
        password_error_message.style.display = 'block';
      }
      if (!/(?=.*[a-z])/.test(Password)) {
        password_error_message.innerHTML = 'Password must contain at least one lowercase letter';
      } else if (!/(?=.*[A-Z])/.test(Password)) {
        password_error_message.innerHTML = 'Password must contain at least one uppercase letter';
      }
      else if (!/(?=.*\d)/.test(Password)) {
        password_error_message.innerHTML = 'Password must contain at least one number';
      }
      else if (!/(?=.*[\W])/.test(Password)) {
        password_error_message.innerHTML = 'Password must contain at least one special character';
      }
      else if (!/(?=.{8,})/.test(Password)) {
        password_error_message.innerHTML = 'Password must be at least 8 characters or numbers';
      }
    });

    const passwordInput = document.getElementById('password');
    const confirm_password_error_message = document.getElementById('confirm_password_error_message');
    const confirmInput = document.getElementById('confirm_password');

    confirmInput.addEventListener('input', function () {
      const password = passwordInput.value.trim();
      const confirm = confirmInput.value.trim();
      if (confirm === password && password !== '') {
        confirmInput.classList.remove('is-invalid');
        confirmInput.classList.add('is-valid');
        confirm_password_error_message.style.display = 'none';
      } else {
        confirmInput.classList.remove('is-valid');
        confirmInput.classList.add('is-invalid');
        confirm_password_error_message.innerHTML = 'Password does not match';
        confirm_password_error_message.style.display = 'block';
      }
    });

