<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\Url;
use Model\Message;
use Helper\FormHelper;
use Model\User;

class Inbox extends AbstractController implements ControllerInterface
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $this->data['users'] = Message::getAllChats();
        $this->render('inbox/list');
    }

    public function sendMessage()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

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
                'name' => 'recipient',
                'options' => $options
            ]);
        } else {
            $options = [];
            $users = new User;
            $users->load($_GET['to']);
            $options[$_GET['to']] = $users->getFullName();
            $form->select([
                'name' => 'recipient',
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

    public function create()
    {
        $date = Date("Y-m-d H:i:s");
        $message = new Message();
        $message->setText($_POST['content']);
        $message->setUserId($_SESSION['user_id']);
        $message->setRecipient($_POST['recipient']);
        $message->setRead(0);
        $message->setCreatedAt($date);
        $message->save();

        Url::redirect('inbox/conversation?user=' . $_POST['recipient']);
    }

    public function changeReadStatus($id)
    {
        $message = new Message();
        $message->load($id);
        $message->setRead(1);
        $message->save();
    }

    public function conversation()
    {
        $data = new Message();
        $chat = $data->getAllMessagesByParticipants($_GET['user']);
        $this->data['messages'] = $chat;
        $this->data['recipient'] = $_GET['user'];

        $this->render('inbox/chat');
    }
}