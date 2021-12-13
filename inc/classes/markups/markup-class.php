<?php
/**
 * Файл класса маркерирования
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Markups;


class Markup {
    
    private $command;
    private $query;
    
    public function __construct($command, $query = []) {
        $this->command = $command;
        $this->query   = $query;
    }
    
    public function getCommand() {
        return $this->command;
    }
    
    public function getQuery() {
        return $this->query;
    }    
}