<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminConfig;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Auth;


class AddAdminConfigModal extends Component
{
    public $admin_config_id;
    public $key;
    public $value;
    public $for_ai_prompt;
    public $edit_mode = false;

    protected $rules = [
        'key' => 'required|string',
        'value' => 'required|string',
        'for_ai_prompt' => 'boolean',
    ];
    protected $listeners = [
        'delete_admin_config' => 'deleteAdminConfig',
        'update_admin_config' => 'updateAdminConfig',
    ];

    public function render()
    {
        return view('livewire.admin.add-admin-config-modal');
    }

    public function submit()
    {
        DB::transaction(function () {
            // Prepare the data for creating a new category
            $data['key'] = $this->key;
            $data['value'] = $this->value;
            $data['for_ai_prompt'] = $this->for_ai_prompt === 'true' ? true : false;
            $data['created_by'] =  Auth::user()->id;
            // Create a new Admin Config record in the database

            if($this->admin_config_id){
                $adminConfig = AdminConfig::where('id', $this->admin_config_id)->first();
                $adminConfig->update($data);
            }else{
                AdminConfig::create($data);
            }
            if ($this->edit_mode) {
                $this->emit('success', __('Admin Config updated'));
            } else {
                // Emit a success event with a message
                $this->emit('success', __('New Admin Config created'));
            }
        });
        // Reset the form fields after successful submission
        $this->reset();
    }

    public function deleteAdminConfig($id)
    {
        AdminConfig::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Admin Config successfully deleted');
    }

    public function updateAdminConfig($id)
    {
        // info("Config Edit Id =>".$id);
        $this->edit_mode = true;
        $adminConfig = AdminConfig::find($id);
        $this->admin_config_id = $adminConfig->id;
        $this->key = $adminConfig->key;
        $this->value = $adminConfig->value;
        $this->for_ai_prompt = $adminConfig->for_ai_prompt;
    }
}
