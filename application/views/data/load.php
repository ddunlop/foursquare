<!DOCTYPE html>
<html>
<head>
<title>4sq</title>
</head>
<body>
<?php
 echo 'checkins: ', count($checkins);

  $parents = array();
    foreach($checkins as $item) {
      if('checkin' == $item->type) {
        $cats = $item->venue->categories;
        foreach($cats as $cat) {
/*
	  if(!isset($cat->primary) || !$cat->primary) {
	    break;
	  }
*/
	  foreach($cat->parents as $parent) {
	    $c = new stdClass();
	    $c->name = $item->venue->name;
	    $c->timestamp = $item->createdAt;
	    $parents[$cat->name.' '.$parent][$item->id] = $c;
	  }
        }
      }
      else {
      }
    }
  foreach($parents as $parent => $places) {
    echo '<li>',$parent,'<ol>';
    foreach($places as $place) {
      echo '<li>',$place->name,' ',date('r',$place->timestamp),'</li>';
    }
    echo '</ol></li>';
  }

/*
echo '<pre>';
print_r($checkins);
echo '</pre>';
*/
?>
</body>
