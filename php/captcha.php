<?php
/*
MicroTXT - A tiny PHP Textboard Software
Copyright (c) 2016 Kevin Froman (https://ChaosWebs.net/)

MIT License
*/
include('settings.php');

// Securely generate captcha
$captchaBytes = 3;
$text = bin2hex(openssl_random_pseudo_bytes($captchaBytes));
$_SESSION['captchaVal'] = $text;

// Create a blank image and add some text
$im = imagecreatefromjpeg("captchabg.jpg");
$text_color = imagecolorallocate($im, 233, 14, 91);

  $linecolor = imagecolorallocate($im, 0xCC, 0xCC, 0xCC);
  // draw random lines on canvas
  for($i=0; $i < 6; $i++) {
    imagesetthickness($im, rand(1,3));
    imageline($im, 0, rand(0,30), 120, rand(0,30), $linecolor);

  }

imagestring($im, 5, rand(1, 100), rand(1, 20),  $text, $text_color);

// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');

// Output the image
imagejpeg($im);

// Free up memory
imagedestroy($im);
?>
