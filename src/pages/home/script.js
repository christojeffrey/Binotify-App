// === function ===
const fetchSongs = () => {
  const urlParams = new URLSearchParams(window.location.search);
  if (!urlParams.has("page") || !urlParams.has("limit")) {
    urlParams.set("page", 1);
    urlParams.set("limit", 10);
    window.location.search = urlParams;
  }
  const page = urlParams.get("page");
  const limit = urlParams.get("limit");

  GET_API(`../../api/song/getSongList.php?page=${page}&limit=${limit}`, null, (status, data) => {
    if (status === 200) {
      let song_list = document.getElementById("cards");
      song_list.innerHTML = "";

      // disable next page button if there is no more song
      page < data.total_page  ? document.getElementById("next-button").removeAttribute("disabled") : document.getElementById("next-button").setAttribute("disabled", true) ;

      // create div song-card-container-id
      for (let i = 0; i < data.data.length; i++) {
        // append child song_list
        song_list.innerHTML += `<div id="song-card-container-${i}"></div>`;
      }
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
              // get year from date format "YYYY--MM-DD"
              year: song.publish_date.split("-")[0],
              genre: song.genre,
              delete_from_album: false,
              add_to_album: false,
              is_admin: localStorage.getItem("admin_token") ? true : false,
            },
          },
          (status, res) => {
            if (status === 200) {
              document.getElementById(`song-card-container-${index}`).innerHTML = res;
            }
          }
        );
      });
    }
  });
};

const movePage = (isGoBack) => {
  const urlParams = new URLSearchParams(window.location.search);
  const prevPage = parseInt(urlParams.get("page"));
  urlParams.set("page", isGoBack ? prevPage - 1 : prevPage + 1);
  window.location.search = urlParams;
  fetchSongs();
};

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
        document.getElementById("player-home").innerHTML = data;
      }
    }
  );
};

// disable going back page if current home page is page 1
const urlParams = new URLSearchParams(window.location.search);
urlParams.get("page") == 1 ? document.getElementById("back-button").setAttribute("disabled", true) : document.getElementById("back-button").removeAttribute("disabled");

// if last_played is >24 hours, reset counter
if (localStorage.getItem("last_played")) {
  const lastPlayed = parseInt(localStorage.getItem("last_played"));
  const now = Date.now();
  const diff = now - lastPlayed;
  console.log(diff);
  if (diff > 86400000) {
    localStorage.setItem("counter", 0);
  }
}
// === load component ===

LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();
fetchSongs();
