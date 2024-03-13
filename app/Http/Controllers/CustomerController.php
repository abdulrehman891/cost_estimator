<?php

namespace App\Http\Controllers;

use App\DataTables\CustomersDataTable;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomersDataTable $customersDataTable)
    {
        //
        $user = auth()->user();
        if($user->can('view customers')){
            return $customersDataTable->with('current_logged',$user->id)->render('pages/apps.customer.list');
        } else {
            return Redirect::to('dashboard');
        }

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
    public function show(Request $customer)
    {
        $user = auth()->user();
        if($user->can('view customers')){
            $customer = Customer::find($customer->id);
            return view('pages/apps.customer.show', compact('customer'));
        } else {
            return Redirect::to('dashboard');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
