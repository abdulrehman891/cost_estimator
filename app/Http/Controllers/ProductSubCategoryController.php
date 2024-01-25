<?php

namespace App\Http\Controllers;

use App\DataTables\ProductSubCategoriesDataTable;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
class ProductSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductSubCategoriesDataTable $productSubCategoriesDataTable)
    {
        //
        return $productSubCategoriesDataTable->render('pages/apps.sub-category.list');
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

    /**
     * Display the specified resource.
     */
    public function show(Request $productSubCategory)
    {
        //
        $user = auth()->user();
        if($user->can('view subcategories')){
            $productSubCategory = ProductSubCategory::with('user','product_category')->find($productSubCategory->id);
            return view('pages/apps.sub-category.show', compact('productSubCategory'));
        } else {
            return Redirect::to('dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSubCategory $productSubCategory)
    {
        //
    }
}
