<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConfirmationModal extends Component
{
    public $id;
    public $title;
    public $message;
    public $route;
    public $method;

    public function __construct($id, $title = 'Confirmation', $message = 'Voulez-vous vraiment continuer ?', $route, $method = 'POST')
    {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
        $this->route = $route;
        $this->method = $method;
    }

    public function render()
    {
        return view('components.confirmation-modal');
    }
}
