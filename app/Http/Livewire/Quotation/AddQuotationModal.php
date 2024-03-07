<?php

namespace App\Http\Livewire\Quotation;

use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\Admin\AdminConfigController;
use App\Models\Product;
use App\Models\ProjectMilestone;
use App\Models\Quotation;
use App\Models\QuoteLineItem;
use App\Models\QuotationTemplate;
use App\Models\QuoteTemplateLineItem;
use Livewire\Component;
use App\Models\User;
use App\Models\Project;
use App\Models\Customer;
use App\Models\ProductPriceHistory;
use App;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;



//use Barryvdh\DomPDF\PDF;
//use Barryvdh\DomPDF\Facade\PDF;
//use Dompdf\Dompdf;




use Illuminate\Support\Facades\DB;
use Auth;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

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
    public $address;
    public $expected_start_date;
    public $expected_end_date;
    public $project_size;
//    public $project_manager = null;
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
    public  $milestone_quote = [];
    public $price_update = [];
    public $unit_price = [];
    public $quantity = [];
    public $discount_price = [];
    public $total_price = [];

    public $products_list;
    public $project_image;
    public $project_image_changed = false;

    public $quoteLineItemsData = [];
    //end of QuoteLine Module
    public $projectMilestoneArray = [];
    public $users_list;
    public $customer_list;
    public $customer_id;
    public $edit_mode = false;
    public $quotationID;
    public $quotationTemplateID;
    public $quote_templates_list;

    public $preview = false;
    public $regenerate = false;
    public $chatGPT_res ="";
    public $res_chatGPT="";

    public $project_list = [];
    public $projects;

    public $use_existing_project = false;
    public $existing_project_id;


    public $messages = [
        'products.0' => 'The Product field is required.',
        'unit_price.0' => 'The Product Unit Price field is required.',
        'quantity.0' => 'The Product Quantity field is required.',
        'total_price.0' => 'The Total Price field is required.',

//        'project_milestone.0' => 'The Project Milestone field is required.',
    ];

    public $validationRules = [
        1 =>[
            'project_name' => 'required|string',
            'expected_start_date' => 'required',
            'expected_end_date' => 'required',
            'project_size' => 'required',
            'project_type' => 'required',
        ],
        2 => [
//            "project_milestone.0" => 'required',
        ],
        3 => [
            'prepared_date' => 'required',
            'assembly_type' => 'required',
            'manufacturer' => 'required',
            'sq_walls' => 'required',
            'sq_field' => 'required',
            'warranty' => 'required',
            'parapet_length' => 'required',
            'building_height' => 'required',
            'deck_type' => 'required',
            'inclusions' => 'required',
            'exclusions' => 'required',
            'payment_schedule' => 'required',
            'price_escalation_clause' => 'required',
            'alterations' => 'required',
            'compliance' => 'required',
            'timelines' => 'required',
            'warranty_clause' => 'required',
        ],
        4 =>[
            "products.0" => 'required',
            "unit_price.0" => 'required',
            "quantity.0" => 'required',
            "total_price.0" => 'required'
        ]

    ];

    protected $listeners = [
        'get_proposal' => 'getProposalChatGPT',
        'delete_quotation' => 'deleteQuotation',
        'update_quotation' => 'updateQuotation',
        'send_quotation' => 'sendQuotation',
    ];

    public function deleteQuotation($id)
    {
        Quotation::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Quotation successfully deleted');
    }

    public function sendQuotation($quotationId)
    {
        return redirect()->route('qoutation.send', $quotationId);
    }
    public function updatedProject_image(){
        $this->project_image_changed = true;
    }
    public function previewProposal(){
        $this->isLoading = true;
        $this->preview = true;
        if($this->chatGPT_res == ''){
            $this->chatGPT_res = $this->getProposalChatGPT();
        }
        $this->emit('responseGenerated');
        $this->isLoading = false;

    }
    public function regenerateProposal(){
        $this->isLoading = true;
        $this->regenerate = true;

        if($this->chatGPT_res){
            $this->chatGPT_res = $this->getProposalChatGPT("regenerate and rephrase with given information");
        }
        $this->emit('responseGenerated');
        $this->isLoading = false;

    }

    public function addQuoteline()
    {
        $this->quoteItems[] = '';
        $x = count($this->quoteItems)-1;
        $this->validationRules[4] =  array_merge(
            $this->validationRules[4],
            [
                "products.$x" => 'required',
                "unit_price.$x" => 'required',
                "quantity.$x" => 'required',
                "total_price.$x" => 'required'
            ]
        );
        $this->messages = array_merge(
            $this->messages,
            [
                "products.$x" => 'The Product field is required.',
                "unit_price.$x" => 'The Product Unit Price field is required.',
                "quantity.$x" => 'The Product Quantity field is required.',
                "total_price.$x" => 'The Product Total Price field is required.'
            ]
        );
    }
    public function removeQuoteline($index)
    {
        unset($this->quoteItems[$index]);
        unset($this->validationRules[4]["products.".$index]);
        unset($this->validationRules[4]["unit_price.".$index]);
        unset($this->validationRules[4]["discount_price.".$index]);
        unset($this->validationRules[4]["quantity.".$index]);
        unset($this->validationRules[4]["total_price.".$index]);
        $this->quoteItems = array_values($this->quoteItems);
    }

    public function addMilestone(){
        $this->milestone_list[] ='';
//        $x = count($this->milestone_list)-1;
//        $this->messages = array_merge(
//            $this->messages,
//            [ "project_milestone.$x" => 'The Project Milestone field is required.' ]
//        );
//        $this->validationRules[2] =  array_merge(
//            $this->validationRules[2],
//            [ "project_milestone.$x" => 'required' ]
//        );
    }
    public function removeMilestone($index){
            unset($this->milestone_list[$index]);
//            unset($this->validationRules[2]["project_milestone.".$index]);
            $this->milestone_list = array_values($this->milestone_list);
    }

    public function increaseStep()
    {
        if($this->currentStep != 2){
            $this->validate($this->validationRules[$this->currentStep]);
        }
        $this->currentStep++;
        if($this->currentStep == 5){
//            $this->getProposalChatGPT();
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
        $this->prepared_date = date('Y-m-d');
        $adminRole = Role::where('name', 'administrator')->first();
        $userIds = $adminRole->users->pluck('id');
        $admin_user_id = $userIds[0];
        $this->products_list = Product::whereIn('created_by',[$admin_user_id, Auth::user()->id])->get(); //Product::all();
        $this->users_list = User::all();
        $this->customer_list = Customer::whereIn('created_by',[$admin_user_id, Auth::user()->id])->get();
        $this->project_list = Project::whereIn('created_by',[$admin_user_id, Auth::user()->id])->get();

        $this->quote_templates_list = QuotationTemplate::whereIn('created_by',[$admin_user_id, Auth::user()->id])->get();

        $adminConfController = new AdminConfigController();
        $adminPrompts = $adminConfController->getAllPrompts();
        $this->inclusions = isset($adminPrompts['inclusions'])?$adminPrompts['inclusions']:"";
        $this->exclusions = isset($adminPrompts['exclusions'])?$adminPrompts['exclusions']:"";
        $this->payment_schedule = isset($adminPrompts['payment_schedule'])?$adminPrompts['payment_schedule']:"";
        $this->price_escalation_clause = isset($adminPrompts['price_escalation'])?$adminPrompts['price_escalation']:"";
        $this->alterations = isset($adminPrompts['alterations'])?$adminPrompts['alterations']:"";
        $this->compliance = isset($adminPrompts['compliance'])?$adminPrompts['compliance']:"";
        $this->timelines = isset($adminPrompts['timelines'])?$adminPrompts['timelines']:"";
        $this->warranty_clause = isset($adminPrompts['warranty'])?$adminPrompts['warranty']:"";
    }
    public function updateQuotation($id)
    {
        $this->edit_mode = true;
        $this->quotationID = $id;
        $quotation = Quotation::find($id);
        $this->prepared_date = $quotation->prepared_date;
        $this->assembly_type = $quotation->assembly_type;
        $this->manufacturer = $quotation->manufacturer;
        $this->sq_walls = $quotation->sq_walls;
        $this->sq_field = $quotation->sq_field;
        $this->customer_id = $quotation->customer_id;
        $this->warranty = $quotation->warranty;
        $this->parapet_length = $quotation->parapet_length;
        $this->building_height = $quotation->building_height;
        $this->deck_type = $quotation->deck_type;
        $this->inclusions = $quotation->inclusions;
        $this->exclusions = $quotation->exclusions;
        $this->payment_schedule = $quotation->payment_schedule;
        $this->price_escalation_clause = $quotation->price_escalation_clause;
        $this->alterations = $quotation->alterations;
        $this->compliance = $quotation->compliance;
        $this->timelines = $quotation->timelines;
        $this->warranty_clause = $quotation->warranty_clause;
        $project_id = $quotation->project_id;
        $customer_id = $quotation->customer_id;
        $project = Project::find($project_id);
        $this->project_name = $project->name;
        $this->description = $project->description;
        $this->address = $project->address;
//        dd($project->image);
        $this->project_image = $project->image;
//        $this->project_image = $project->image;
        $this->expected_start_date = $project->expected_start_date;
        $this->expected_end_date = $project->expected_end_date;
        $this->project_size = $project->project_size;
        $this->project_type = $project->project_type;

        $project_milestone = ProjectMilestone::where('project_id',$project_id)->get();
//        $this->milestone_list =$project_milestone;
        for($x = 0; $x < count($project_milestone); $x++)
        {
            $this->project_milestone[$x] = $project_milestone[$x]->name;
            $this->milestone_description[$x] = $project_milestone[$x]->description;
            if($x > 0)
            {
                $this->milestone_list[] = '';
            }
        }

        $quoteLineItems = QuoteLineItem::where('quotation_id',$id)->get();
        for($x = 0; $x < count($quoteLineItems); $x++)
        {
            $this->products[$x] = $quoteLineItems[$x]->product_id;
            $this->unit_price[$x] = $quoteLineItems[$x]->unit_price;
            $this->discount_price[$x] = $quoteLineItems[$x]->discount_price;
            $this->quantity[$x] = $quoteLineItems[$x]->quantity;
            $this->total_price[$x] = $quoteLineItems[$x]->total_price;
            if($x > 0)
            {
                $this->quoteItems[] = '';
            }
        }
    }
    public function render()
    {
        return view('livewire.quotation.add-quotation-modal');
    }
    public function hydrate()
    {
        $this->emit('data-change-event');
//        $this->emit('select2');
    }

    public function toFloatTwo($number){
        return (!empty($number) && is_numeric($number))? number_format((float)$number, 2, '.', ''):0;
    }

    public function toIntSimple($number){
        return (!empty($number) && is_numeric($number))? (int)$number:0;
    }

    public function updated($key, $value){
        $this->saved = FALSE;
//        dd($key);
        if($key == "projects")
        {
            $project_details = Project::find($value);
            if($project_details){
                $this->project_name = $project_details->name;
                $this->description = $project_details->description;
                $this->address = $project_details->address;
//                dd($project_details->image);
                $this->project_image = $project_details->image;
                $this->expected_start_date = $project_details->expected_start_date;
                $this->expected_end_date = $project_details->expected_end_date;
                $this->project_size = $project_details->project_size;
                $this->project_type = $project_details->project_type;
                $this->use_existing_project = true;
                $this->existing_project_id = $value;
            }
        }
        if($key == "quotationTemplateID"){
            $quotationTemplate = QuotationTemplate::find($this->quotationTemplateID);
            if($quotationTemplate)
            {
                $this->assembly_type = $quotationTemplate->assembly_type;
                $this->manufacturer = $quotationTemplate->manufacturer;
                $this->sq_walls = $quotationTemplate->sq_walls;
                $this->sq_field = $quotationTemplate->sq_field;
                $this->warranty = $quotationTemplate->warranty;
                $this->parapet_length = $quotationTemplate->parapet_length;
                $this->building_height = $quotationTemplate->building_height;
                $this->deck_type = $quotationTemplate->deck_type;
                $this->inclusions = $quotationTemplate->inclusions;
                $this->exclusions = $quotationTemplate->exclusions;
                $this->payment_schedule = $quotationTemplate->payment_schedule;
                $this->price_escalation_clause = $quotationTemplate->price_escalation_clause;
                $this->alterations = $quotationTemplate->alterations;
                $this->compliance = $quotationTemplate->compliance;
                $this->timelines = $quotationTemplate->timelines;
                $this->warranty_clause = $quotationTemplate->warranty_clause;
            }
            $quoteTemplateLineItems = QuoteTemplateLineItem::where('quotation_template_id',$this->quotationTemplateID)->get();
            for($x = 0; $x < count($quoteTemplateLineItems); $x++)
            {
                $this->products[$x] = $quoteTemplateLineItems[$x]->product_id;
                $this->unit_price[$x] = $quoteTemplateLineItems[$x]->unit_price;
                $this->discount_price[$x] = $quoteTemplateLineItems[$x]->discount_price;
                $this->quantity[$x] = $quoteTemplateLineItems[$x]->quantity;
                $this->total_price[$x] = $quoteTemplateLineItems[$x]->total_price;
                if($x > 0)
                {
                    $this->quoteItems[] = '';
                }
            }
        }
        $parts = explode(".",$key);
        if(count($parts) == 2 && $parts[0] == "products"){
            $product = $this->products_list->where('id', $value)->first();
            $this->unit_price[$parts[1]] = $product->price;
        }
        if(count($parts) == 2 && $parts[0] == "quantity"){
            if(isset($this->discount_price[$parts[1]]))
            {
                $this->total_price[$parts[1]] = $this->toFloatTwo($this->unit_price[$parts[1]]) * $this->toIntSimple($value) - $this->toFloatTwo($this->discount_price[$parts[1]]);
            }else{
                $this->total_price[$parts[1]] = $this->toFloatTwo($this->unit_price[$parts[1]]) * $this->toIntSimple($value);
            }
        }
        if(count($parts) == 2 && $parts[0] == "discount_price"){
            if(isset($this->quantity[$parts[1]]))
            {
                $this->total_price[$parts[1]] = $this->toFloatTwo($this->unit_price[$parts[1]]) * $this->toFloatTwo($this->quantity[$parts[1]]) - $this->toIntSimple($value);
            }
        }
    }
    public function submit(){
//        $this->validate($this->validationRules[4]);
//        dd($this->chatGPT_res);
          if ($this->edit_mode) {
//            $this->quotationID
              if($this->preview == false && $this->regenerate == false)
              {
                  $this->chatGPT_res = $this->getProposalChatGPT();
              }
              if($this->chatGPT_res){
                  if($this->use_existing_project == false)
                  {
                      $project_id = $this->addProject();
                  }else{
                      $project_id = $this->existing_project_id;
                  }
                  $this->addProjectMilestone($project_id);
                  $quotation_id = $this->addQuotation($project_id);
                  $this->addQuoteLineItems($quotation_id);
                  $this->generatePDF($this->chatGPT_res,$quotation_id);
                  $quote_history = Quotation::find($quotation_id);
                  $quote_history->parent_quotation = $this->quotationID;
                  $quote_history->save();
              }
            $this->emit('success', __('Quotation updated'));
        } else {
              if($this->preview == false && $this->regenerate == false)
              {
//                  dd("updated");
                  $this->chatGPT_res = $this->getProposalChatGPT();
              }
//              $this->chatGPT_res = $this->getProposalChatGPT();
              if($this->chatGPT_res){
                  $project_id = $this->addProject();
                  $this->addProjectMilestone($project_id);
                  $quotation_id = $this->addQuotation($project_id);
                  $this->addQuoteLineItems($quotation_id);
                  $this->generatePDF($this->chatGPT_res,$quotation_id);
              }
            // Emit a success event with a message
            $this->emit('success', __('New Quotation created'));
        }
//        $this->increaseStep();
    }
    public function addQuoteLineItems($quotation_id)
    {
        $quotation = Quotation::find($quotation_id);
        if($quotation){
            $project_milestone = ProjectMilestone::where('project_id',$quotation->project_id)->get();
        }
        $milestone_array = $project_milestone->toArray();
        for ($x = 0; $x < count($this->products); $x++) {
            $quoteLineItem_obj = new QuoteLineItem();
            $quoteLineItem_obj->product_id = $this->products[$x];
            $quoteLineItem_obj->unit_price = $this->unit_price[$x];
            $quoteLineItem_obj->discount_price = $this->discount_price ? $this->discount_price[$x] : 0;
            $quoteLineItem_obj->quantity = $this->quantity[$x];
            $quoteLineItem_obj->total_price = $this->total_price[$x];
            foreach ($milestone_array as $milestone)
            {
                if(isset($milestone) && $this->milestone_quote)
                {
                    if($milestone['name'] === $this->milestone_quote[$x])
                    {
                        $milestone_id = $milestone['id'];
                    }
                }
            }
            if(isset($milestone_id))
            {
                $quoteLineItem_obj->project_milestone_id = $milestone_id;
            }
            $quoteLineItem_obj->created_by =  Auth::user()->id;
            $quoteLineItem_obj->quotation_id = $quotation_id;
            $product = $this->products_list->where('id', $this->products[$x])->first();
            $product_name = $product->product_name;
            $this->quoteLineItemsData[] = array(
                "item_name" => $product_name,
                "unit_price" => $this->unit_price[$x],
                "discount_price" => $this->discount_price ? $this->discount_price[$x] : 0,
                "quantity" => $this->quantity[$x],
                "total_price" => $this->total_price[$x]
            );
            $quoteLineItem_obj->save();
            if($this->price_update && isset($this->price_update[$x]) && $this->price_update[$x] == true){
                    $product_history = new ProductPriceHistory();
                    $product_history->old_unit_price = $product->price;
                    $product_history->new_unit_price = $this->unit_price[$x];
                    $product_history->created_by = Auth::user()->id;
                    $product_history->product_id = $product->id;
                    $product_history->save();
            }
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
            $project_obj->address = $this->address;
            if($this->project_image && !empty($this->project_image))
            {
                if($this->project_image_changed)
                {
                    $project_obj->image = $this->project_image->store('uploads', 'public');
                }
            }
            $project_obj->created_by =  Auth::user()->id;
            $project_obj->expected_start_date =  $this->expected_start_date;
            $project_obj->expected_end_date =  $this->expected_end_date;
            $project_obj->project_size =  $this->project_size;
            $project_obj->project_type =  $this->project_type;
            $project_obj->manager_id =  Auth::user()->id;
            $project_obj->save();
            return $project_obj->id;
    }
    public function addProjectMilestone($project_id)
    {
        for ($x = 0; $x < count($this->project_milestone); $x++) {
            $pm_obj = new ProjectMilestone();
            $pm_obj->name = $this->project_milestone[$x];
            $pm_obj->description = $this->milestone_description ? $this->milestone_description[$x] : "";
            $pm_obj->created_by =  Auth::user()->id;
            $pm_obj->project_id = $project_id;
            $this->projectMilestoneArray[] = array(
                "milestone_name" => $this->project_milestone[$x],
                "milestone_description" => $this->milestone_description ? $this->milestone_description[$x] : "",
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
        $project_manager = User::find(Auth::user()->id);
        if(!empty($project_manager->id)){
            $projectData['project_manager'] =  $project_manager->name;
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
    public function getProposalChatGPT($prefix = "")
    {
        $this->isLoading = true;
        $chat =new ChatGPTController();
        $formData = $this->getQuotationString();
        $msg_data = '';
        if($this->regenerate == true)
        {
            $msg_data .= $prefix;
        }

        if(isset($adminAiPrompts['pre_data'])){
            $msg_data = $adminAiPrompts['pre_data'];

        } else{
            $msg_data = "I need you to work as an expert Construction Quotation Generator. You have the ability to analyze and create a Construction Project Proposal by using provided information. The complete project information of project is as follows:";
        }
        $msg_data .= "
            <--Project Details Start-->";
        $msg_data .= $formData['projectDetails'];
        $msg_data .= "
        <--Project Details End -->
        <--Quotation Details Start-->";
        $msg_data .= $formData['quotationDetails'];
        $msg_data .= "
        <--Quotation Details End-->
        <--Quote Line Items Start-->";
        $msg_data .= $formData['quoteLineItemsDetails'];
        $msg_data .= "
        <--Quote Line Items End-->
        ";

        if(isset($adminAiPrompts['post_data'])){
            $msg_data = $adminAiPrompts['post_data'];
        } else{
//            $msg_data .= "I need you to add details in points using above information and along with that, modify and include the specific information in headings as per mentioned sections:
//        Warranty, Inclusions, Payment Schedule, Compliance and Warranty Clause.
//        Moreover, also mention Risk Factors, Validity, Disclaimers and calculate Total Quotable Price using total price of all Quote Line Items.";
        }
        if(isset($adminAiPrompts['final_remarks'])){
            $msg_data = $adminAiPrompts['final_remarks'];
        } else{
            $msg_data .="check above details and give information with bold headings Validity, Risk Factors and Disclaimers.";
        }

        info($msg_data);

        $this->chatGPT_res = $chat->createPurposalChatGPT($msg_data);
//        sleep(2);
        $this->isLoading = false;
        return $this->chatGPT_res;
    }

    private function generatePDF($response,$quote_id)
    {
        $project_manager = User::find(Auth::user()->id);
        $company_name = $project_manager->companyProfile->name;
        $company_email = $project_manager->companyProfile->email;
        $company_address = $project_manager->companyProfile->address;
        $company_phone = $project_manager->companyProfile->phone;
        $company_website = $project_manager->companyProfile->website;
        $year_architect_shingles = $project_manager->companyProfile->year_architect_shingles;
        $mil_tpo = $project_manager->companyProfile->mil_tpo;
        $company_logo = $project_manager->companyProfile->logo;
        $quotation = Quotation::find($quote_id);
        $project_image = Project::find($quotation->project_id)->image;
        if(!empty($project_manager->id)){
            $project_manager_name =  $project_manager->name;
        } else {
            $project_manager_name =  "";
        }
        $milestone_array = [];
        $project_milestone = ProjectMilestone::where('project_id',$quotation->project_id)->get();
        foreach ($project_milestone as $milestone){
            $index = $milestone->id;
            $milestone_cost = QuoteLineItem::where('project_milestone_id', $index)->get();
            $total_cost = 0;
            foreach ($milestone_cost as $cost){
                $total_cost += $cost->total_price;
            }
            $milestone_array[]=[
                'milestone_name' => $milestone->name,
                'milestone_description' => $milestone->description,
                'milestone_cost' => $total_cost,
            ];
        }
        $data = [
            'project_name' => $this->project_name,
            'project_address' => $this->address,
            'project_image' => $project_image,
            'company_name' => $company_name,
            'company_email' => $company_email,
            'year_architect_shingles' => $year_architect_shingles,
            'mil_tpo' => $mil_tpo,
            'company_address' => $company_address,
            'company_phone' => $company_phone,
            'company_website' => $company_website,
            'company_logo' => $company_logo,
            'project_manager' => $project_manager_name,
            'prepared_date' => $this->prepared_date,
            'inclusion' => $this->inclusions,
            'exclusions' => $this->exclusions,
            'payment_schedule' => $this->payment_schedule,
            'price_escalation_clause' => $this->price_escalation_clause,
            'alterations' => $this->alterations,
            'compliance' => $this->compliance,
            'timeline' => $this->timelines,
            'warranty_clause' => $this->warranty_clause,
            'chatGPTResponse' => $response,
            'mileStoneData' => $milestone_array,
        ];
        try {
            $pdf = PDF::loadView('pdf-template.proposal',$data)->save("uploads/$quote_id.pdf",'public');
            if($pdf){
                return $pdf->download("uploads/$quote_id.pdf");
            }else{
                return false;
            }
            return $pdf->download();
            $filePath = asset('storage/docs.pdf');

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
    }
}
