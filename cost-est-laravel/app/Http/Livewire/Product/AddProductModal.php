<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Auth;

class AddProductModal extends Component
{
    public $product_name;
    public $sku;
    public $created_by;
    public $description;
    public $price;
    public $stock_quantity;
    public $weight;
    public $width;
    public $length;
    public $height;
    public $color;
    public $material;
    public $category_name;
    public $sub_category;

    public $subcategories;
    public $selectedCategory;




    protected $rules = [
        'product_name' => 'required|string',
        'sku' => 'required|email',
        'created_by' => 'required|string',
        'description' => 'string',
    ];
    public function render()
    {
        return view('livewire.product.add-product-modal',['categories' => ProductCategory::all()]);
    }
    public function mount()
    {
        $this->subcategories = collect();
    }

    public function updatedSelectedCategory($value)
    {
        $this->subcategories = ProductSubCategory::where('product_category_id', $value)->get();
    }

    public function submit()
    {

        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data['product_name'] = $this->product_name;
            $data['sku'] = $this->sku;
            $data['created_by'] = Auth::user()->id;
            $data['description'] = $this->description;
            $data['price'] = $this->price;
            $data['weight'] = $this->weight;
            $data['length'] = $this->length;
            $data['width'] = $this->width;
            $data['height'] = $this->height;
            $data['material'] = $this->material;
            $data['color'] = $this->description;
            $data['stock_quantity'] = $this->stock_quantity;
            $data['product_category_id'] = $this->selectedCategory;
            $data['product_subcategory_id'] = $this->sub_category;
            // Create a new user record in the database
            Product::updateOrCreate($data);


//            if ($this->edit_mode) {
//                // Assign selected role for user
//                $this->emit('success', __('User updated'));
//            } else {
//
//
//                // Emit a success event with a message
//                $this->emit('success', __('New user created'));
//            }
        });

        // Reset the form fields after successful submission
//        $this->reset();
    }
}
