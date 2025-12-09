<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\detail_departement;

class CreateKaryawan extends Component
{
    public $areas,$roles,$departments,$detail_departements,$positions;
    public $areadisabled = false; 
    public $selectedOption1;

    protected $listeners = ['departement_change'  => 'dataReceived',
                            'pic_job' => 'viewArea'];
    
    public function dataReceived($data)
    {

        $this->detail_departements = detail_departement::where('departement_id', $data)->get();
        
    }

    public function viewArea($data)
    {
        $this->areadisabled = $data;
        
    }

    public function render()
    {

        return view('livewire.create-karyawan');
    }
}
