<?php

namespace App\Http\Livewire\ProjectMilestone;

use Livewire\Component;

class AddProjectMilestoneModal extends Component
{
    public $tempplates = [];



    public function render()
    {
        return view('livewire.project-milestone.add-project-milestone-modal');
    }
}
