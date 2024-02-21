<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportProduct implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
     *
     *
    */

    public function headings(): array
    {
        return [
            'ID',
            'PRODUCT NAME',
            'DESCRIPTION',
            'PRICE',
            'WEIGHT',
            'LENGTH',
            'WIDTH',
            'HEIGHT',
            'MATERIAL',
            'COLOR',
            'STOCK QUANTITY',
            'PRODUCT CATEGORY ID',
            'PRODUCT SUBCATEGORY ID',
            'CREATED BY',
            'SKU',
            'CREATED AT',
            'UPDATED AT',
            'DELETED AT',

        ];
    }
    public function collection()
    {
        return Product::all();
    }
}
