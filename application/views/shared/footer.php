<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
 <script>window.jQuery || document.write("<script src='js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>


 <!-- scripts concatenated and minified via ant build script-->
<?php
echo html::script('media/js/plugins.js'),html::script('media/js/script.js')
?>

 <!-- end scripts-->

<?php
	echo View::factory('profiler/stats');
?>

</body>
</html>
