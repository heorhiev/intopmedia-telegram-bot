<?php
/**
 * Файл класса команды "checkpay"
 *
 * @package intopmedia
 * @author  Ruslan Heorhiiev (SKYPE: rgeorgievs)
 * @version 1.0.0
 */
 
namespace Intopmedia\TG\Commands;

use Intopmedia\TG\Bot;
use Intopmedia\TG\Services\Settings;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use Intopmedia\TG\Services\Storage;
use Intopmedia\Service\Pays\EasyPay;
use Intopmedia\Entety\Product;
use Intopmedia\Repository\Orders;

class CheckPayCommand extends Command {
    
    /**     
     * @var string Command Name
     */
    protected static $name = "checkpay";


    /**
     * @var string Command Description
     */
    protected static $description = "\xE2\x9C\x85 Проверить оплату";  

        
    /**
     * @var string Command Button Text
     */
    protected static $buttonText = "\xE2\x9C\x85 Проверить оплату";

    
    /**
     * @var bool Is the step command?
     */
    protected static $isStep = true;    
            
            
    /**
     * Handler
     */
    public static function handler(Bot $bot) {
        parent::handler($bot);

        /*$bot->sendMessage('ddddddddddd');
        return;*/

        $command = Storage::restoreCommand(
            $bot->getMessage()->getChatId()
        );

        //file_put_contents(INTOPMEDIA_TG_DIR . '/test.txt', print_r($params, 1));

        $params = self::parseParams($command);

        //file_put_contents(INTOPMEDIA_TG_DIR . '/test1.txt', print_r($params, 1));
     
        $message = static::getTitle();
        
        if (!$params['receipt_id'] && !$params['receipt_amount']) {
            $message .= Settings::getCheckPayText();
        } else {
            $pay = new EasyPay();

            $product = new Product($params['product']);

            //file_put_contents(INTOPMEDIA_TG_DIR . '/test.txt', 'dddddd');

            $offer = $product->getOffer($params['count']);

            if (
                $params['receipt_amount'] == $offer['price'] &&
                $pay->isPaid($params['receipt_id'], $params['receipt_amount'])
            ) {
                // успешная оплата
                $measurementTexts = $product->getMeasurementTexts();

                $message .= str_replace(
                    ['{title}', '{count}', '{price}', '{result}'],
                    [
                        $product->getTitle(), 
                        $params['count'] . ' ' . $measurementTexts[1],
                        $offer['price'],
                        $offer['text'],
                    ],
                    Settings::getCheckpaySuccessText()
                );

                Orders::addOrder($command, $params['receipt_id'], 'EasyPay', $message);

                $product->deleteOffer($params['count']);

            } else {
                $measurementTexts = $product->getMeasurementTexts();

                $message .= str_replace(
                    ['{title}', '{count}', '{price}', '{error}'],
                    [
                        $product->getTitle(), 
                        $params['count'] . ' ' . $measurementTexts[1],
                        $offer['price'],
                        'Проверка оплаты не пройдена.',
                    ],
                    Settings::getCheckpayFailText()
                );
            }
        }

        $backCommand = sprintf(
            "%s product_%s count_%s", 
            OrderCommand::getCommand(), 
            $params['product'], 
            $params['count']
        );
          
        $buttons[] = [  
            static::getBackButton([$backCommand]), 
            StartCommand::getButton()
        ];
            
        $keyboard = new InlineKeyboardMarkup($buttons);  
        
        $bot->sendMessage($message, $keyboard);
    }


    /**
     * Считывает параметры
     */
    private static function parseParams($params) {
        //file_put_contents(INTOPMEDIA_TG_DIR . '/test2.txt', print_r($params, 1));

        $params = preg_replace("/[^0-9 .]/", '', $params);
        $params = explode(' ', trim($params));

        //file_put_contents(INTOPMEDIA_TG_DIR . '/test3.txt', print_r($params, 1));

        return [
            'product'        => (int) $params[0],
            'count'          => $params[1],
            'receipt_id'     => (int) $params[2],
            'receipt_amount' => (int) $params[3],
        ];
    }


    /**
     * Устанавливает данные квитанции
     */
    public static function setReceipt($receipt) {

    }
}