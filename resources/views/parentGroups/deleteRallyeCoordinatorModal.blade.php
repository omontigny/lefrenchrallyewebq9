<!-- +AJO : Model section begin -->
<div class="modal fade" id="deleteRallyeCoordinatorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="title col-white text-center" id="defaultModalLabel">Delete Rallye confirmation</h4>
            </div>
            <div class="modal-body col-white">
                {{ Form::open(['action' => ['RallyeCoordinatorsController@destroy', $rallye->id], 'method' => 'POST']) }}  
                @csrf
                {{Form::hidden('_method', 'DELETE')}}
                <div class="form-group">
                    <label for="rallye_id"><b>Please enter the rally's title to delete</b></label>
                    {{form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
                  </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-link waves-effect col-white">Delete</button>
                <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No, Cancel</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
  </div>
  <!-- +AJO : Model section end -->