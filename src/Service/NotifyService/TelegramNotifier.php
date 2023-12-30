<?php

declare(strict_types=1);

namespace App\Service\NotifyService;

use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

final class TelegramNotifier implements NotifierInterface
{
    public function __construct(
        private readonly ChatterInterface $chatter,
    ) {}

    public function notify(string $message): void
    {
        $this->chatter->send(new ChatMessage($message));
    }
}
