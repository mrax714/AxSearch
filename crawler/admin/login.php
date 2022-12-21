<?php 
session_start();
if(isset($_COOKIE['login']) && !isset($home)){
 header("Location: home.php");
 exit;
}elseif(!isset($index) && !isset($_COOKIE['login'])){
 header("Location: index.php");
 exit;
}
?>
