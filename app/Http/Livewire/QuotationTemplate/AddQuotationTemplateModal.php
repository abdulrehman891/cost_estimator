<?php

namespace App\Http\Livewire\QuotationTemplate;

use App\Models\QuotationTemplate;
use App\Models\QuoteTemplateLineItem;
use App\Http\Controllers\Admin\AdminConfigController;
use App\Models\Product;
use Livewire\Component;
use Auth;
class AddQuotationTemplateModal extends Component
{
    public $currentStep;
    public $totalStep = 5;
    public $isLoading = false;
    public $quoteTemplateItems = [''];

    //List for Quotation Template Module
    // public $prepared_date;
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
    //End of Quotation Template Module Fields

    //Quote Template Line Items
    public $quote_template_line_items;
    public $formData;
    public $products = [];
    public $unit_price = [];
    public $quantity = [];
    public $discount_price = [];
    public $total_price = [];

    public $products_list;

    public $quoteTemplateLineItemsData = [];
    //end of Quote Template Line Module

    public $users_list;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'string',
        // 'prepared_date' => 'required',
        'project_size' => 'required'
    ];

    protected $listeners = [
        'delete_quotation_template' => 'deleteQuotationTemplate',
    ];

    public function deleteQuotationTemplate($id){
        QuotationTemplate::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Quotation Template successfully deleted');
    }

    public function increaseStep(){
        $this->currentStep++;
        if ($this->currentStep > $this->totalStep) {
            $this->currentStep = $this->totalStep;
        }
    }
    public function decreaseStep(){
        $this->currentStep--;
    }
    public function mount(){
        $this->currentStep = 1;
        $this->products_list =  Product::all();

        $adminConfController = new AdminConfigController();
        $adminPrompts = $adminConfController->getAllPrompts();
        $this->inclusions = isset($adminPrompts['inclusions']) ? $adminPrompts['inclusions'] : "";
        $this->exclusions = isset($adminPrompts['exclusions']) ? $adminPrompts['exclusions'] : "";
        $this->payment_schedule = isset($adminPrompts['payment_schedule']) ? $adminPrompts['payment_schedule'] : "";
        $this->price_escalation_clause = isset($adminPrompts['price_escalation']) ? $adminPrompts['price_escalation'] : "";
        $this->alterations = isset($adminPrompts['alterations']) ? $adminPrompts['alterations'] : "";
        $this->compliance = isset($adminPrompts['compliance']) ? $adminPrompts['compliance'] : "";
        $this->timelines = isset($adminPrompts['timelines']) ? $adminPrompts['timelines'] : "";
        $this->warranty_clause = isset($adminPrompts['warranty']) ? $adminPrompts['warranty'] : "";
    }
    public function addQuoteTemplateLine(){
        $this->quoteTemplateItems[] = '';
    }
    public function removeQuoteline($index){
        unset($this->quoteTemplateItems[$index]);
        $this->quoteTemplateItems = array_values($this->quoteTemplateItems);
    }
    public function render(){
        return view('livewire.quotation-template.add-quotation-template-modal');
    }
    public function hydrate(){
        $this->emit('select2');
    }

    public function toFloatTwo($number){
        return (!empty($number) && is_numeric($number)) ? number_format((float)$number, 2, '.', '') : 0;
    }

    public function toIntSimple($number){
        return (!empty($number) && is_numeric($number)) ? (int)$number : 0;
    }

    public function updated($key, $value){
        //        dd($key);
        $this->saved = FALSE;

        $parts = explode(".", $key);
        if (count($parts) == 2 && $parts[0] == "products") {
            $product = $this->products_list->where('id', $value)->first();
            $this->unit_price[$parts[1]] = $product->price;
        }
        if (count($parts) == 2 && $parts[0] == "quantity") {
            if ($this->discount_price) {
                $this->total_price[$parts[1]] = $this->toFloatTwo($this->unit_price[$parts[1]]) * $this->toIntSimple($value) - $this->toFloatTwo($this->discount_price[$parts[1]]);
            } else {
                $this->total_price[$parts[1]] = $this->toFloatTwo($this->unit_price[$parts[1]]) * $this->toIntSimple($value);
            }
        }
    }

    public function submit(){
        $quotation_id = $this->addQuotationTemplate();
        $this->addQuoteTemplateLineItems($quotation_id);
    }

    public  function addQuotationTemplate(){
        $quotation_obj = new QuotationTemplate();
        // $quotation_obj->prepared_date = $this->prepared_date;
        $quotation_obj->assembly_type = $this->assembly_type;
        $quotation_obj->manufacturer = $this->manufacturer;
        $quotation_obj->sq_walls = $this->sq_walls;
        $quotation_obj->sq_field = $this->sq_field;
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
        $quotation_obj->warranty_clause = $this->warranty_clause;
        $quotation_obj->created_by =  Auth::user()->id;
        $quotation_obj->save();
        return $quotation_obj->id;
    }


    public function addQuoteTemplateLineItems($quotation_id){
        for ($x = 0; $x < count($this->products); $x++) {
            $quoteLineItem_obj = new QuoteTemplateLineItem();
            $quoteLineItem_obj->product_id = $this->products[$x];
            $quoteLineItem_obj->unit_price = $this->unit_price[$x];
            $quoteLineItem_obj->discount_price = $this->discount_price[$x];
            $quoteLineItem_obj->quantity = $this->quantity[$x];
            $quoteLineItem_obj->total_price = $this->total_price[$x];
            $quoteLineItem_obj->created_by =  Auth::user()->id;
            $quoteLineItem_obj->quotation_template_id = $quotation_id;
            $product = $this->products_list->where('id', $this->products[$x])->first();
            $product_name = $product->product_name;
            $this->quoteTemplateLineItemsData[] = array(
                "item_name" => $product_name,
                "unit_price" => $this->unit_price[$x],
                "discount_price" => $this->discount_price[$x],
                "quantity" => $this->quantity[$x],
                "total_price" => $this->total_price[$x]
            );
            $quoteLineItem_obj->save();
        }
    }
}
