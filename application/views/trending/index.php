<?php
  echo View::factory('shared/header')
    ->set('title', "What's trending now");
?>

<ul>
<?php

// This code is hacky, buckets may not have the proper min_per_pixel if there are to many data points, and because buckets may not be even
$now = new DateTime();//date('c',1307624347));
$day = new DateInterval('P1D');
$start = clone $now;
$start->sub($day);

//echo 'now: ', $now->format('Y-m-d H:i:s'), ' start: ', $start->format('Y-m-d H:i:s'), PHP_EOL;


$image_width = 100;

$start_sec = $start->format('U');
$end_sec = $now->format('U');

$minutes_per_day = floor( ( $end_sec - $start_sec ) / 60);

$min_per_pixel = floor( $minutes_per_day / $image_width );

$div = $minutes_per_day / $image_width;

foreach($venues as $venue) {
  $counts = array();
  $relivent = false;
  $max = 0;
  foreach($venue['here'] as $here) {
    if($here['date']->sec < $start_sec || $here['date']->sec > $end_sec) {
      continue;
    }
    $bucket = floor( ( $here['date']->sec - $start_sec ) / ( 60 * $div ) );
    $counts[$bucket] []= $here['count'];
    if($max <  $here['count']) {
      $max = $here['count'];
    }
    $relivent = true;
  }
  
  if(!$relivent) {
    continue;
  }

  for($i = 0 ; $i < $image_width ; $i++) {
    if(!array_key_exists($i, $counts)) {
      $counts[$i] = 0;
    }
    else {
      $counts[$i] = round ( array_sum($counts[$i]) / $min_per_pixel );
    }
  }
  ksort($counts);
  $address = '';
  if(array_key_exists('address', $venue['location'])) {
    $address = $venue['location']['address'];
  }
  echo '<li>', $venue['name'], ' ', $address, '  max: ', $max,
    '<img src="http://chart.googleapis.com/chart?chs=',
    $image_width ,'x75&cht=ls&chco=0077CC&chd=t:',
    implode(',', $counts), '"></li>';
}
?>
</ul>

<?php
  echo View::factory('shared/footer');
?>
