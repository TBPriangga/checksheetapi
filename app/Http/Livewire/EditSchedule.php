<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\team;
use App\Models\team_member;

class EditSchedule extends Component
{

    public $teams ;
    public $genba ;
    public $team_id;
    public $team_members = [];
    public $team_array = [];
    public $selectedTeam;
    public $buttonVisible = false;

    public function updatedSelectedTeam($value)
    {
        $this->team_id = $value;
        $this->team_members = team_member::where('team_id', $this->team_id)->get();
        $this->team_array = [];
        foreach($this->team_members as $member) {
            array_push($this->team_array,$member->user->id);
        }
        $this->buttonVisible = true;
    }

    public function hapusUser($data)
    {
        $index = array_search($data, $this->team_array);
        unset($this->team_array[$index]);
        $this->team_members = team_member::whereIn("user_id", $this->team_array)->where('team_id', $this->team_id)->get();
        if (empty($this->team_array)) {
            $this->buttonVisible = false;
        } else {
            $this->buttonVisible = true;
        }

    }

    public function mount() {
        $this->teams = team::where('deleted_at', null)->get();
        $this->team_members = team_member::where('team_id', $this->genba->team_id)->get();
        $this->team_id = $this->genba->team_id;
        foreach($this->team_members as $member) {
            array_push($this->team_array, $member->user->id);
        }
        $this->buttonVisible = true;
    }


    public function render()
    {
        return view('livewire.edit-schedule');
    }
}
