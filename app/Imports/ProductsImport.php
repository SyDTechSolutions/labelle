<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            "provider_id" => $row['provider_id'],
            "code" => $row['code'],
            "name" => $row['name'],
            "quantity" => $row['quantity'],
            "subquantity" => $row['subquantity'],
            "price" => $row['price'],
            "pricewithtaxes" => $row['pricewithtaxes'],
            "measure" => $row['measure'],
        ]);
    }
}
