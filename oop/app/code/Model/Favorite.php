<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Favorite extends AbstractModel implements ModelInterfaces
{
    private int $adId;

    private int $userId;

    protected const TABLE = 'favorite_ads';

    /**
     * @return int
     */
    public function getAdId(): int
    {
        return $this->adId;
    }

    /**
     * @param int $adId
     */
    public function setAdId(int $adId): void
    {
        $this->adId = $adId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUser(): object
    {
        $user = new User();
        $user->load($this->userId);
        return $user;
    }

    public function getAd(): object
    {
        $ad = new Catalog();
        $ad->load($this->adId);
        return $ad;
    }

    public function __construct(?int $id = null)
    {
        if ($id !== null) {
            $this->load($id);
        }
    }

    public function assignData(): void
    {
        $this->data = [
            'ad_id' => $this->adId,
            'user_id' => $this->userId
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($data)) {
            $this->id = (int)$data['id'];
            $this->adId = (int)$data['ad_id'];
            $this->userId = (int)$data['user_id'];
        }
        return $this;
    }

    public function loadByUserAndAd(int $userId, int $adId): ?Favorite
    {
        $db = new DBHelper();
        $rez = $db->select()
            ->from(self::TABLE)
            ->where('user_id', $userId)
            ->andWhere('ad_id', $adId)
            ->getOne();
        if(!empty($rez)){
            $this->load($rez['id']);
            return $this;
        }
        return null;
    }

    public static function totalFavoriteAds(): int
    {
        $total = new DBHelper();
        $rez = $total
            ->select('COUNT(id)')
            ->from(self::TABLE)
            ->where('user_id', $_SESSION['user_id'])
            ->get();

        return (int)$rez[0][0];
    }

}