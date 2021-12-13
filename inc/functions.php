<?php
/**
 * Файл функций
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */


/**
 * Функция выполняет поиск
**/
function intopmedia_get_term($s) {
    
    global $wpdb;    
	
    $sql = $wpdb->prepare(
        "SELECT *
        FROM `{$wpdb->terms}`
        WHERE 
            `name` LIKE %s
        LIMIT 10;",
        '%' . $wpdb->esc_like($s) . '%'
    );  
    
    return $wpdb->get_row($sql);    
}


/**
 * Функция выполняет поиск
**/
function intopmedia_get_post($s, $post_type = 'post') {
    
    global $wpdb;    
	
    $sql = $wpdb->prepare(
        "SELECT *
        FROM `{$wpdb->posts}`
        WHERE 
            `post_status` = 'publish' AND
            `post_type` = %s AND
            `post_alt` LIKE %s
        LIMIT 10;",
        $wpdb->_escape($post_type),
        '%' . $wpdb->esc_like($s) . '%'
    );  
    
    return $wpdb->get_row($sql);    
}
