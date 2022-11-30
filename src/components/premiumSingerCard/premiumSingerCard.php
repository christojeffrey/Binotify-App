<?php
    function premiumSingerCard($args){
        // $singer_id, $name, $is_subscribed, $on_click_subscribe, $on_click_go_to_premium_songs_page

        extract($args);

        $subscribe_button = "";
        $go_to_premium_songs_page_button = "";
        if (!$is_subscribed){
            $subscribe_button = 
            <<<EOT
            <button onclick="$on_click_subscribe($id)">
                <img class="subscribe-button" src="../../assets/icons/plus.svg" alt="Subscribe"/>
            </button>
            EOT;
            $play_button = "";
        } else {
            $go_to_premium_songs_page_button = 
            <<<EOT
            <button onclick="$on_click_go_to_premium_songs_page()">
                <img class="go-to-premium-songs-page-button" src="../../assets/icons/plus.svg" alt="Subscribe"/>
            </button>
            EOT;
        }



        $html = <<<"EOT"
        <style>
        .premium-singer-desc{
            width: 15%;
        }
        .premium-singer-card{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid black;
            margin: 1rem;
        }
        </style>
            <div class="flex flex-row premium-singer-card">
                    <div class="premium-singer-desc">
                        $name
                    </div>
                    <Button>
                        Subscribe
                    </Button>

            </div>
        EOT;
        return $html;
    }
?>