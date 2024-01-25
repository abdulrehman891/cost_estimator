<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductPriceHistory;
use App\DataTables\ProductPriceHistoryDataTable;
use Illuminate\Support\Facades\Redirect;

class ProductPriceHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductPriceHistoryDataTable $productPriceHistoryDataTable)
    {
        //
        return $productPriceHistoryDataTable->render('pages/apps.product-price-history.list');
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
    }


    public function store_manual(Request $request)
    {
        $validatedData = $request->validate([
            'new_unit_price' => 'required|string',
            'old_unit_price' => 'string',
            'product_id'=>'required|string'
        ]);
        $validatedData['created_by'] = auth()->id();
        $productPriceHistory = ProductPriceHistory::create($validatedData);
        return json_encode(array("success"=> true, "message" => 'Product Price History Record created successfully.', "data"=>$productPriceHistory));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $productPriceHistory)
    {
        //
        $productPriceHistory = ProductPriceHistory::with('user','product')->find($productPriceHistory->id);
        return view('livewire/apps.product-price-history.show', compact('productPriceHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductPriceHistory $productPriceHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductPriceHistory $productPriceHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductPriceHistory $productPriceHistory)
    {
        //
    }


    /**
     * Remove the specified resource from storage manually.
     */
    public function destroy_manual(Request $request, ProductPriceHistory $productPriceHistory)
    {
        if($request->has('id')){
            $productPriceHistory = ProductPriceHistory::with('product')->find($request->id);
        } else {
            $productPriceHistory = (object) array();
        }

        if (!isset($productPriceHistory->id)) {
            return $this->sendError('Product Price History not found', $request->toArray(), 400);
        }
        $productPriceHistory->delete();
        return $this->sendResponse('Product Price History Record deleted successfully.', $productPriceHistory);
    }

}
