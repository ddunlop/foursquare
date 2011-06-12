<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Trending extends Controller {
  public function action_index() {
    $this->getData(View::factory('trending/index'));
  }
  
  public function action_map() {
    $this->getData(View::factory('trending/map'));    
  }
  
  private function getData($view) {
    $m = new Mongo();
    $trending = $m->foursquare->trending;
    
    
    $end = new DateTime();//'2011-06-10T02:37:00.000Z');;

    $delta = new DateInterval('P1D');
    
    $start = clone $end;
    $start->sub($delta);
    
    $venues = $trending->find(array(
      'last' => array(
        '$gt' => new MongoDate($start->format('U')),
        '$lt' => new MongoDate($end->format('U'))
      )
    ))->sort(array('last'=>-1));

    if(null === $venues) {
      $this->response->body(View::factory('fail'));
      return;
    }

    $this->response->body(
      $view
        ->bind('venues', $venues)
        ->bind('start', $start)
        ->bind('end', $end)
    );
  }
}
