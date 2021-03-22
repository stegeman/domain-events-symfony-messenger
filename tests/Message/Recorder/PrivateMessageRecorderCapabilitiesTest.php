<?php

declare(strict_types=1);

namespace Stegeman\Tests\SymfonyMessengerDomainEvents\Message\Recorder;

use PHPUnit\Framework\TestCase;

class PrivateMessageRecorderCapabilitiesTest extends TestCase
{
    /** @test */
    public function messagesCanBeAdded(): void
    {
        $recordable = $this->getDummyRecordable();
        $recordable->recordMessage();

        $this->assertCount(1, $recordable->recordedMessages());

        $recordable->recordMessage();
        $this->assertCount(2, $recordable->recordedMessages());

        $recordable->eraseMessages();
        $this->assertCount(0, $recordable->recordedMessages());
    }

    private function getDummyRecordable(): DummyRecordable
    {
        return new DummyRecordable();
    }
}
