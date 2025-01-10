<?php

namespace App\Notifications;

use App\Helper\Common;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Telegram\TelegramMessage;

class MediafireChecker extends Notification
{
    use Queueable;
    private $details;

    /**
     * Create a new notification instance.
     *
     * @param $details
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        //$url = url('/invoice/' . $this->invoice->id);
        $datetime = Common::getCurrentVNTime();

        $text = "`$datetime` "."\n\n"."\xE2\x9A\xA0 ".' '.$this->details['message'];
        $text = str_replace('_', '\_', $text);

        return TelegramMessage::create()
            // Optional recipient user id.
            //->to($notifiable->telegram_user_id)
            // Markdown supported.
            //->content($this->details['message'])
            ->content($text)

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            // (Optional) Inline Buttons
            ->button($this->details['actionText'], $this->details['actionUrl'])
            ->button('List links', route('mediafireLinks.index'));

            //->button('Download Invoice', $url)
            // (Optional) Inline Button with callback. You can handle callback in your bot instance
           // ->buttonWithCallback('Confirm', 'confirm_invoice ' . $this->invoice->id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
