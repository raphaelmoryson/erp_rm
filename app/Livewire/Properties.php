<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Unit; // Assure-toi d'importer le modèle Unit

class Properties extends Component
{
    public $occupancyRate;
    public $currentTab = 'info';
    public $units = [];
    public $building = [];

    public function mount($building, $occupancyRate)
    {
        $this->building = $building;
        $this->occupancyRate = $occupancyRate;
    }

    public function setTab($tab)
    {
        $this->currentTab = $tab;
    }
    public function loadUnits()
    {
        $this->units = Unit::where('property_id', $this->building->id)->get();
    }

    public function render()
    {
        $data = ['building' => $this->building, 'occupancyRate'=> $this->occupancyRate];

        if ($this->currentTab === 'lots') {
            $data['units'] = $this->building;
        } elseif ($this->currentTab === 'compta') {
            $data['building'] = $this->building;
        }

        return view('livewire.properties', $data);
    }

}

