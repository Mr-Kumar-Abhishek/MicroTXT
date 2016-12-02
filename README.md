# MicroTXT 💻

A tiny [textboard style](https://en.wikipedia.org/wiki/Textboard) software written in PHP, no database required.

It is meant to be simple to use and host.

## Features

* ✅ Only PHP 5.x+ required (No database!)
* ✅ Hidden/unlisted threads (start your thread title with .)
* ✅ MOTDs
* ✅ Less than 300kb uncompressed
* ✅ Markdown for parent posts
* ✅ No JavaScript required (JavaScript is used minimally but only to increase usability)

## Installing

MicroTXT is only tested in a Linux environment, however, it should work on Windows/Unix with little to no modification.

Simply download and place the files in your PHP 5+ enabled website directory, and edit php/settings.php to your liking. You should probably also change rules.txt and faq.txt too.

**You also need the GD PHP library installed on your PHP instance if you want to use the included captcha**

## Configuring

Just edit php/settings.php

To disable the captcha just change $captcha to false, or to make the captcha appear every time, change $postsBeforeCaptcha to 0.

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
