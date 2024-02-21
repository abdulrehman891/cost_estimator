<?php

namespace App\Http\Livewire\Category;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Category;


class AddCategoryModal extends Component
{
    public $category_id;
    public $name;
    public $description;
    public $edit_mode = false;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'string',
    ];
    protected $listeners = [
        'delete_category' => 'deleteCategory',
        'update_category' => 'updateCategory',
    ];

    public function render()
    {
        return view('livewire.category.add-category-modal');
    }

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            // Prepare the data for creating a new category
            $data['name'] = $this->name;
            $data['description'] = $this->description;
            $data['created_by'] =  Auth::user()->id;
            // Create a new category record in the database
            if($this->category_id){
                $category = ProductCategory::where('id', $this->category_id)->first();
                $category->update($data);
            }else{
                ProductCategory::create($data);
            }
            if ($this->edit_mode) {
                $this->emit('success', __('Category updated'));
            } else {
                // Emit a success event with a message
                $this->emit('success', __('New category created'));
            }
        });
        // Reset the form fields after successful submission
        $this->reset();
    }

    public function deleteCategory($id)
    {
        ProductCategory::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Category successfully deleted');
    }

    public function updateCategory($id)
    {
        $this->edit_mode = true;
        $productCategory = ProductCategory::find($id);
        $this->category_id = $productCategory->id;
        $this->name = $productCategory->name;
        $this->description = $productCategory->description;
    }
}
