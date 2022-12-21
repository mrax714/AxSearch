<?php $index="";include("login.php");?>
<?php 
if(isset($_POST['username']) && isset($_POST['password'])){
 $ushahs=hash("sha512", 'admin');
 $hashed=hash("sha512", 'crack420');
 if(hash("sha512", $_POST['password'])==$hashed && hash("sha512", $_POST['username'])==$ushahs){
	setcookie("login","1",time()+6000000000);// second on page time 
  header("Location: home.php");
 }else{
  echo "Not Ok";
 }
}
?><!DOCTYPE html>
<html>

	<head>
		<title><?php echo $title; ?></title>
		<script src="/js/jquery.min.js"></script>
		<script src="/js/kickstart.js"></script> <!-- KICKSTART -->
		<link rel="stylesheet" href="/css/kickstart.css" media="all" /> <!-- KICKSTART -->
		<link rel="stylesheet" href="/style.css" media="all" /> <!-- KICKSTART -->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
	</head>

	<body>
<div class="grid">
<div class="col_12 left">
<h1>Web Crawler Login</h1>
<form action="" method="POST">
 <input type="text" name="username"/>
 <input type="password" name="password"/>
 <button>Login</button>
</form>
