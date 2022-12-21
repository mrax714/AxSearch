<?php 
if(isset($_GET['crawl'])){
$l=$_GET['l'];
unlink("$l.lock");
 header("Location: admin/home.php");
 exit;
}
