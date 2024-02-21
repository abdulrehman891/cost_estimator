<?php

namespace App\Http\Livewire\SubCategory;

use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Auth;

class AddSubcategoryModal extends Component
{
    public $sub_category_name;

    public $description;
    public $product_category;
    public $edit_mode = false;
    public $categories = array();

    public $company;

    protected $rules = [
        'sub_category_name' => 'required|string',
        'product_category' => 'required|string',
    ];

    protected $listeners = [
        'delete_sub_category' => 'deleteSubCategory',
        'update_sub_category' => 'updateSubCategory',
    ];
    public function render()
    {
        return view('livewire.sub-category.add-subcategory-modal');
    }

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data['name'] = $this->sub_category_name;
            $data['description'] = $this->description;
            $data['product_category_id'] = $this->product_category;
            $data['created_by'] =  Auth::user()->id;
            // Create a new sub category record in the database
            ProductSubCategory::updateOrCreate($data);

            if ($this->edit_mode) {
                // Assign selected role for user
                $this->emit('success', __('User updated'));
            } else {
                // Emit a success event with a message
                $this->emit('success', __('New Sub-Category created'));
            }
        });
        // Reset the form fields after successful submission
        $this->reset();
    }


    public function deleteSubCategory($id)
    {
        ProductSubCategory::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Sub Category successfully deleted');
    }
    public function updateSubCategory($id)
    {
        $this->edit_mode = true;
        $productSubCategory = ProductSubCategory::find($id);
        $this->product_category = $productSubCategory->product_category_id;
        $this->categories = ProductCategory::all();
        $this->sub_category_name = $productSubCategory->name;
        $this->description = $productSubCategory->description;
    }
    public function hydrate()
    {
        $this->emit('data-change-event');
    }
    public function mount(){
        $this->categories = ProductCategory::all();
    }


}
