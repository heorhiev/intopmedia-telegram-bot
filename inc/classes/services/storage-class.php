<?php
/**
 * Файл класса хранилища
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Services;

class Storage {
    
    const TABLE_NAME = 'sd_tg_storage_commands';    
    
    /**
     * Возвращает команду
     * @return string
    **/
    public static function restoreCommand($chatId) {
        global $wpdb;
        
        return $wpdb->get_var($wpdb->prepare(
        	'SELECT `command` FROM ' . self::TABLE_NAME .' WHERE `chat_id` = %d',
            $chatId
        ));
    }
    
    /**
     * Устанавливает команду
     * @return $chatId
    **/    
    public static function storeCommand($chatId, $command) {
        global $wpdb;
        
        if (self::restoreCommand($chatId)) {
            $wpdb->update(
                self::TABLE_NAME,
                ['command' => $command],
                ['chat_id' => $chatId],
                ['%s'],
                ['%d']
            );            
        } else {
            $wpdb->insert(
            	self::TABLE_NAME,
            	['chat_id' => $chatId, 'command' => $command],
            	['%s']
            );             
        } 
        
        return $chatId;                      
    } 
    
    /**
     * Сбрасывает команду
     * @return status
    **/        
    public static function reset($chatId) {
        global $wpdb;
        
        return $wpdb->delete(
            self::TABLE_NAME,
            ['chat_id' => $chatId],
            ['%s']
        );
    }    
}