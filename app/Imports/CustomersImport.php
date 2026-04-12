<?php

namespace App\Imports;

use App\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new Customer([
            "name" => $row['nombre'],
            "email" => $row['email'],
            "phone" => $row['telefono'],
            "address" => $row['direccion'],
            "PorcentajeDescuento" => 0.0,
        ]);
    }
}
