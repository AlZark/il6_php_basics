<?php

namespace Service\PriceChangeInformer;

use Model\Favorite;
use Helper\DBHelper;

class Messenger
{
    public function setMessages($adId)
    {
        $userIds = Favorite::getUsersIdsByAd($adId);
        var_dump($userIds);
        foreach ($userIds as $userId){
            $db = new DBHelper();
            $data = [
                'user_id' => $userId,
                'ad_id' => $adId,
            ];
            $db->insert('price_informer_queue', $data)->exec();
        }
    }

}