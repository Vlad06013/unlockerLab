<?php

declare(strict_types=1);

//namespace App\Orchid\Platform\Events;
namespace Valibool\TelegramConstruct\Platform\Events;

use Illuminate\Queue\SerializesModels;
use Valibool\TelegramConstruct\Models\File\TgConstructAttachment;

/**
 * Class UploadFileEvent.
 */
class UploadFileEvent
{
    use SerializesModels;


    public TgConstructAttachment $attachment;

    /**
     * @var int
     */
    public int $time;

    /**
     * UploadFileEvent constructor.
     */
    public function __construct(TgConstructAttachment $attachment, int $time)
    {
        $this->attachment = $attachment;
        $this->time = $time;
    }
}
