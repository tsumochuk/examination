<?php

namespace App\Service\NotifyService;

interface NotifierInterface
{
    public function notify(string $message): void;
}
