<div class="col-xs-12">
    <h4><span class="glyphicon glyphicon-th-list"></span> Access Control</h4>
    <hr>
    @if(count($accessControl) > 0)
    @else
    <p class="text-danger"><b> There is no set access control in the app.</b></p>
    @endif

    <div class="container-fluid">
        <p>Use the buttons below to enable/disable access to specific Members sections. Note: if you send acceptance
            emails, it will only contain links to sections that are <b>enabled</b>. E.g. If the Event Groups section is
            disabled, the acceptance email you send will not contain the link to the Event Groups section.</p>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Access control</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table dataTable js-exportable">
                                <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Menu Option</th>
                                        <th style="width:40px;">status</th>
                                        <th style="width:40px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accessControl as $row)
                                    <tr>
                                        <td><strong>{{$row->menuoption}}</strong></td>
                                        @if($row->status)
                                        <td><strong>ON</strong></td>
                                        @else
                                        <td><strong>OFF</strong></td>
                                        @endif
                                        <td>
                                            <a href="/accessControl/{{$row->id}}/reverseAccessControlStatusById"><button
                                                    type="button" class="btn btn-info btn-sm"><span
                                                        class="glyphicon glyphicon-flash"></span></button></a>
                                            <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                                                data-target="#deleteAccessControlModal_{{$row->id}}"><span
                                                    class="glyphicon glyphicon-remove"></span></button>
                                        </td>
                                    </tr>
                                    <!-- +AJO : Model section begin -->
                                    <div class="modal fade" id="deleteAccessControlModal_{{$row->id}}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="title col-white text-center" id="defaultModalLabel">
                                                        Delete Access Control Confirmation</h4>
                                                </div>
                                                <div class="modal-body col-white">
                                                    {{ Form::open(['action' => ['AccessControlController@destroy', $row->id], 'method' => 'POST']) }}
                                                    @csrf
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    <div class="form-group">
                                                        <label for="accessConrol_id"><b>Do you really want to delete the
                                                                access control for the following menu option:
                                                                {{$row->menuoption}}?</b></label>
                                                        <input name="accessConrol_id" type="hidden"
                                                            value="{{$row->id}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-link waves-effect col-white">Yes, delete</button>
                                                    <button type="button" class="btn btn-link waves-effect col-white"
                                                        data-dismiss="modal">No, cancel</button>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end model section -->
                                    @endforeach
                                    <!-- Adding new line -->
                                    <tr>
                                        {{ Form::open(['action' => 'AccessControlController@store', 'method' => 'POST']) }}
                                        @csrf
                                        <td>
                                            <div class="form-group form-float">
                                                <select class="form-control show-tick ms select2"
                                                    data-placeholder="Select" name="menuoption" required>
                                                    <option value="" selected disabled>-- Please select a menu option --
                                                    </option>
                                                    <option value="MYRALLYE">My Rallye</option>
                                                    <option value="MYEVENTGROUP">My Event Group</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <div class="form-group form-float">
                                                {{form::submit('Add new', ['class' => 'btn btn-primary'])}}
                                            </div>
                                        </td>
                                        {{ Form::close() }}
                                    </tr>
                                    <!-- Adding new line -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- #END# Exportable Table -->



    </div>
