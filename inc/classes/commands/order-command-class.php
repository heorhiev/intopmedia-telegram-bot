<?php
/**
 * Файл класса команды "order"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Settings;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use Intopmedia\Entety\Product;

class OrderCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "order";


    /**
     * @var string Command Description
     */
    protected static $description = "\xE2\x9C\x85 Оформление заказа";  

        
    /**
     * @var string Command Button Text
     */
    protected static $buttonText = "\xE2\x9C\x85 Оформление заказа";

    
    /**
     * @var bool Is the step command?
     */
    protected static $isStep = true; 
            
            
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);

        $params = self::parseParams($bot->getMessage()->getParams()); 

        $product = new Product($params['id']);

        $measurementTexts = $product->getMeasurementTexts();

        $description = str_replace(
            ['{title}', '{count}', '{price}'],
            [
                $product->getTitle(), 
                $params['count'] . ' ' . $measurementTexts[1],
                $product->getOfferPrice($params['count'])
            ],
            Settings::getOrderInstructionText()
        );

        $message  = "\xE2\x9E\xA1 <b>Оформление заказа</b>" . PHP_EOL . PHP_EOL;
        $message .= $description;

        $checkPayParams = sprintf(
            "product_%s count_%s",
            $product->getId(), 
            $params['count']
        );
          
        $buttons = [
            [
                CheckPayCommand::getButton($checkPayParams)
            ],
            [
                static::getBackButton([ProductCommand::getCommand() . ' ' . $product->getId()]), 
                StartCommand::getButton()
            ]
        ];

        //file_put_contents(INTOPMEDIA_TG_DIR . '/test.txt', print_R($buttons, 1));
            
        $keyboard = new InlineKeyboardMarkup($buttons);  
        
        $bot->sendMessage($message, $keyboard);
    }    


    /**
     * Считывает параметры
     */
    private static function parseParams($params) {
        $params = preg_replace("/[^0-9 .]/", '', $params);
        $params = explode(' ', $params);

        return [
            'id'    => (int) $params[0],
            'count' => $params[1],
        ];
    }
}