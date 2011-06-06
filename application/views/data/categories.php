<?php
  echo View::factory('shared/header');
?>

<ul>
<?php
	foreach($categories as $category) {
		echo '<li>',html::image($category->icon),html::chars($category->name),'</li>';
	}
?>
</ul>

<?php
  echo View::factory('shared/footer');
?>
