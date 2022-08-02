<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\MembershipPrice;
use Illuminate\Support\Facades\Redirect;
use Exception;

class PaymentSearchController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    return view('payment.paymentSearchForm');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function find(Request $request)
  {
    //
    try {
      //
      $this->validate($request, [
        //Rules to validate
        'parentemail' => 'required',
        'childlastname' => 'required',
        'childfirstname' => 'required'
      ]);

      $application = Application::where('parentemail', trim(strtolower($request->input('parentemail'))))
        ->where('childlastname', trim(strtoupper($request->input('childlastname'))))
        ->where('childfirstname', ucwords(trim(strtolower($request->input('childfirstname')))))
        ->where('status', 4)
        ->get()
        ->first();

      if ($application != null) {
        $membershipPrice = MembershipPrice::where('is_boarder', $application->is_boarder)
          ->where('schoolyear_id', $application->schoolyear_id)
          ->get()
          ->first();

        if ($membershipPrice != null) {
          if ($application->rallye->isPetitRallye) {
            return Redirect::back()->withError('E200: ' . 'No membership payment for children in a Petit Rallye.');
          } else {
            $data = [
              'application' => $application,
              'membershipPrice' => $membershipPrice
            ];

            return view('payment.paymentSearchResults')->with($data);
          }
        } else {
          return Redirect::back()->withError('225: ' . 'The memberhip price are set yet, please try later on.');
        }
      } else {
        return Redirect::back()->withError('E201: ' . 'No application found or your application requestion has not been approved yet.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E135: ' . $e->getMessage());
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
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
