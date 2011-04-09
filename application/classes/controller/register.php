<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Register extends Controller {

  private function load_config() {
    $this->foursquare_api_conf = Kohana::config('foursquare_api');
  }

public function action_t() {
  echo 'worked ',Arr::get($_GET,'t','failed');
}

public function action_test() {
  $r = Request::factory('http://localhost/~ddunlop/4sq/register/t');
  $r->query('t','WOOOO');
echo 'here';
  echo $r->render();
echo 'here';
  echo $r->execute();
echo 'here';
}

  public function action_index() {
    $this->load_config();

    $url = $this->foursquare_api_conf['authorize_url'] . '?'
      .'client_id='.$this->foursquare_api_conf['client_id']
      .'&response_type=code'
      .'&redirect_uri='.$this->foursquare_api_conf['redirect_uri'];
    $this->request->redirect($url);
  }

  public function action_4sqcallback() {
    $this->load_config();

    $url = $this->foursquare_api_conf['access_url'].'?'
      .'client_id='.$this->foursquare_api_conf['client_id']
      .'&client_secret='.$this->foursquare_api_conf['client_secret']
      .'&grant_type=authorization_code'
      .'&redirect_uri='.$this->foursquare_api_conf['redirect_uri']
      .'&code='.Arr::get($_GET,'code',false);

    $token = json_decode(Remote::get($url));

    $user = ORM::factory('user')
      ->where('token','=',$token->access_token)
      ->find();
    $user->token = $token->access_token;
    $user->save();
    $this->request->redirect('data/load/' . $user->id);
  }

}
