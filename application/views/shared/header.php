<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo url::site('favicon.ico'); ?>">
  <link rel="apple-touch-icon" href="<?php echo url::site('apple-touch-icon.png'); ?>">

	<?php
		echo html::style('media/css/style.css?v=2', array('type'=>null)),
			html::script('media/js/libs/modernizr-1.7.min.js');
	?>

</head>

<body>