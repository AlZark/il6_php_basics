<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Comments extends AbstractModel
{
    protected const TABLE = 'comment';

    private $content;

    private $user_id;

    private $ad_id;

    private $created_at;

    private $catalog;

    private $user;

    private $ip;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getAdId()
    {
        return $this->ad_id;
    }

    public function setAdId($ad_id)
    {
        $this->ad_id = $ad_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getCatalog()
    {
        return $this->catalog;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function __construct($id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    protected function assignData()
    {
        $this->data = [
            'content' => $this->content,
            'user_id' => $this->user_id,
            'ad_id' => $this->ad_id,
            'created_at' => $this->created_at,
            'ip' => $this->ip
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $data['id'];
        $this->content = $data['content'];
        $this->user_id = $data['user_id'];
        $this->ad_id = $data['ad_id'];
        $this->created_at = $data['created_at'];
        $this->ip = $data['ip'];

        $user = new User();
        $this->user = $user->load($this->user_id);

        $catalog = new Catalog();
        $this->catalog = $catalog->load($this->ad_id);

        return $this;
    }

    public static function getAllCatalogComments($ad_id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('ad_id', $ad_id)->order('id', 'DESC')->get();
        $comments = [];
        foreach ($data as $element) {
            $comments[] = $element;
        }
        return $comments;
    }

    public static function getTotalComments($ad_id)
    {
        $db = new DBHelper();
        $data = $db->select('COUNT(id)')->from(self::TABLE)->where('ad_id', $ad_id)->get();
        return $data[0][0];
    }

    //TODO
    public function getAllUserComments()
    {

    }

}