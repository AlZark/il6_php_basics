<?php

namespace Service\PriceChangeInformer;

use Model\Catalog;
use Helper\DBHelper;
use Model\Message;
use Model\User;

class Cron
{
    public function exec()
    {
        $db = new DBHelper();
        $data = $db->select()->from('price_informer_queue')->limit(100)->get();
        foreach ($data as $element){
            $user = new User();
            $user->load($element['user_id']);
            $ad = new Catalog($element['ad_id']);
            $messageText = "Hi ". $user->getName() . " Car price changed. Car: " . $ad->getTitle();

            $message = new Message();
            $message->setText($messageText);
            $message->setSenderId(31);
            $message->setRecipientId($user->getId());
            $message->setRead(0);
            $message->setCreatedAt(date('Y-m-d H:i:s'));
            $message->setAdSlug('');
            $message->save();
            $db = new DBHelper();
            $db->delete()->from('price_informer_queue')->where('id', $element['id'])->exec();
        }
    }
}