<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\KeyValue;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

class KeyValuesController extends Controller
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
        $keyvalues = KeyValue::orderBy('key', 'asc')->get();
        return view('keyvalues.index')->with('keyvalues', $keyvalues);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E210: ' . $e->getMessage());
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
        //
        return view('keyvalues.create');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E211: ' . $e->getMessage());
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
                'key' => 'required'
            ]);
            
            // Add a keyvalue
            $key = strtoupper($request->input('key'));

            $keyvalue = KeyValue::where('key', $key)->first();
        
            if($keyvalue == null)
            {
                $keyvalue = new KeyValue;
                $keyvalue->key = $key;
                $keyvalue->value = $request->input('value');
                $keyvalue->save();    
                return redirect('/keyvalue')->with('success', 'M057: A keyvalue has been created');
            }
            else
            {
                return Redirect::back()->withError('E246: Please try a new key, ' . $key .' exists already.');
            }
            

            
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E212: ' . $e->getMessage());
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
        $keyvalue = KeyValue::find($id);
        return view('keyvalues.edit')->with('keyvalue', $keyvalue);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E214: ' . $e->getMessage());
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
        //
        $this->validate($request, [
            //Rules to validate
                'key' => 'required'
            ]);
            
        // Add a keyvalue
        $keyvalue = KeyValue::find($id);
        $keyvalue->key = strtoupper($request->input('key'));
        $keyvalue->value = $request->input('value');
        $keyvalue->save();

        return redirect('/keyvalue')->with('success', 'M078: The keyvalue has been updated');
    }
    catch (Exception $e) {
        return Redirect::back()->withError('E215: ' . $e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try
        {
            // We check if keyvalueYear to delete if it is used 
            $keyvalue = KeyValue::find($id);
            $keyvalue->delete();
            return redirect('/keyvalue')->with('success', 'M079: keyvalue deleted');
        }
            catch (Exception $e) {
                return Redirect::back()->withError('E217: ' . $e->getMessage());
            }
        }
    }
