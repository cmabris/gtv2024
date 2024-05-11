<?php

namespace App\Http\Livewire\Admin\Map;

use App\Models\PointOfInterest;
use Livewire\Component;

class Map extends Component
{
    public $searchColumn = 'id';

    public function render()
    {
        $points = PointOfInterest::all();

        return view('livewire.admin.map.map', compact('points'));
    }
}
