<?php 
session_start();
session_unset();
session_destroy();
echo "退出成功!<a href='login.php'>点击这里重新登录!<a/>";
?>