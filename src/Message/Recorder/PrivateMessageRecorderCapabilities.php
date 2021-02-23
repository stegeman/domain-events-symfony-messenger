<?php
declare(strict_types=1);

namespace LeeroyJenkins\Message\Recorder;

/**
 * Use this trait in classes which implement ContainsRecordedMessages to privately record and later release Message
 * instances, like events.
 */
trait PrivateMessageRecorderCapabilities
{
    private array $messages = [];

    /**
     * {@inheritdoc}
     */
    public function recordedMessages(): array
    {
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseMessages(): void
    {
        $this->messages = [];
    }

    /**
     * Record a message.
     *
     * @param object $message
     */
    protected function record($message): void
    {
        $this->messages[] = $message;
    }
}