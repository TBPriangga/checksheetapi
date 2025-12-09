<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\laporan;

class DataTables extends Component
{
    public $laporans;

    public function render()
    {
        $this->laporans = laporan::paginate(2);
        return view('livewire.data-tables');
    }
}
