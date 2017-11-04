<?php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "www.rankwatch.com");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $real_url = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
    $html = curl_exec($ch);
    $info = curl_getinfo($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $ip = gethostbyname($real_url);

$doc = new DOMDocument();
@$doc->loadHTML($html);



$nodes = $doc->getElementsByTagName('title');
$title = $nodes->item(0)->nodeValue;
$metas = $doc->getElementsByTagName('meta');
for ($i = 0; $i < $metas->length; $i++)
{
    $meta = $metas->item($i);
    if($meta->getAttribute('name') == 'description')
        $description = $meta->getAttribute('content');
    if($meta->getAttribute('name') == 'keywords')
        $keywords = $meta->getAttribute('content');
}

echo "Title: $title". '<br/><br/>';
echo "Description: $description". '<br/><br/>';
echo "Keywords: $keywords".'<br/><br/>';
echo 'IP address ',$ip.'<br/><br/>';
echo 'Took ', $info['total_time'], ' seconds to send a request '.'<br/><br/>';
echo ' HTTP Status ',$http_code . '<br/><br/>';
$regex='|<a.*?href="(.*?)"|';
    preg_match_all($regex,$html,$parts);
    $links=$parts[1];
    foreach($links as $link){
        echo "Internal and External Links".": ". $link."<br/><br/>";
    }

curl_close($ch);
?>