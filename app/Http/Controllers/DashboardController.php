<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {

//        if (Storage::disk('public')->exists('/uploads/docs_2.pdf')) {
//            $filePath = Storage::disk('public')->path('uploads/docs_2.pdf');dd($filePath);
//            return response()->download($filePath, 'asimocs_2.pdf');
//        } else {
//            abort(404, 'File not found');
//        }
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages/dashboards.index');
    }
}
