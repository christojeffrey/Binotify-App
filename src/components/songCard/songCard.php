<?php
    function songCard($args) {

    // titlecolor is green is the song is selected
        // $id, $title, $artist, $audio_path, $img, on_click, $genre, $delete_from_album, $add_to_album, $year
        extract($args);
    // titlecolor is green is the song is selected
        
 
    // // if is admin, show the edit button
    // $edit_button = "";
    // if ($is_admin) {
    //     $edit_button = <<<EOT
    //         <div class="song-card-button">
    //             <a href="../update-song/index.php?song_id=$id">
    //                 <img class="play-edit-button" src="../../assets/icons/edit.svg" alt="Edit"/>
    //             </a>
    //         </div>
    //     EOT;
    // }

    $play_button = <<<EOT
    <button onclick = "$on_click($id, '$title', '$artist', '$audio_path', '$img')" class = "button">
        <img class="play-edit-button" src="../../assets/icons/play.svg" alt="Play"/>
    </button>
    EOT;

    $delete_button = "";
    if ($delete_from_album){
        $delete_button = 
        <<<EOT
        <button onclick="$on_click_delete($id, '$title', '$artist', '$publish_date', '$genre', '$audio_path', '$image_path', $duration)" class="erase-button button">
            <img class="" src="../../assets/icons/delete.svg" alt="Edit"/>
        </button>
        EOT;
        $play_button = "";
    }

    $add_button = "";
    if ($add_to_album){
        $add_button = 
        <<<EOT
        <button onclick="$on_click_add($id, '$title', '$artist', '$publish_date', '$genre', '$audio_path', '$image_path', $duration,$new_album_id)">
            <img class="add-button" src="../../assets/icons/plus.svg" alt="Add"/>
        </button>
        EOT;
        $play_button = "";
    }

    $html = 
    <<<"EOT"
        <style>

        .play-edit-button {
            width:20px;
            filter: invert(81%) sepia(15%) saturate(8%) hue-rotate(357deg) brightness(87%) contrast(89%);

        }
        .button {
            margin: 0 0.5rem;
        }
        .selected-song {
            background-color: green;
        }
        .song-card-information-container {
            display: flex;
            justify-content: space-between;
            width: 70%;
        }
        .song-card-container{
            display: flex;
            flex-direction: row;
            margin: 2px;
            padding: 1px;
            width: 100%;
            justify-content: space-between;
            margin: 30px 0px;
        }
        .song-card-container:hover {
            background-color: #464646;
        }

        .ref-to-song-detail-container {
            display: flex;
            flex: 1;
            flex-direction: row;
            justify-content: flex-start;
        }

        .song-card-button {
            padding: 10px;
        }
        .song-card-button-container {
            margin-right: 30px;
            display: flex;
            align-self: center;
        }

        .song-image {
            width: 50px;
            height: 50px;
            align-self: center;
        }
        
        .title{
            font-weight: bold;
        }
        
        .song-text{
            width: 100%;
            margin-left: 15px;
            padding: 5px;
        }

        .erase-button{
            background-color: transparent;
        }
        .erase-button img{
            width: 1.5rem;
            height: 1.5rem;
            cursor: pointer;
            margin-left: auto;
            margin-top: auto;
            background-color: transparent;
            filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(115deg) brightness(113%) contrast(101%);
        }

        .erase-button img:hover{
            filter: invert(15%) sepia(80%) saturate(6424%) hue-rotate(358deg) brightness(110%) contrast(115%)
        }

        .add-button{
            width: 1.5rem;
            height: 1.5rem;
            cursor: pointer;
            margin-left: auto;
            margin-top: auto;
            filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(115deg) brightness(113%) contrast(101%);
        }

        .add-button:hover{
            filter: invert(80%) sepia(60%) saturate(6179%) hue-rotate(99deg) brightness(97%) contrast(77%);
        }

        .right-side{
            margin: auto 0.5em;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .left-side{
            margin-right : auto;
        }

        .song-year {
            color: #b3b3b3;
            align-self: center
        }
        .desc {
            font-size: 14px;
        }
        </style>
    
        <div id ="song-card-$id" class="song-card-container">
            <div class="song-card-information-container">
                <a href = "../song-detail/index.php?song_id=$id" class = "ref-to-song-detail-container">
                    <img src="$img" alt="Song Cover" class="song-image">
                    <div class ="song-text">
                        <div class ="title">$title</div>
                        <div class="desc">$artist  -  $genre</div>
                    </div>
                </a>    
                <div class="song-year">
                    $year
                </div>
            </div>

            <div class="song-card-button-container">
                $add_button
                $delete_button
                $play_button
                $edit_button
            </div>
        </div>
    EOT;
    
    return $html;
    }
?>