<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $property;
    public $unit;
    public $description;
    public $workOrderLink;
    public $filePath;

    /**
     * Crée une nouvelle instance du Mailable.
     */
    public function __construct($company, $property, $unit, $description, $workOrderLink, $filePath)
    {
        $this->company = $company;
        $this->property = $property;
        $this->unit = $unit;
        $this->description = $description;
        $this->workOrderLink = $workOrderLink;
        $this->filePath = $filePath;
    }

    /**
     * Construire le message email.
     */
    public function build()
    {
        return $this->subject("Bon de travaux pour intervention - {$this->property->name}")
                    ->view('emails.work_order')
                    ->attach($this->filePath, [
                        'as' => 'Bon_de_travaux.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
