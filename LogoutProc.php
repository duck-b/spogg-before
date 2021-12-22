<html>
	<style>
	body
		{
		 text-align: center;
		 margin: 0 auto;
		}


	#box
		{
		 position: absolute;
		 width: 50px;
		 height: 50px;
		 left: 50%;
		 top: 50%;
		 margin-left: -25px;
		 margin-top: -25px;
		}
	</style>
<?php
	setcookie('user_no', '', time()-3600, '/');
	setcookie('player_no', '', time()-3600, '/');
	setcookie('admin', '', time()-3600, '/');
    session_start();
    session_destroy();
?>
<body>
	<img id="box" src="img/loading.gif" alt="loading">
</body>
<meta http-equiv="refresh" content="0;url=index.html" />
</html>