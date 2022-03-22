<div class="col-xs-12">
  <h4><span class="glyphicon glyphicon-envelope"></span> Mails </h4>
    <hr>
  <a href={{secure_url("/sendTestMail")}}>
    <button type="button" class="btn btn-primary btn-md">
      <span class="glyphicon glyphicon-envelope"></span> Send Test Mail
    </button>
  </a>
  <button type="button" class="btn btn-warning btn-md" data-toggle="modal" data-target="#sendMail">
    <span class="glyphicon glyphicon-send"></span> Send Custom Mail
  </button>

  <!-- +AJO : Modal section begin only if coordonator or superadmin-->
  @if(Auth::user()->active_profile == Config::get('constants.roles.COORDINATOR') || Auth::user()->active_profile == Config::get('constants.roles.SUPERADMIN'))
    <div class="modal fade" id="sendMail" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
              <div class="modal-header">
                  <h4 class="title text-center" id="defaultModalLabel">Send Mail</h4>
              </div>

              <div class="modal-body">
                {{ Form::open(['action' => 'MailsController@sendCustomMails', 'method' => 'GET']) }}
                @csrf

                <div class="form-group row">
                  <div class="col-sm-2">
                    <label for=""><b>From:<span class="text-danger">*</span></b></label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="from" id="from" value="{{$mail_from}}" disabled required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-2">
                    <label for=""><b>To:<span class="text-danger"> *</span></b></label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="to" id="to"  value="{{$mail_from}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-2">
                    <label for=""><b>Bcc:<span class="text-danger"> *</span></b></label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" rows="3" class="form-control" name="bcclist" id="bcclist" value="" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-2">
                    <label for=""><b>Subject:<span class="text-danger"> *</span></b></label>
                  </div>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="subject" id="subject" value="[{{$_ENV['APP_NAME']}}] : " required>
                  </div>
                </div>
                <label for="group_id"><b>Mail Body</b></label>
                <div id="toolbar-container"></div>
                {{-- <div class="border" id="myTextarea" > --}}
                  {{-- <p name="mail_body" id="mail_body"> {{$mail_body}} </p>
                  <br><br><br><br> --}}
                  <textarea name="mail_body" id="myTextarea2" class="form-control text-left" rows = "13" cols = "50" >{{$mail_body}}</textarea>
                {{-- </div> --}}
                <br>
              </div>

              <input name="applications" type="hidden" value="">
              <input name="sender" type="hidden" value="{{$mail_from}}">

              <div class="modal-footer">
                {{form::submit('Send', ['class' => 'btn btn-primary'])}}
                  <button type="button" class="btn btn-default float-right" data-dismiss="modal">Cancel</button>
              </div>
              {{ Form::close() }}
        </div>
      </div>
    </div>
  @endif
  <!-- END MODAL-->


