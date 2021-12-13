<?php
/**
 * Файл регистрации Ajax функций
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 

/**
 * Общение через Telegram API
**/
function intopmedia_tg_bot_api_request() { 

    Intopmedia\TG\Controllers\Communication::main();
    
    exit;
}

add_action('wp_ajax_tg_bot_api', 'intopmedia_tg_bot_api_request');
add_action('wp_ajax_nopriv_tg_bot_api', 'intopmedia_tg_bot_api_request');

