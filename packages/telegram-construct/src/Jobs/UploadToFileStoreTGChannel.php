<?php

namespace Valibool\TelegramConstruct\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Valibool\TelegramConstruct\Models\Bot;
use Valibool\TelegramConstruct\Models\File\TgConstructAttachment;
use Valibool\TelegramConstruct\Models\Message;
use Valibool\TelegramConstruct\Services\Messages\Output\OutputMessage;

class UploadToFileStoreTGChannel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $botToken;
    private string|null $chatId = null;
    private $attachments;

    /**
     * Create a new job instance.
     */
    public function __construct(array $attachmentsIds, Message $message)
    {
        $this->message = $message;
        $this->attachments = $message->attachment;
        $bot = Bot::find($message->bot_id);
        if($fileStore = $bot->fileStoreChannel()){
            $this->chatId = $fileStore->channel_tg_id;
        }
        $this->botToken = $bot->token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if ($this->chatId == null) {
            return;
        }

        $output = new OutputMessage($this->botToken);

        foreach ($this->attachments as $attachment) {

            if (!$attachment->tg_file_id) {

                $output->setAttachments($attachment);

                $res = $output->sendMessage($this->chatId);

                if ($res->photo) {

                    $attachment->tg_type = 'photo';
                    $attachment->tg_file_id = $res->response['photo'][0]['file_id'];

                }
                if ($res->animation) {
                    $attachment->tg_type = 'animation';
                    $attachment->tg_file_id = $res->response['animation']['file_id'];

                }
                $attachment->save();
            }
        }
    }
}
