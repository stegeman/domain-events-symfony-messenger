<?php

declare(strict_types=1);

namespace Stegeman\Tests\SymfonyMessengerDomainEvents\Message\Recorder;

use Stegeman\SymfonyMessengerDomainEvents\Message\Recorder\PrivateMessageRecorderCapabilities;

class DummyRecordable
{
    use PrivateMessageRecorderCapabilities;

    public function recordMessage(): void
    {
        $this->record(new \stdClass());
    }
}
