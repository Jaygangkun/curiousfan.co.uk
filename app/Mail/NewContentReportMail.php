<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContentReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $emailBody;
    public $emailSubject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report, $emailSubject, $emailBody)
    {
        $this->report = $report;
        $this->emailSubject = $emailSubject;
        $this->emailBody = $emailBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->emailSubject){
            return $this->subject($this->emailSubject)
                ->markdown('emails.adminContentReported');
        }
        return $this->subject(__('v14.admin-new-content-report-subject'))
            ->markdown('emails.adminContentReported');
    }
}
