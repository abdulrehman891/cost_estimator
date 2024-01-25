<?php

namespace App\Http\Controllers;

use App\DataTables\ProductCategoriesDataTable;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductCategoriesDataTable $categoriesDataTable)
    {
        //
        return $categoriesDataTable->render('pages/apps.category.list');
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
    public function show(Request $productCategory)
    {
        //
        $user = auth()->user();
        if($user->can('view categories')){
            $productCategory = ProductCategory::with('user')->find($productCategory->id);
            return view('pages/apps.category.show', compact('productCategory'));
        } else {
            return Redirect::to('dashboard');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }
}
