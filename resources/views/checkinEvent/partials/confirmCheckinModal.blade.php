<!-- +AJO : Model section Confirm Checkin begin -->
<div class="modal fade" id="ConfirmCheckInModal_{{$row->id}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-green">
      <div class="modal-header">
        <h4 class="title col-white text-center" id="defaultModalLabel">Checking - Confirmation</h4>
      </div>
      <div class="media-object"><img src="{{$row->childphotopath}}" alt="" width="150"
          class="rounded-circle"></div>
      <div class="modal-body col-white">
        {{ Form::open(['action' => ['CheckinEventExtraController@update', $row->id], 'method' => 'POST']) }}
        @csrf
        {{Form::hidden('_method', 'PUT')}}
        <div class="form-group">
          <label for="action"><b>Do you really want to confirm {{$row->childfirstname}}
              presence?</b></label>
          <input name="action" type="hidden" value="1">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-link waves-effect col-white">Yes</button>
        <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No,
          cancel</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
<!-- END MODAL-->
