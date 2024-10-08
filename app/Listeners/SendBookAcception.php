<?php

namespace App\Listeners;

use App\Events\BookProcessed;
use App\Mail\BookAcceptShip;
use App\Services\MailService;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class SendBookAcception
{
    /**
     * Create the event listener.
     */
    public function __construct(
        public MailService $mailService,
        public UserService $userService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookProcessed $event): void
    {
        $token = $this->userService->generateAcceptToken($event->user, $event->book);
        $this->mailService->sendBookAccept($event->user->email, $event->user->full_name, $event->book, $token);
    }
}
