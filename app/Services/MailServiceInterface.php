<?php

namespace App\Services;

interface MailServiceInterface
{
    public function send(string $recipient, string $message);
}