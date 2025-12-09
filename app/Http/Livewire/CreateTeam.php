<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\team_member;

class CreateTeam extends Component
{
    public $users, $Userarray;
    public $buttonVisible = false;
    public $selectedUser = [];

    protected $listeners = ['UserSelect'  => 'addUser'];

    public function mount()
    {
        
        $this->users = User::all();

        // $this->users = User::whereNotIn('id', function($query) {
        //     $query->select('user_id')->from('team_members');
        // })->get();

        $this->buttonVisible = false;

        $this->Userarray = user::whereIn("id", $this->selectedUser)->get();
    }


    public function addUser($data)
    {
        if (!in_array($data, $this->selectedUser) && $data !== "" && $data != null) {
            array_push($this->selectedUser,$data);
    
            $this->Userarray = user::whereIn("id", $this->selectedUser)->get();
            $this->buttonVisible = true;
        }

    }

    public function hapusUser($data)
    {
        $index = array_search($data, $this->selectedUser);
        unset($this->selectedUser[$index]);

        $this->Userarray = user::whereIn("id", $this->selectedUser)->get();
        if (empty($this->selectedUser)) {
            $this->buttonVisible = false;
        }

    }

    public function render()
    {
        return view('livewire.create-team');
    }
}
