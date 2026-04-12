<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductBarcodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function print(Product $product)
    {
        $products = collect([$product]);
       
        return view('products.barcodesprint', compact('products'));
    }

    public function printLote()
    {
        $productIds = Str::of(request('barcodes'))->explode(',');
        
        $products = Product::whereIn('id',$productIds)->get();

        return view('products.barcodesprint', compact('products'));
    }
}
