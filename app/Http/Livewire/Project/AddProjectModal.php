<?php

namespace App\Http\Livewire\Project;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Auth;

class AddProjectModal extends Component
{
    public $project_id;
    public $project_name;
    public $description;
    public $expected_start_date;
    public $expected_end_date;

    public $project_manager = null;

    public $project_size;

    public $project_type;
    public $edit_mode = false;

    protected $listeners = [
        'delete_project' => 'deleteProject',
        'update_project' => 'updateProject',
    ];

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
            if($this->project_id){
                $project = Project::where('id', $this->project_id)->first();
                $project->update($data);
            }else{
                Project::create($data);
            }
            if ($this->edit_mode) {
                // Assign selected role for user
                $this->emit('success', __('Project updated'));
            } else {
//                 Emit a success event with a message
                $this->emit('success', __('New project created'));
            }
        });

        // Reset the form fields after successful submission
        $this->reset();
    }
    public function deleteProject($id)
    {
        Project::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Project successfully deleted');
    }
    public function updateProject($id){
        $this->edit_mode = true;
        $project = Project::find($id);
        $this->project_id = $project->id;
        $this->project_name = $project->name;
        $this->description= $project->description;
        $this->expected_start_date= $project->expected_start_date;
        $this->expected_end_date= $project->expected_end_date;
        $this->project_size= $project->project_size;
        $this->project_type= $project->project_type;
//        $this->project_manager= $project->project_manager;
    }
}
