const addAlbum = () => {
    const album_title = document.getElementById('album-title').value;
    const singer = document.getElementById('singer').value;
    const publish_date = document.getElementById('publish-date').value;
    const genre = document.getElementById('genre').value;

    var image_file_name;
    const image_files = document.getElementById('image-file').files;
    if (image_files.length > 0) {
        var formData = new FormData();
        const image_file = image_files[0];
        const image_file_ext = image_file.name.split('.').pop();

        formData.append("file", image_files[0]);
        image_file_name = Date.now() + "." + image_file_ext

        UPLOAD_API('../../api/upload/fileUpload.php?type=album-image&name=' + image_file_name, token, formData,(status, data) => {
            if (status !== 200) {
                alert("error uploading image");
                return;
            }
        })
    }

    const body = {
        "album_title": album_title,
        "singer": singer,
        "publish_date": publish_date,
        "genre": genre,
        "image_path": image_file_name,
    }

    POST_API('../../api/album/addAlbum.php', token, body,  (status, data) => {
        if (status === 200) {
            // if success, show success message
            alert("success");
            window.location.href = "../album-list/index.php";
        } else {
            // if fail, show error message
            alert(data.error);
        }
    })
}

const onChange = () => {
    const [file] = document.getElementById("image-file").files;
    if (file) {
      document.getElementById("album-image").src = URL.createObjectURL(file);
    }
  }

checkTokenOnPageLoad(true);
LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();
getGenreList()