(function () {
  let URLParams = new URLSearchParams(window.location.search);
  if (!URLParams.get("keyWord")) return;
  axios({
    method: "GET",
    url: "./verify.php",
    params: { token: URLParams.get("keyWord") },
  }).then(({ data }) => {
    if (data.existence) {
      let triggerPr = data.pr.sort((a, b) => a - b)[0];
      let randomNum = Math.floor(Math.random() * (1 - 100) + 100);
      if (triggerPr >= randomNum) handleAutoDbReturn && handleAutoDbReturn();
    }
  });
})();
