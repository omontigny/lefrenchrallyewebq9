<!-- +AJO : Modal section begin only if coordonator or superadmin-->
<div class="modal fade" id="sendSMSModal" tabindex="-1" role="dialog">

  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="title text-center" id="defaultModalLabel">Send SMS</h4>
          </div>

          <div class="modal-body">
            {{ Form::open(['action' => ['MultiCheckinController@sendSMSMissingChildren', $invitation_id], 'method' => 'POST']) }}
            @csrf

            <div class="form-group row">
              <div class="col-sm-2">
                <label for=""><b>From:<span class="text-danger">*</span></b></label>
              </div>
              <div class="col-sm-10">
                <input type="text" class="form-control" disabled name="from" id="from" value="Le FrenchRallye <{{env('TWILIO_PHONE')}}>" required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label for=""><b>Bcc:<span class="text-danger"> *</span></b></label>
              </div>
              <div class="col-sm-10">
                <input type="text" rows="3" class="form-control" name="bcclist" id="bcclist" value="{{$missingChildrenList ?? ''}}" required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label for=""><b>Subject:<span class="text-danger"> *</span></b></label>
              </div>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="subject" id="subject" value="[{{env('APP_NAME')}}] - [Children Attending]: " required>
              </div>
            </div>
            <label for="group_id"><b>SMS Body</b></label>
            <div id="toolbar-container"></div>
            <div class="border" id="myTextarea" >
               {{-- <p name="mail_body" id="mail_body"> {{ $SMSBodyPlacehodeler ?? '' }} </p>
              <br><br><br><br> --}}
              <textarea name="smsBody" disabled id="myTextarea" class="form-control text-left" rows = "8" cols = "50" >{{ $SMSBodyPlacehodeler ?? '' }}</textarea>
            {{-- </div> --}}
            <br>
          </div>

          <input name="invitation_id" type="hidden" value="{{$invitation_id}}">
          <input name="missingChildren" type="hidden" value="{{$missingChildren}}">

          <div class="modal-footer">
            {{form::submit('Send', ['class' => 'btn btn-primary'])}}
              <button type="button" class="btn btn-default float-right" data-dismiss="modal">Cancel</button>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
