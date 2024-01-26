<?php

namespace App\Http\Controllers;

use App\DataTables\QuotationsDataTable;
use App\Models\Quotation;
use App\Models\Customer;
use App\Models\User;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\JLSignnowHelpersController;
use Illuminate\Support\Facades\Redirect;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(QuotationsDataTable $quotationDataTable)
    {
        $user = auth()->user();
        if ($user->can('view quotations')) {
            return $quotationDataTable->render('pages/apps.quotation.list');
        } else {
            return Redirect::to('dashboard');
        }
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

    public function sendProposal($quotation_id)
    {
        // session()->flash('message', 'Post successfully updated.');
        // return redirect()->route('quotation.list')->with('success', 'your message,here');

        //send the quotation to the selected customer
        $quotation_id = urldecode($quotation_id);
        $quote_data = Quotation::with('project')->find($quotation_id);

        $manager_id = (!empty($quote_data->project->manager_id)) ? $quote_data->project->manager_id : 1;
        $manager_details = User::select('name')->find($manager_id);
        $manager_company_details = CompanyProfile::where('user_id', '=', $manager_id)->first();
        $customer_details = Customer::find($quote_data->customer_id);

        //echo "<pre>";
        // print_r($customer_details);
        // print_r($quote_data->project);
        // print_r($manager_details['name']);
        // print_r($quote_data);
        // print_r($manager_company_details->email);
        // die;

        $manager_email = auth()->user()->email;
        $manager_email = "testmanager44@mailinator.com";

        $cont = new JLSignnowHelpersController($manager_company_details->email);
        $request_data = array(
            'sign_doc_name' => $cont->doc_name_pre . $quote_data->project->name,
            'send_to_email' => $customer_details->email,
            'manager_email' => $manager_email,
            'fields' => array(
                //preject related data
                'client_project_name' => $quote_data->project->name,
                'client_project_start_date' => $quote_data->project->expected_start_date,
                'client_project_end_date' => $quote_data->project->expected_end_date,
                'client_project_type' => $quote_data->project->project_type,
                'company_project_manager' => $manager_details['name'],
                //client related data
                "client_name" => $customer_details->name,
                "client_name_company_name" => $customer_details->name . "," . $customer_details->company_name,
                "client_address_phone" => $customer_details->company_address . "," . $customer_details->phone_number,
                //company related data for the sender
                "company_name_address" => $manager_company_details->name . ',' . $manager_company_details->address,
                "company_phone_email" => $manager_company_details->phone . ",wequote@gmail.com",
            )
        );

        $myRequest = new \Illuminate\Http\Request();
        $myRequest->setMethod('POST');
        $myRequest->merge($request_data);
        $send_doc_response = $cont->sendSignNowDocumenttoSign($myRequest);
        if ($send_doc_response->getData()->status == true) {
            echo $send_doc_response->getData()->msg;
            //save the document details
            //signnow_document_id
            $updated_data = array(
                'signnow_document_id' => $send_doc_response->getData()->documentUniqueId,
                'status' => 'Pending_Manager_Signature'
            );
            $quote_data->update($updated_data);
        } else {
            echo "Failed to send document";
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
