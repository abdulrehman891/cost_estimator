<?php

namespace App\Http\Livewire\Project;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Auth;

class AddProjectModal extends Component
{
    public $project_name;
    public $description;
    public $expected_start_date;
    public $expected_end_date;

    public $project_manager = null;

    public $project_size;

    public $project_type;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'string',
        'expected_start_date' => 'required',
        'expected_end_date' => 'required',
        'project_size' => 'required'
    ];
    public function render()
    {
        return view('livewire.project.add-project-modal',['users' => User::all()]);
    }

    public function submit()
    {

        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data['name'] = $this->project_name;
            $data['description'] = $this->description;
            $data['created_by'] =  Auth::user()->id;
            $data['expected_start_date'] =  $this->expected_start_date;
            $data['expected_end_date'] =  $this->expected_end_date;
            $data['project_size'] =  $this->project_size;
            $data['project_type'] =  $this->project_type;
            $data['manager_id'] =  $this->project_manager;
            // Create a new user record in the database
            //manager_id
            Project::updateOrCreate($data);


//            if ($this->edit_mode) {
//                // Assign selected role for user
//                $this->emit('success', __('User updated'));
//            } else {
//
//
//                // Emit a success event with a message
//                $this->emit('success', __('New user created'));
//            }
        });

        // Reset the form fields after successful submission
//        $this->reset();
    }
}
