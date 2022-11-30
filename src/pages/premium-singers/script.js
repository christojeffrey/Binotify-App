const subscriber_id = localStorage.getItem("id");

const fetchSubscribedSingers = async () => {
  console.log("before fetching subscribed singers")
     await GET_API(`../../api/subscription/getSubscribedSingers.php?subscriber_id=${subscriber_id}`, null, (status, data) => {
      console.log("data" ,data);
      return (status === 200) ? data.data : [];
    });
}

const subscribeSinger = (singer_id) => {
  // setup payload
  const header = {
    "Content-Type": "text/xml",
  };
  let xml = builder
  .create("Envelope", { version: "1.0", encoding: "UTF-8" })
  .att("xmlns", "http://schemas.xmlsoap.org/soap/envelope/")
  .ele("Body")
  .ele("updateSubscription", {
    xmlns: "http://services.binotify/",
  })
  .ele("arg0", { xmlns: "" }, singer_id)
  .up()
  .ele("arg1", { xmlns: "" }, subscriber_id)
  .end({ pretty: true });

  console.log("payload setuped");
  // hit endpoint
  let SOAP_URL = config.SOAP_API_URL;
  fetch(`${SOAP_URL}` , {
    method: "POST",
    headers: header,
    body: xml,
    redirect: "follow",
  })
    .then((response) => response.text())
    .then((result) => {
      console.log("result", result);
      return result;
    })
    .catch((error) => {
      console.log("error", error);
      return error;
    });
}

const goToPremiumSongsPage = () => {
    console.log("ke premium songs")
}

const fetchPremiumSingers  = () => {
    console.log("54")
    fetch(`${config.REST_API_URL}/singer`, {
        method: "GET"
        })
        .then((res) => {console.log(res.json()); return res.json()})
        .then((data) => {
          console.log("data 60", data)
            let premium_singer_list = document.getElementById("cards");
            console.log("before fetch");
            // const subscribed_singers = await fetchSubscribedSingers(subscriber_id);
            // console.log("subscribed_singers", subscribed_singer);
            // premium_singer_list.innerHTML = "";
            // data.forEach((singer, index) => {
            //     LOAD_COMPONENT(
            //         {
            //           name: "premiumSingerCard",
            //           args: {
            //             id: `${singer.id}`,
            //             name: `${singer.name}`,
            //             is_subscribed: subscribed_singers.includes(singer.id),
            //             on_click_subscribe: "subscribeSinger",
            //             on_click_go_to_premium_songs_page: "goToPremiumSongsPage",
            //           },
            //         },
            //         (status, res) => {
            //           if (status === 200) {
            //             premium_singer_list.innerHTML += `<div id="song-card-container-${index}">${res}</div>`;
            //           }
            //         }
            //       );
            // });
        // })
        // .catch((err) => {
        //     console.log(err);
        });

    // GET_API(`${config.REST_API_URL}/song/${audio_path}`, null, (status, data) => {
    //   if (status === 200) {
    //     let premium_singer_list = document.getElementById("cards");
    //     premium_singer_list.innerHTML = "";
  
    //     // create div song-card-container-id
    //     for (let i = 0; i < data.data.length; i++) {
    //       // append child song_list
    //       song_list.innerHTML += `<div id="song-card-container-${i}"></div>`;
    //     }
    //     data.data.forEach((song, index) => {
    //       LOAD_COMPONENT(
    //         {
    //           name: "songCard",
    //           args: {
    //             id: `${song.song_id}`,
    //             title: `${song.song_title}`,
    //             artist: `${song.singer}`,
    //             audio_path: "../../assets/song-audio/" + song.audio_path,
    //             img: SONG_IMAGE_PATH + song.image_path,
    //             on_click: "songCardOnClick",
    //             // get year from date format "YYYY--MM-DD"
    //             year: song.publish_date.split("-")[0],
    //             genre: song.genre,
    //             delete_from_album: false,
    //             add_to_album: false,
    //             is_admin: localStorage.getItem("admin_token") ? true : false,
    //           },
    //         },
    //         (status, res) => {
    //           if (status === 200) {
    //             document.getElementById(`song-card-container-${index}`).innerHTML = res;
    //           }
    //         }
    //       );
    //     });
    //   }
    // });
  };

checkTokenOnPageLoad(false);
LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();
fetchPremiumSingers();