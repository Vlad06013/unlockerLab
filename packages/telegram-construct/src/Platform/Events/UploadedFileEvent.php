<?php

declare(strict_types=1);

namespace Valibool\TelegramConstruct\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Valibool\TelegramConstruct\Models\File\TgConstructAttachment;

/**
 * This class represents the event that fires after a file is uploaded.
 */
class UploadedFileEvent
{
    use SerializesModels;

    /**
     * @var TgConstructAttachment
     */
    public TgConstructAttachment $attachment;

    /**
     * UploadedFileEvent constructor.
     */
    public function __construct(TgConstructAttachment $attachment)
    {
        $this->attachment = $attachment;
    }
}
