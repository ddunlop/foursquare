<!DOCTYPE html>
<html>
<head>
<title>4sq</title>
</head>
<body>
<?php
	echo 'checkins: ', count($checkins);


	$parents = array();
	$cat = array();
	
    foreach($checkins as $item) {
      if('checkin' == $item->type) {
        $cats = $item->venue->categories;
        foreach($cats as $cat) {
/*
	  if(!isset($cat->primary) || !$cat->primary) {
	    break;
	  }
*/
		$gcat = new stdClass();
		$gcat->name = $cat->name;
		$gcat->icon = $cat->icon;
		$gcats[$cat->name]
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
    if(strpos($parent, 'Nightlife Spots') === false) {
      continue;
    }
    echo '<li>',$parent,'<ol>';
    foreach($places as $place) {
      echo '<li>',$place->name,' ',date('r',$place->timestamp),'</li>';
    }
    echo '</ol></li>';
  }


echo '<pre>';
print_r($checkins);
echo '</pre>';

?>
</body>
