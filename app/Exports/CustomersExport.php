<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings() : array
    {
        return [
            'Nombre',
            'Email',
            'Telefono',
            'Dirección',
        ];
    }

    public function columnFormats() : array
    {
        return [
            'A' => '@',
            'B' => '@',
        ];
    }
    public function collection()
    {
        return Customer::select('name','email','phone','address')->get();
    }
}
