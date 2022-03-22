<div class="col-xs-12">
        <h4><span class="glyphicon glyphicon-user"></span> Special Access</h4>
        <hr>
        @if(count($specialAccess) > 0)
        @else
        <p class="text-danger"><b>Nobody currently has received a special access.</b></p>
        @endif
    
        <div class="container-fluid">
                <p>Adding someone will <b>automatically send them an email</b> informing them that they have been granted special access with a link to the apply page. Make sure to spell/capitalise their name correctly as it will be displayed in the email. E.g. "Dear FullName..."</p>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Special access</strong> List</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table dataTable js-exportable">
                                    <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th style="width:40px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($specialAccess as $row)
                                        <tr>
                                            <td><strong>{{$row->fullname}}</strong></td>
                                            <td><strong><a href="mailto:{{$row->email}}"></a>{{$row->email}}</strong></td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                                                    data-target="#deleteAccessControlModal_{{$row->id}}"><span
                                                        class="glyphicon glyphicon-remove"></span></button>
                                            </td>
                                        </tr>
                                        <!-- +AJO : Model section begin -->
                                        <div class="modal fade" id="deleteAccessControlModal_{{$row->id}}"
                                            tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content bg-danger">
                                                    <div class="modal-header">
                                                        <h4 class="title col-white text-center" id="defaultModalLabel">
                                                            Delete Special Access Confirmation</h4>
                                                    </div>
                                                    <div class="modal-body col-white">
                                                        {{ Form::open(['action' => ['SpecialAccessController@destroy', $row->id], 'method' => 'POST']) }}
                                                        @csrf
                                                        {{Form::hidden('_method', 'DELETE')}}
                                                        <div class="form-group">
                                                            <label for="userRole_id"><b>Do you really want to delete the
                                                                    special access for {{$row->fullname}}?</b></label>
                                                            <input name="userRole_id" type="hidden"
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
                                            {{ Form::open(['action' => 'SpecialAccessController@store', 'method' => 'POST']) }}
                                            <td>
                                                <div class="form-group form-float">
                                                    {{form::text('fullname', '', ['class' => 'form-control', 'placeholder' => 'full name'])}}
                                                </div>
    
                                            </td>
                                            <td>
    
                                                <div class="form-group form-float">
                                                    {{form::text('email', '', ['class' => 'form-control', 'placeholder' => 'email'])}}
                                                </div>
    
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