<?php
/**
 * Файл класса команды "product"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Settings;
use Intopmedia\TG\Markups\ProductPricesMarkup;
use Intopmedia\Entety\Product;

class ProductCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "product";


    /**
     * @var string Command Description
     */
    protected static $description = "\xF0\x9F\x9B\x82 Товар";  

        
    /**
     * @var string Command Button Text
     */
    protected static $buttonText = "\xF0\x9F\x9B\x82 Товар";
            
            
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);

        $id = (int) $bot->getMessage()->getParams(); 

        $product = new Product($id);
        $measurementTexts = $product->getMeasurementTexts();

        $message  = "\xE2\x9E\xA1 <b>" . $product->getTitle() . "</b>" . PHP_EOL;
        $message .= strip_tags($product->getContent());

        $message .= PHP_EOL . "<b>Выберите " . $measurementTexts[0] . ":</b>";

        $markup = new ProductPricesMarkup(OrderCommand::getCommand(), [
            'ID' => $product->getID(),
        ]);

        $keyboard = $markup->getInlineKeyboard([
            static::getBackButton([PricelistCommand::getCommand()]),
            StartCommand::getButton()
        ]);

        $bot->sendMessage($message, $keyboard);
    }    
}