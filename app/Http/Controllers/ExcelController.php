<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportProduct;
use App\Exports\ExportProduct;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function exportProducts()
    {
        return Excel::download(new ExportProduct, 'products.xlsx');
    }


    public function importProducts(Request $request)
    {
        // Excel::import(new ImportUser, $request->file('file')->store('files'));
        // return redirect()->back();


        $file = $request->file('file');
        if ($file == true) {
            Excel::import(new ImportProduct, $file);
            return redirect()->back();
        }
    }
}
