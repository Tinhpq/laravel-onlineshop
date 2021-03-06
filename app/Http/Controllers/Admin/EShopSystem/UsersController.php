<?php

namespace App\Http\Controllers\Admin\EShopSystem;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->pushCriteria(new UsersWithRoles())->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->user->create($request->all());

        if ($request->get('role'))
        {
            $user->roles()->sync($request->get('role'));
        }
        else
        {
            $user->roles()->sync([]);
        }

        Flash::success('User successfully created');

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
    public function edit($id)
    {
        $user      = $this->user->find($id);
        $roles     = $this->role->all();
        $userRoles = $user->roles();
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->user->find($id);

        $user->email = $request->get('email');
        if ($request->get('password'))
        {
            $user->password = $request->get('password');
        }
        $user->save();

        if ($request->get('role'))
        {
            $user->roles()->sync($request->get('role'));
        }
        else
        {
            $user->roles()->sync([]);
        }

        Flash::success('User successfully updated');

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->delete($id);

        Flash::success('User successfully deleted');

        return redirect('/users');
    }
}
