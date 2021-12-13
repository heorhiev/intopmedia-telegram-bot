<?php
/**
 * Файл класса маркерирования записей
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Markups;

use Intopmedia\Entety\Product;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class ProductPricesMarkup extends Markup {        
    
    public function getInlineKeyboard($afterButtons = []) {
        
        $offers = $this->getOffers();
        $buttons  = [];        
        
        $i = 0;
        $delimer = 2 < count($offers) ? 1 : 0;
        
        foreach ($offers as $item) {
            $t = sprintf(
                "%s (%s грн.)", 
                $item['count'],
                $item['price']
            );

            $c = sprintf(
                "%s product_%s count_%s", 
                $this->getCommand(), 
                $this->getQuery()['ID'], 
                $item['count']
            );
            
            $buttons[$i][] = [
                'text'          => $t, 
                'callback_data' => $c
            ]; 
            
            if ($delimer < count($buttons[$i])) {
                $i++;    
            }
        } 

        if ($afterButtons) {
            foreach ($afterButtons as $afterButton) {
                $buttons[] = [$afterButton];    
            }  
        }
        
        return new InlineKeyboardMarkup($buttons);
    }
    

    private function getOffers() {
        $product = new Product(
            (int) $this->getQuery()['ID']
        );
        
        return $product->getOffers();
    }
}