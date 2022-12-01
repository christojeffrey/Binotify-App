<?php


    function subscribeSinger($singer_id, $subscriber_id) {
        $webservice_url = "http://binotify_soap:8080/api/binotify";

        $request_body = '
        <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
            <Body>
                <newSubscription xmlns="http://services.binotify/">
                    <arg0 xmlns="">'. $singer_id .'</arg0>
                    <arg1 xmlns="">'. $subscriber_id .'</arg1>
                    <arg2 xmlns="">x1NbJ4r1e1FAyFNUColSeLG1DhXL6eUfZfDHp93/TWco1YdmDJ+U31Z1S3lLlvYBtZes1nIMwJCQ0bhTaYXkcvdlY4XJjICbedsY3eGGtWXLnZW6/VTP46kpbDQGI/EnJsTIewV8jUpFkIyR/1YD0g==</arg2>
                </newSubscription>
            </Body>
        </Envelope>';
        

        $headers = array(
            'Content-Type: text/xml; charset=utf-8');

        $ch = curl_init($webservice_url);
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close ($ch);

        if ($result !== FALSE) {
            return $result;
        } else {
            return FALSE;
        };
    };

    function premiumSingerCard($args){
        // $subscribver_id, $singer_id, $name, $is_subscribed, $on_click_subscribe, $on_click_go_to_premium_songs_page

        extract($args);

        $subscribe_button = "";
        $go_to_premium_songs_page_button = "";
        if (!$is_subscribed){
            $subscribe_button = 
            <<<EOT
            <button onclick=subscribeSinger($singer_id, $subscriber_id)>
                Subscibe
            </button>
            EOT;
            $play_button = "";
        } else {
            $go_to_premium_songs_page_button = 
            <<<EOT
            <button onclick="$on_click_go_to_premium_songs_page($id)">
                Go To
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
        // echo premiumSingerCard(
        //     singer_id: 2,
        //     subscriber_id: 2,
        //     name: "Singer 2",
        //     is_subscribed: false,
        //     on_click_subscribe: "subscribeSinger",
        //     on_click_go_to_premium_songs_page: "goToPremiumSongsPage"
            
        // ) ;
    }
?>