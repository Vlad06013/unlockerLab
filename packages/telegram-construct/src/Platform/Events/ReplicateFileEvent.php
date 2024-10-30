<?php

declare(strict_types=1);

namespace Valibool\TelegramConstruct\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Valibool\TelegramConstruct\Models\File\TgConstructAttachment;

/**
 * Class ReplicateFileEvent.
 */
class ReplicateFileEvent
{
    use SerializesModels;

    public TgConstructAttachment $attachment;

    /**
     * The timestamp when the event occurred.
     *
     * @var int
     */
    public int $time;

    /**
     * ReplicateFileEvent constructor.
     */
    public function __construct(TgConstructAttachment $attachment, int $time)
    {
        $this->attachment = $attachment;
        $this->time = $time;
    }
}
