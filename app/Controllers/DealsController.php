<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\Database;
use App\Services\DatabaseInterface;
use App\Services\MailService;
use App\Services\MailServiceInterface;
use App\Services\Validator;
use App\Services\ValidatorInterface;

class DealsController
{
    private MailServiceInterface $mailService;
    private DatabaseInterface $database;
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->mailService = (new MailService());
        $this->database = (new Database());
        $this->validator = (new Validator());
    }

    public function index(): void
    {
        View::show('index.php');
    }

    public function partners(): void
    {
        $applications = $this->database->getDeals();
        View::show('partners.php', ['applications' => $applications]);
    }

    public function create(): void
    {
        if (!isset($_POST['email']) && !isset($_POST['sum'])) {
            View::show('index.php', [
                'error' => 'Please fill out all fields!'
            ]);
        }

        if (!$this->validator->email($_POST['email'])) {
            View::show('index.php', [
                'error' => 'Email is in wrong format'
            ]);
        }
        if (!$this->validator->sum($_POST['sum'])) {
            View::show('index.php', [
                'error' => 'Sum must be between 1 and 1000000'
            ]);
        }

        $applicationId = $this->database->submit($_POST['email'], $_POST['sum']);

        if ($applicationId == null) {
            View::show('index.php', ['error' => 'Application with this email already exists']);
        } else {
            $this->database->assign($applicationId, $_POST['sum']);
            $this->mailService->send($_POST['email'], 'path/to/email.html');

            header('Location: /');
        }
    }

    public function offer(): void
    {
        if (!isset($_POST['id'])) {
            View::show('partners.php', [
                'error' => 'Please enter the sum!'
            ]);
        }

        if ($this->validator->id($_POST['id']) == false) {
            $applications = $this->database->getDeals();
            View::show('partners.php', [
                'error' => 'Application with this ID does not exist',
                'applications' => $applications
            ]);
            return;
        }

        $email = $this->database->getEmail($_POST['id']);

        $this->mailService->send($email, 'path/to/email.html');

        header('Location: /partner/applications');
    }
}