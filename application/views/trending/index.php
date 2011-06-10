<?php
  echo View::factory('shared/header');
?>

<ul>
<?php
  foreach($venues as $venue) {
    echo '<li>';
    $last = '';
    if(array_key_exists('last', $venue)) {
      $last = date('Y-M-d H:i', $venue['last']->sec);
    }
    $address = '';
    if(array_key_exists('address', $venue['location'])) {
      $address = $venue['location']['address'];
    }
    echo $venue['name'], ' - ', $address, ' ', $last;
    $stats = array();
    foreach($venue['here'] as $trend) {
      array_push($stats, $trend['count']);
    }

    echo 'min of trending: ',count($stats), ' max: ',max($stats);
    echo '<div><img src="https://chart.googleapis.com/chart?chs=100x75&cht=ls&chco=0077CC&chd=t:', implode(',', $stats), '"></div>';
    echo '</li>';
  }
?>
</ul>

<?php
  echo View::factory('shared/footer');
?>
