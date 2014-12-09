<?php

// funksjoner

function get_content($url) { 

	$ch = curl_init();  
     
	curl_setopt ($ch, CURLOPT_URL, $url);  
	curl_setopt ($ch, CURLOPT_HEADER, 0);  
      
	ob_start();  
      
	curl_exec ($ch);  
	curl_close ($ch);  
	$string = ob_get_contents();  
      
	ob_end_clean();  
         
	return $string;
}  



function trunc($phrase, $max_words) {
   $phrase_array = explode(' ',$phrase);
   if(count($phrase_array) > $max_words && $max_words > 0)
      $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
   return $phrase;
}

// Twitter- og Facebookikoner

$litentwitt = "data:image/png;base64,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";
$litenface = "data:image/png;base64,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";
$generiskbokomslag = "data:image/png;base64,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";
?>