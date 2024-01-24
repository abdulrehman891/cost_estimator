<?php

namespace App\Http\Controllers;

use App\DataTables\QuotationsDataTable;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(QuotationsDataTable $quotationDataTable)
    {
        //
        return $quotationDataTable->render('pages/apps.quotation.list');
    }

    public function downloadProposal(Request $quoation_id)
    {
        if (Storage::disk('public')->exists("/uploads/$quoation_id->id.pdf")) {
            $filePath = Storage::disk('public')->path("/uploads/$quoation_id->id.pdf");
            return response()->download($filePath, 'construction_proposal.pdf');
        } else {
            abort(404, 'File not found');
        }
    }

    public function sendProposal(Request $quotation_id)
    {
        dd($quotation_id);
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
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
