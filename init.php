<?php
/*
Plugin Name: Intopmedia Telegram Bot
Description: Плагин реализации Telegram бота.
Version: 2.1.1
Author: Ruslan Heorhiiev
*/

define('INTOPMEDIA_TG', __FILE__);
define('INTOPMEDIA_TG_DIR', plugin_dir_path(INTOPMEDIA_TG));
define('INTOPMEDIA_TG_V', '2.1.1');

include 'inc/ajax.php';
include 'inc/functions.php';
include 'inc/telegram.php';