<?php

namespace App\Http\Livewire\Quotation;

use App\Http\Controllers\ChatGPTController;
use App\Models\Product;
use App\Models\ProjectMilestone;
use App\Models\Quotation;
use App\Models\QuoteLineItem;
use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\Customer;
use App;
use PDF;
use Illuminate\Support\Facades\Storage;



//use Barryvdh\DomPDF\PDF;
//use Barryvdh\DomPDF\Facade\PDF;
//use Dompdf\Dompdf;




use Illuminate\Support\Facades\DB;
use Auth;
use Livewire\WithFileUploads;

class AddQuotationModal extends Component
{
    use WithFileUploads;
    public $currentStep;
    public $totalStep = 5;
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
    public $quoteItems = [''];

    //Project Milestone
    public $milestone_list = [''];
    public $milestone_name;
    public  $project_milestone = [];
    public $milestone_description = [];
    //End of Project Milestone

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

    //Quote Line Items
    public $quote_line_items;
    public $formData;
    public  $products = [];
    public $unit_price = [];
    public $quantity = [];
    public $discount_price = [];
    public $total_price = [];

    public $products_list;

    public $quoteLineItemsData = [];
    //end of QuoteLine Module
    public $projectMilestoneArray = [];
    public $users_list;

    public $customer_list;
    public $customer_id;

    public $res_chatGPT="";

    protected $rules = [
        'name' => 'required|string',
        'description' => 'string',
        'expected_start_date' => 'required',
        'expected_end_date' => 'required',
        'prepared_date' => 'required',
        'project_size' => 'required'
    ];

    protected $listeners = [
        'get_proposal' => 'getProposalChatGPT',
        'delete_quotation' => 'deleteQuotation',
    ];

    public function deleteQuotation($id)
    {
        Quotation::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Quotation successfully deleted');
    }

    public function increaseStep()
    {
        $this->currentStep++;
        if($this->currentStep == 5){
            $this->getProposalChatGPT();
        }
        if($this->currentStep > $this->totalStep)
        {
            $this->currentStep = $this->totalStep;
        }
    }
    public function decreaseStep()
    {
        $this->currentStep--;
    }
    public function mount(){
        $this->currentStep = 1;
        $this->products_list =  Product::all();
        $this->users_list = User::all();
        $this->customer_list = Customer::all();
    }
    public function addMilestone(){
        $this->milestone_list[] ='';
    }
    public function removeMilestone($index){
        unset($this->milestone_list[$index]);
        $this->milestone_list = array_values($this->milestone_list);
    }
    public function addQuoteline()
    {
        $this->quoteItems[] = '';
    }
    public function removeQuoteline($index)
    {
        unset($this->quoteItems[$index]);
        $this->quoteItems = array_values($this->quoteItems);
    }
    public function render()
    {
        addVendors(['formrepeater']);
        return view('livewire.quotation.add-quotation-modal');
    }
    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updated($key, $value){
//        dd($key);
        $this->saved = FALSE;

        $parts = explode(".",$key);
        if(count($parts) == 2 && $parts[0] == "products"){
            $product = $this->products_list->where('id', $value)->first();
            $this->unit_price[$parts[1]] = $product->price;
        }
        if(count($parts) == 2 && $parts[0] == "quantity"){
            if($this->discount_price)
            {
                $this->total_price[$parts[1]] = $this->unit_price[$parts[1]] * $value - $this->discount_price[$parts[1]];
            }else{
                $this->total_price[$parts[1]] = $this->unit_price[$parts[1]] * $value;
            }

        }
    }
    public function submit(){
        $project_id = $this->addProject();
        $this->addProjectMilestone($project_id);
        $quotation_id = $this->addQuotation($project_id);
        $this->addQuoteLineItems($quotation_id);
        $this->getProposalChatGPT($quotation_id);
//        $this->increaseStep();
    }
    public function addQuoteLineItems($quotation_id)
    {
        for ($x = 0; $x < count($this->products); $x++) {
            $quoteLineItem_obj = new QuoteLineItem();
            $quoteLineItem_obj->product_id = $this->products[$x];
            $quoteLineItem_obj->unit_price = $this->unit_price[$x];
            $quoteLineItem_obj->discount_price = $this->discount_price[$x];
            $quoteLineItem_obj->quantity = $this->quantity[$x];
            $quoteLineItem_obj->total_price = $this->total_price[$x];
            $quoteLineItem_obj->created_by =  Auth::user()->id;
            $quoteLineItem_obj->quotation_id = $quotation_id;
            $product = $this->products_list->where('id', $this->products[$x])->first();
            $product_name = $product->product_name;
            $this->quoteLineItemsData[] = array(
                "item_name" => $product_name,
                "unit_price" => $this->unit_price[$x],
                "discount_price" => $this->discount_price[$x],
                "quantity" => $this->quantity[$x],
                "total_price" => $this->total_price[$x]
            );
            $quoteLineItem_obj->save();
        }
    }
    public  function addQuotation( $project_id)
    {
        $quotation_obj = new Quotation();
        $quotation_obj->prepared_date = $this->prepared_date;
        $quotation_obj->assembly_type = $this->assembly_type;
        $quotation_obj->manufacturer = $this->manufacturer;
        $quotation_obj->sq_walls = $this->sq_walls;
        $quotation_obj->sq_field = $this->sq_field;
        $quotation_obj->customer_id = $this->customer_id;
        $quotation_obj->warranty = $this->warranty;
        $quotation_obj->parapet_length = $this->parapet_length;
        $quotation_obj->building_height = $this->building_height;
        $quotation_obj->deck_type = $this->deck_type;
        $quotation_obj->inclusions = $this->inclusions;
        $quotation_obj->exclusions = $this->exclusions;
        $quotation_obj->payment_schedule = $this->payment_schedule;
        $quotation_obj->price_escalation_clause = $this->price_escalation_clause;
        $quotation_obj->alterations = $this->alterations;
        $quotation_obj->compliance = $this->compliance;
        $quotation_obj->timelines = $this->timelines;
        $quotation_obj->project_id = $project_id;
        $quotation_obj->warranty_clause = $this->warranty_clause;
        $quotation_obj->created_by =  Auth::user()->id;
        $quotation_obj->save();
        return $quotation_obj->id;
    }

