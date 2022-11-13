
// get song id from url parameter query
const urlParams = new URLSearchParams(window.location.search);
const song_id = urlParams.get("song_id");

// function to fill the form with the song data to be updated
// song data are fetched from backend
const prefillForm = () => {
    GET_API(`../../api/song/getSongDetail.php?song_id=${song_id}`, token, (status, data) => {
        // fill the form fields with the song data
        if (status === 200) {
            document.getElementById("song-title").value = data.song_title;
            document.getElementById("singer").value = data.singer;
            document.getElementById(`genre-option-${data.genre}`).setAttribute("selected", true);
            data.album_id != null ? 
                document.getElementById(`album-option-${data.album_id}`).setAttribute("selected", true)
            :
                document.getElementById("album-option-none").setAttribute("selected", true);
            document.getElementById("song-image").setAttribute("src", SONG_IMAGE_PATH + data.image_path);

            const publish_date = new Date(data.publish_date);
            document.getElementById("publish-date").value = publish_date.toDateInputValue();


        } else {
            alert("Error fetching song data");
        }

    })
}


const onChange = () => {
    const [file] = document.getElementById("image-file").files;
    if (file) {
      document.getElementById("song-image").src = URL.createObjectURL(file);
    }
  }

const updateSong = () => {
    // get the form data
    const song_title = document.getElementById("song-title").value;
    const singer = document.getElementById("singer").value;
    const album_id = document.getElementById("album-id").value;
    const publish_date = document.getElementById("publish-date").value;
    const genre = document.getElementById("genre").value;
    const duration = 10;
    
    const unique_file_name = Date.now()

    var audio_file_name;
    const audio_files = document.getElementById('audio-file').files;
    if (audio_files.length > 0) {
        var formData = new FormData();
        const audio_file = audio_files[0];
        const auio_file_ext = audio_file.name.split('.').pop();

        formData.append('file', audio_file);
        audio_file_name = unique_file_name + "." + auio_file_ext

        UPLOAD_API('../../api/upload/fileUpload.php?type=song-audio&name=' +  audio_file_name, token, formData,  (status, data) => {
            if (status !== 200) {
                alert("error uploading audio");
                return;
            }
        })
    }

    var image_file_name;
    const image_files = document.getElementById('image-file').files;
    if (image_files.length > 0) {
        var formData = new FormData();
        const image_file = image_files[0];
        const image_file_ext = image_file.name.split('.').pop();

        formData.append("file", image_files[0]);
        image_file_name = unique_file_name + "." + image_file_ext

        UPLOAD_API('../../api/upload/fileUpload.php?type=song-image&name=' + image_file_name, token, formData,(status, data) => {
            if (status !== 200) {
                alert("error uploading image");
                return;
            }
        })
    }




    const body = {
        "song_id": song_id,
        "song_title": song_title,
        "singer": singer,
        "publish_date": publish_date,
        "genre": genre,
        "audio_path": audio_file_name ? audio_file_name : null,
        "image_path": image_file_name ? image_file_name : null,
        "duration": duration,
        "album_id": album_id
    }
    POST_API("../../api/song/updateSongDetail.php", token, body, (status, data) => {
        if (status === 200) {
            alert("Song updated successfully");
            window.location.href = "../song-detail/index.php?song_id=" + song_id;
        } else {
            alert("Error updating song");
        }
    })
}

checkTokenOnPageLoad(true);
getAlbumList();
getGenreList();
LOAD_NAVBAR()
LOAD_ACCOUNT_INFO()
prefillForm();