<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Message extends AbstractModel implements ModelInterfaces
{

    private $text;

    private $user_id;

    private $recipient;

    private $read;

    private $created_at;

    protected const TABLE = 'message';

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    public function getRead()
    {
        return $this->read;
    }

    public function setRead($read)
    {
        $this->read = $read;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function __construct($id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    public function assignData()
    {
        $this->data = [
            'text' => $this->text,
            'user_id' => $this->user_id,
            'recipient' => $this->recipient,
            'is_read' => $this->read,
            'created_at' => $this->created_at,
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($data)) {
            $this->id = $data['id'];
            $this->text = $data['text'];
            $this->user_id = $data['user_id'];
            $this->recipient = $data['recipient'];
            $this->read = $data['is_read'];
            $this->created_at = $data['created_at'];
        }
    }

    public static function countNewMessages($user_id)
    {
        $db = new DBHelper();
        $total = $db->select('COUNT(id)')->from(self::TABLE)->where('recipient', $user_id)->andWhere('is_read', 0)->get();
        return $total[0][0];
    }

    public static function getAllMessages($user_id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('recipient', $user_id)->orWhere('user_id', $user_id)->order('created_at', 'DESC')->get();
        $messages = [];
        foreach ($data as $element) {
            $message = new Message();
            $message->load($element['id']);
            $messages[] = $message;
        }
        return $messages;
    }

}