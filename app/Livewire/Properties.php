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
    public $payments = [];
    public $companies = [];
    
    public $occupiedUnits = 0;

    public $technicalFolders = [];

    public function mount($building, $occupancyRate, $technicalFolders, $payments, $occupiedUnits, $companies)
    {
        if (!is_object($building)) {
            throw new \Exception("Le bâtiment n'est pas un objet valide");
        }
    
        $this->building = $building;
        $this->occupancyRate = $occupancyRate;
        $this->technicalFolders = $technicalFolders;
        $this->payments = $payments;
        $this->occupiedUnits = $occupiedUnits;
        $this->companies = $companies;
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
        $data = ['units' => $this->units, 'building' => $this->building, 'occupancyRate' => $this->occupancyRate, 'technicalFolders' => $this->technicalFolders, 'occupiedUnits' => $this->occupiedUnits];

        return view('livewire.properties', $data);
    }

}

