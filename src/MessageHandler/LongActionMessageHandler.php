<?php

namespace App\MessageHandler;

use App\Message\LongActionMessage;
use App\Services\LongActionService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class LongActionMessageHandler
{


    public function __construct(
        private LongActionService $longActionService
    )
    {
    }

    public function __invoke(LongActionMessage $message)
    {
        $this->longActionService->proceed($message->isWithError());
    }
}
