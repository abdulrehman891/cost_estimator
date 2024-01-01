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
    public $categories;
    public $product_id;
    public $category_id;
    public $edit_mode;

    //delete_product
    protected $listeners = [
        'delete_product' => 'deleteProduct',
        'update_product' => 'updateProduct',
        'category_value_change' => 'changeCategory'
    ];

    protected $rules = [
        'product_name' => 'required|string',
        'sku' => 'required|email',
        'created_by' => 'required|string',
        'description' => 'string',
    ];
    public function render()
    {
        return view('livewire.product.add-product-modal');
    }
    public function mount()
    {
        $this->subcategories = collect();
        $this->categories = ProductCategory::all();
    }

    public function hydrate()
    {
//        dump("hyderated");
        $this->emit('data-change-event');
    }

    public function changeCategory($value)
    {
        $sub_category = ProductSubCategory::where('product_category_id', $value)->get();
        if($sub_category)
        {
            $this->subcategories = $sub_category;
        }else{

        }
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
            $data['color'] = $this->color;
            $data['stock_quantity'] = $this->stock_quantity;
            $data['product_category_id'] = $this->category_id;
            $data['product_subcategory_id'] = $this->sub_category;
            // Create a new user record in the database
            if($this->product_id){
                $product = Product::where('id', $this->product_id)->first();
                $product->update($data);
            }else{
                Product::create($data);
            }

            if ($this->edit_mode) {
                // Assign selected role for user
                $this->emit('success', __('User updated'));
            } else {
                // Emit a success event with a message
                $this->emit('success', __('New product created'));
            }
            $this->reset();
        });

        // Reset the form fields after successful submission
        $this->reset();
    }
    public function updateProduct($id){
        $this->edit_mode = true;
        $product = Product::find($id);
        $this->product_id = $product->id;
        $this->product_name = $product->product_name;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->weight = $product->weight;
        $this->length = $product->length;
        $this->width = $product->width;
        $this->height = $product->height;
        $this->material = $product->material;
        $this->color = $product->material;
        $this->stock_quantity = $product->stock_quantity;
//        $this->selectedCategory;
//        $this->sub_category;

    }

    public function deleteProduct($id){
        Product::destroy($id);
        // Emit a success event with a message
        $this->emit('success', 'Product successfully deleted');
    }
}
