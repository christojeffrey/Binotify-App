// === function ===
const fetchSongs = () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.has("creator_id") || !urlParams.has("singer_name")) {
        window.location.href = "/home";
    }
    const creator_id = parseInt(urlParams.get("creator_id"));
    const singer_name = urlParams.get("singer_name");

    document.getElementById("singer-name").innerHTML = singer_name + "'s Premium Songs";

    const user_id = parseInt(localStorage.getItem("id"));

    const body = {
        "creator_ids" : [creator_id],
        "subscriber_id" : user_id,
    }

    

    POST_API(`http://binotify_rest:3000/song/premium`, null, body, (status, data) => {
        if (status === 200){
            console.log(data);
            let song_list = document.getElementById("cards");
            song_list.innerHTML = "";

            // create div song-card-container-id
            for (let i = 0; i < data.songs.length; i++) {
                // append child song_list
                song_list.innerHTML += `<div id="song-card-container-${i}"></div>`;
            }

            data.songs.forEach((song, index) => {
                console.log(song.title)
                LOAD_COMPONENT(
                    {
                        name:"premiumSongCard",
                        args: {
                            id: `${song.song_id}`,
                            title: `${song.title}`,
                            audio_path: `${song.audio_path}`,
                            on_click: "premiumSongCardOnClick",
                        }
                    },
                    (status, res) => {
                        if (status === 200) {
                            document.getElementById(`song-card-container-${index}`).innerHTML = res;
                        }
                    }
                )
            });

        } else {
            alert("Internal server error");
        }
    })
}

let previd = null;

const premiumSongCardOnClick = (id, title, audio_path) => {
    if (previd != null){
        document.getElementById("song-card-" + previd).classList.remove("selected-song");
    }

    document.getElementById("song-card-" + id).classList.add("selected-song");
    previd = id;
    
    LOAD_COMPONENT(
        {
            name: "player",
            args: {
                id: id,
                title: title,
                audio_path: `http://binotify_rest:3000/song/${audio_path}`,
            }
        },
        (status, data) => {
            if(status === 200) {
                document.getElementById("player-home").innerHTML = data;
            }
        }
    )
        
}

LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();
fetchSongs();