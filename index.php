<?php
/*
MicroTXT - A tiny PHP Textboard Software
Copyright (c) 2016 Kevin Froman (https://ChaosWebs.net/)

MIT License
*/
include('php/settings.php');
include('php/csrf.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title><?php echo $siteTitle; ?></title>
	<link rel="icon" type="image/x-icon" href="favicon.png?v=1">
	<link rel='stylesheet' href='theme.css'>
</head>
<body>
	<h1 class='center logo'><?php echo $siteTitle;?></h1>

	<div id='postList'>
		Threads:<br><br>
		<?php
		// List current threads
		$files = glob('posts/*.html');
		foreach ($files as $file => $fileDisplay) {
			$fileDisplay = str_replace('.html', '', $fileDisplay);
			$fileDisplay = str_replace('posts/', '', $fileDisplay);
			$pos = strrpos($fileDisplay, '-');
			echo '<a href="view.php?post=' . $fileDisplay . '">' . substr($fileDisplay, 0, $pos) . '</a>';
			echo '<br>';
		}
		?>
	</div>
	<?php
	if ($motd)
	{
		echo '<div class="motd">' . file_get_contents('motd.txt') . '</div>';
	}
	?>
	<div class='postForm'>
		<form method='post' action='submit.php'>
			<label>Title: <input required type='text' name='title' maxlength='20'></label>
			<br><br>
			<label>Name: <input required type='text' name='name' maxlength='20' value='Anonymous'></label>
			<br><br>
			<label>Tripcode: <input type='password' name='tripcode' maxlength='100'></label>
			<br><br>
			<textarea required name='text' maxlength='100000' placeholder='Text Post' cols='50' rows='10'></textarea>
			<br><br>
			<input type='hidden' name='CSRF' value='<?php echo $CSRF;?>'>
			<br>
			<?php
			if ($captcha)
			{
				if (! isset($_SESSION['currentPosts']))
				{
					$_SESSION['currentPosts'] = $postsBeforeCaptcha;
				}
				if ($_SESSION['currentPosts'] >= $postsBeforeCaptcha)
				{
					echo '<img src="php/captcha.php" alt="captcha">';
					echo '<br><br><label>Captcha Text: <input required type="text" name="captcha" maxlength="10"></label><br><br>';
				}
			}
			?>
			<input type='submit' value='Post' class='submitPostButton'>
			<br>
			<p>Be sure to <a href='rules.txt'>read the rules</a> before posting.</p>
			<p><a href='faq.txt'>FAQ</a></p>
		</form>
	</div>

</body>
</html>
