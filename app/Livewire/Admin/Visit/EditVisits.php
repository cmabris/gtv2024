<?php

namespace App\Livewire\Admin\Visit;

use App\Models\PointOfInterest;
use App\Models\Visit;
use Livewire\Component;
use function view;

class EditVisits extends Component
{
    public $deviceId, $visitId;
    public $pointsOfInterest = [];

    protected $listeners = ['openEditModal'];

    public $editForm = [
        'open' => false,
        'useragent' => '',
        'ssoo' => '',
        'pointOfInterest' => ''
    ];

    protected $rules = [
        'editForm.pointOfInterest' => 'required|exist_point_of_interest',
        'editForm.useragent' => 'required|max:200',
        'editForm.ssoo' => 'required',
    ];

    protected $validationAttributes = [
        'editForm.useragent' => 'Agente',
        'editForm.ssoo' => 'ssoo',
        'editForm.description' => 'descripción',
    ];

    public function openEditModal(Visit $visit)
    {
        $this->reset(['editForm']);

        $this->visitId = $visit->id;
        $this->editForm['pointOfInterest'] = $visit->pointOfInterest->id;
        $this->editForm['ssoo'] = $visit->ssoo;
        $this->editForm['useragent'] = $visit->useragent;

        $this->getPointsOfInterest();

        $this->editForm['open'] = true;
    }

    public function getPointsOfInterest()
    {
        $this->pointsOfInterest = PointOfInterest::all();
    }

    public function update(Visit $vist)
    {
        $this->validate();

        $vist->update([
            'updater' => auth()->user()->id,
            'point_of_interest_id' => $this->editForm['pointOfInterest'],
            'ssoo' => $this->editForm['ssoo'],
            'useragent' => $this->editForm['useragent'],
        ]);

        $this->editForm['open'] = false;
        $this->reset(['editForm']);

        $this->dispatch('render')->to('admin.visit.show-visits');
        $this->dispatch('visitUpdated');
    }

    public function render()
    {
        return view('livewire.admin.visit.edit-visits');
    }
}
