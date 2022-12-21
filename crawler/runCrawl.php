<?php
set_time_limit(50);
error_reporting(1);
ini_set('display_errors', 'on');

$dir = realpath(dirname(__FILE__));
$s = "$dir/crawlStatus.txt";
$c = file_get_contents($s);
if ($c == 0)
{
    function execInbg($cmd)
    {
        if (substr(php_uname() , 0, 7) == "Windows")
        {
            pclose(popen("start /B " . $cmd, "r"));
        }
        else
        {
            exec($cmd . " > /dev/null &");
        }
    }
    file_put_contents($s, 0);
    execInbg("php -q $dir/bgCrawl.php");
    
    echo "Started Running";
}
else
{
    echo "Currently Running";
}
?>
