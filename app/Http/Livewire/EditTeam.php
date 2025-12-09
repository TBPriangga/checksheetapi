<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\team;
use App\Models\User;

class EditTeam extends Component
{
    public $getUsers, $Userarray, $team_id, $team;
    public $buttonVisible = true;
    public $selectedUser = [];
    public $users = [];

    protected $listeners = ['UserSelectEdit'  => 'addUser'];

    public function mount()
    {
        $this->team = team::where('id', $this->team_id)->first();
        // $this->getUsers = User::whereNotIn('id', function($query) {
        //     $query->select('user_id')->from('team_members');
        // })->get();
        $this->users = user::all();
        foreach($this->team->user as $user) {
            array_push($this->selectedUser,$user->user_id);
        }

        // foreach ($this->getUsers as $user) {
        //     $this->users[] = ['id' => $user->id, 'name' => $user->name];
        
        // }
        // $this->users = json_encode($this->users);
        $this->buttonVisible = true;

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
        return view('livewire.edit-team');
    }
}
