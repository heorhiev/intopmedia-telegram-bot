<?php
/**
 * Файл класса команды "start"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Settings;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class StartCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "start";


    /**
     * @var string Command Description
     */
    protected static $description = "\xF0\x9F\x8F\xA0"; 


    /**
     * @var string Command Button Text
     */
    protected static $buttonText = "\xF0\x9F\x8F\xA0 На главную";            
    
       
    /**
     * @var bool Is the step command?
     */
    protected static $resetStorage = true;      
            
            
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);                                                        
        
        $textMessage = Settings::getStartText(); 
        
        // список команд
        $commands = $bot::getMenu();        
        $buttons  = [];
        
        foreach ($commands as $command) {                        
            $buttons[] = [[
                'text' => call_user_func([
                    $command, 
                    'getDescription'
                ]), 
                'callback_data' => call_user_func([
                    $command, 
                    'getCommand'
                ])
            ]];            
        }
        
        $keyboard = new InlineKeyboardMarkup($buttons); 
        
        $bot->sendMessage($textMessage, $keyboard);
    }    
}