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
//$more = false;
      $offset += $limit;
    } while($more);

    $this->response->body(View::factory('data/map')
      ->bind('checkins',$checkins)
      ->bind('user_id', $id)
    );
      
/*
    $this->response->body(View::factory('data/load')
      ->bind('checkins',$checkins)
    );
    */
  }

	public function action_categories() {
		$categories = ORM::factory('category')->find_all();
		$this->response->body(
			View::factory('data/categories')
				->bind('categories',$categories)
		);
	}

  public function action_load_categories() {
	$this->load_config();

	$user = ORM::factory('user',1);
    $url = $this->foursquare_api_conf['categories_url'].'?'
 		.'oauth_token='.$user->token;
	$data = json_decode(Remote::get($url));
	if($data->meta->code !== 200) {
		echo 'error response code: ',$data->meta->code;
		die;
	}
	$categories = $data->response->categories;
	foreach($categories as $category) {
		$db_cat = ORM::factory('category')
			->where('name','=',$category->name)
			->where('4sq_id','=',null)
			->find();
		foreach($category as $attr => $value) {
			if(!is_array($value)) {
				if('id' == $attr) {
					$attr = '4sq_id';
				}
				echo 'attr: ',$attr,' value:',$value,'<br/>';
				$db_cat->$attr = $value;
			}
		}
		$db_cat->save();
		if(isset($category->categories)) {
			$this->_load_sub_categories($category->categories,$db_cat->id);
		}
	}
	echo '<pre>';
	print_r($categories);
	echo '</pre>';
	echo View::factory('profiler/stats');
  }

	private function _load_sub_categories($categories, $parent = null) {
		foreach($categories as $category) {
			$db_cat = ORM::factory('category')
				->where('4sq_id','=',$category->id)
				->find();
			foreach($category as $attr => $value) {
				if(is_array($value)) continue;
				if($attr == 'id') {
					$attr = '4sq_id';
				}
				$db_cat->$attr = $value;
			}
			$db_cat->parent = $parent;
			$db_cat->save();
			if(isset($category->categories)) {
				$this->_load_sub_categories($category->categories,$db_cat->id);
			}
		}
	}

}
