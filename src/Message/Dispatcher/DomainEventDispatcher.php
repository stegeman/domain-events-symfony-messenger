<?php

declare(strict_types=1);

namespace ALWT\Message\Dispatcher;

use ALWT\Message\Recorder\ContainsRecordedMessages;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class DomainEventDispatcher
{
    public function __construct(
        private MessageBusInterface $eventBus
    ) {}

//    public function getSubscribedEvents(): array
//    {
//        return [
//            Events::preFlush,
//            Events::postFlush,
//        ];
//    }
//
//    public function preFlush(PreFlushEventArgs $eventArgs): void
//    {
//        $em = $eventArgs->getEntityManager();
//        $uow = $em->getUnitOfWork();
//        foreach ($uow->getIdentityMap() as $entities) {
//            foreach ($entities as $entity) {
//                $this->dispatchEventsForEntity($entity);
//            }
//        }
//        foreach ($uow->getScheduledEntityDeletions() as $entity) {
//            $this->dispatchEventsForEntity($entity);
//        }
//    }
//
//    public function postFlush(PostFlushEventArgs $eventArgs): void
//    {
//        $em = $eventArgs->getEntityManager();
//        $uow = $em->getUnitOfWork();
//        foreach ($uow->getIdentityMap() as $entities) {
//            foreach ($entities as $entity) {
//                $this->dispatchEventsForEntity($entity);
//            }
//        }
//    }

    public function dispatchEventsForEntity(ContainsRecordedMessages $entity): void
    {
//        if ($entity instanceof ContainsRecordedMessages
//            && (
//                !$entity instanceof Proxy
//                || ($entity instanceof Proxy && $entity->__isInitialized__)
//            )
//        ) {
            foreach ($entity->recordedMessages() as $event) {
                $this->eventBus->dispatch((new Envelope($event))->with(new DispatchAfterCurrentBusStamp()));
            }
            $entity->eraseMessages();
//        }
    }
}
