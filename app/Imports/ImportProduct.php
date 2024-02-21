<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProduct implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([

            'id' => $row['id'],
            'product_name' => $row['product_name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'weight' => $row['weight'],
            'length' => $row['length'],
            'width' => $row['width'],
            'height' => $row['height'],
            'material' => $row['material'],
            'color' => $row['color'],
            'stock_quantity' => $row['stock_quantity'],
            'product_category_id' => $row['product_category_id'],
            'product_subcategory_id' => $row['product_subcategory_id'],
            'created_by' => $row['created_by'],
            'sku' => $row['sku'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'deleted_at' => $row['deleted_at'],
        ]);
    }
}
