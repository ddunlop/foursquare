<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Trending extends Controller {
  public function action_index($user_id = false) {
    $m = new Mongo();
    $trending = $m->foursquare->trending;
    $venues = $trending->find()->sort(array('last'=>-1));
    if(null === $venues) {
      $this->response->body(View::factory('fail'));
      return;
    }
    
    $this->response->body(
      View::factory('trending/index')
        ->bind('venues', $venues)
    );
  }
}
