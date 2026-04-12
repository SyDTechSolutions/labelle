<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proforma;

class CajasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
        $search['created_by'] = request('created_by');



        $proformas = Proforma::search($search)->latest()->paginate(10);

        return view('caja.index', compact('proformas', 'search'));
    }
    
    public function destroy(Proforma $proforma)
    {
       
        $this->authorize('update', $proforma);

        $proforma->lines->each->delete();
        $proforma->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }
        return Redirect('/caja');
    }
}
