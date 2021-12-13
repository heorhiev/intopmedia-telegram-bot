<?php
/**
 * Файл класса настроек
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Services;

use Intopmedia\Service\Settings as GlobalSettings;

class Settings {
        
    /**
     * Приветственный текст
     */
    public static function getStartText() {
        return self::getOption('start_text');        
    }       
    
    
    /**
     * Помощь
     */
    public static function getHelpText() {
        return self::getOption('help_text');        
    } 
    
    
    /**
     * Инструкция оформления заказа
     */
    public static function getOrderInstructionText() {
        return self::getOption('order_instruction_text');        
    }
    
    
    /**
     * Инструкция проверки оплаты
     */
    public static function getCheckPayText() {
        return self::getOption('checkpay_text');        
    }


    /**
     * Правила
     */
    public static function getRegulationsText() {
        return self::getOption('regulations_text');        
    } 


    /**
     * Успешная оплата
     */
    public static function getCheckpaySuccessText() {
        return self::getOption('checkpay_suc_text', "Товар оплачен!");         
    }   
    
    
    /**
     * Не оплачен
     */
    public static function getCheckpayFailText() {
        return self::getOption('checkpay_fail_text', "Товар не оплачен.");         
    }   
    
       
    /**
     * Контакты
     */
    public static function getContactusText() {
        return self::getOption('contactus_text', "Если есть вопросы, напишите и отправьте \xF0\x9F\x98\x8E");        
    }   
    
        
    /**
     * Наш Email
     */
    public static function getContactusEmail() {
        return self::getOption('contactus_email', get_bloginfo('admin_email'));         
    } 


    /**
     * Успешная отправка
     */
    public static function getContactusSuccessText() {
        return self::getOption('contactus_suc_text', "\xE2\x9C\x85 Ваше сообщение отправлено!");         
    } 
    
    
    /**
     * Возвращает опцию настроек
     */
    public static function getOption($key, $default = '') {
        $value = GlobalSettings::getOption('telegram', $key);      
        
        if (!$value) {
            $value = $default;
        }  
        
        return $value;
    }    
}