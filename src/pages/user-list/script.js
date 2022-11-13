// load user list
// admin_token is required
const getUserList = () => {
  GET_API("../../api/auth/getAllUsers.php", token, (status, data) => {
    if (status === 200) {
      let user_list = document.getElementById("user-list");
      user_list.innerHTML = "";
      data.forEach((user) => {
        LOAD_COMPONENT(
          {
            name: "userCard",
            args: {
              username: `${user.username}`,
              email: `${user.email}`,
              is_admin: `${user.is_admin}`,
              name: `${user.name}`,
            },
          },
          (status, data) => {
            if (status === 200) {
              user_list.innerHTML += data;
            }
          }
        );
      });
    }
  });
}



checkTokenOnPageLoad(true);
console.log(token)
LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();
getUserList();