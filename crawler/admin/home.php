<?php 
function time_elapsed_string($datetime, $full = false) {
$datetime=trim($datetime);

    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
    
}

set_time_limit(0);
ignore_user_abort(true);
ini_set('display_errors', 'on');
error_reporting(1);
$title='Web Crawler';
if (isset($_GET['errors']))
{
error_reporting(1);
}
$home="";include("login.php");?>
<!DOCTYPE html>
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
<h1><a href='./'>Web Crawler</a></h1>
<h1><a class='button' href='/unlock.php?l=crawl'>Unlock</a></h1>
<p><?php $time=(int)@file_get_contents('../crawl.lock'); echo time_elapsed_string('@'.$time); ?></p>
<form method="POST">


<fieldset>
    <legend>URLs</legend>

 <input type="text" name="url[]" placeholder="URL1" style="width:100%;"/><br/>
 <input type="text" name="url[]" placeholder="URL2" style="width:100%;"/><br/>
 <input type="text" name="url[]" placeholder="URL3" style="width:100%;"/><br/>
 <input type="text" name="url[]" placeholder="URL4" style="width:100%;"/><br/>
 </fieldset>
<fieldset>
    <legend>Follow Mode</legend>

<input id="follow0" type="radio" name="follow" value="0"/>
  <label for="follow0"> All Links</label>
  <p>The crawler will follow EVERY link, even if the link leads to a different host or domain.
If you choose this mode, you really should set a limit to the crawling-process (see limit-options),
otherwise the crawler maybe will crawl the whole WWW!</p>

<input id="follow1" type="radio" name="follow" value="1"/><label for="follow1"> Domain</label>
</p>The crawler only follow links that lead to the same domain like the one in the root-url.
E.g. if the root-url (setURL()) is "http://www.foo.com", the crawler will follow links to "http://www.foo.com/..."
and "http://bar.foo.com/...", but not to "http://www.another-domain.com/...".
</p>


<input id="follow2" type="radio" name="follow" value="2" checked />
 <label for="follow2"> Host</label><p>The crawler will only follow links that lead to the same host like the one in the root-url.
E.g. if the root-url (setURL()) is "http://www.foo.com", the crawler will ONLY follow links to "http://www.foo.com/...", but not
to "http://bar.foo.com/..." and "http://www.another-domain.com/...". This is the default mode.</p>

<input id="follow3" type="radio" name="follow" value="3"/>
   <label for="follow3"> Path</label><p>The crawler only follows links to pages or files located in or under the same path like the one of the root-url.
E.g. if the root-url is "http://www.foo.com/bar/index.html", the crawler will follow links to "http://www.foo.com/bar/page.html" and
"http://www.foo.com/bar/path/index.html", but not links to "http://www.foo.com/page.html".

</p></fieldset>

<fieldset>
    <legend>Filter</legend>

 <label for="filter">Filter:</label><input id="filter" type="text" name="filter" placeholder="words|word" style="width:100%;"/><br/>
 </fieldset>
 <fieldset>
     <legend>Settings</legend>

 <label for="bgFull">Full Crawl:</label><input id="bgFull" type="checkbox" name="bgFull" /><br/>
  <label for="errors">Error Reporting:</label><input id="errors" type="checkbox" name="errors" /><br/>
 </fieldset>
 <div class='right'>


 <button>Crawl</button>
 </div>
</form></div>
<?php
if(isset($_POST['url'])){
?>
<hr><h2>Crawling Status</h2>
<div class="col_12 left visible">
<?php 

 $crawlToken=418941;
 $url4Array=$_POST['url'];
foreach($url4Array as $url)
{
	if(!empty($url)){
	$urls[]=$url;
	}
}
unset($url4Array);
$url4Array=$urls;
 //print_r($url4Array);

 include("../crawl.php");
}
?></div>
