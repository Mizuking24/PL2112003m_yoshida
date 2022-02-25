function sub() {
  var formName = document.getElementById("formName").value;
  var formEmail = document.getElementById("formEmail").value;
  var formPass = document.getElementById("formPass").value;
  var nameErr = document.getElementById("nameError");
  var emailErr = document.getElementById("emailError");
  var passErr = document.getElementById("passError");
  var sub = document.getElementById("subId");
  nameErr.innerHTML = "";
  emailErr.innerHTML = "";
  passErr.innerHTML = "";
  sub.type = "submit";
  if (formName == "") {
    nameErr.style.color = "red";
    nameErr.innerHTML = "値を入力してください";
    sub.type = "button";
  }
  if (formEmail == "") {
    emailErr.style.color = "red";
    emailErr.innerHTML = "値を入力してください";
    sub.type = "button";
  } else if (formEmail.match(/^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/)) {
  } else {
    emailErr.style.color = "red";
    emailErr.innerHTML = "メールアドレスが不正です";
    formEmail = "";
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