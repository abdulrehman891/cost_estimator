<?php

namespace App\Http\Livewire\Quotation;

use App\Http\Controllers\ChatGPTController;
use App\Models\Product;
use Livewire\Component;
use App\Models\User;
use App\Models\Project;

use Illuminate\Support\Facades\DB;
use Auth;
class AddQuotationModal extends Component
{
    public $currentStep = 1;
    public $isLoading = false;
//    public $name, $amount, $description, $status = 1, $stock;
//    public $successMessage = '';

    //List for Project Module
    public $project_name;
    public $description;
    public $expected_start_date;
    public $expected_end_date;
    public $project_size;
    public $project_manager = null;
    public $project_type;
    //End of Project module fields
    public $quoteItems = [];

    //Project Milestone
    public $milestone_name;
    public $milestone_description;


    //List for Quotation Module
    public $prepared_date;
    public $assembly_type;
    public $manufacturer;
    public $sq_walls;
    public $sq_field;
    public $warranty;
    public $parapet_length;
    public $building_height;
    public $deck_type;
    public $inclusions;
    public $exclusions;
    public $payment_schedule;
    public $price_escalation_clause;
    public $alterations;
    public $compliance;
    public $timelines;
    public $warranty_clause;
    //End of Quotation Module Fields



    public $quote_line_items;
    public $formData;


    public $res_chatGPT="";

    protected $rules = [
        'name' => 'required|string',
        'description' => 'string',
        'expected_start_date' => 'required',
        'expected_end_date' => 'required',
        'project_size' => 'required'
    ];

    protected $listeners = [
        'get_proposal' => 'getProposalChatGPT',
    ];

    public function increaseStep()
    {
        $this->currentStep++;
    }

    public function decreaseStep()
    {
        $this->currentStep--;
    }
    public function mount(){
        $this->currentStep = 1;

    }
    public function addLineItem()
    {
        $this->quoteItems[] = '';
    }
    // New method for removing line items
    public function removeLineItem()
    {
    }
    public function render()
    {
        addVendors(['formrepeater']);
        return view('livewire.quotation.add-quotation-modal',['users' => User::all(), 'products' => Product::all()]);
    }
    public function addProject(){
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
        });
    }


    public function getQuotationString(){
        $projectData['project_name'] = $this->project_name;
        $projectData['project_description'] = $this->description;
        $projectData['project_expected_start_date'] =  $this->expected_start_date;
        $projectData['project_expected_end_date'] =  $this->expected_end_date;
        $projectData['project_size'] =  $this->project_size;
        $projectData['project_type'] =  $this->project_type;
        $project_manager = User::find($this->project_manager);
        if(!empty($project_manager->id)){

            $projectData['project_manager'] =  $project_manager->first_name." ".$project_manager->last_name;
        } else {

            $projectData['project_manager'] =  "N/A";
        }


        $quotationData['prepared_date']= $this->prepared_date;
        $quotationData['assembly_type']= $this->assembly_type;
        $quotationData['manufacturer']= $this->manufacturer;
        $quotationData['sq_walls']= $this->sq_walls;
        $quotationData['sq_field']= $this->sq_field;
        $quotationData['warranty']= $this->warranty;
        $quotationData['parapet_length']= $this->parapet_length;
        $quotationData['building_height']= $this->building_height;
        $quotationData['deck_type']= $this->deck_type;
        $quotationData['inclusions']= $this->inclusions;
        $quotationData['exclusions']= $this->exclusions;
        $quotationData['payment_schedule']= $this->payment_schedule;
        $quotationData['price_escalation_clause']= $this->price_escalation_clause;
        $quotationData['alterations']= $this->alterations;
        $quotationData['compliance']= $this->compliance;
        $quotationData['timelines']= $this->timelines;
        $quotationData['warranty_clause']= $this->warranty_clause;


        $quoteLineItemsData[] = array("item_name" => "TPO bonding adhesive", "unit_price" => "10", "discount_price" => "0", "quantity" => "10", "total_price" => "100");
        $quoteLineItemsData[] = array("item_name" => "60 mil 10' x 100' TPO", "unit_price" => "25", "discount_price" => "0", "quantity" => "10", "total_price" => "250");
        $quoteLineItemsData[] = array("item_name" => "Cut edge sealant' TPO", "unit_price" => "32", "discount_price" => "0", "quantity" => "10", "total_price" => "320");

        $response = array(
            "projectDetails" => json_encode($projectData),
            "quotationDetails" => json_encode($quotationData),
            "quoteLineItemsDetails" => json_encode($quoteLineItemsData),
        );

        return $response;
    }

    public function updated($key, $value){

    }

    public function getProposalChatGPT()
    {
        $this->isLoading = true;
        $chat =new ChatGPTController();
        $formData = $this->getQuotationString();
        $msg_data = "Create a construction project proposal by using below information Project Information
Project Details:";
        $msg_data .= $formData['projectDetails'];
        $msg_data .= "

        as per above details write details with below heading
Warranty, Inclusions, Payment Schedule, Compliance and warranty clause
moreover also mention risk factors for quote line items take below details and calculate line total and full total.";
        $msg_data .= $formData['quoteLineItemsDetails'];
        $msg_data .= " check below detail quotation details and use it in proposal
        ";
        $msg_data .= $formData['quotationDetails'];
        $msg_data .= "

            take above information and write proposal can be send to client for approval.
                        Also mention validity and disclaimers
                        Create around 250 words";
        $this->res_chatGPT =$chat->createPurposalChatGPT($msg_data);
        sleep(2);

        $this->generatePDF($this->res_chatGPT); // Generate PDF from the response
        $this->isLoading = false; // Stop loading
        $this->emit('dataUpdated');
    }

    private function generatePDF($response)
    {
        $pdfPath = storage_path("app/public/proposal.pdf");
        file_put_contents($pdfPath, $response);
    }
//    public function firstStepSubmit()
//    {
//        $validatedData = $this->validate([
//            'name' => 'required|unique:products',
//            'amount' => 'required|numeric',
//            'description' => 'required',
//        ]);
//
//        $this->currentStep = 2;
//    }
//
//    /**
//     * Write code on Method
//     *
//     * @return response()
//     */
//    public function secondStepSubmit()
//    {
//        $validatedData = $this->validate([
//            'stock' => 'required',
//            'status' => 'required',
//        ]);
//
//        $this->currentStep = 3;
//    }
//
//    /**
//     * Write code on Method
//     *
//     * @return response()
//     */
//    public function submitForm()
//    {
//        Product::create([
//            'name' => $this->name,
//            'amount' => $this->amount,
//            'description' => $this->description,
//            'stock' => $this->stock,
//            'status' => $this->status,
//        ]);
//
//        $this->successMessage = 'Product Created Successfully.';
//
//        $this->clearForm();
//
//        $this->currentStep = 1;
//    }
//
//    /**
//     * Write code on Method
//     *
//     * @return response()
//     */
//    public function back($step)
//    {
//        $this->currentStep = $step;
//    }
//
//    /**
//     * Write code on Method
//     *
//     * @return response()
//     */
//    public function clearForm()
//    {
//        $this->name = '';
//        $this->amount = '';
//        $this->description = '';
//        $this->stock = '';
//        $this->status = 1;
//    }
}
