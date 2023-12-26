<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\DataTables\ProductsDataTable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductsDataTable $productdataTable)
    {
        return $productdataTable->render('pages/apps.product.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'created_by' => 'required|string',
        ]);
        $validatedData['sku'] = $request->sku;
        $validatedData['product_subcategory_id'] = $request->product_subcategory_id;
        $validatedData['product_category_id'] = $request->product_category_id;
        $validatedData['stock_quantity'] = $request->stock_quantity;
        $validatedData['color'] = $request->color;
        $validatedData['material'] = $request->material;
        $validatedData['height'] = $request->height;
        $validatedData['width'] = $request->width;
        $validatedData['length'] = $request->length;
        $validatedData['weight'] = $request->weight;
        $validatedData['description'] = $request->description;
        $product = Product::create($validatedData);
        return $this->sendResponse('Product Created successfully.', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $product)
    {
        //
        $product = Product::with('user','product_category','product_subcategory')->find($product->id);
        return view('pages/apps.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
