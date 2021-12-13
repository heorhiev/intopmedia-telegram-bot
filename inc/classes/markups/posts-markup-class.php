<?php
/**
 * Файл класса маркерирования записей
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Markups;

use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class PostsMarkup extends Markup {        
    
    public function getInlineKeyboard($afterButtons = []) {
        
        $posts = $this->getPosts();
        $buttons  = [];        
        
        $i = 0;
        $delimer = 6 < count($posts) ? 1 : 0;
        
        foreach ($posts as $post) {
            $c = sprintf("%s %s", $this->getCommand(), $post->ID);

            if ($icon = get_post_meta($post->ID, 'emoji_icon', 1)) {
                $icon = "{$icon} ";
            }
            
            $buttons[$i][] = [
                'text'          => $icon . $post->post_title, 
                'callback_data' => $c
            ]; 
            
            if ($delimer < count($buttons[$i])) {
                $i++;    
            }
        } 
        
        if ($afterButtons) {
            foreach ($afterButtons as $afterButton) {
                $buttons[] = [$afterButton];    
            }  
        }
        
        return new InlineKeyboardMarkup($buttons);
    }
    
    private function getPosts() {
        $args = array_merge($this->getQuery(), [
            'posts_per_page' => 99,
        ]);
        
        return get_posts($args);
    }    
    
}