function formSubmit() {
  // get username from id username
  const username = document.getElementById("username").value;
  // get password from id password
  const raw_password = document.getElementById("password").value;
  
  if (username === "" || raw_password === "") {
    document.getElementById("status").innerHTML = "Please fill all the field";
    return;
  }
  
  // hash password
  const password = sha256(raw_password)
  
  document.getElementById("status").innerHTML = "logging in...";
  POST_API("../../api/auth/login.php", null, { username, password }, (status, data) => {
    if (status === 200) {
      // if status is 200, redirect to index.html
      console.log("data: " + data);
      // check if user_token or admin_token
      if (data.user_token) {
        // set user_token to local storage
        localStorage.setItem("user_token", data.user_token);
        // redirect to pages/home-user
      } else if (data.admin_token) {
        // set admin_token to local storage
        localStorage.setItem("admin_token", data.admin_token);
        // set username to local storage
      }
      localStorage.setItem("username", username);
      localStorage.setItem("id", data.id);
      window.location.href = "../home/index.php";
    } else {
      // else, show error message
      document.getElementById("status").innerHTML = data.error;
    }
  });
}

let form = document.querySelector("form");
form.addEventListener("change", function () {
  document.getElementById("status").innerHTML = "";
});
