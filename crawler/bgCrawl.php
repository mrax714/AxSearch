<?php
$dir = realpath(dirname(__FILE__));
$GLOBALS['bgFull'] = '';
$crawlToken = 418941;
$lock = "crawl.lock";
if (!file_exists($lock))
{
   // file_put_contents($lock, time());

}
	else
{
	//die("Crawler is already running...");
}



    include $dir . '/crawl.php';
   unlink($lock); 
