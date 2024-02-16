<?php

namespace App\Http\Livewire\CompnanyProfile;

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Auth;
use Livewire\WithFileUploads;
use App\Http\Controllers\JLSignnowHelpersController;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\MultipartStream;


class AddCompanyProfile extends Component
{
    use WithFileUploads;
    public $user;
    public $signnow_brand_id;
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
        if ($this->companyProfile) {
            $this->edit_mode =  true;
            $this->company_name = $this->companyProfile->name;
            $this->slogan = $this->companyProfile->slogan;
            $this->description = $this->companyProfile->description;
            $this->address = $this->companyProfile->address;
            $this->phone_number = $this->companyProfile->phone;
            $this->website = $this->companyProfile->website;
            $this->company_id = $this->companyProfile->id;
            $this->email = $this->companyProfile->email;
            $this->signnow_brand_id = $this->companyProfile->signnow_brand_id;

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

    public function updateCompanyProfile()
    {
        dd('ok');
    }

    public function submit()
    {
        $company_profile = [];
        $db_name = "";
        $db_email = "";
        $db_logo = "";
        if (!empty($this->company_id)) {
            $company_profile = CompanyProfile::where('id', $this->company_id)->first();
            $db_name = $company_profile->name;
            $db_email = $company_profile->email;
            $db_logo = $company_profile->image;
        }
        $data = [];
        DB::transaction(function () use (&$company_profile, &$data) {
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
            if ($this->edit_mode) {
                if ($this->image && $this->image_updated) {
                    $data['logo'] = $this->image->store('uploads', 'public');
                }
                $company_profile->update($data);
            } else {
                if ($this->image) {
                    $data['logo'] = $this->image->store('uploads', 'public');
                }
                $company_profile = CompanyProfile::create($data);
            }
        });
        //do the branding settings for Signnow
        $cont = new JLSignnowHelpersController(Auth::user()->email);
        //$company_profile = CompanyProfile::where('id', $this->company_id)->first();

        // Log::info(print_r($company_profile, 1));
        // Log::info(print_r($data, 1));

        if (empty($company_profile->signnow_brand_id)) {
            //create a new brand to manage invite email logo, colors, texts and other custom settings                       
            $request_data = array(
                'title' => "Brand for " . $this->company_name . " by User:" . Auth::user()->email,
                'contact_email' => $this->email,
                'logo_url' => (!empty($data['logo'])) ? asset('storage/' . $data['logo']) : asset('storage/' . $this->image)
            );
            Log::info(print_r($request_data, 1));
            $response = $cont->CreateBrandFromTemplate($request_data);
            if ($response->getData()->status == true) {
                //save the ID to the company profile record
                $newdata['signnow_brand_id'] = $response->getData()->id;
                $company_profile->update($newdata);
            } else {
                Log::info("Error occured while creating the new Brand where Company Id=$this->company_id");
                Log::info(print_r($response, 1));
            }
        } else if (!empty($company_profile->signnow_brand_id)) {
            //update the existing brand to manage invite email logo, colors, texts and other custom settings
            //in case of email change, update the brand editor sender info
            if ($company_profile->email !=  $db_email) {
                $request_data = array(
                    'brand_id' => $company_profile->signnow_brand_id,
                    'contact_email' => $this->email,
                );
                $response = $cont->EditBrandEditorInfo($request_data);
                if ($response->getData()->status == false) {
                    Log::info("Error occured while updating the Brand email where Company Id=$this->company_id");
                    Log::info(print_r($response, 1));
                }
            }
            //in case of name change, update the brand title
            if ($company_profile->name !=  $db_name) {
                $request_data = array(
                    'brand_id' => $company_profile->signnow_brand_id,
                    'title' => "Brand for " . $this->company_name . " by User:" . Auth::user()->email
                );
                $response = $cont->EditBrandName($request_data);
                if ($response->getData()->status == false) {
                    Log::info("Error occured while updating the Brand name where Company Id=$this->company_id");
                    Log::info(print_r($response, 1));
                }
            }
            //in case of logo change, update the brand logo
            if ($this->image_updated) {
                // The attribute has been changed
                $request_data = array(
                    'brand_id' => $company_profile->signnow_brand_id,
                    'logo_url' => asset('storage/' . $data['logo'])
                );
                Log::info(print_r($request_data, 1));
                $response = $cont->EditBrandLogo($request_data);
                if ($response->getData()->status == false) {
                    Log::info("Error occured while updating the Brand logo where Company Id=$this->company_id");
                    Log::info(print_r($response, 1));
                }
            }
        }

        /* backup code, if need to create signnow organization any time
        if ($this->image) {
            // Create a multipart stream for the logo file
            $logoStream = new MultipartStream([
                [
                    'name' => 'logo',
                    'contents' => fopen($this->image->getRealPath(), 'r'),
                    'filename' => $this->image->getClientOriginalName(),
                ],
            ]);
        }
        
         $request_data = array(
            'title' => $this->company_name,
            'phone_number' => $this->phone_number,
        );
        $company_profile = CompanyProfile::where('id', $this->company_id)->first();
        if (!empty($company_profile->signnow_organization_id)) {
            $response = $cont->EditOrganization($request_data, $company_profile->signnow_organization_id);
            if ($response->getData()->status == false) {
                Log::info("Error occured while updating the Organziation for $company_profile->signnow_organization_id where Company Id=$this->company_id");
                Log::info(print_r($response, 1));
            }
        } else {
            $response = $cont->CreateOrganization($request_data);
            if ($response->getData()->status == true) {
                //save the ID to the company profile record
                $newdata['signnow_organization_id'] = $response->getData()->id;
                $company_profile->update($newdata);
            } else {
                Log::info("Error occured while creating the new Organziation where Company Id=$this->company_id");
                Log::info(print_r($response, 1));
            }
        }
        if ($this->image && !empty($company_profile->signnow_organization_id)) {
            $logo_path = $this->image->getRealPath();
            $logo_path = $data['logo'];
            // Get the base64-encoded logo
            //$base64Logo = base64_encode(file_get_contents($this->image->getRealPath()));

            Log::info("Logo=$logo_path");
            $response = $cont->uploadOrganizationLogo($logoStream, $company_profile->signnow_organization_id,$this->company_name);
            if ($response->getData()->status == false) {
                Log::info("Error occured while uploading the Organziation Logo for $company_profile->signnow_organization_id where Company Id=$this->company_id");
                Log::info(print_r($response, 1));
            }
        }
        */
    }
}
