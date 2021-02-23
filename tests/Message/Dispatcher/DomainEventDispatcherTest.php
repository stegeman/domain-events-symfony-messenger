<?php

declare(strict_types=1);

namespace Tests\ALWT\Message\Dispatcher;

use ALWT\Message\Recorder\ContainsRecordedMessages;
use ALWT\Message\Dispatcher\DomainEventDispatcher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class DomainEventDispatcherTest extends TestCase
{
    /** @test */
    public function domainEventsAreDispatched(): void
    {
        $messageBus = $this->createDummyMessageBus();

        $dispatcher = $this->getDomainEventDispatcher($messageBus);

        $dispatcher->dispatchEventsForEntity(
            $this->createEntityContainingOneRecordedMessage(
                [
                    new \stdClass()
                ]
            )
        );

        $this->assertCount(1, $messageBus->messages);
    }

    private function getDomainEventDispatcher(MessageBusInterface $messageBus): DomainEventDispatcher
    {
        return new DomainEventDispatcher($messageBus);
    }

    private function createMessageBus(): MessageBusInterface
    {
        $messageBus = $this->getMockBuilder(MessageBusInterface::class)->getMock();

        /** @var MessageBusInterface $messageBus */
        return $messageBus;
    }

    private function createContainsRecorderdMessages(): ContainsRecordedMessages
    {
        $entity = $this->getMockBuilder(ContainsRecordedMessages::class)->getMock();

        /** @var ContainsRecordedMessages $entity */
        return $entity;
    }

    private function createDummyMessageBus(): MessageBusInterface
    {
        return new class implements MessageBusInterface {

            public $messages = [];

            public function dispatch($message, array $stamps = []): Envelope
            {
                $this->messages[] = $message;

                return $message;
            }
        };
    }

    private function createEntityContainingOneRecordedMessage(array $messages): ContainsRecordedMessages
    {
        /** @var MockObject $entity */
        $entity = $this->createContainsRecorderdMessages();

        $entity->expects($this->once())
            ->method('recordedMessages')
            ->willReturn($messages);

        /** @var ContainsRecordedMessages $entity */
        return $entity;
    }
}
