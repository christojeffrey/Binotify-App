<?php
    function premiumSongCard($args) {
        extract($args);

    $play_button = <<<EOT
    <button onclick="$on_click($id,'$title','$audio_path')" class = "button">
        <img class="play-edit-button" src="../../assets/icons/play.svg" alt="Play"/>
    </button>
    EOT;

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

        </style>
    
        <div id ="song-card-$id" class="song-card-container">
            <div class="song-card-information-container">
                <div class = "ref-to-song-detail-container">
                    <div class ="song-text">
                        <div class ="title">$title</div>
                    </div>
                </div>    
            </div>

            <div class="song-card-button-container">
                $play_button
            </div>
        </div>
    EOT;
    
    return $html;
    }
?>