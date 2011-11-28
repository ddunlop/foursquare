<!DOCTYPE html>
<html>
<head>
<title>4sq</title>
</head>
<body>
<?php
 echo 'checkins: ', count($checkins);

  $venues = array();
  foreach($checkins as $item) {
    if(isset($item->venue)) {
      if(!array_key_exists($item->venue->id, $venues)) {
        $venues[$item->venue->id] = array(
          '_id' => $user_id . '-' . $item->venue->id,
          'user_id' => (int)$user_id,
          'name' => $item->venue->name,
          'loc' => array(
            $item->venue->location->lat,
            $item->venue->location->lng,
            
          ),
          'count' => 0,
        );
      }
      $venues[$item->venue->id]['count']++;
    }
  }
  
  $m = new Mongo();
  $loc = $m->foursquare->locations;
//  $venues['_id'] = $user_id;
//  $loc->update(array('_id'=>$user_id), $venues, array('upsert'=>true));
  foreach($venues as $id => $data) {
    $loc->update(
      array('_id' => $user_id . '-' . $id ),
      $data,
      array('upsert' => true)
    );
  }

  echo '<p>', html::anchor('map/' . $user_id, 'See Map'), '</p>';
?>
</body>
