<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Repositories\UserRepository;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('update', auth()->user());

        $search['q'] = request('q');

        if (request('q')) {
            $users = User::search(request('q'))->with('roles')->paginate(10);
        } else {
            $users = User::with('roles')->paginate(10);
        }

        return view('users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('update', auth()->user());

        return view('users.create');
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
            'dni' => 'nullable|string|unique:users|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required',
            'commission' => 'nullable|numeric',
        ]);

        $data = request()->all();

        if(!$request->commission){
            $data['commission'] = 0;
        }

        $data['role'] = Role::where('id', $data['role'])->first();

        $user = $this->userRepo->store($data);

        flash('Usuario creado', 'success');

        return redirect('/users');
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
    public function edit(User $user)
    {
        $this->authorize('update', auth()->user());

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', auth()->user());

        $data = $this->validate($request, [
            'dni' => ['nullable', 'string', Rule::unique('users')->ignore($user->id), 'max:255'],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required',
            'commission' => 'nullable|numeric',
        ]);

        $data = request()->all();

        if(!$request->commission){
            $data['commission'] = 0;
        }

        

        $user = $this->userRepo->update($user, $data);

        flash('Usuario actualizado', 'success');

        return Redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('update', auth()->user());

        $user->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/users');
    }
}
