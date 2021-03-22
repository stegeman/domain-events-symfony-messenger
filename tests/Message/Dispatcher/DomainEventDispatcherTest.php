<?php

declare(strict_types=1);

namespace Stegeman\Tests\SymfonyMessengerDomainEvents\Message\Dispatcher;

use stdClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stegeman\SymfonyMessengerDomainEvents\Message\Dispatcher\DomainEventDispatcher;
use Stegeman\SymfonyMessengerDomainEvents\Message\Recorder\ContainsRecordedMessages;
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
                    new stdClass()
                ]
            )
        );

        $this->assertCount(1, $messageBus->messages);
    }

    /** @test */
    public function entityThatIsNotInstanceOfContainsRecordedMessagesIsIgnored(): void
    {
        $messageBus = $this->createDummyMessageBus();
        $dispatcher = $this->getDomainEventDispatcher($messageBus);

        $dispatcher->dispatchEventsForEntity(
            $this->createNonEventEntity()
        );

        $this->assertCount(0, $messageBus->messages);
    }

    private function getDomainEventDispatcher(MessageBusInterface $messageBus): DomainEventDispatcher
    {
        return new DomainEventDispatcher($messageBus);
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

    private function createNonEventEntity(): stdClass
    {
        return new stdClass();
    }
}
