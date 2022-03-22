<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Members;
use Illuminate\Support\Facades\Auth;
use App\Models\Schoolyear;
use App\Models\MembershipPrice;
use App\Models\KeyValue;

use Exception;
use Illuminate\Support\Facades\Redirect;


class MembershipPricesController extends Controller
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
            $Schoolyears = Schoolyear::all();
            $membershipPrices = MembershipPrice::get();
            
            $data = [
                'SchoolYears'  => $Schoolyears,
                'membershipPrices' => $membershipPrices
            ];

            return view('membershipPrices.index')->with($data);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E218: ' . $e->getMessage());
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
        $schoolyears = Schoolyear::all();
        $data = [
            'schoolyears'  => $schoolyears
        ];
        return view('membershipPrices.create')->with($data);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E219: ' . $e->getMessage());
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
                'schoolyear_id' => 'required',
                'mount' => 'required'
            ]);
            
            // Add a keyvalue
            $membershipPrice = new MembershipPrice;
            $membershipPrice->is_boarder = ($request->has('is_boarder') )? true : false;;
            $membershipPrice->schoolyear_id = $request->input('schoolyear_id');
            $membershipPrice->mount = $request->input('mount');
            $membershipPrice->save();

            return redirect(route('membershipprices'))->with('success', 'M081: A keyvalue has been created');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E220: ' . $e->getMessage());
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
        $membershipPrice = MembershipPrice::find($id);
        $schoolyears = Schoolyear::all();
 
        $data = [
            'schoolyears'  => $schoolyears,
            'membershipPrice' => $membershipPrice
        ];
        return view('membershipPrices.edit')->with($data);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E222: ' . $e->getMessage());
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
            
        // Add a membershipPrice
        $membershipPrice = MembershipPrice::find($id);
        $membershipPrice->is_boarder = ($request->has('is_boarder') )? true : false;
        $membershipPrice->schoolyear_id = ($request->has('schoolyear_id'))? $request->input('schoolyear_id') : $membershipPrice->schoolyear_id;
        $membershipPrice->mount = ($request->has('mount'))? $request->input('mount') : $membershipPrice->mount;
        $membershipPrice->save();

        return redirect('/membershipprices')->with('success', 'M080: The membership price has been updated');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E223: ' . $e->getMessage());
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
            $membershipPrice = MembershipPrice::find($id);
            $membershipPrice->delete();
            return redirect('/membershipprices')->with('success', 'M079: The selected membership price deleted');
        }
            catch (Exception $e) {
                return Redirect::back()->withError('E224: ' . $e->getMessage());
            }
        }
    }
