<?php

declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\Url;
use Model\Message;
use Helper\FormHelper;
use Model\User;
use Helper\StringHelper;

class Inbox extends AbstractController implements ControllerInterface
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }
    }

    public function index():void
    {
        $this->data['users'] = Message::getAllChats();
        $this->render('inbox/list');
    }

    public function sendMessage():void
    {
        $form = new FormHelper('inbox/create', 'POST');
        $form->textArea('content');

        if ($_GET['to'] == null) {
            $users = User::getAllUsers();
            $options = [];
            foreach ($users as $user) {
                $id = $user->getId();
                if ($id != $_SESSION['user_id']) {
                    $options[$id] = $user->getName();
                }
            }
            $form->select([
                'name' => 'recipient_id',
                'options' => $options
            ]);
        } else {
            $options = [];
            $users = new User;
            $users->load($_GET['to']);
            $options[$_GET['to']] = $users->getFullName();
            $form->select([
                'name' => 'recipient_id',
                'options' => $options
            ]);
        }

        $form->input([
            'class' => 'submit',
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Send'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('inbox/new');
    }

    public function create():void
    {
        $date = Date("Y-m-d H:i:s");
        $message = new Message();
        $message->setText(StringHelper::censor((string)$_POST['content']));
        $message->setSenderId((int)$_SESSION['user_id']);
        $message->setRecipientId((int)$_POST['recipient_id']);
        $message->setRead(0);
        $message->setCreatedAt((string)$date);
        $message->save();

        Url::redirect('inbox/conversation?user=' . $_POST['recipient_id']);
    }

    public function changeReadStatus(int $id): void
    {
        $message = new Message();
        $message->load($id);
        $message->setRead(1);
        $message->save();
    }

    public function conversation(): void
    {
        $data = new Message();
        $chat = $data->getAllMessagesByParticipants((int)$_GET['user']);
        $this->data['messages'] = $chat;
        $this->data['recipient_id'] = $_GET['user'];

        $this->render('inbox/chat');
    }
}