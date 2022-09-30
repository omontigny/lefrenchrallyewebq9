@extends('layout.master')
@section('title', 'Payment Subscription')
@section('parentPageTitle', 'Admin')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/select2/select2.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/css/stripe.css') }}" >
@stop

@section('content')
<div class='container'>
  <h2>Subscription Payment Form </h2>
    <h7 class="text-warning" align="center"><i><b>Notice:</b> Be careful not double click on payment button, <br>Also, the process can take several seconds please wait and don't stop-reload the page otherwise you will be charged twice.</i></h7>
    <p><br></p>
    <div class="row">
      <div class="col-md-10 order-md-1">
        {{-- <form id="payment-form" role="form" action="{{ route('stripe.get') }}" method="GET" class="require-validation" data-secret=""> --}}
        <form action="{{ route('stripe.charge') }}" method="post" id="payment-form" class="require-validation form-prevent-multiple-submits" data-secret="">

          @csrf
          <input name="application_id" type="hidden" value="{{$application->id}}">
          <input name="membershipPrice_id" type="hidden" value="{{$membershipPrice->id}}">
          <input name="membershipPrice" type="hidden" value="{{$membershipPrice->mount}}">
          <input id="paymentIntent_id" name="paymentIntent_id" type="hidden" value="">
          <input id="paymentIntent_client_secret" name="paymentIntent_client_secret" type="hidden" value="">
          <input id="paymentDescription" name="paymentDescription" type="hidden" value="{{$description}}">

          <fieldset>
            <div class='form-group form-float'>
                  <label class='control-label' for="cardholder-name"><b> Name on Card</b></label>
                  <input class='form-control' size='4' type='text' name="cardholder-name" id="cardholder-name" placeholder='Name on Card' required>
                  <div class="help-info">
                    <p>Please enter the name on your card</p>
                </div>
            </div>

          <div class="mb-3">
              <label for="card-element">
                  <b>Credit or Debit card</b>
              </label>
              <div id="card-element">
                  <!-- A Stripe Element will be inserted here. -->
              </div>
              <br>
              <!-- Used to display form errors. -->
                <div id='error-div' class='form-row row' hidden>
                <div class='col-md-12 warning form-group hide'>
                    <div class='alert-warning alert'>
                      <p id='error-message'><b></b></p>
                    </div>
                </div>
              </div>
          </div>
          <hr class="mb-4">
          <div class="col-12">
            <button type="button" id="payment-button" class="btn btn-primary btn-lg btn-block button-prevent-multiple-submits" data-toggle="modal" data-target="#PaymentConfirmationModal_{{$application->id}}">Pay Now (£ {{$membershipPrice->mount}})</button>
          </div>

          <hr class="mb-4">
          <div class="mb-3" id="card-message"></div>
            <!-- +AJO : Modal EDIT section begin -->
            <div class="modal fade" id="PaymentConfirmationModal_{{$application->id}}" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="title text-center" id="defaultModalLabel">Confirmation</h4>
                  </div>

                  <div class="modal-body">
                    {{ Form::open(['method' => 'POST', 'url' => route('stripe.charge'),'id' => 'payment-form', 'class' => ['require-validation', 'form-prevent-multiple-submits' ]]) }}
                      @csrf

                    <p for=""><b>Child first name: </b>{{$application->childfirstname}}</p>
                    <p for=""><b>Child Last name: </b>{{$application->childlastname}}</p>
                    <p for=""><b>Parent email: </b>{{$application->parentemail}}</p>
                    <p for=""><b>Membership Price: </b><span class="text-danger">£ {{$membershipPrice->mount}}</span></p>

                    <input name="invitation_id" type="hidden"
                        value="{{$application->id}}">
                    <div class="modal-footer">
                        {{form::submit("Pay Now", ['class' => 'btn btn-primary button-prevent-multiple-submits'])}}
                        <button type="button" class="btn btn-default float-right"
                            data-dismiss="modal">Cancel</button>
                    </div>
                    {{ Form::close() }}
                  </div>
                </div>
              </div>
            </div>
            <!-- END MODAL EDIT -->
        </form>
    </div>
  </div>
</div>

@stop

@section('page-script')
  <script src="{{secure_asset('assets/js/pages/payment/submit.js')}}"></script>
  <script src="https://js.stripe.com/v3/"></script>

  <script>
  var publishable_key = '{{ env('STRIPE_KEY') }}';
  </script>
  <script src="{{secure_asset('assets/js/pages/payment/card.js') }}"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      window.history.pushState(null, "", window.location.href);
      window.onpopstate = function() {
          window.history.pushState(null, "", window.location.href);
          window.onbeforeunload = function() { return "You work will be lost."; };
      };
  });
</script>
@endsection
