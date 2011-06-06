<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Map extends Controller {
  public function action_map($user_id = false) {
    $m = new Mongo();
    $locations = $m->foursquare->locations;
    $venues = $locations->findOne(array('_id'=>$user_id));
    if(null === $venues) {
      $this->response->body(View::factory('fail'));
      return;
    }
    
    $this->response->body(
      View::factory('map/map')
        ->bind('venues', $venues)
    );
  }
}