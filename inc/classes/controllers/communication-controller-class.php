<?php
/**
 * Файл класса коммуникации
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Controllers;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Storage;

class Communication {
    
    private static $bot;
    
    /**
     * Инициализация общения
    **/
    public static function main() {            

    	self::$bot = new Bot();    	
            	
    	$message = self::$bot->getMessage(); // получение объекта сообщения            	                
    	$command = $message->getCommand();  // получение команды, если ее передали 
        
        //$text    = $message->getParams(); // получение текста, если его передали (тут лежит все, что не является командой)
                      	
        // если комманда не введена, идет получение команды из предыдущего шага, вызов и восстановление
    	if (empty($command)) {
            $command = Storage::restoreCommand(
                $message->getChatId()
            );
    	} 

    	self::callCommand($command, $message);
    }
    
    /**
     * Вызов необходимого метода по комманде
    **/
    private static function callCommand($command, $message) {
        $class = self::$bot->getCommand($command);        

        if ($class) {    
            if ($class::isStep()) {
            	// сохранение команды, которую ввел пользователь
                $params = $message->getParams();

                if (stristr($command, 'checkpay') && $command != 'checkpay') {
                    $command = self::clearCheckPay($command);
                }

                Storage::storeCommand(
                    $message->getChatId(), 
                    $command . ' ' . $params
                );
            }
            
            $class::handler(self::$bot, $message);           
        }
    }  
    
    
    /**
     * Очищает параметры
     */
    private static function clearCheckPay($params) {
        $params = explode(' ', $params);
        unset($params[3], $params[4]);
        return implode(' ', $params);
    }
}