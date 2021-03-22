<?php

declare(strict_types=1);

namespace Stegeman\SymfonyMessengerDomainEvents\Message\Dispatcher;

use Stegeman\SymfonyMessengerDomainEvents\Message\Recorder\ContainsRecordedMessages;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class DomainEventDispatcher
{
    public function __construct(
        private MessageBusInterface $eventBus
    ) {
    }

    public function dispatchEventsForEntity(object $entity): void
    {
        if ($entity instanceof ContainsRecordedMessages === false) {
            return;
        }

        foreach ($entity->recordedMessages() as $event) {
            $this->eventBus->dispatch((new Envelope($event))->with(new DispatchAfterCurrentBusStamp()));
        }
        $entity->eraseMessages();
    }
}
