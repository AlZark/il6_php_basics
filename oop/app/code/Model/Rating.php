<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Rating extends AbstractModel implements ModelInterfaces
{
    private int $score;

    private int $ad_id;

    private int $user_id;

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
        return $this->ad_id;
    }

    /**
     * @param int $ad_id
     */
    public function setAdId(int $ad_id): void
    {
        $this->ad_id = $ad_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
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
            'ad_id' => $this->ad_id,
            'user_id' => $this->user_id
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($data)) {
            $this->id = (int)$data['id'];
            $this->score = (int)$data['score'];
            $this->ad_id = (int)$data['ad_id'];
            $this->user_id = (int)$data['user_id'];
        }
        return $this;
    }

    public static function getAdRating(int $id): float
    {
        $db = new DBHelper();
        $rating = $db->select('AVG(score)')->from(self::TABLE)->where('ad_id', $id)->get();
        return round($rating[0][0],1);
    }

    public static function checkIfAlreadyRated(int $id): bool
    {
        $db = new DBHelper();
        $rez = $db->select()
            ->from(self::TABLE)
            ->where('ad_id', $id)
            ->andWhere('user_id', $_SESSION['user_id'])
            ->getOne();
        return empty($rez);
    }
}