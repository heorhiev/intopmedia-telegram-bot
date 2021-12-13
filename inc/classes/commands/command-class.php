<?php
/**
 * Файл родительского класа комманд
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\Service\Render;
use Intopmedia\TG\Services\Storage;

class Command {  
    
    /**     
     * @var string Command Name
     */
    protected static $name;


    /**
     * @var string Command Description
     */
    protected static $description;    


    /**
     * @var string Command Button Text
     */
    protected static $buttonText;        
   
    
    /**
     * @var bool Is the step command?
     */
    protected static $isStep = false;  
    
       
    /**
     * @var bool Is the step command?
     */
    protected static $resetStorage = false; 
         
    
    
    /**
     * Get command name
     * @return string
     */
    public static function getName() {
        return static::$name;
    } 
    
    
    /**
     * Get command name
     * @return string
     */
    public static function getCommand() {
        return '/' . static::getName();
    }     
    
    
    /**
     * Get command decription
     * @return string
     */
    public static function getDescription() {
        return static::$description;
    }          
    
    
    /**
     * Command handler
     */
    public static function handler(Bot $bot) {
        if (static::$resetStorage) {
            Storage::reset(
                $bot->getMessage()->getChatId()
            );
        }
        
        /*file_put_contents(
            INTOPMEDIA_TG_DIR . 'test.txt',
            static::$name
        ); */       
    }
    
    
    /**
     * Is the step command?
     */    
    public static function isStep() {
        return static::$isStep;
    }    
    
    
    /**
     * Render template
     */
    protected static function render($part, $attributes = []) {
        return Render::get('telegram/' . $part, $attributes);
    } 
        
    
    /**
     * Button text
     */    
    protected static function getButtonText() {
        return static::$buttonText;
    }
    
        
    
    /**
     * Button
     */    
    protected static function getButton($params = '') {
        return [
            'text' => static::getButtonText(), 
            'callback_data' => join(' ', [
                static::getCommand(),
                $params
            ])                     
        ];
    } 
        
    
    /**
     * Back Button
     */    
    protected static function getBackButton($callback_data = []) {
        return [
            'text' => "\xF0\x9F\x94\x99 Назад", 
            'callback_data' => join(' ', $callback_data)                     
        ];
    }
    
    protected static function getTitle() {
        return '<b>' . static::getDescription() . '</b>' . PHP_EOL . PHP_EOL;
    } 
    
}
