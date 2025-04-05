<?php
// app/View/Components/Navbar.php
namespace App\View\Components;

use Illuminate\View\Component;

class Navbar extends Component
{
    public $title;

    public function __construct($title = 'Mon application')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.Navbar');
    }
}
