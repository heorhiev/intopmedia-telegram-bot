<?php
/**
 * Файл класса команды "regulations"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Settings;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class RegulationsCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "regulations";


    /**
     * @var string Command Description
     */
    protected static $description = "\xF0\x9F\x9B\x82 Правила";  

        
    /**
     * @var string Command Button Text
     */
    protected static $buttonText = "\xF0\x9F\x9B\x82 Правила";
            
            
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);    
              
        $message = trim(static::getTitle()) . PHP_EOL . PHP_EOL;
        $message .= Settings::getRegulationsText() . PHP_EOL;

        $buttons[] = [StartCommand::getButton()]; 

        $keyboard = new InlineKeyboardMarkup($buttons);
        
        $bot->sendMessage($message, $keyboard);
    }    
}