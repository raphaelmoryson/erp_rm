<?php

namespace App\Livewire;

use Livewire\Component;

class Unit extends Component
{

    public $currentTab = 'info';

    public $units = [];
    public $tenants = [];
    public function mount($units, $tenants) {
        $this->units = $units;
        $this->tenants = $tenants;
    }
    public function setTab($tab)
    {
        $this->currentTab = $tab;
    }
    public function render()
    {
        return view('livewire.unit');
    }
}
