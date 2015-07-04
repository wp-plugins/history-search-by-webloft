<?php

// Fjerne rusk og rask i treff

// array_filter uten argumenter fjerner tomme elementer
$treff = array_filter( $treff );

// Fjerner linjeskift (/r og /n) samt tab (/t) og whitespace foran og bak (trim)
foreach($treff as &$changetreff) {
	$changetreff['beskrivelse'] = trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $changetreff['beskrivelse']));
}

?>
