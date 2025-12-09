<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\area;
use App\Models\User;
use App\Models\user_has_area;

class FormAreaPIC extends Component
{
    public $laporan;
    public $genba_area;
    public $selectdisable;

    public $areas, $PIC;
    public $area;

    public $selectedOption;

    public function updatedSelectedOption($value)
    {
        $this->PIC = user_has_area::where('area_id', $value)->where('role_id', 4)->first();
        if($value != "") {
            $area = area::where('id', $value)->first();
            $this->area = $area->name;
        }
    }
    
    public function mount()
    {
        $this->areas = Area::all();
        if(!is_null($this->laporan)) {
            $this->PIC = user_has_area::where('area_id', $this->laporan->area_id)->where('role_id', 4)->first();
        } else if (!is_null($this->genba_area)){
            $this->PIC = user_has_area::where('area_id', $this->genba_area)->where('role_id', 4)->first();
        } else {
            $this->PIC = "";
        }

    }

    public function render()

    {
        
        return view('livewire.form-area-pic');
    }
}
