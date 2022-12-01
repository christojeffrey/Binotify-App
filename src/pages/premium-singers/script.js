const subscriber_id = localStorage.getItem("id");

// const fetchSubscribedSingers = async () => {
//   let temp = null;
//   GET_API(`../../api/subscription/getSubscribedSingers.php?subscriber_id=${subscriber_id}`, null, async (status, data) => {
//     if (status === 200) {
//       console.log("data.data", data.data);
//       temp = data.data;
//     }
//   });
//   return temp;
// };

const subscribeSinger = (singer_id) => {
  singer_id = 2;
  // setup payload
  let data = `<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
      <Body>
        <newSubscription xmlns="http://services.binotify/">
          <arg0 xmlns="">${singer_id}</arg0>
          <arg1 xmlns="">${subscriber_id}</arg1>
          <arg2 xmlns="">${config.SOAP_TOKEN}</arg2>
        </newSubscription>
      </Body>
    </Envelope>`;

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost:8083/api/binotify", true);
  xhr.setRequestHeader("Content-Type", "text/xml");

  xhr.onload = (e) => {
    if (xhr.readyState === 4) {
      console.log(xhr.responseText);
      callbackfn(xhr.status, JSON.parse(xhr.responseText));
    }
  };
  xhr.onerror = (e) => {
    console.error(xhr.statusText);
  };
  xhr.ontimeout = () => {
    console.error(`The request timed out.`);
  };
  xhr.timeout = TIMEOUT_TIME;
  xhr.send(data);
};

const goToPremiumSongsPage = () => {
  console.log("ke premium songs");
};

const fetchPremiumSingers = async () => {
  console.log("54");

  // get all singers
  let allSingers = await fetch(`${config.REST_API_URL}/singer`, {
    method: "GET",
  })
    .then((res) => {
      return res.json();
    })
    .then((data) => {
      return data;
    })
    .catch((err) => {
      console.log("err", err);
    });
  allSingers = allSingers.singers;
  console.log("fetchedSinger", allSingers);

  // get subscribed singers by me(the user)
  let subscribed_singers;
  GET_API(`../../api/subscription/getSubscribedSingers.php?subscriber_id=${subscriber_id}`, null, async (status, data) => {
    if (status === 200) {
      console.log("data.data", data.data);
      subscribed_singers = data.data;

      // load individual singer
      let premium_singer_list = document.getElementById("cards");
      allSingers.forEach((singer, index) => {
        console.log("subscribed_singers.includes(singer.user_id)", subscribed_singers.includes(singer.user_id));
        LOAD_COMPONENT(
          {
            name: "premiumSingerCard",
            args: {
              id: `${singer.id}`,
              name: `${singer.name}`,
              is_subscribed: subscribed_singers.includes(singer.user_id),
              on_click_subscribe: "subscribeSinger",
              on_click_go_to_premium_songs_page: "goToPremiumSongsPage",
            },
          },
          (status, res) => {
            if (status === 200) {
              premium_singer_list.innerHTML += `<div id="song-card-container-${index}">${res}</div>`;
            }
          }
        );
      });
    }
  });
};

checkTokenOnPageLoad(false);
LOAD_NAVBAR();
LOAD_ACCOUNT_INFO();
fetchPremiumSingers();
