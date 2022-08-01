<!-- +AJO : Modal section Cancel Checkin begin -->
<div class="modal fade" id="CancelingCheckInModal_{{$row->id}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h4 class="title col-white text-center" id="defaultModalLabel">Checking decline</h4>
      </div>
      <div class="media-object"><img src="{{$row->childphotopath}}" alt="" width="150"
          class="rounded-circle"></div>
      <div class="modal-body col-white">
        {{ Form::open(['action' => ['CheckinEventExtraController@update', $row->id], 'method' => 'POST']) }}
        @csrf
        <div class="form-group">
          <label for="action"><b>Are you sure your {{$row->childfirstname}} will NOT be attending
              ?</b></label>
          <input name="action" type="hidden" value="0">
        </div>
      </div>
      {{Form::hidden('_method', 'PUT')}}
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
