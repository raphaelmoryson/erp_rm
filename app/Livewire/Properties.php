<?php
namespace App\Livewire;
 
use Livewire\Component;
use App\Models\Unit; // Assure-toi d'importer le modèle Unit

class Properties extends Component
{
    public $building;
    public $currentTab = 'info';

    public function mount($building)
    {
        $this->building = $building;
    }

    public function setTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function render()
    {
        $data = [];

        if ($this->currentTab === 'info') {
            $data['building'] = $this->building;
        } elseif ($this->currentTab === 'lots') {
            $data['units'] = Unit::where('property_id', $this->building->id)->get();
        } elseif ($this->currentTab === 'compta') {
            $data['building'] = $this->building;
        }

        return view('livewire.properties', $data);
    }
}

