<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use App\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct(CustomerRepository $customerRepo)
    {
        $this->middleware('auth');
        $this->customerRepo = $customerRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     

        $search['q'] = request('q');

        if (request('q')) {
            $customers = Customer::search(request('q'))->orderBy('id')->paginate(10);
        } else {
            $customers = Customer::orderBy('id')->paginate(10);
        }

        if (request()->wantsJson()) {
            return response($customers, 200);
        }

        
        return view('customers.index', compact('customers', 'search'));
    }

    public function export()
    {
        return \Excel::download(new CustomersExport, 'Clientes.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Customer::class);

        return view('customers.create');
    }

    public function import(Request $request){
        $file = $request->file('archivo');
        \Excel::import(new CustomersImport, $file);
        return redirect('/customers');
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
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email',
        //     'phone' => 'required',
        //     'address' => 'required',
        //     'PorcentajeDescuento' => 'numeric',
        // ]);

        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required',
            'address' => 'required',
            'PorcentajeDescuento' => 'numeric',
        ]);

        $v->sometimes('tipo_identificacion', 'required', function ($input) {
            return $input->identificacion != '';
        });

        $v->sometimes('identificacion', 'required|numeric', function ($input) {
            return $input->tipo_identificacion != '';
        });

        $v->sometimes('identificacion', 'digits:9', function ($input) {
            return $input->tipo_identificacion == '01';
        });

        $v->sometimes('identificacion', 'digits:10', function ($input) {
            return $input->tipo_identificacion == '02' || $input->tipo_identificacion == '04';
        });

        $v->sometimes('identificacion', 'digits_between:11,12', function ($input) {
            return $input->tipo_identificacion == '03';
        });
        
        $v->validate();

        $data = request()->all();

        $customer = $this->customerRepo->store($data);

        flash('Cliente creado', 'success');

        return redirect('/customers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        if (request()->wantsJson()) {
            return response($customer, 200);
        }

        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        // $this->validate($request, [
        //     'name' => 'required|string|max:255',
        //     'email' => ['required', 'email'],
        //     'phone' => 'required',
        //     'address' => 'required',
        //     'PorcentajeDescuento' => 'numeric',
        // ]);
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required',
            'address' => 'required',
            'PorcentajeDescuento' => 'numeric',
        ]);

        $v->sometimes('tipo_identificacion', 'required', function ($input) {
            return $input->identificacion != '';
        });

        $v->sometimes('identificacion', 'required|numeric', function ($input) {
            return $input->tipo_identificacion != '';
        });

        $v->sometimes('identificacion', 'digits:9', function ($input) {
            return $input->tipo_identificacion == '01';
        });

        $v->sometimes('identificacion', 'digits:10', function ($input) {
            return $input->tipo_identificacion == '02' || $input->tipo_identificacion == '04';
        });

        $v->sometimes('identificacion', 'digits_between:11,12', function ($input) {
            return $input->tipo_identificacion == '03';
        });

        $v->validate();

        $customer = $this->customerRepo->update($customer, $request->all());

        flash('Cliente actualizado', 'success');

        return Redirect('/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('update', $customer);
        
        $customer->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/customers');
    }
}
