<?php

    function premiumSingerCard($args){
        // $subscribver_id, $creator_id, $singer_name, $is_subscription_accepted, $is_subscription_pending, $is_subscription_rejected, $on_click_subscribe, 

        extract($args);
        $subscribe_button = "";
        $subscription_pending_information = "";
        $subscription_rejected_information = "";
        $go_to_premium_songs_page_button = "";


        if ($is_subscription_pending){
            $subscription_pending_information = 
            <<<EOT
            <button class="pending-information" disabled>
                Pending
            </button>
            EOT;
        } else if ($is_subscription_accepted){
            $go_to_premium_songs_page_button = 
            <<<EOT
            <a href="../premium-song/index.php?creator_id=$creator_id&singer_name=$singer_name" class="goto-song-list">
                Open Song List 
            </a>
            EOT;
        } else if ($is_subscription_rejected){
            $subscription_rejected_information = 
            <<<EOT
            <button class="rejected-information" disabled>
                Rejected
            </button>
            EOT;
        } else {
            $subscribe_button = 
            <<<EOT
            <button class="subscribe-button" onclick="subscribeSinger($creator_id, $subscriber_id)">
                Subscribe
            </button>
            EOT;
        }

        

        $html = <<<"EOT"
        <style>
        .premium-singer-desc{
            width: 15%;
            margin-left: 1rem;
        }
        .pending-information{
            background-color: #b3b3b3;
            border: none;
            color: white;
            padding: 15px 32px;
            border-radius: 0.5em;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        .pending-information:disabled{
            cursor: not-allowed;
            pointer-events: all !important;
        }
        .rejected-information{
            background-color: #ed4337;
            border: none;
            color: white;
            padding: 15px 32px;
            border-radius: 0.5em;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        .rejected-information:disabled{
            cursor: not-allowed;
            pointer-events: all !important;
        }

        .subscribe-button{
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            border-radius: 0.5em;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transform: scale(0.98);
        }
        .subscribe-button:hover{
            transform: scale(1);
        }
        .subscribe-button:active{
            transform: scale(0.98);
        }

        .goto-song-list{
            background-color: #0047ab;
            border: none;
            color: white;
            padding: 15px 32px;
            border-radius: 0.5em;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transform: scale(0.98);
        }
        .goto-song-list:hover{
            transform: scale(1);
        }
        .goto-song-list:active{
            transform: scale(0.98);
        }

        .premium-singer-card{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            background-color: #181818;
            padding: 0.5em;
            border-radius: 0.5em;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            margin: 0.5em;
        }
        </style>
            <div class="flex flex-row premium-singer-card">
                    <div class="premium-singer-desc">
                        $singer_name
                    </div>
                    
                    $subscribe_button
                    $subscription_pending_information
                    $subscription_rejected_information
                    $go_to_premium_songs_page_button
            </div>
        EOT;
        echo $html;
    }
?>