    public function addProject(){
            $project_obj = new Project();
            // Prepare the data for creating a new user
            $project_obj->name = $this->project_name;
            $project_obj->description = $this->description;
            $project_obj->created_by =  Auth::user()->id;
            $project_obj->expected_start_date =  $this->expected_start_date;
            $project_obj->expected_end_date =  $this->expected_end_date;
            $project_obj->project_size =  $this->project_size;
            $project_obj->project_type =  $this->project_type;
            $project_obj->manager_id =  $this->project_manager;
            $project_obj->save();
            return $project_obj->id;
    }
    public function addProjectMilestone($project_id)
    {
        for ($x = 0; $x < count($this->project_milestone); $x++) {
            $pm_obj = new ProjectMilestone();
            $pm_obj->name = $this->project_milestone[$x];
            $pm_obj->description = $this->milestone_description[$x];
            $pm_obj->created_by =  Auth::user()->id;
            $pm_obj->project_id = $project_id;
            $this->projectMilestoneArray[] = array(
                "milestone_name" => $this->project_milestone[$x],
                "milestone_description" => $this->milestone_description[$x],
            );
            $pm_obj->save();
        }
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

        $response = array(
            "projectDetails" => json_encode($projectData),
            "projectMilestones" => json_encode($this->projectMilestoneArray),
            "quotationDetails" => json_encode($quotationData),
            "quoteLineItemsDetails" => json_encode($this->quoteLineItemsData),
        );

        return $response;
    }
    public function getProposalChatGPT($quote_id)
    {
        $this->isLoading = true;
        $chat =new ChatGPTController();
        $formData = $this->getQuotationString();
//        dd($formData);
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
//        $this->res_chatGPT =$chat->createPurposalChatGPT($msg_data);
        //sleep(2);
        $this->res_chatGPT = "";
        $this->generatePDF($this->res_chatGPT,$quote_id); // Generate PDF from the response
//        $this->isLoading = false; // Stop loading
//        $this->emit('dataUpdated');
    }

    private function generatePDF($response,$quote_id)
    {

//        if (Storage::disk('public')->exists('/uploads/docs_2.pdf')) {
//            $filePath = Storage::disk('public')->path('uploads/docs_2.pdf');dd($filePath);
//            return response()->download($filePath, 'asimocs_2.pdf');
//        } else {
//            abort(404, 'File not found');
//        }
        try {
//            $pdf = PDF::loadHTML("working is of HTML")->save('uploads/docs_2.pdf','public');
            $pdf = PDF::loadView('pdf-template.proposal')->save("uploads/$quote_id.pdf",'public');
            if($pdf){
                return $pdf->download("uploads/$quote_id.pdf");
            }else{
                return false;
            }
            return $pdf->download();
            $filePath = asset('storage/docs.pdf');
//            dd($pdf);
//            dd(Storage::exists('public/docs.pdf'));

            return response()->download($filePath);
            dd($filePath);
            if(file_exists($filePath))
            {
                return response()->download($filePath);
                dd('ok');
            }else{
                dd('not ok');

            }
            return response()->download($filePath, 'docs.pdf',$headers);
        } catch (\Exception $e) {
            dd('PDF generation error: ' . $e->getMessage());
            // Handle the error as needed
        }
//        $dompdf = new Dompdf();
//        $dompdf->loadHtml($html);
//
//// (Optional) Setup the paper size and orientation
//        $dompdf->setPaper('A4', 'landscape');
////        return $dompdf->download("abc.pdf");
//
//// Render the HTML as PDF
////        $dompdf->render();
//
//// Output the generated PDF to Browser
//         return $dompdf->stream();
//        return $dompdf;
//
//        $pdfPath = storage_path("app/public/proposal.pdf");
//        file_put_contents($pdfPath, $response);
    }
}
