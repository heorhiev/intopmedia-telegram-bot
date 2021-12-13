<?php
/**
 * Файл класса телеграм бота
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG;

use Intopmedia\TG\Services\Message;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

class Bot {
    
    const API_TOKEN = '1956972988:AAHrlSJhWcxZMvwEaroN-Qd9Dk25wODECQA';
    
    const NAME = 'helldp4bot';
    
    private static $commands = [
        'start'       => 'Intopmedia\TG\Commands\StartCommand',
        'help'        => 'Intopmedia\TG\Commands\HelpCommand',
        'pricelist'   => 'Intopmedia\TG\Commands\PriceListCommand',
        'product'     => 'Intopmedia\TG\Commands\ProductCommand',
        'order'       => 'Intopmedia\TG\Commands\OrderCommand',
        'checkpay'    => 'Intopmedia\TG\Commands\CheckPayCommand',
        'regulations' => 'Intopmedia\TG\Commands\RegulationsCommand',
        'contactus'   => 'Intopmedia\TG\Commands\ContatcusCommand',
    ];
    
    private static $bot;
    private static $update;
    private static $message;
    

    public function __construct($data = []) {
        self::$bot = new BotApi(self::API_TOKEN);        
        
        if (empty($data)) {
            $data = BotApi::jsonValidate(self::getRaw(), true);
        } 

        self::$update = Update::fromResponse($data);
    }
    
    
    /**
     * Выполнение команды
     * @return this
    */    
    public function executeCommand($command) {
        try { 
            $class = self::getCommand($command);
            $class::handler($this);
        } catch (\TelegramBot\Api\Exception $e) {
            $e->getMessage();
        }         
        
        return $this;
    }
    
           
    public static function answerCallbackQuery($text = '', $popup = false) {
        self::getRequest()->answerCallbackQuery(
            self::getMessage()->getCallbackId(),
            $text,
            $popup
        );
    }
    
        
    /**
     * Отправка сообщения
     * @return result
    */    
    public static function sendMessage($textMessage, $keyboard = null, $acceptEdit = true) {           

        if (self::getMessage()->isCallbackQuery()) {            
            //self::answerCallbackQuery();
        }

        if ($acceptEdit && self::getMessage()->isEdited()) {                        
            return self::getRequest()->editMessageText(
                self::getMessage()->getChatid(), 
                self::getMessage()->getId(), 
                $textMessage, 
                'HTML', 
                true, 
                $keyboard
            );    
        } else {
            return self::getRequest()->sendMessage(
                self::getMessage()->getChatid(), 
                $textMessage, 
                'HTML', 
                true, 
                null,
                $keyboard
            );  
        }        
    }      
    

    /**
     * Возвращает объект сообщения
     * @return  Intopmedia\TG\Message
    */
    public static function getMessage() {
  
        if (!self::$message) {
            self::$message = new Message(self::$update);
        }
        
        return self::$message;
    }    
    

    /**
     * API методы
     * @return bot api
    */
    public static function getRequest() {
        return self::$bot;
    }  
    
    
    /**
     * Возвращает класс команды
     * @return class
    */    
    public static function getCommand($command) {
        $commands = self::getCommands();

        $command = trim($command);

        if ($pos = strpos($command, " ")) {
            $command = substr($command, 0, $pos);
        }
        
        if (isset($commands[$command])) {
            return $commands[$command];
        }
        
        return null;
    }        
    

    /**
     * Возвращает команды
     * @return array
    */    
    public static function getCommands() {
        return self::$commands;
    } 
    

    /**
     * Возвращат меню
     * @return array
     */
    public static function getMenu() {
        return [
            self::$commands['pricelist'],            
            self::$commands['regulations'], 
            self::$commands['contactus'],         
        ];
    }          
    

    /**
     * Вовзращает полученные данные
     * @return json
    */
    private static function getRaw() {
        return file_get_contents('php://input');
    }
}