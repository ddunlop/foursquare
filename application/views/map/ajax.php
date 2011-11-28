<?php
$out = array();
foreach($venues as $venue) {
  array_push($out, $venue);
}

echo json_encode( $out );