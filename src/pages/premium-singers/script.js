const subscriber_id = localStorage.getItem("id");


const subscribeSinger = (creator_id) => {
    let temp;
    const body = {
      "subscriber_id": subscriber_id,
      "creator_id": creator_id,
    }
    POST_API(`../../api/subscription/subscribeSinger.php`, null, body, (status, data) => {
    if (status === 200) {
      alert("Subscription request sent");
      window.location.reload();
    } 
  });
};



const fetchPremiumSingers = async () => {

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
  let subscription_requested_singers;
  GET_API(`../../api/subscription/getSubscribedSingers.php?subscriber_id=${subscriber_id}`, null, async (status, data) => {
    if (status === 200) {
      accepted_subscription_singers = data.accepted;
      pending_subscription_singers = data.pending;
      rejected_subsctiption_singers = data.rejected;

      // load individual singer
      let premium_singer_list = document.getElementById("cards");
      premium_singer_list.innerHTML = "";

      for (let i = 0; i < allSingers.length; i++) {
        // append child song_list
        premium_singer_list.innerHTML += `<div id="premium-singer-card-container-${i}"></div>`;
      }


      allSingers.forEach((singer, index) => {
        LOAD_COMPONENT(
          {
            name: "premiumSingerCard",
            args: {
              creator_id: `${singer.user_id}`,
              subscriber_id: `${subscriber_id}`,
              singer_name: `${singer.name}`,
              is_subscription_accepted: accepted_subscription_singers.includes(singer.user_id),
              is_subscription_pending: pending_subscription_singers.includes(singer.user_id),
              is_subscription_rejected: rejected_subsctiption_singers.includes(singer.user_id),
              on_click_subscribe: "subscribeSinger",
            },
          },
          (status, res) => {
            if (status === 200) {
              document.getElementById(`premium-singer-card-container-${index}`).innerHTML = res;
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
