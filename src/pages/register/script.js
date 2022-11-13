const WAITING_UPDATE_TIME = 1000;
// if no update email in certain seconds, do checkEmail
let emailTimer = setTimeout(checkEmail, WAITING_UPDATE_TIME);
let usernameTimer = setTimeout(checkUsername, WAITING_UPDATE_TIME);

function checkEmail() {
  let emailvalue = document.getElementById("email").value;

  if (emailvalue == "") {
    document.getElementById("emailStatus").innerHTML = "";
    return;
  }
  //   check if email format valid
  if (!emailvalue.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/)) {
    document.getElementById("email").style.borderColor = "red";
    document.getElementById("emailStatus").innerHTML = "Invalid email format";
    return;
  }

  POST_API("../../api/auth/checkIsEmailUniqueForRegister.php", null, { email: emailvalue }, (status, data) => {
    if (status === 200) {
      if (data.is_unique) {
        // document.getElementById("emailStatus").innerHTML = "email is unique";
        document.getElementById("email").style.borderColor = "green";
      } else {
        document.getElementById("emailStatus").innerHTML = "email is not unique";
        document.getElementById("email").style.borderColor = "red";
      }
    } else {
      // else, show error message
      document.getElementById("emailStatus").innerHTML = data.error;

      //   change border to red
      document.getElementById("email").style.borderColor = "red";
    }
  });
}

function updateEmail() {
  // reset emailTimer back to certain seconds
  clearTimeout(emailTimer);
  emailTimer = setTimeout(checkEmail, WAITING_UPDATE_TIME);

  //   change back state
  document.getElementById("emailStatus").innerHTML = "";
  document.getElementById("email").style.borderColor = "";
}

function checkUsername() {
  let usernamevalue = document.getElementById("username").value;

  if (usernamevalue == "") {
    document.getElementById("usernameStatus").innerHTML = "";
    return;
  }

  //   check if username length is more than 8
  if (usernamevalue.length < 3) {
    document.getElementById("username").style.borderColor = "red";
    document.getElementById("usernameStatus").innerHTML = "Username must be more than 3 characters";
    return;
  }

  POST_API("../../api/auth/checkIsUsernameUniqueForRegister.php", null, { username: usernamevalue }, (status, data) => {
    if (status === 200) {
      if (data.is_unique) {
        // document.getElementById("usernameStatus").innerHTML = "username is unique";
        document.getElementById("username").style.borderColor = "green";
      } else {
        document.getElementById("usernameStatus").innerHTML = "username is not unique";
        document.getElementById("username").style.borderColor = "red";
      }
    } else {
      // else, show error message
      document.getElementById("usernameStatus").innerHTML = data.error;

      //   change border to red
      document.getElementById("username").style.borderColor = "red";
    }
  });
}

function updateUsername() {
  // reset usernameTimer back to certain seconds
  clearTimeout(usernameTimer);
  usernameTimer = setTimeout(checkUsername, WAITING_UPDATE_TIME);

  //   change back state
  document.getElementById("usernameStatus").innerHTML = "";
  document.getElementById("username").style.borderColor = "";
}

function formSubmit() {
  // prevent reload
  event.preventDefault();

  //   get all the value
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const password2 = document.getElementById("password2").value;
  //   console.log(email, username, password, password2);

  //   check if all the field is filled
  if (name === "" || email === "" || username === "" || password === "" || password2 === "") {
    document.getElementById("status").innerHTML = "Please fill all the field";
    return;
  }

  //   check if email format valid
  if (!email.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/)) {
    document.getElementById("email").style.borderColor = "red";
    document.getElementById("emailStatus").innerHTML = "Invalid email format";
    return;
  }

  //   check if password match
  if (password !== password2) {
    document.getElementById("password").style.borderColor = "red";
    document.getElementById("password2").style.borderColor = "red";
    document.getElementById("status").innerHTML = "Password not match";
    return;
  }

  //   check if password length is more than 8
  if (password.length < 3) {
    document.getElementById("password").style.borderColor = "red";
    document.getElementById("password2").style.borderColor = "red";
    document.getElementById("status").innerHTML = "Password must be more than 3 characters";
    return;
  }

  //   check if username length is more than 8
  if (username.length < 3) {
    document.getElementById("username").style.borderColor = "red";
    document.getElementById("status").innerHTML = "Username must be more than 3 characters";
    return;
  }

  document.getElementById("status").innerHTML = "registering...";
  //   send request to register
  POST_API("../../api/auth/register.php", null, { name, email, username, password }, (status, data) => {
    if (status === 200) {
      //   set user_token to local storage
      localStorage.setItem("user_token", data.token);
      //  set username to local storage
      localStorage.setItem("username", username);
      //   redirect to pages/home-user
      window.location.href = "../home/index.php";
    } else {
      // else, show error message
      document.getElementById("status").innerHTML = data.error;
    }
  });
}

// clear status on form update
let form = document.querySelector("form");
form.addEventListener("change", function () {
  document.getElementById("status").innerHTML = "";
});
