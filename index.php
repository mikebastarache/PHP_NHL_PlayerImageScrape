<?php
set_time_limit(900);

$sites = array( 
'http://ducks.nhl.com', 
'http://flames.nhl.com', 
'http://blackhawks.nhl.com', 
'http://avalanche.nhl.com', 
'http://bluejackets.nhl.com', 
'http://redwings.nhl.com', 
'http://stars.nhl.com', 
'http://oilers.nhl.com', 
'http://kings.nhl.com', 
'http://wild.nhl.com', 
'http://predators.nhl.com', 
'http://coyotes.nhl.com', 
'http://sharks.nhl.com', 
'http://blues.nhl.com', 
'http://canucks.nhl.com', 
'http://bruins.nhl.com', 
'http://sabres.nhl.com', 
'http://hurricanes.nhl.com', 
'http://panthers.nhl.com', 
'http://canadiens.nhl.com', 
'http://devils.nhl.com', 
'http://islanders.nhl.com', 
'http://rangers.nhl.com', 
'http://senators.nhl.com', 
'http://flyers.nhl.com', 
'http://penguins.nhl.com', 
'http://lightning.nhl.com', 
'http://mapleleafs.nhl.com', 
'http://capitals.nhl.com', 
'http://jets.nhl.com'
); 

foreach ( $sites as $site ) { 
//$site = "http://redwings.nhl.com";
$roster_string = file_get_contents($site . '/club/roster.htm');
$roster_string = file_get_contents($site . '/club/roster.htm?type=prospect');
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
preg_match_all('/<nobr><a href="(.*)">/msU', $roster_string, $links);


echo '<ol>';
for($i = 0; $i < count($links[1]); $i++) {
	
	$file_string = file_get_contents($site . $links[1][$i]);
	
	//preg_match_all('/<img id="ros_headshot" class="ros_headshot" src="(.*)" \/>/i', $file_string, $images);
	preg_match('/<img height="150" .*?(?=src)src=\"([^\"]+)\"/si', $file_string, $images);
	$img_out = $images[1];
	
	preg_match('/<div class="plyrTmbPlayerName">(.*)<\/div>/msU', $file_string, $playernom);
	$name_out = $playernom[1];
	
	//$playername = preg_match_all('/<h1 class="pagetitle">(.*)<\/h1>/msU', $file_string, $playernom);
	//preg_match_all('/<div class="plyrTmbPlayerName">(.*)<\/div>/i', $file_string, $playernom);

?>

<p><strong>Player:</strong>
<?php
echo '<br>'.$name_out;
echo '<br><img src="'.$img_out.'">';
$output = "images/".trim($name_out).".jpg";
echo '<br>'.$output;
file_put_contents($output, file_get_contents($img_out));
?>
</p>

<?php
//break;
}
echo '</ol>';
} 
die(); 
?>
