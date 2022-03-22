<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Role_User;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Facades\Redirect;


class RolesController extends Controller
{

    // if user is not identified, he will be redirected to the login page
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
        try
        {
            //
            $roles = Role::orderBy('rolename', 'asc')->get();
            return view('roles.index')->with('roles', $roles);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E144: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try
        {
        return view('roles.create');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E145: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
        //
        $this->validate($request, [
            //Rules to validate
                'rolename' => 'required'
            ]);
            
            // Add a role
            $role = new  Role;
            $role->rolename = strtoupper($request->input('rolename'));
            $role->save();

            return redirect('/roles')->with('success', 'M054: role created');
            }
            catch (Exception $e) {
                return Redirect::back()->withError('E146: ' . $e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
        //
        $role = Role::find($id);
        return view('roles.edit')->with('role', $role);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E148: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
        //
        $this->validate($request, [
            //Rules to validate
                'rolename' => 'required'
            ]);
            
        // Add a role
        $role = Role::find($id);
        $role->rolename = $request->input('rolename');
        $role->save();

        return redirect('/roles')->with('success', 'M055: role updated');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E149: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        try
        {
        //Checking if the role to delete is used 
        $roleUser = Role_User::where('role_id', $id)->first();
        $role = Role::find($id);
        if($roleUser == null)
        {
            $role->delete();
            return redirect('/roles')->with('success', 'M056: Role deleted');
        }
        else{
            return Redirect::back()->withError('E150: Please update or delete users using this role first before delete the role ' . $role->rolename);
        }
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E151: ' . $e->getMessage());
        }
    }
}
