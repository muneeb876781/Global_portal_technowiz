<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;

class ThresholdAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $userCount;

    public function __construct(Campaign $campaign, $userCount)
    {
        $this->campaign = $campaign;
        $this->userCount = $userCount;
    }   

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Low Acquisitions Alert',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Organizer.Dashboard.Mails.CampaignMonitoringAlert',
            with: [
                'campaign' => $this->campaign,
                'userCount' => $this->userCount,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
 