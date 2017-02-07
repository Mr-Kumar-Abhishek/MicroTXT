<?php
/*
MicroTXT - A tiny PHP Textboard Software
Copyright (c) 2016 Kevin Froman (https://ChaosWebs.net/)

MIT License
*/
include('php/settings.php');
include('php/csrf.php');
include('php/sqlite.php');
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
		<h3>Threads:</h3><br>
		<table><tr><th>Title</th><th>Author</th></tr>
		<?php
		$max = 0; // Largest thread number in database
		$threadDisplayCount = 1;
		$countReached = false;
		$lastID = 1;
		if (! isset($_GET['range'])){
			$requestRange = 0;
		}
		else{
			$requestRange = $_GET['range'];
		}

		$requestRange = $db->escapeString($requestRange);

	 $sql =<<<EOF
		 SELECT MAX(ID) from threads;
EOF;
$ret = $db->query($sql);

if ($ret == false){
	echo '<p style="color: red;">No posts!</p>';
}

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
		 $max = $row['MAX(ID)'];
	 }

	 // Get all threads within the specified range

	 $sql =<<<EOF
	   SELECT * FROM Threads ORDER BY ROWID DESC LIMIT $threadListLimit OFFSET $requestRange;
EOF;
	$ret = $db->query($sql);
	while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
		echo '<tr><td><a href="view.php?post=' . $row['TITLE'] . '">' . $row['TITLE'] . '</a></td><td>' . $row['AUTHOR'] . '</td></tr>';
		$lastID = $row['ID'];
	}
	echo '</table>';

	if ($requestRange > 0){
			echo '<a href="index.php?range=' . ($requestRange - $threadListLimit) . '"><button>Back</button></a>';
	}
	if (intval($lastID) != 1){
		echo '<br><br><a href="index.php?range=' . ($requestRange + $threadListLimit) . '"><button>Next</button></a>';
	}

	$db->close();
?>
	</div>
	<?php
	$error = '';
	if ($motd)
	{
		echo '<div class="motd">' . file_get_contents('motd.txt') . '</div>';
	}
	if (isset($_SESSION['mtPostError'])){
		if ($_SESSION['mtPostError']){
			if (isset($_SESSION['mtPostErrorTxt'])){
				$error = htmlentities($_SESSION['mtPostErrorTxt']);
			}
			echo '<div style="color: red; text-align: center; margin-bottom: 1em;">There was an error publishing your post: ' . $error . '</div>';
			$_SESSION['mtPostError'] = false;
		}
	}
	?>
	<div class='postForm'>
		<form method='post' action='submit.php'>
			<label>Title: <input required type='text' name='title' maxlength='20'></label>
			<br><br>
			<label>Name: <input required type='text' name='name' maxlength='20' value='Anonymous'></label>
			<br><br>
			<label>Tripcode: <input type='password' name='tripcode' maxlength='100' placeholder='optional'></label>
			<br><br>
			<textarea required name='text' maxlength='100000' placeholder='Text Post' cols='50' rows='10'></textarea>
			<br><br>
			<input type='hidden' name='CSRF' value='<?php echo $CSRF;?>'>
			<br>
			<?php
			if ($captcha) {
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
<?php
if ($keepSessionAlive == true){
	echo '<iframe src="keep-alive.php" style="display: none;"></iframe>';
}
?>
</body>
</html>