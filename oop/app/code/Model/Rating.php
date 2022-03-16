<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Rating extends AbstractModel implements ModelInterfaces
{
    private int $score;

    private int $adId;

    private int $userId;

    protected const TABLE = 'rating';

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

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
            'score' => $this->score,
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
            $this->score = (int)$data['score'];
            $this->adId = (int)$data['ad_id'];
            $this->userId = (int)$data['user_id'];
        }
        return $this;
    }

    public static function getAdRating(int $id): float
    {
        $db = new DBHelper();
        $rating = $db->select('AVG(score)')->from(self::TABLE)->where('ad_id', $id)->get();
        return round($rating[0][0],1);
    }

    public function loadByUserAndAd($userId, $adId)
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
        return $this;
    }

    public static function checkIfAlreadyRated(int $id): bool
    {
        $db = new DBHelper();
        $rez = $db->select()
            ->from(self::TABLE)
            ->where('ad_id', $id)
            ->andWhere('user_id', $_SESSION['user_id'])
            ->getOne();
        return !empty($rez);
    }

}