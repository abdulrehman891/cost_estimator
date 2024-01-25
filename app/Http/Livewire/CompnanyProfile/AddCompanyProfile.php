<?php

namespace App\Http\Livewire\CompnanyProfile;

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Auth;
use Livewire\WithFileUploads;

class AddCompanyProfile extends Component
{
    use WithFileUploads;
    public $user;
    public $companyProfile;
    public $company_name;
    public $slogan;
    public $description;
    public $address;
    public $email;
    public $phone_number;
    public $website;

    public $image;
    public $established_date;
    public $edit_mode = false;
    public $company_id;
    public $image_updated = false;

    public function mount()
    {
        $this->user = auth()->user();
        $this->companyProfile = $this->user->companyProfile ?? null;
        if($this->companyProfile){
            $this->edit_mode =  true;
            $this->company_name = $this->companyProfile->name;
            $this->slogan = $this->companyProfile->slogan;
            $this->description = $this->companyProfile->description;
            $this->address = $this->companyProfile->address;
            $this->phone_number = $this->companyProfile->phone;
            $this->website = $this->companyProfile->website;
            $this->company_id = $this->companyProfile->id;
            $this->email = $this->companyProfile->email;

//            $file = UploadedFile::fake()->create($this->companyProfile->logo);
//            $file = new File($this->companyProfile->logo);
//            $this->image = $file->temporaryUrl();
            $this->image = $this->companyProfile->logo;
//            dd(asset('storage/'.$this->image));
            $this->established_date = $this->companyProfile->established;
        }
    }

    public function render()
    {
        return view('livewire.compnany-profile.add-company-profile');
    }

    public function updatedImage()
    {
        $this->image_updated = true;
    }

    public function updateCompanyProfile(){
        dd('ok');
    }

    public function submit()
    {
        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data['name'] = $this->company_name;
            $data['slogan'] = $this->slogan;
            $data['created_by'] = Auth::user()->id;
            $data['description'] = $this->description;
            $data['address'] = $this->address;
            $data['phone'] = $this->phone_number;
            $data['email'] = $this->email;
            $data['website'] = $this->website;
            $data['established'] = $this->established_date;
            $data['user_id'] = Auth::user()->id;
            if($this->image){
                $data['logo'] = $this->image->store('uploads','public');
            }
            if($this->edit_mode)
            {
                $company_profile = CompanyProfile::where('id', $this->company_id)->first();
                $company_profile->update($data);
            }else{
                CompanyProfile::create($data);
            }

        });
    }

}
