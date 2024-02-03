<?php
namespace App\Http\Controllers;
use App\DataTables\QuotationTemplatesDataTable;
use App\Models\QuotationTemplate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class QuotationTemplateController extends Controller
{
    public function index(QuotationTemplatesDataTable $quotationDataTable)
    {
        $user = auth()->user();
        // if ($user->can('view quotation templates')) {
            return $quotationDataTable->render('pages/apps.quotation-template.list');
        // } else {
        //     return Redirect::to('dashboard');
        // }
    }
    public function show(Request $quotation_template)
    {
//        $user = auth()->user();
//        if($user->can('view quotation templates')){
            $quotation_template = QuotationTemplate::with('user')->find($quotation_template->id);
            return view('pages/apps.quotation-template.show',compact('quotation_template'));

//        } else {
//            return Redirect::to('dashboard');
//        }
    }
}
