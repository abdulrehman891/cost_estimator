<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Http\Request;

class SendNotification extends Notification
{
    use Queueable;
    private $request;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'sender_id' => $this->request->sender_id,
            'receiver_id' => $this->request->receiver_id,
            'reminder_date' => date('Y-m-d', strtotime($this->request->reminder_date)),
            'document_name' => $this->request->document_name,
            'message' => $this->request->message,
            'message_rtl' => $this->request->message_rtl,
            'record_module' => !empty($this->request->record_module) ? $this->request->record_module : '',
            'record_id' => !empty($this->request->record_id) ? $this->request->record_id : '',
            'record_ref_number' => !empty($this->request->record_ref_number) ? $this->request->record_ref_number : '',
            'parent_module' => !empty($this->request->parent_module) ? $this->request->parent_module : '',
            'parent_id' => !empty($this->request->record_ref_number) ? $this->request->parent_id : '',
            'parent_ref_number' => !empty($this->request->parent_ref_number) ? $this->request->parent_ref_number : '',
            'status_code' => !empty($this->request->status_code) ? $this->request->status_code : '',
            'status_msg' => !empty($this->request->status_msg) ? $this->request->status_msg : '',
        ];
    }
}
