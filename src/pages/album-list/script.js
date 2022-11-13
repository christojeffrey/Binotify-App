// Function
const fetchAlbum = () =>{
    const urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.get("page") || !urlParams.has("limit")){
        urlParams.set("page", 1);
        urlParams.set("limit", 10);
        window.location.search = urlParams;
    }
    const page = urlParams.get("page");
    const limit = urlParams.get("limit");
    const is_admin = localStorage.getItem("admin_token")? true : false;

    GET_API(`../../api/album/getAlbumList.php?page=${page}&limit=${limit}`,null, (status,data)=>{
        if(status === 200){
            let album_list = document.getElementById("albums");
            album_list.innerHTML = "";

            // disable next page button if there is no more album
            data.albums.length < limit ? document.getElementById("next-button").setAttribute("disabled", true) : document.getElementById("next-button").removeAttribute("disabled");
            

            
            for(let i = 0; i < data.albums.length; i++){
                album_list.innerHTML += `<div id="album-card-container-${i}"></div>`;
            }
            
            data.albums.forEach((album,index) => {
                let year = new Date(album.publish_date).getFullYear();
                LOAD_COMPONENT(
                    {
                        name: "albumCard",
                        args: {
                            id: `${album.album_id}`,
                            album_title: `${album.album_title}`,
                            singer: `${album.singer}`,
                            year: `${year}`,
                            genre: `${album.genre}`,
                            img: "../../assets/album-image/" + album.image_path,
                            on_click: "albumCardOnClick",
                            is_admin: `${is_admin}`,
                        }
                    },
                    (status, data) => {
                        if (status === 200){
                            document.getElementById(`album-card-container-${index}`).innerHTML += data;
                        }
                    }
                    );
                });
            }
        });
    }
    
//Pagination cr:Addin
const urlParams = new URLSearchParams(window.location.search);
urlParams.get("page") == 1 ? document.getElementById("back-button").setAttribute("disabled", true) : document.getElementById("back-button").removeAttribute("disabled");
const movePage = (isGoBack) => {
    const urlParams = new URLSearchParams(window.location.search);
    const prevPage = parseInt(urlParams.get("page"));
    urlParams.set("page", isGoBack ? prevPage - 1 : prevPage + 1);
    window.location.search = urlParams;
    fetchSongs();
    };

// Load Component
LOAD_COMPONENT(
    {
      name: "navbar",
      args: {
        is_admin: localStorage.getItem("admin_token") ? true : false,
        is_logged_in: localStorage.getItem("user_token") || localStorage.getItem("admin_token") ? true : false,
      },
    },
    (status, data) => {
      if (status === 200) {
        document.getElementById("navbar").innerHTML = data;
      }
    }
);

// load account info
LOAD_COMPONENT(
    {
      name: "accountInfo",
      args: {
        username: localStorage.getItem("username"),
      },
    },
    (status, data) => {
      if (status === 200) {
        document.getElementById("account-info").innerHTML = data;
      }
    }
  );

  LOAD_COMPONENT(
    {
      name: "accountInfo",
      args: {
        username: localStorage.getItem("username"),
      },
    },
    (status, data) => {
      if (status === 200) {
        document.getElementById("account-info").innerHTML = data;
      }
    }
  );




// // update card style
// let previd = null;
// albumCardOnClick = (id) => {
// if (previd != null) {
//     document.getElementById("album-card-" + previd).classList.remove("selected-album");
// }
// document.getElementById("album-card-" + id).classList.add("selected-album");
// console.log("selected id " + id);
// previd = id;
// };



LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();
fetchAlbum();