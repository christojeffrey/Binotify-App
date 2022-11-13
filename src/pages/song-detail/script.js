token = localStorage.getItem("user_token") || localStorage.getItem("admin_token");
if (!localStorage.getItem("admin_token")) {
  document.getElementById("button-container").hidden = true;
}

LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();

// get song id from query
const urlParams = new URLSearchParams(window.location.search);
const song_id = urlParams.get("song_id");

// load song detail from getSongDetail
GET_API(`../../api/song/getSongDetail.php?song_id=${song_id}`, null, (status, data) => {
  if (status === 200) {
    // set song title
    document.getElementById("song-title").innerText = data.song_title;
    // set song singer
    document.getElementById("singer").innerText = data.singer;
    // set song publish date
    document.getElementById("date-genre").innerText = data.publish_date + " • " + data.genre;
    // set song duration
    document.getElementById("duration").innerText = durationConverter(data.duration);

    // set song image
    document.getElementById("song-image").setAttribute("src", SONG_IMAGE_PATH + data.image_path);

    document.getElementById("edit-hyperlink").href = `../update-song/index.php?song_id=${data.song_id}`

    if (data.album_id) {
      document.getElementById("ref-to-album-detail-page").innerHTML = data.album_title;
      document.getElementById("ref-to-album-detail-page").setAttribute("href", `../album-detail/index.php?album_id=${data.album_id}`);
    } else {
      document.getElementById("ref-to-album-detail-page-button").setAttribute("hidden", true);

    }
    // load song player
    if (!localStorage.getItem("counter") || !localStorage.getItem("last_played")) {
      localStorage.setItem("counter", 1);
      localStorage.setItem("last_played", Date.now());
    } else {
      const prevCounter = parseInt(localStorage.getItem("counter"));
      // check if the user is authenticated by checking user_token and admin_token in local storage
      if ((!localStorage.getItem("user_token") && !localStorage.getItem("admin_token")) && prevCounter >= 3) {
        alert("You have")
      } else {
        // if the counter is more than 3, show alert
        localStorage.setItem("counter", prevCounter + 1);
        localStorage.setItem("last_played", Date.now());
        LOAD_COMPONENT(
          {
            name: "player",
            args: {
              id: song_id,
              title: data.song_title,
              singer: data.singer,
              audio_path: "../../assets/song-audio/" + data.audio_path,
              img: SONG_IMAGE_PATH + data.image_path
            },
          },
          (status, data) => {
            if (status === 200) {
              document.getElementById("player").innerHTML = data;
            }
          }
        );
      }
    }

  }
});

const deleteSong = () => {
  GET_API(`../../api/song/deleteSong.php?song_id=${song_id}`, token, (status, data) => {
      if (status === 200) {
          alert("Song deleted successfully");
          window.location.href = "../home/index.php";
      } else {
          alert(data.error);
      }
  })
}