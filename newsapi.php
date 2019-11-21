<?php 
require 'vendor/autoload.php';

use jcobhams\NewsApi\NewsApi;

$newsapi = new NewsApi('fdfcb0b526b24fa788a2891caaeacd3b');

$topheadlines = json_encode($newsapi->getTopHeadlines(null, null, 'gb', null, 20, null));
$someArray = json_decode($topheadlines, True);

$news_articles = $someArray['articles'];
$news_titles = array();

for ($x = 0; $x < count($news_articles); $x++) {
	array_push($news_titles, $news_articles[$x]['title']);
	echo(nl2br($news_titles[$x]."\n"));
};
?>