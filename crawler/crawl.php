<?php


if (isset($_GET['errors']))
{
    ini_set('display_errors', 'on');
    error_reporting(1);
}

if (!isset($crawlToken) || $crawlToken != 418941)
{
    if (!isset($_GET['78wc58v']))
    {
        die('Error');
    }
}

$dir = realpath(dirname(__FILE__));
register_shutdown_function('shutdown');
include $dir . '/PHPCrawl/libs/PHPCrawler.class.php';
include $dir . '/simple_html_dom.php';
include $dir . '/../inc/config.php';
function domain($url)
{
    $parse = parse_url($url);
    return str_ireplace('www.', '', parse_url($url, PHP_URL_HOST)); // prints 'google.com'
    
}

function shutdown()
{
    global $dir;
    $error = error_get_last();
    if ($error !== null && $error['type'] === E_ERROR)
    {
        file_put_contents($dir . '/crawlStatus.txt', '0');
        get_headers(HOST . '/crawler/runCrawl.php');
    }
}



function addURL($t, $u, $d, $i)
{
    global $dbh;
    if ($t != '' && filter_var($u, FILTER_VALIDATE_URL))
    {
        $check = $dbh->prepare('SELECT `id` FROM `search` WHERE `url`=?');
        $check->execute(array(
            $u
        ));
        $t = preg_replace("/\s+/", ' ', $t);
        $t = substr($t, 0, 1) == ' ' ? substr_replace($t, '', 0, 1) : $t;
        $t = substr($t, -1) == ' ' ? substr_replace($t, '', -1, 1) : $t;
        $t = html_entity_decode($t, ENT_QUOTES);
        $d = html_entity_decode($d, ENT_QUOTES);
        echo "<a href='$u' target='_blank'>$u</a>" . "<br/>\n";
        ob_flush();
        flush();
        if (!empty($d) && $check->rowCount() == 0)
        {
            $sql = $dbh->prepare('INSERT INTO `search` (`title`, `url`, `description`, `image`) VALUES (?, ?, ?, ?)');
            $sql->execute(array(
                $t,
                $u,
                $d,
                $i,
            ));
        }
        else
        {
            $sql = $dbh->prepare('UPDATE `search` SET `description` = ?, `title` = ?, `image` = ? WHERE `url`=?');
            $sql->execute(array(
                $d,
                $t,
                $i,
                $u,
            ));
        }
    }
}





class WSCrawler extends PHPCrawler
{
    public function handleDocumentInfo(PHPCrawlerDocumentInfo $p)
    {
        $u = $p->url;
        $c = $p->http_status_code;
        $s = $p->source;
        if ($c == 200 && $s != '')
        {
            $html = str_get_html($s);
            if (is_object($html))
            {
                $d = '';
                $do = $html->find('meta[name=description]', 0);
                if ($do)
                {
                    $d = $do->content;
                }
                $img = '';
                $do = $html->find('meta[property=og:image]', 0);
                if ($do)
                {
                    $img = $do->content;
                }
                $t = $html->find('title', 0);
                $go = 'video';
                if (isset($_POST['filter']))
                {
                    $go = $_POST['filter'];
                }
                if (preg_match('/(' . $go . ')/i', $u))
                {
                    if ($t && !empty($d) && !empty($img))
                    {
                        $t = $t->innertext;
                        addURL($t, $u, $d, $img);
                    }
                }
                $html->clear();
                unset($html);
            }
        }
    }
}



function crawl($u)
{
    $dir = '/home2/axworx05/search.axads.co/crawler/admin';
    $s = '/home2/axworx05/search.axads.co/crawler/crawlStatus.txt';
    //$dir.='/admin';
    $follow_mode = 2;
    if (isset($_REQUEST['follow']))
    {
        $follow_mode = $_REQUEST['follow'];
    }
    $C = new WSCrawler();
    $C->obeyNoFollowTags(true);
    $C->obeyRobotsTxt(true);
    $C->enableResumption();
    $C->setFollowMode($follow_mode);
    $C->setUrlCacheType(PHPCrawlerUrlCacheTypes::URLCACHE_SQLITE);
    $C->setWorkingDirectory($dir . "/tmp/");
    // If process was started the first time:
    // Get the C-ID and store it somewhere in order to be able to resume the process later on
    if (!file_exists($dir . "/tmp/crawlerid_for_" . domain($u) . ".tmp"))
    {
        $crawler_id = $C->getCrawlerId();
        file_put_contents($dir . "/tmp/crawlerid_for_" . domain($u) . ".tmp", $crawler_id);
    }
    // If process was restarted again (after a termination):
    // Read the C-id and resume the process
    else
    {
        $crawler_id = file_get_contents($dir . "/tmp/crawlerid_for_" . domain($u) . ".tmp");
        $C->resume($crawler_id);
    }
    $C->setURL($u);
$C->addLinkPriority("/(busty|gangbang|redhead)/i", 10);
$C->addLinkPriority("/(boob|teen)/i", 5);
    $C->addContentTypeReceiveRule('#text/html#');
    $C->addURLFilterRule('#(jpg|gif|png|pdf|jpeg|svg|css|js)$# i');
    $C->setTrafficLimit(1000 * 1024*10);

if (!isset($_GET['bgFull']) && !isset($GLOBALS['bgFull']))
    {
        $C->setTrafficLimit(1000 * 1024 *10);
    }
    $C->setUserAgentString('AxBot (https://search.axads.co/about/bot.php)');
    if (PHP_SAPI == 'cli')
    {
        // That's it, start crawling using 5 processes
        $crawler->goMultiProcessed(5);
    }
    else
    {
        $C->go();
        // At the end, after the process is finished, we print a short
        // report (see method getReport() for more information)
        $report = $C->getProcessReport();
        if (PHP_SAPI == "cli") $lb = "\n";
        else $lb = "<br />";
        echo "Summary:" . $lb;
        echo "Links followed: " . $report->links_followed . $lb;
        echo "Documents received: " . $report->files_received . $lb;
        echo "Bytes received: " . $report->bytes_received . " bytes" . $lb;
        echo "Process runtime: " . $report->process_runtime . " sec" . $lb;
    }
   // file_put_contents($s, 0);
  //unlink($s);
    // After the process is finished completely: Delete the C-ID
    unlink($dir . "/tmp/crawlerid_for_" . domain($u) . ".tmp");
}




if (!isset($url4Array))
{
    // Get the last indexed URLs (If there isn't, use default URL's) & start Crawling
    $last = $dbh->prepare('SELECT `url` FROM search');
    $last->execute();
    $count = $last->rowCount();
    if ($count < 1)
    {
        crawl('https://www.stackoverflow.com/'); // The Default URL #1
        
    }
    else
    {
        $urls = $last->fetchAll();
        $index = rand(0, $count - 1);
        crawl($urls[$index]['url']);
    }
}
elseif (is_array($url4Array))
{
    foreach ($url4Array as $url)
    {
        crawl($url);
    }
}

