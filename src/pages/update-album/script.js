let prev_image_path = "";
let album_id = 0;
let prev_singer = "";

const fetchAlbum = () => {
  // get album id from query
  const urlParams = new URLSearchParams(window.location.search);
  album_id = urlParams.get("album_id");
  
  const token = localStorage.getItem("user_token") || localStorage.getItem("admin_token");
  
  // load song detail from getSongDetail
  GET_API(`../../api/album/getAlbumByID.php?album_id=${album_id}&song_detailed=1`,token, (status, data) => {
    if (status === 200) {
      prev_image_path = data.image_path;

      // image_path
      document.getElementById("album-image").src = "../../assets/album-image/" + data.image_path;
  
      // album_title
      document.getElementById("album-title").value = data.album_title;
  
      // singer
      document.getElementById("singer").value = data.singer;
      document.getElementById("singer-modal").innerHTML = data.singer;

      // publish_date
      console.log(data.publish_date);
      document.getElementById("publish-date").value = new Date(data.publish_date).toDateInputValue();

      // genre
      document.getElementById("genre").value = capitalizeFirstLetter(data.genre);

      // for each song in album, show songCard
      data.songs.forEach((song) => {
        LOAD_COMPONENT(
          {
            name: "songCard",
            args: {
              id: song.song_id,
              title: song.song_title,
              artist: song.singer,
              publish_date: song.publish_date,
              duration: song.duration,
              audio_path: song.audio_path,
              img: SONG_IMAGE_PATH + song.image_path,
              image_path: song.image_path,
              genre: song.genre,
              delete_from_album: true,
              on_click_delete: "onClickDelete",
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
}


const onClickDelete = (song_id, song_title, singer, publish_date, genre, audio_path, image_path,duration) => {
  const body = {
    "song_id": song_id,
    "song_title": song_title,
    "singer": singer,
    "publish_date": publish_date,
    "genre": genre,
    "duration": duration,
    "album_id": null,
  }
  const token = localStorage.getItem("user_token") || localStorage.getItem("admin_token");
  POST_API('../../api/song/updateSongDetail.php?delete-album=1', token, body, (status, data) => {
    if (status === 200) {
      window.location.reload();
    }
  });
}

const fetchModalData = () => {
  const token = localStorage.getItem("user_token") || localStorage.getItem("admin_token");
  GET_API('../../api/song/getSongByAlbumSinger.php?album-id='+album_id+'&album-free=1', token, (status, data) => {
    if (status === 200) {
      // for each song, show songCard
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
              on_click_add: "onClickAdd",
              genre: song.genre,
              new_album_id: album_id,
              add_to_album: true,
              publish_date: song.publish_date,
              duration: song.duration,
            },
          },
          (status, data) => {
            if (status === 200) {
              document.getElementById("song-list-modal").innerHTML += data;
            }
          }
        );
      });
    }
  });
}

const onClickAdd = (song_id, song_title, singer, publish_date, genre, audio_path, image_path,duration, album_id) => {
  const body = {
    "song_id": song_id,
    "song_title": song_title,
    "singer": singer,
    "publish_date": publish_date,
    "genre": genre,
    "duration": duration,
    "album_id": album_id,
  }
  const token = localStorage.getItem("user_token") || localStorage.getItem("admin_token");
  POST_API('../../api/song/updateSongDetail.php?', token, body, (status, data) => {
    if (status === 200) {
      window.location.reload();
    }
  });
}

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

// Timezone support
Date.prototype.toDateInputValue = (function() {
  var local = new Date(this);
  local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
  return local.toJSON().slice(0,10);
});

const onChange = () => {
  const [file] = document.getElementById("image-file").files;
  if (file) {
    document.getElementById("album-image").src = URL.createObjectURL(file);
  }
}

const updateAlbum = () => {
  const album_title = document.getElementById("album-title").value;
  const singer = document.getElementById("singer").value;
  const publish_date = document.getElementById("publish-date").value;
  const genre = document.getElementById("genre").value;

  const image_files = document.getElementById("image-file").files;

  let image_path = prev_image_path

  if (image_files.length > 0 ){
    image_path = image_files[0].name;
    let formData = new FormData();

    formData.append("file", image_files[0]);
    UPLOAD_API('../../api/upload/fileUpload.php?type=album-image&name=' + image_path, token, formData,(status, data) => {
      if (status !== 200) {
          alert("error uploading image");
          return;
      }
  })
  }
  const body = {
    "album_id": album_id,
    "album_title": album_title,
    "singer": singer,
    "publish_date": publish_date,
    "genre": genre,
    "image_path": image_path,
  }

  POST_API('../../api/album/updateAlbum.php', token, body, (status, data) => {
    if (status === 200) {
        // if success, show success message
        alert("Album updated succesfully")
        window.location.href = `../album-detail/index.php?album_id=${album_id}`;
        // document.getElementById('add-song-form-container').reset();
    } else {
        // else, show error message
        alert("error")
    }
});





}


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

// Get the modal
var modal = document.getElementById("modal");

// Get the button that opens the modal
var btn = document.getElementById("plus-button");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}



checkTokenOnPageLoad(true);
getGenreList();
fetchAlbum(); 
fetchModalData();