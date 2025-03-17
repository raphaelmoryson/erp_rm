<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestQuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $property;
    public $unit;
    public $problem;
    public $quoteLink;

    /**
     * Create a new message instance.
     */
    public function __construct($company, $property, $unit, $problem, $quoteLink)
    {
        $this->company = $company;
        $this->property = $property;
        $this->unit = $unit;
        $this->problem = $problem;
        $this->quoteLink = $quoteLink;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->from('contact@immoflow.com', 'ImmoFlow')
            ->subject('📩 Demande de devis pour une intervention')
            ->view('emails.request_quote')
            ->with([
                'company' => $this->company,
                'property' => $this->property,
                'unit' => $this->unit,
                'problem' => $this->problem,
                'quoteLink' => $this->quoteLink,
            ]);

       
        return $email;
    }
}
