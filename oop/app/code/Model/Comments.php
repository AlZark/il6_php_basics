<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Comments extends AbstractModel implements ModelInterfaces
{
    protected const TABLE = 'comment';

    private string $content;

    private int $user_id;

    private int $ad_id;

    private string $created_at;

    private $catalog;

    private $user;

    private string $ip;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getAdId(): int
    {
        return $this->ad_id;
    }

    public function setAdId(int $ad_id): void
    {
        $this->ad_id = $ad_id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getCatalog(): object
    {
        return $this->catalog;
    }

    public function getUser(): object
    {
        return $this->user;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    public function __construct(?int $id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    public function assignData(): void
    {
        $this->data = [
            'content' => $this->content,
            'user_id' => $this->user_id,
            'ad_id' => $this->ad_id,
            'created_at' => $this->created_at,
            'ip' => $this->ip
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$data['id'];
        $this->content = (string)$data['content'];
        $this->user_id = (int)$data['user_id'];
        $this->ad_id = (int)$data['ad_id'];
        $this->created_at = (string)$data['created_at'];
        $this->ip = (string)$data['ip'];

        $user = new User();
        $this->user = $user->load($this->user_id);

        $catalog = new Catalog();
        $this->catalog = $catalog->load($this->ad_id);

        return $this;
    }

    public static function getAllCatalogComments(int $ad_id): array
    {
        $db = new DBHelper();
        $data = $db->select()
            ->from(self::TABLE)
            ->where('ad_id', $ad_id)
            ->order('id', 'DESC')
            ->get();
        $comments = [];
        foreach ($data as $element) {
            $comments[] = $element;
        }
        return $comments;
    }

    public static function getTotalComments(int $ad_id): int
    {
        $db = new DBHelper();
        $data = $db->select('COUNT(id)')->from(self::TABLE)->where('ad_id', $ad_id)->get();
        return (int)$data[0][0];
    }

}