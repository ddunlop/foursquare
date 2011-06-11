<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Trending extends Controller {
  public function action_index($user_id = false) {
    $m = new Mongo();
    $trending = $m->foursquare->trending;
    $now = new DateTime();
    $day = new DateInterval('P1D');
    $yesterday = $now->sub($day);
    $venues = $trending->find(array(
      'last' => array('$gt' => new MongoDate($yesterday->format('U')))
    ))->sort(array('last'=>-1));
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
