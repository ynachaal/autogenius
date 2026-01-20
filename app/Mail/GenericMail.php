<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class GenericMail extends Mailable implements ShouldQueue
{
    public string $body;
    public string $subjectLine;

    public function __construct(string $body, string $subjectLine)
    {
        $this->body = $body;
        $this->subjectLine = $subjectLine;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->html($this->body);
    }
}
