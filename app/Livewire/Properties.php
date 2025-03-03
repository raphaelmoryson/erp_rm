<?php
namespace App\Livewire;

use App\Models\TechnicalFolder;
use Livewire\Component;
use App\Models\Unit;

class Properties extends Component
{
    public $occupancyRate;
    public $currentTab = 'info';
    public $units = [];
    public $building = [];

    public $technicalFolders = [];

    public function mount($building, $occupancyRate, $technicalFolders)
    {
        $this->building = $building;
        $this->occupancyRate = $occupancyRate;
        $this->technicalFolders = $technicalFolders;
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
        $data = ['building' => $this->building, 'occupancyRate'=> $this->occupancyRate, 'technicalFolders' => $this->technicalFolders];

        if ($this->currentTab === 'lots') {
            $data['units'] = $this->building;
        } elseif ($this->currentTab === 'compta') {
            $data['building'] = $this->building;
        }

        return view('livewire.properties', $data);
    }

}

