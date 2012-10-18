<?php 
$sites = array( 
'http://bruins.nhl.com/club/', 
); 

foreach ( $sites as $site ) { 
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-GB; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)'); 
    curl_setopt($ch, CURLOPT_URL, $site); 
    curl_setopt($ch, CURLOPT_REFERER, $site); 
    curl_setopt($ch, CURLOPT_ENCODING, ''); // all supported encoding types (identity,deflate,gzip) 
    curl_setopt($ch, CURLOPT_FAILONERROR, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_NOBODY, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 45); 

    if ( ! $html = curl_exec($ch))   
    { 
        echo '<p>'.curl_error($ch).'</p>'; 
    } 
    else 
    {               
        $xmlDoc = new DOMDocument();  
        if ( @$xmlDoc->loadHTML($html) ) { 
            echo "{$site} successful.  Found " . count($xmlDoc->getElementsByTagName('img')) . " images.<br />\n"; 
        } else { 
            echo "{$site} invalid<br />\n"; 
        } 
    } 
} 
die();       
?>