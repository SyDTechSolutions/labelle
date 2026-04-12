<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Product;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProductsExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    public function __construct($min = null)
    {
        $this->min = $min;
    }

    public function headings() : array
    {
        return [
            'Código Prov.',
            'Código',
            'Nombre',
            'Precio',
            'Precio IV',
            'Medida',
            'Existencia',
            'Mínimo',
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

        $products = Product::select('provider_id','code', 'name', 'price', 'priceWithTaxes','measure', 'quantity', 'min')->get();

        if($this->min){
            
            $products = $products->filter(function ($item, $key) {

                return $item->quantity <= $item->min;
            });

        }
        
       
        return $products;
        
    }
}