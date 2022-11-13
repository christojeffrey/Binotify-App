// load navbar
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

let filterText = "";
let sortText = "";
let option;
let search_text;
let filter;
let sort;
function onSearchClick() {
  // get option
  option = document.getElementById("search-option").value;
  // get search text
  search_text = document.getElementById("search-text").value;

  // get filter
  filter = document.getElementById("filter").value;
  if (filter !== "") {
    filterText = "&filter_by=" + filter;
  }

  // get sort
  sort = document.getElementById("sort").value;
  if (sort !== "") {
    sortText = "&sort=" + sort;
  }

  fetchSongs();
}

let page = 1;
function fetchSongs() {
  POST_API(`../../api/song/searchSong.php?page=${page}&limit=10${sortText}${filterText}`, null, [{ search_key: option, search_value: search_text }], (status, data) => {
    if (status === 200) {
      let song_list = document.getElementById("song-list");
      // append child song_list
      song_list.innerHTML = "";
      for (let i = 0; i < data.data.length; i++) {
        // append child song_list
        song_list.innerHTML += `<div id="song-card-container-${i}"></div>`;
      }
      if (data.data.length === 0) {
        song_list.innerHTML += `<div class="no-result-text">No result found</div>`;
      } else{
          data.data.forEach((song, index) => {
            LOAD_COMPONENT(
              {
                name: "songCard",
                args: {
                  id: `${song.song_id}`,
                  title: `${song.song_title}`,
                  artist: `${song.singer}`,
                  audio_path: "../../assets/song-audio/" + song.audio_path,
                  img: SONG_IMAGE_PATH + song.image_path,
                  on_click: "songCardOnClick",
                  genre: song.genre,
                },
              },
              (status, res) => {
                if (status === 200) {
                  console.log("index", index);
                  document.getElementById("song-card-container-" + index).innerHTML = res;
                }
              }
            );
          });
      }


      // if total page > 0, show pagination
      if (data.total_page > 0) {
        document.getElementById("pagination").innerHTML = "";

        if (page > 1) {
          // add prev button
          document.getElementById("pagination").innerHTML += `
         <button onclick="onPrevClick()" class="move-page-button flex justify-center items-center"
        id="back-button">
        <img class="prevnexticon" src="../../assets/icons/prev.svg" alt="prev" />
    </button>`;
        }
        if (page < data.total_page) {
          // add next button
          document.getElementById("pagination").innerHTML += `<button onclick="onNextClick()" class="move-page-button flex justify-center items-center  "
          id="next-button"> <img class="prevnexticon" src="../../assets/icons/next.svg" alt="next" />
      </button> 
        `;
        }
      }
    }
  });
}

function onPrevClick() {
  page--;
  fetchSongs();
}
function onNextClick() {
  page++;
  fetchSongs();
}
// update card style
let previd = null;
const songCardOnClick = (id, title, singer, audio_path, img) => {
  // if there is no counter in local variable, set play counter to 1
  if (!localStorage.getItem("counter") || !localStorage.getItem("last_played")) {
    localStorage.setItem("counter", 1);
    localStorage.setItem("last_played", Date.now());
  } else {
    const prevCounter = parseInt(localStorage.getItem("counter"));
    // check if the user is authenticated by checking user_token and admin_token in local storage
    if (!localStorage.getItem("user_token") && !localStorage.getItem("admin_token")) {
      // if the counter is more than 3, show alert
      if (prevCounter >= 3) {
        alert("You have played more than 3 songs today. Please login to continue listening");
        return;
      }
    }
    localStorage.setItem("counter", prevCounter + 1);
    localStorage.setItem("last_played", Date.now());
  }
  if (previd != null) {
    document.getElementById("song-card-" + previd).classList.remove("selected-song");
  }

  document.getElementById("song-card-" + id).classList.add("selected-song");

  console.log("selected id " + id);
  previd = id;
  LOAD_COMPONENT(
    {
      name: "player",
      args: {
        id: id,
        title: title,
        singer: singer,
        audio_path: audio_path,
        img: img
      },
    },
    (status, data) => {
      if (status === 200) {
        document.getElementById("player").innerHTML = data;
      }
    }
  );
};
