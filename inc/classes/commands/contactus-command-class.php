<?php
/**
 * Файл класса команды "contactus"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Sharer;
use Intopmedia\TG\Services\Settings;
use Intopmedia\TG\Services\Storage;
use Intopmedia\Entety\Country;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class ContatcusCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "contactus";


    /**
     * @var string Command Button Text
     */
    protected static $buttonText = "\xE2\x9C\x89 Связаться с нами";      


    /**
     * @var string Command Description
     */
    protected static $description = "\xE2\x9C\x89 Связаться с нами";                       
      
    
    /**
     * @var bool Is the step command?
     */
    protected static $isStep = true;    
          
        
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);
                
        $text = $bot->getMessage()->getParams();
        $textMessage = static::getTitle();
        $keyboard = null;

        //file_put_contents(INTOPMEDIA_TG_DIR . '/test.txt', 'asdfasdf');
        
        if (!$text) {    
            $textMessage .= Settings::getContactusText();            
        } else {
            Storage::reset($bot->getMessage()->getChatId());
            
            $emailMessage  = 'Username: <a href="https://t.me/' . $bot->getMessage()->getUsername() . '">@' . $bot->getMessage()->getUsername() . '</a>;';
            $emailMessage .= '<br><br>';
            $emailMessage .= 'Message:<br>';
            $emailMessage .= $text;
            
            wp_mail(
                Settings::getContactusEmail(),
                $bot::NAME .  ' @' . $bot->getMessage()->getUsername(), 
                $emailMessage
            );
                                              
            $textMessage .= Settings::getContactusSuccessText();                                   
        }
        
        $buttons = [[StartCommand::getButton()]];                             
            
        $keyboard = new InlineKeyboardMarkup($buttons);         
        
        $bot->sendMessage($textMessage, $keyboard);               
    }        
}