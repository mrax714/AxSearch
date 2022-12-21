<?php 
if(isset($_GET['l'])){
$l=$_GET['l'];
unlink("../$l.lock");
 header("Location: /home.php");
 exit;
}
