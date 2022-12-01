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
            <p>Pending</p>
            EOT;
        } else if ($is_subscription_accepted){
            $go_to_premium_songs_page_button = 
            <<<EOT
            <a href="../premium-song/index.php?creator_id=$creator_id&singer_name=$singer_name">
                Song List 
            </a>
            EOT;
        } else if ($is_subscription_rejected){
            $subscription_rejected_information = 
            <<<EOT
            <p>Rejected</p>
            EOT;
        } else {
            $subscribe_button = 
            <<<EOT
            <button onclick="subscribeSinger($creator_id, $subscriber_id)">
                Subscribe
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