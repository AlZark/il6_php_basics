<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Message extends AbstractModel implements ModelInterfaces
{

    private string $text;

    private int $user_id;

    private int $recipient;

    private int $read;

    private string $created_at;

    protected const TABLE = 'message';

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getRecipient(): int
    {
        return $this->recipient;
    }

    public function setRecipient(int $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getRead(): int
    {
        return $this->read;
    }

    public function setRead(int $read): void
    {
        $this->read = $read;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
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
            'text' => $this->text,
            'user_id' => $this->user_id,
            'recipient' => $this->recipient,
            'is_read' => $this->read,
            'created_at' => $this->created_at,
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        if (!empty($data)) {
            $this->id = (int)$data['id'];
            $this->text = (string)$data['text'];
            $this->user_id = (int)$data['user_id'];
            $this->recipient = (int)$data['recipient'];
            $this->read = (int)$data['is_read'];
            $this->created_at = (string)$data['created_at'];
        }
        return $this;
    }

    public static function countNewMessages(): int
    {
        $db = new DBHelper();
        $total = $db->select('COUNT(*)')
            ->from(self::TABLE)
            ->where('recipient', $_SESSION['user_id'])
            ->andWhere('is_read', 0)
            ->get();
        return (int)$total[0][0];
    }

    public static function getAllChats(): array
    {
        $dbSenders = new DBHelper();
        $uniqSenders = $dbSenders->select('DISTINCT(user_id)')
            ->from(self::TABLE)
            ->where('recipient', $_SESSION['user_id'])
            ->get();

        $dbReceivers = new DBHelper();
        $uniqReceivers = $dbReceivers->select('DISTINCT(recipient)')
            ->from(self::TABLE)
            ->Where('user_id', $_SESSION['user_id'])
            ->get();

        for($i = 0; $i < sizeof($uniqSenders); $i++){
            $senders[$i] = $uniqSenders[$i][0];
        }

        for($i = 0; $i < sizeof($uniqReceivers); $i++){
            $receivers[$i] = $uniqReceivers[$i][0];
        }

        return array_unique(array_merge($senders, $receivers));
    }

    public function getAllMessagesByParticipants(int $user): array
    {
        $db = new DBHelper();
        $data = $db->select('id')
            ->from(self::TABLE)
            ->where('recipient', $user)
            ->andWhere('user_id', (int)$_SESSION['user_id'])
            ->orwhere('recipient', (int)$_SESSION['user_id'])
            ->andWhere('user_id', $user)
            ->order('created_at', 'DESC')
            ->get();
        $messages = [];
        foreach ($data as $element) {
            $message = new Message();
            $message->load((int)$element['id']);
            $messages[] = $message;
        }
        return $messages;
    }

    public static function countNewMessagesPerChat(int $user): int
    {
        $data = new Message();
        $messages = $data->getAllMessagesByParticipants($user);
        $total = [];
        foreach ($messages as $message) {
            $db = new DBHelper();
            $total = $db->select('COUNT(*)')
                ->from(self::TABLE)
                ->where('recipient', $_SESSION['user_id'])
                ->andWhere('id', $message->getId())
                ->andWhere('is_read', 0)
                ->get();
            return (int)$total[0][0];
        }
        return (int)$total[0][0];
    }
}