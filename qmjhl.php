<?php
set_time_limit(900);
error_reporting(E_ALL | E_STRICT);

$in_charset = 'ISO-8859-1';   // == 'windows-874'
$out_charset = 'utf-8';

header('Content-type: text/html; charset=' . $out_charset);

$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=> implode("\r\n", array(
                   'Content-type: text/plain; charset=' . $in_charset
                ))
  )
);

$context = stream_context_create($opts);

$sites = array( 
'http://theqmjhl.ca/roster/list/team/55/sort/last',
'http://theqmjhl.ca/roster/list/team/51/sort/last',
'http://theqmjhl.ca/roster/list/team/44/sort/last',
'http://theqmjhl.ca/roster/list/team/56/sort/last',
'http://theqmjhl.ca/roster/list/team/52/sort/last',
'http://theqmjhl.ca/roster/list/team/47/sort/last',
'http://theqmjhl.ca/roster/list/team/43/sort/last',
'http://theqmjhl.ca/roster/list/team/57/sort/last',
'http://theqmjhl.ca/roster/list/team/58/sort/last',
'http://theqmjhl.ca/roster/list/team/59/sort/last',
'http://theqmjhl.ca/roster/list/team/53/sort/last',
'http://theqmjhl.ca/roster/list/team/54/sort/last',
'http://theqmjhl.ca/roster/list/team/45/sort/last',
'http://theqmjhl.ca/roster/list/team/60/sort/last',
'http://theqmjhl.ca/roster/list/team/49/sort/last',
'http://theqmjhl.ca/roster/list/team/46/sort/last',
'http://theqmjhl.ca/roster/list/team/50/sort/last',
'http://theqmjhl.ca/roster/list/team/77/sort/last'
); 

foreach ( $sites as $site ) { 
//$site = "http://redwings.nhl.com";
$roster_string = file_get_contents($site,false, $context);
if ($in_charset != $out_charset) {
    $contents = iconv($in_charset, $out_charset, $contents);
}

//$file_string = file_get_contents('http://bruins.nhl.com/club/player.htm?id=8471246');
//$file_string = file_get_contents('http://theqmjhl.ca/roster/show/id/6850');


//preg_match('/<title>(.*)<\/title>/i', $file_string, $title);
//$title_out = $title[1];

/*
preg_match('/<meta name="keywords" content="(.*)" \/> /i', $file_string, $keywords);
$keywords_out = $keywords[1];

preg_match('/<meta name="description" content="(.*)" \/> /i', $file_string, $description);
$description_out = $description[1];
*/
preg_match_all('/<A HREF=\'(.*)\' class=\'content\'>/msU', $roster_string, $links);
preg_match_all('/class=\'content\'>(.*)<\/a>/msU', $roster_string, $name);

echo '<ol>';
for($i = 0; $i < count($links[1]); $i++) {
	
	list($firstname, $lastname) = explode(',',$name[1][$i],2);
	$name_out = trim($lastname).' '.trim($firstname);
	
	$file_string = utf8_decode(file_get_contents("http://theqmjhl.ca/roster" . $links[1][$i]));
	
	
	preg_match_all('/<img id="ros_headshot" class="ros_headshot" src="(.*)" \/>/i', $file_string, $images);
	//preg_match('/<img height="150" .*?(?=src)src=\"([^\"]+)\"/si', $file_string, $images);
	
	foreach ($images[1] as $value) {
	 // $img_out = iconv("UTF-8", "ISO-8859-1", $value);
	  $img_out = $value;
	}
	
	//preg_match('/<div class="plyrTmbPlayerName">(.*)<\/div>/msU', $file_string, $playernom);
	
	/*
	$playername = preg_match_all('/<h1 class="pagetitle">(.*)<\/h1>/msU', $file_string, $playernom);
	var_dump($playernom[1]);
	foreach ($playernom[1] as $value) {
	  $name_out = trim($value);
	  echo $value;
	  break;
	}
	*/

?>

<p><strong>Player:</strong>
<?php
echo '<br>'.$name_out;
echo '<br><img src="'.$img_out.'">';
$output = "images/".trim($name_out).".jpg";
echo '<br>'.$output;
file_put_contents($output, file_get_contents($img_out, false,$context));

?>
</p>

<?php
//break;
}
echo '</ol>';
} 
die(); 
?>
