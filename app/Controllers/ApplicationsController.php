<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\Database;
use App\Services\DatabaseInterface;
use App\Services\MailService;
use App\Services\MailServiceInterface;

class ApplicationsController
{
    private MailServiceInterface $mailService;
    private DatabaseInterface $database;

    public function __construct()
    {
        $this->mailService = (new MailService());
        $this->database = (new Database());
    }

    public function index()
    {
        View::show('index.php');
    }

    public function partners()
    {
        $applications = $this->database->getDeals();
        View::show('partners.php', ['applications' => $applications]);
    }

    public function create(): void
    {
        if (isset($_POST['email']) && isset($_POST['sum'])) {

            $applicationId = $this->database->submit($_POST['email'], $_POST['sum']);

            if ($applicationId == null) {
                View::show('index.php', ['error' => 'Application with this email already exists']);
            } else {
                $this->database->assign($applicationId, $_POST['sum']);
                $this->mailService->send($_POST['email'], 'path/to/email.html');

                header('Location: /');
            }
        }
    }

    public function offer(): void
    {
        if (isset($_POST['id'])) {
            if ($this->database->offer($_POST['id']) == false) {
                $applications = $this->database->getDeals();
                View::show('partners.php', [
                    'error' => 'Application with this ID does not exist',
                    'applications' => $applications
                ]);
            } else {
                $email = $this->database->getEmail($_POST['id']);

                $this->mailService->send($email, 'path/to/email.html');
            }
        }

        header('Location: /partner/applications');
    }
}