<?php
  header('Content-Type: text/html; charset=UTF-8');

  $name = "吉田";

  $url = "http://localhost:8000/controllers/api.php?name=" . $name;

  $data = json_decode(file_get_contents($url));

  if ($data->status === "yes") {
    print $data->user_info->password;
  }
?>