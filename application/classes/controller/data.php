<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Data extends Controller {

  public function action_index() {
    $this->request->response = View::factory('data/index');
  }

  private function load_config() {
    $this->foursquare_api_conf = Kohana::config('foursquare_api');
  }

  public function action_load($id = false) {
    $this->load_config();

    $user = ORM::factory('user',$id);

    if(!$user->loaded()) {
      $this->response->body(View::factory('fail'));
      return;
    }

    $checkins = array();
    $offset = 0;

    $date = new DateTime();
    $year = new DateInterval('P1Y');
    $one_year_ago = $date->sub($year)->format('U')-1;

    $limit = 250;

    do {
      $url = $this->foursquare_api_conf['checkins_url'].'?'
	.'oauth_token='.$user->token
	.'&limit='.$limit
	.'&offset='.$offset
	.'&afterTimestamp='.$one_year_ago;
      $json = json_decode(Remote::get($url));
      $items = $json->response->checkins->items;

      $checkins = array_merge($checkins,$items);

      $more = count($items) == $limit;
$more = false;
      $offset += $limit;
    } while($more);

    $this->response->body(View::factory('data/load')
      ->bind('checkins',$checkins)
    );
  }

} // End Welcome
