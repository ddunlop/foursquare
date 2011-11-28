<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Map extends Controller {
  public function action_index($user_id = false) {    
    $this->response->body(
      View::factory('map/map')
        ->set('venues', array())
    );
  }
  
  public function action_ajax($user_id = false) {
    if( false === $user_id ) {
      return false;
    }
    
    $bounds = Arr::get($_GET, 'bounds', false);
    if( false == $bounds ) {
      return;
    }
    
    $bounds = explode(',', $bounds);
    $bounds = array(
      array((float)$bounds[0], (float)$bounds[1]),
      array((float)$bounds[2], (float)$bounds[3])
    );
    /*
    > box = [[40.73083, -73.99756], [40.741404,  -73.988135]]
    > db.locations.find({"loc" : {"$within" : {"$box" : box}}})
    */
    $m = new Mongo();
    $locations = $m->foursquare->locations;
    $venues = $locations->find(array(
      'loc' => array(
        '$within' => array(
          '$box' => $bounds
        )
      )
      ))
      ->limit(100)
      ->sort(
        array('count' => -1)
      );
      
    $this->response->headers('Content-type', 'application/json');
    $this->response->body(
      View::factory('map/ajax')
        ->bind('venues', $venues)
    );
  }
}
