function sub() {
  var formTitle = document.getElementById("formTitle").value;
  var formBody = document.getElementById("formBody").value;
  var titleErr = document.getElementById("titleError");
  var bodyErr = document.getElementById("bodyError");
  var sub = document.getElementById("subId");
  titleErr.innerHTML = "";
  bodyErr.innerHTML = "";
  sub.type = "submit";
  if (formTitle == "") {
    titleErr.style.color = "red";
    titleErr.innerHTML = "値を入力してください";
    sub.type = "button";
  } else if (formTitle.match(/^.{1,20}$/)) {
  } else {
    titleErr.style.color = "red";
    titleErr.innerHTML = "titleは20文字以下で入力してください。";
    sub.type = "button";
  }
  if (formBody == "") {
    bodyErr.style.color = "red";
    bodyErr.innerHTML = "値を入力してください";
    sub.type = "button";
  } else if (formBody.match(/^.{1,100}$/)) {
  } else {
    bodyErr.style.color = "red";
    bodyErr.innerHTML = "bodyは100文字以下で入力してください。";
    sub.type = "button";
  }
}