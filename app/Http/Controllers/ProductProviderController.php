<?php

namespace App\Http\Controllers;

use App\ProductProvider;
use App\ProductProviderLine;
use Illuminate\Http\Request;


class ProductProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->authorize('create', ProductProvider::class);

        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');



        $productproviders = ProductProvider::search($search);

       
        $productproviders = $productproviders->latest()->paginate(20);


        return view('productProviders.index', compact('productproviders', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', ProductProvider::class);

        return view('productProviders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate(request(), [
        //     'cliente' => 'required',
        //     'factura_proveedor' => ['nullable', new UniquePurchase(request('provider_id'))],

        // ]);
        $data = $request->all();
        $data['created_by'] = auth()->id();
        
        $productprovider = ProductProvider::create($data);

        $productprovider = $productprovider->saveLines($data['lines']);

        

      
        return $productprovider;

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductProvider $productprovider)
    {
       // $this->authorize('update', $productProvider);
      
        $productprovider->load('lines');

       

        if (request()->wantsJson()) {
            return response($productprovider, 200);
        }


        return view('productProviders.edit', [
            'productprovider' => $productprovider
            
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductProvider $productprovider)
    {
        //$this->authorize('update', $productProvider);

        // $this->validate(request(), [
        //     'cliente' => 'required',
        //     'factura_proveedor' => ['nullable', new UniquePurchase(request('provider_id'), $purchase->id)],

        // ]);

        $productprovider->fill(request()->all());
        $productprovider->lines()->delete();
        $productprovider->save();

        
        $productprovider = $productprovider->saveLines(request('lines'));

       


        return $productprovider;
    }

   

    public function destroy(ProductProvider $productprovider)
    {
       // $this->authorize('update', $productProvider);
     
        $productprovider->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/productproviders');
    }


   
}
