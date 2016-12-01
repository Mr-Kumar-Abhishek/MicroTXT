<?php
/*
MicroTXT - A tiny PHP Textboard Software
Copyright (c) 2016 Kevin Froman (https://ChaosWebs.net/)

MIT License
*/
include('php/settings.php');
include('php/csrf.php');
include('php/Parsedown.php');

$Parsedown = new Parsedown();

function tripcode($tripcode)
{
	if ($tripcode == '')
	{
		return '';
	}
	else
	{
		return '<input type="text" readonly value="' . hash('sha256', $tripcode . $salt) . '" class="tripcode">';
	}
}

// Redirect if some BS is going on
function redirectError()
{
	setcookie('microtxterror', 'true', time()+3600);
	header('location: index.php');
	die(0);
}

if (! isset($_POST['text']) || ! isset($_POST['CSRF']) || ! isset($_POST['title']) || ! isset($_POST['name']) || ! isset($_POST['tripcode']))
{
	redirectError();
}

if ($_POST['CSRF'] != $_SESSION['CSRF'])
{
	redirectError();
}


if ($captcha)
{
	if (! isset($_SESSION['currentPosts']))
	{
		$_SESSION['currentPosts'] = $postsBeforeCaptcha;
	}
	if ($_SESSION['currentPosts'] >= $postsBeforeCaptcha)
	{
		if (! isset($_POST['captcha']))
		{
			redirectError();
		}
		if ($_POST['captcha'] != $_SESSION['captchaVal'])
		{
			redirectError();
		}
		else
		{
			$_SESSION['currentPosts'] = 0;
		}
	}
}


// Get user data

$text = $_POST['text'];
$title = $_POST['title'];
$name = $_POST['name'];
$tripcode = $_POST['tripcode'];

if (strlen($_POST['text']) > 100000 || strlen($_POST['title'] > 20) || strlen($_POST['name'] > 20) || strlen($_POST['tripcode'] > 100))
{
	redirectError();
}

// html encode user data to prevent xss
$text = htmlentities($text);
$text = $Parsedown->text($text);

$title = str_replace('/', '', $title);
$title = str_replace('\\', '', $title);
$title = str_replace('#', '', $title);
$title = str_replace('&', '', $title);
$title = str_replace('.', '', $title);

if ($title == ''){
	redirectError();
}

$title = htmlentities($title);
$name = htmlentities($name);
$tripcode = htmlentities($tripcode);

// Create the new page file

$currentCount = (int) file_get_contents('threadCount.txt');
$newCount = $currentCount + 1;
$newCount = "$newCount";
file_put_contents('threadCount.txt', $newCount, LOCK_EX);

// Make the new post file
$title = rtrim(ltrim($title));

if (! $allowHidden)
{
	$title = ltrim($title, '.');
}

$postFile = 'posts/' . $title . ' - ' . $newCount . '.html';

$postID = time();

$doctype = '<!DOCTYPE HTML>';
$compiled =  $doctype . '<div class="title">' . $title . '</div><div class="name">' . $name . '</div>' . tripcode($tripcode) . ' <div class="postID" id="OP" onClick="javascript: clickItem(\'OP\');">' . $postID . '</div> <div class="post" id="post">' . $text . '</div><span id="' . $postID . '"></span>';


file_put_contents($postFile, $compiled, LOCK_EX);

if ($captcha)
{
	$_SESSION['currentPosts'] = $_SESSION['currentPosts'] + 1;
}

header('location: view.php?post=' . $title . ' - ' . $newCount);

?>
