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
    public $product_category_id = null;

    public $product_category;

    public $edit_mode = false;


    public $company;
    protected $listeners = [
        'selectedCompanyItem',
        'delete_sub_category' => 'deleteSubCategory',
        'update_sub_category' => 'updateSubCategory',
    ];

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
        $this->product_category_id = $productSubCategory->product_category_id;
        $this->sub_category_name = $productSubCategory->name;
        $this->description = $productSubCategory->description;
    }
    public function hydrate()
    {
        $this->emit('select2');
    }
    //.......
    public function selectedCategoryItem($item)
    {
        if ($item) {
            $this->product_category = ProductCategory::all();
            $this->emit('selectedCompanyId', $this->product_category->id);
        }
        else
            $this->company = null;
    }


    public function render()
    {
        return view('livewire.sub-category.add-subcategory-modal',['categories' => ProductCategory::all()]);
    }

    public function submit()
    {
        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data['name'] = $this->sub_category_name;
            $data['description'] = $this->description;
            $data['product_category_id'] = $this->product_category_id;
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
}
