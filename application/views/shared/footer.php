<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
 <script>window.jQuery || document.write("<script src='js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>


 <!-- scripts concatenated and minified via ant build script-->
<?php
echo html::script('media/js/plugins.js'),html::script('media/js/script.js');

if(isset($script)) {
  echo html::script($script);
}
?>

 <!-- end scripts-->

<?php
//	echo View::factory('profiler/stats');
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-87184-3']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_trackPageLoadTime']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>
