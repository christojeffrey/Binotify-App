checkTokenOnPageLoad(false);


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

// get album id from query
const urlParams = new URLSearchParams(window.location.search);
const album_id = urlParams.get("album_id");


// load song detail from getSongDetail
GET_API(`../../api/album/getAlbumByID.php?album_id=${album_id}&song_detailed=1`, token, (status, data) => {
  if (status === 200) {
    let year = new Date(data.publish_date).getFullYear();
    // album_title
    document.getElementById("album-title").innerText = data.album_title;
    document.getElementById("album-title").title = data.album_title;

    // singer
    document.getElementById("singer").innerText = data.singer;
    // total_duration
    document.getElementById("total-duration").innerText = durationConverter(data.total_duration);
    // publish_date
    document.getElementById("publish-year").innerText = year;
    //image_path
    document.getElementById("album-image").src = "../../assets/album-image/" + data.image_path;
    //song_count
    document.getElementById("song-count").innerText = data.song_count;
    
    //anchor tag edit
    document.getElementById("edit-hyperlink").href = `../update-album/index.php?album_id=${album_id}`

    // for each song in album, show songCard
    data.songs.forEach((song) => {
      LOAD_COMPONENT(
        {
          name: "songCard",
          args: {
            id: song.song_id,
            title: song.song_title,
            artist: song.singer,
            audio_path: "../../assets/song-audio/" + song.audio_path,
            img: SONG_IMAGE_PATH + song.image_path,
            on_click: "songCardOnClick",
            genre: song.genre,
          },
        },
        (status, data) => {
          if (status === 200) {
            document.getElementById("song-list").innerHTML += data;
          }
        }
      );
    });
  }
});

const deleteAlbum = () => {
  const urlParams = new URLSearchParams(window.location.search);
  const album_id = urlParams.get("album_id");
  const token = localStorage.getItem("user_token") || localStorage.getItem("admin_token");
  if (confirm("Are you sure you want to delete this album?")) {
    GET_API(`../../api/album/deleteAlbum.php?album_id=${album_id}`, token, (status, data) => {
      if (status === 200) {
        window.location.href = "../album-list/index.php";
      }
    });
  }
}

if (!localStorage.getItem("admin_token")) {
  document.getElementById("button-container").hidden = true;
}

LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();