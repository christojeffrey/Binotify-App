<?php
    function albumCard($args){
        // $id, $album_title, $singer, $year, $genre, on_click, $is_admin
        extract($args);

        // if is admin, show the edit button
        $edit_button = "";
        if (true) {
            $edit_button = 
            <<<EOT
            <div class = "edit-icon m-4">
                <a href= "../update-album/index.php?album_id=$id">
                    <img class="edit-button" src="../../assets/icons/edit.svg" alt="Edit"/>
                </a>
            </div>
            EOT;
        }

        $html = 
        <<<"EOT"

            <style>
                .edit-icon{    
                    position: absolute;
                    right: 0px;
                    bottom: 0px;
                }
                
                .albums_item {
                    display: flex;
                    padding: 0.5rem;
                    width: 200px;
                    min-width:0;
                }
                .album{
                    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                    background-color: #181818;
                    padding: 0.5em;
                    border-radius: 0.5em;
                    display: flex;
                    flex-direction: column;
                    overflow: hidden;
                    
                }
                .album:hover{
                    background-color: #282828;
                    cursor: pointer;
                }
                img{
                    width: 180px;
                    height: 180px;
                    border-radius: 0.5em;
                }
                
                .album-info h4 {
                    white-space:nowrap;
                    text-overflow: ellipsis;
                    overflow: hidden;
                    font-size: 16px;
                    color: #FFFFFF;
                    margin:0.5em 0;
                }

                .album-info p {
                    white-space:nowrap;
                    text-overflow: ellipsis;
                    overflow: hidden;
                    font-size: 13px;
                    color: #B3B3B3;
                    margin:0;
                }

                .edit-button{
                    filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(115deg) brightness(113%) contrast(101%);
                    width: 1.5rem;
                    height: 1.5rem;
                    cursor: pointer;
                    margin-left: auto;
                    margin-top: auto;
                }

                .edit-button:hover{
                    filter: invert(80%) sepia(60%) saturate(6179%) hue-rotate(99deg) brightness(97%) contrast(77%);
                }
                
                .play-icon{
                    margin-left: auto;
                    transform: translateY(10px);
                    
                    opacity:0;
                }

                .album:hover .play-icon{
                    opacity:1;
                    transform:translateY(0);
                }
                .play-icon:hover .circle{
                    cursor: auto;
                    transform: scale(1);
                }

                .circle{
                    width: 2.5rem;
                    height: 2.5rem;
                    border-radius: 50%;
                    background-color: rgb(50,233,50);
                    display:grid;
                    transform: scale(0.95);
                }

                .triangle{
                    width:0;
                    height:0;
                    border-left:8px solid transparent;
                    border-right:8px solid transparent;
                    border-bottom:16px solid black;
                    transform: rotate(90deg);
                    margin-left: 0.9rem;
                    margin-top:0.7rem;
                }
                .container{
                    display:flex;
                }
            </style>
            <div class="relative">
                <div>
                    <a href="../album-detail/index.php?album_id=$id" id="album-card-$id" class="albums_item">
                        <div class="album">
                            <img src="$img" alt="Album Thumbnail">
                            <div class="album-info">
                                <h4><b>$album_title</b></h4>
                                <div class="container">
                                    <div>
                                        <p>$singer</p>
                                        <p>$year • $genre</p>
                                    </div>
                                    <!--
                                        <div class="play-icon">
                                            <div class="circle">
                                                <div class="triangle">
                                                </div>
                                            </div>
                                        </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- $edit_button -->
            </div>
        EOT;
        return $html;
    }
?>