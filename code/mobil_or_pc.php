<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$is_mobile = preg_match('/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i', $user_agent);

if ($is_mobile) {
  header('Location: phone_beta/m_login.php');
  exit();
}
?>