<?php
/**
 * Файл класса команды "pricelist"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Markups\PostsMarkup;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class PricelistCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "pricelist";


    /**
     * @var string Command Button Text
     */
    protected static $buttonText = "\xE2\x9E\xA1 Прайс-лист";
     
    

    /**
     * @var string Command Description
     */
    protected static $description = "\xE2\x9E\xA1 Прайс-лист";                       
      
    
    /**
     * @var bool Is the step command?
     */
    protected static $isStep = true; 
          
        
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);

        $textMessage = trim(static::getTitle());
/*
        $bot->sendMessage('dddd');
        exit;
*/
        $posts = get_posts([
            'posts_per_page' => 99,
        ]);

        foreach ($posts as $key => $post) {
            $textMessage .= PHP_EOL . PHP_EOL;
            $textMessage .= '<b>' . $post->post_title . '</b>' . PHP_EOL;
            $textMessage .= wp_trim_words(strip_tags($post->post_content), 50);
        } 

        $textMessage .= PHP_EOL . PHP_EOL;

        $textMessage .= "\xE2\x9C\x85 <b>Выбор товара:</b>";

        $markup = new PostsMarkup(ProductCommand::getCommand());
        
        $keyboard = $markup->getInlineKeyboard([
            StartCommand::getButton()
        ]);
        
        //$keyboard = new InlineKeyboardMarkup($buttons);      
        
        //$buttons = [[StartCommand::getButton()], [StartCommand::getButton()]];                             
            
        //$keyboard = new InlineKeyboardMarkup($buttons);   
        
        $bot->sendMessage($textMessage, $keyboard);
    }        
}