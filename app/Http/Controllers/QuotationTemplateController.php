<?php
namespace App\Http\Controllers;
use App\DataTables\QuotationTemplatesDataTable;
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
}
