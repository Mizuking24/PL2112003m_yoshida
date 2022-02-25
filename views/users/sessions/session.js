function sub() {
  var formName = document.getElementById("formName").value;
  var formPass = document.getElementById("formPass").value;
  var nameErr = document.getElementById("nameError");
  var passErr = document.getElementById("passError");
  var sub = document.getElementById("subId");
  nameErr.innerHTML = "";
  passErr.innerHTML = "";
  sub.type = "submit";
  if (formName == "") {
    nameErr.style.color = "red";
    nameErr.innerHTML = "値を入力してください";
    sub.type = "button";
  }
  if (formPass == "") {
    passErr.style.color = "red";
    passErr.innerHTML = "値を入力してください";
    sub.type = "button";
  } else if (formPass.match(/^\w{6,20}$/)) {
  } else {
    passErr.style.color = "red";
    passErr.innerHTML = "passwordは6文字以上、20文字以下の半角英数字で入力してください。";
    formPass = "";
    sub.type = "button";
  }
}