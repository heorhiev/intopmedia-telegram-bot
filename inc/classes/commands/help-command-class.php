<?php
/**
 * Файл класса команды "help"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Settings;

class HelpCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "help";


    /**
     * @var string Command Description
     */
    protected static $description = "\xF0\x9F\x99\x8B";  
            
            
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);                            
        
        // список команд
        $commands = $bot::getCommands();        
        $response = Settings::getHelpText() . PHP_EOL;
        
        unset(
            $commands['beffollow'], 
            $commands['mysubscriptioncountry']
        );
        
        foreach ($commands as $name => $command) {
            $response .= sprintf(
                '/%s - %s' . PHP_EOL, 
                $name, 
                call_user_func([$command, 'getDescription']
            ));
        }

        // отправка списка команда
        $bot->sendMessage($response);
    } 
    
}