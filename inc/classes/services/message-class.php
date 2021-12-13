<?php
/**
 * Файл класса сообщения
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */

namespace Intopmedia\TG\Services;

class Message {
    
    private $id;
    private $callbackId;
    private $chatId;
    private $command;
    private $params;
    private $userName;
    private $isCallbackQuery;
    private $isCountry;
    
    public function __construct($update) {
        if ($update->getMessage()) {
            $this->mapMessage($update->getMessage());
        } elseif ($update->getCallbackQuery()) {            
            $this->mapCallbackQuery($update->getCallbackQuery());
        }
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getCallbackId() {
        return $this->callbackId;
    }    
    
    public function getChatId() {
        return $this->chatId;
    }    
    
    public function getCommand() {
        return $this->command;
    }
        
    public function getParams() {
        return $this->params;
    }         
        
    public function getUsername() {
        return $this->userName;
    } 
    
    public function isCallbackQuery() {    
        return $this->isCallbackQuery;
    }    
    
    public function isEdited() {    
        return $this->isCallbackQuery && ! $this->isCountry;
    }     
    
    private function mapMessage($message) {    
        $this->id       = $message->getId();
        $this->chatId   = $message->getChat()->getId();
        $this->userName = $message->getChat()->getUsername();
        $this->command  = $message->getCommand();
        $this->params   = $message->getParams();
        $this->isCountry = stristr($message->getText(), 'Restrictions:');
    } 
    
    private function mapCallbackQuery($callbackQuery) {
        $this->mapMessage($callbackQuery->getMessage());
        
        $this->isCallbackQuery = true;
        $this->callbackId = $callbackQuery->getId();
        $this->command = $callbackQuery->getCommand(); 
        $this->params  = $callbackQuery->getParams();                          
    }   
}