# MicroTXT 💻

A tiny textboard software written in PHP, no database required.

It is meant to be simple to use and host.

## Features

* ✅ Only PHP 5.x+ required (No database!)
* ✅ Hidden/unlisted threads (start your thread title with .)
* ✅ MOTDs
* ✅ Less than 300kb uncompressed
* ✅ Markdown for parent posts
* ✅ No JavaScript required (JavaScript is used minimally but only to increase usability)

## Installing

Simply download and place the files in your PHP 5+ enabled website directory, and edit php/settings.php to your liking.

## Configuring

Just edit php/settings.php

To disable the captcha just change $captcha to false, or to make the captcha appear every time, change $postsBeforeCaptcha to true.

## Warnings

This is new, there may be some issues with it. 
Don't rely on it for huge communities, it doesn't scale for very high traffic projects (it's not meant to).
Change the salt in settings.php, otherwise tripcodes may be easier to brute force.

## Demo

You can use the demo board [on my website](https://chaoswebs.net/mt/).

## Donate 💲

If you want to support development, a dollar or two would be appreciated.

Bitcoin: 3GKzFQyfE35U6Gi9XeN3xGQ3tMZy3x2ByQ

[Or, donate another way](https://chaoswebs.net/?page=donate)
