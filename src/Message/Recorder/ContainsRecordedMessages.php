<?php
declare(strict_types=1);

namespace ALWT\Message\Recorder;

interface ContainsRecordedMessages
{
    /**
     * Fetch recorded messages.
     *
     * @return object[]
     */
    public function recordedMessages();

    /**
     * Erase messages that were recorded since the last call to eraseMessages().
     */
    public function eraseMessages();
}
