<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProviderRepository;
use App\Provider;

class ProviderController extends Controller
{
    public function __construct(ProviderRepository $providerRepo)
    {
        $this->middleware('auth');
        $this->providerRepo = $providerRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index');

        $search['q'] = request('q');

        if (request('q')) {
            $providers = Provider::search(request('q'))->latest()->paginate(10);
        } else {
            $providers = Provider::latest()->paginate(10);
        }

         if (request()->wantsJson()) {
            return response($providers, 200);
        }

        return view('providers.index', compact('providers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create');

        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required',
            'address' => 'nullable',
            'dni'=>'required|string|max:15',
            'provincia'=>'required|string|max:4',
            'canton'=>'required|string|max:4',
            'description'=> 'required|string'
        ]);

        $data = request()->all();

        $provider = $this->providerRepo->store($data);

        flash('Proveedor creado', 'success');

        return redirect('/providers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        $this->authorize('update', $provider);

        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $provider)
    {
        $this->authorize('update', $provider);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required',
            'address' => 'nullable',
            'dni'=>'required|string|max:15',
            'provincia'=>'required|string|max:4',
            'canton'=>'required|string|max:4',
            'description'=> 'required|string'
        ]);

        $provider = $this->providerRepo->update($provider, $request->all());

        flash('Proveedor actualizado', 'success');

        return Redirect('/providers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $this->authorize('update', $provider);

        $provider->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/providers');
    }
}
